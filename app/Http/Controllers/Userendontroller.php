<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use App\Helpers\WhatsAppSend;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pindata;
use App\Models\Api;
use App\Models\Application;
use App\Models\Award;
use App\Models\Degree;
use App\Models\Circle;
use App\Models\Company;
use App\Models\Course;
use App\Models\HiringPartner;
use App\Models\Instructors;
use App\Models\Role;
use App\Models\LoanEnquiry;
use App\Models\PortalSetting;
use App\Models\Testimonial;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Userendontroller extends Controller
{
    public function index(Request $post)
    {
        $user = Auth::user();

        $data['univercities'] = University::where('status', 'active')->get();
        $data['categories'] = DB::table('course_category')->where('status', 'active')->get();
        $data['trending'] = DB::table('universities')->where('bestseller', 'yes')->get();
        $data['freeCourse'] = DB::table('free_course_show_hide')->where('user_id', auth()->id())->where('show_hide', 'active')->first();


        $data['coursesByCategory'] = [];
        foreach ($data['categories'] as $category) {
            $data['coursesByCategory'][$category->course_category_slug] = [
                'label'   => $category->course_category,
                'courses' => Course::where('course_category', $category->course_category_slug)
                    ->where('status', 'active')
                    ->get(),
            ];
        }

        $data['brands'] = HiringPartner::where('status', 'active')->get();
        $data['testimonials'] = Testimonial::where('status', 'active')->get();
        $data['instructors'] = Instructors::where('status', 'active')->get();
        $data['inst'] = Instructors::where('status', 'active')->orderBy('id', 'desc')->first();
        $data['awards'] = Award::where('status', 'active')->get();
        $data['degreeCategories'] = DB::table('degree_category')
            ->select('degree_category.*')
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM universities u WHERE u.degree_category = degree_category.id AND u.status = "active") as universities_count'))
            ->where('degree_category.status', 'active')
            ->get();

        $data['goals'] = DB::table('goals')->where('status', 'active')->get();
        $data['walletBalance'] = DB::table('course_list')->where('user_id', Auth::id())->sum('course_hours');
        $data['user'] = $user;
        $data['slider'] = DB::table('main_slider')->where('status', 'active')->orderBy('id', 'desc')->first();
        $data['learner'] = DB::table('learner_support')->where('status', 'active')->orderBy('id', 'desc')->first();
        $data['mediaItems'] = DB::table('footer_media')->where('status', 'active')->orderByDesc('id')->get();
        $data['mediaHeading'] = DB::table('footer_media')->where('status', 'active')->first();
        $data['homepage'] = DB::table('homepage_settings')->where('status', 'active')->first();


        // dd($data['coursesByCategory']);

        // dd($data['degree_categories'],$data['universities']);



        return view('frontend_home')->with($data);
    }

    public function indexStudent()
    {
        $recent = Application::where('user_id', Auth::id())->orderBy('created_at', 'desc')->limit(5)->get();
        $recentCourses = University::whereIn('id', $recent->pluck('course_id'))->get();

        return view('student_dashboard', compact('recentCourses'));
    }
    public function goalsView()
    {
        return view('goals.goalslist');
    }

    public function goalsCreate(Request $post)
    {
        $post->validate([
            'user_id' => 'required',
            'goals_name' => 'required',
            'status' => 'required'
        ]);

        $exists = DB::table('goals')
            ->where('goals_name', $post->goals_name)
            ->when($post->id, function ($query) use ($post) {
                return $query->where('id', '!=', $post->id);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Goal name already exists!'
            ]);
        }

        if (!empty($post->id)) {
            DB::table('goals')->where('id', $post->id)->update([
                'user_id' => $post->user_id,
                'goals_name' => $post->goals_name,
                'status' => $post->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Goal updated successfully'
            ]);
        } else {
            // Insert new goal
            DB::table('goals')->insert([
                'user_id' => $post->user_id,
                'goals_name' => $post->goals_name,
                'status' => $post->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Goal added successfully'
            ]);
        }
    }
}
