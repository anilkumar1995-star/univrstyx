<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseTopic;
use App\Models\CourseFeature;
use App\Helpers\ImageHelper;
use App\Helpers\Permission;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class CourseController extends Controller
{
    public function courseView(){
         $courses = Course::all();
          $cat = DB::table('course_category')
        ->pluck('course_category', 'course_category_slug');
        return view('course.courselist', compact('courses','cat'));
    }
     public function courseCategoryView(){
         $courses = Course::all();
          $cat = DB::table('course_category')
        ->pluck('course_category', 'course_category_slug');
        return view('course.coursecategory', compact('courses','cat'));
    }
   public function CourseDetails($id)
{
    $data['course'] = Course::findOrFail($id);

    $data['courseComparison'] = CourseFeature::where('course_id', $id)->get();
    $data['coursetopics'] = CourseTopic::where('course_id', $id)->get();
    $data['topics'] = json_decode($data['course']->course_related, true);
    $data['coursesByCategory'] = Course::select('course_category')
        ->groupBy('course_category')
        ->pluck('course_category');

    $data['relatedCourses'] = Course::where('course_category', $data['course']->course_category)
        ->where('id', '!=', $id)
        ->get();

    $data['doctorates'] = Degree::where('degree_category', 'doctorate')->get();

    return view('course.viewcourse')->with($data);
}    

public function ShowHideStatus($userid)
{
    $record = DB::table('free_course_show_hide')->where('user_id', $userid)->first();
    return response()->json([
        'status' => 'success',
        'data' => $record
    ]);
}
public function addShowHide(Request $post)
{
    $post->validate([
        'user_id' => 'required',
        'show_hide' => 'required|in:active,inactive'
    ]);

    $record = DB::table('free_course_show_hide')
                ->where('user_id', $post->user_id)
                ->first();

    $data = [
        'user_id' => $post->user_id,
        'show_hide' => $post->show_hide
    ];

    if ($record) {

        DB::table('free_course_show_hide')->where('id', $record->id)->update($data);
        $message = 'Record updated successfully';
    } else {
        DB::table('free_course_show_hide')->insert($data);
        $message = 'Record added successfully';
    }

    return response()->json([
        'status' => 'success',
        'message' => $message
    ], 200);
}



public function courseCategory(Request $post)
{
    $post->validate([
        'user_id'             => 'required',
        'course_category'     => 'required',
        'course_category_slug'=> 'required',
        'status'              => 'required|in:active,inactive',
    ]);

    if ($post->id) {
        $current = DB::table('course_category')->where('id', $post->id)->first();
        if (
            ($current->course_category !== $post->course_category) ||
            ($current->course_category_slug !== $post->course_category_slug)
        ) {
            $exists = DB::table('course_category')
                ->where(function ($q) use ($post) {
                    $q->where('course_category', $post->course_category)
                      ->orWhere('course_category_slug', $post->course_category_slug);
                })
                ->where('id', '!=', $post->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category or slug already exists!'
                ]);
            }
        }

        DB::table('course_category')
            ->where('id', $post->id)
            ->update([
                'user_id'             => $post->user_id,
                'course_category'     => $post->course_category,
                'course_category_slug'=> $post->course_category_slug,
                'status'              => $post->status,
            ]);

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    } else {
        $exists = DB::table('course_category')
            ->where(function ($q) use ($post) {
                $q->where('course_category', $post->course_category)
                  ->orWhere('course_category_slug', $post->course_category_slug);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Category or slug already exists!'
            ]);
        }

        DB::table('course_category')->insert([
            'user_id'             => $post->user_id,
            'course_category'     => $post->course_category,
            'course_category_slug'=> $post->course_category_slug,
            'status'              => $post->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Category added successfully']);
    }
}
public function CourseDetailsAjax($id)
{
    $course = Course::find($id);

    if (!$course) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found'
        ]);
    }

    $course->course_related = json_decode($course->course_related, true) ?? [];

    $topics = \DB::table('course_topics')
        ->where('course_id', $id)
        ->get();

    $features = \DB::table('course_features')
        ->where('course_id', $id)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $course,
        'topics' => $topics,
        'features' => $features
    ]);
}

public function courseCreate(Request $post)
{
    $post->validate([
        'user_id' => 'required',
        'course_category' => 'required',
        'course_title' => 'required',
        'course_learners' => 'required|integer',
        'course_hours' => 'required|integer',
        'course_related' => 'required',
        'course_description' => 'required',
        'free_certificate' =>'required',
        'is_share' => 'required',
        'helpline_number' => 'required',
        'certificate_intro' => 'required',
        'keybenefit_content' => 'nullable',
        'who_enroll' => 'nullable',
        'why_choose_course' => 'nullable',
        'course_icon' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        'certificate_img' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
    ]);

    $originalFile = null;
    $certificate = null;

    if ($post->hasFile('course_icon')) {
        $file = $post->file('course_icon');
        $ImageUpload = ImageHelper::imageUploadHelper('course_icon', $file);
        if ($ImageUpload['status']) {
            $originalFile = $ImageUpload['data']['target_file'];
        }
    }

    if ($post->hasFile('certificate_img')) {
        $file = $post->file('certificate_img');
        $ImageUpload = ImageHelper::imageUploadHelper('certificate_img', $file);
        if ($ImageUpload['status']) {
            $certificate = $ImageUpload['data']['target_file'];
        }
    }

    if ($post->id) {
        $course = Course::find($post->id);
        if (!$course) {
            return response()->json(['status' => 'failed', 'message' => 'Course not found'], 404);
        }

        $course->update([
            'user_id' => $post->user_id,
            'course_category' => $post->course_category,
            'course_title' => $post->course_title,
            'course_learners' => $post->course_learners,
            'course_hours' => $post->course_hours,
            'course_description' => $post->course_description,
            'free_certificate' => $post->free_certificate,
            'is_share' => $post->is_share,
            'course_related' => json_encode($post->course_related),
            'status' => 'active',
            'helpline_number' => $post->helpline_number,
            'certificate_intro' => $post->certificate_intro,
            'keybenefit_content' => $post->keybenefit_content,
            'who_enroll' => $post->who_enroll,
            'status' => $post->status,
            'why_choose_course' => $post->why_choose_course,
            'course_icon' => $originalFile ?? $course->course_icon,          
            'certificate_img' => $certificate ?? $course->certificate_img,   
        ]);

        $course->topics()->delete(); 
        if ($post->topic) {
            foreach ($post->topic as $i => $topic) {
                if (!empty($topic)) {
                    $course->topics()->create([
                        'topic' => $topic,
                        'topic_headding' => $post->topic_headding[$i] ?? null,
                        'topic_content' => $post->topic_content[$i] ?? null,
                    ]);
                }
            }
        }

 
        $course->features()->delete(); 
        if ($post->feature_name) {
            foreach ($post->feature_name as $i => $featureName) {
                if (!empty($featureName)) {
                    $course->features()->create([
                        'feature_name' => $featureName,
                        'free_course' => $post->free_course[$i] ?? 'no',
                        'paid_course' => $post->paid_course[$i] ?? 'no',
                    ]);
                }
            }
        }

        $message = 'Course Details updated successfully';
    } else {
 
        $course = Course::create([
            'user_id' => $post->user_id,
            'course_category' => $post->course_category,
            'course_title' => $post->course_title,
            'course_learners' => $post->course_learners,
            'course_hours' => $post->course_hours,
            'course_description' => $post->course_description,
            'free_certificate' => $post->free_certificate,
            'is_share' => $post->is_share,
            'course_related' => json_encode($post->course_related),
            'status' => $post->status,
            'helpline_number' => $post->helpline_number,
            'certificate_intro' => $post->certificate_intro,
            'keybenefit_content' => $post->keybenefit_content,
            'who_enroll' => $post->who_enroll,
            'why_choose_course' => $post->why_choose_course,
            'course_icon' => $originalFile,
            'certificate_img' => $certificate,
        ]);

        if ($post->topic) {
            foreach ($post->topic as $i => $topic) {
                if (!empty($topic)) {
                    $course->topics()->create([
                        'topic' => $topic,
                        'topic_headding' => $post->topic_headding[$i] ?? null,
                        'topic_content' => $post->topic_content[$i] ?? null,
                    ]);
                }
            }
        }

        if ($post->feature_name) {
            foreach ($post->feature_name as $i => $featureName) {
                if (!empty($featureName)) {
                    $course->features()->create([
                        'feature_name' => $featureName,
                        'free_course' => $post->free_course[$i] ?? 'no',
                        'paid_course' => $post->paid_course[$i] ?? 'no',
                    ]);
                }
            }
        }

        $message = 'Course Details added successfully';
    }

    return response()->json(['status' => 'success', 'message' => $message], 200);
}


    public function syllabusDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:holiday_list,id'
        ]);

        try {
            $syllabus = FestivalDetail::find($request->id);
            if ($syllabus) {
                $syllabus->delete();
                return response()->json(['status' => 'success', 'message' => 'Syllabus deleted successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Syllabus not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete syllabus'], 500);
        }
    }
 }
