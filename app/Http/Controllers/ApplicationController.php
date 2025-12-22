<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Application;
use App\Models\Community;
use App\Models\FestivalDetail;
use App\Models\Grievance;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function saveStep(Request $request)
    {
        $request->validate([
            'programme_id' => 'required|integer',
            'step' => 'required|string',
            'payload' => 'required|array',
        ]);

        $user = \Auth::user();

        $application = Application::firstOrCreate(
            ['user_id' => $user->id, 'programme_id' => $request->programme_id, 'status' => 'draft'],
            ['step_data' => [], 'current_step' => 'step1']
        );

        $data = $application->step_data ?? [];

        $data[$request->step] = $request->payload;

        $application->step_data = $data;
        $application->current_step = $request->step;
        $application->save();

        return response()->json([
            'success' => true,
            'message' => 'Step saved.',
            'application_id' => $application->id,
            'current_step' => $application->current_step,
        ]);
    }

    public function get($id)
    {
        return Grievance::find($id);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reply_message' => 'required|string'
        ]);

        $g = Grievance::find($request->id);

        if (!$g) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $g->reply_message = $request->reply_message;
        $g->status = 'resolved';
        $g->save();

        return response()->json(['success' => true]);
    }

    public function applyPage($id)
    {
        $programme = University::findOrFail($id);
        return view('application.apply_form', compact('programme'));
    }

    public function applicationView()
    {

        return view('application.application_list');
    }

    public function grievanceView()
    {
        return view('application.grievance_list');
    }

    public function screening($id)
    {
        $programme = University::findOrFail($id);
        return view('application.screening', compact('programme'));
    }
    public function reserveSeat($id)
    {
        $programme = University::findOrFail($id);
        return view('application.reserve_seat', compact('programme'));
    }
    public function checkout($id)
    {
        $programme = University::findOrFail($id);

        $data = [
            'programme' => $programme,
            'monthly_amount' => number_format($programme->monthly_amount ?? 8125),
            'total_amount'   => number_format($programme->total_amount ?? 225000),
            'seat_amount'    => number_format($programme->seat_amount ?? 15000),
            'start_date'     => $programme->start_date ?? 'Dec 31, 2025',
        ];

        return view('application.checkout', $data);
    }


    public function storeApplication(Request $request)
    {

        $validated = $request->validate([
            'prefix' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'dob' => 'required|date|before:today',
            'city' => 'nullable|string|max:255',
            'bachelor' => 'nullable|string|max:255',
            'bachelor_percentage' => 'nullable|numeric|min:0|max:100',
            'masters' => 'nullable|string|max:255',
            'masters_percentage' => 'nullable|numeric|min:0|max:100',
            'experience' => 'nullable|string|max:255',
            'organisation' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|max:50',
            'course_id' => 'required|'
        ]);

        Application::create([
            'user_id' => auth()->id(),
            'prefix' => $validated['prefix'] ?? null,
            'name' => $validated['name'],
            'father_name' => $validated['father_name'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'phone' => auth()->user()->mobile ?? null,
            'email' => auth()->user()->email ?? null,
            'city' => $validated['city'] ?? null,
            'bachelor' => $validated['bachelor'] ?? null,
            'bachelor_percentage' => $validated['bachelor_percentage'] ?? null,
            'masters' => $validated['masters'] ?? null,
            'masters_percentage' => $validated['masters_percentage'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'organisation' => $validated['organisation'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'referral_code' => $validated['referral_code'] ?? null,
            'course_id' => $validated['course_id'],
            'payment_status' => 'pending',
        ]);

        return redirect()
            ->route('reserve.seat', ['id' => $validated['course_id']])
            ->with('success', 'Screening details saved successfully!');
    }


    public function screeningSubmit(Request $request)
    {
        // validation and saving logic here
    }

    public function finalize(Request $request)
    {
        $request->validate([
            'programme_id' => 'required|integer',
            'application_id' => 'nullable|integer',
        ]);

        $user = \Auth::user();

        $application = null;
        if ($request->application_id) {
            $application = Application::where('id', $request->application_id)
                ->where('user_id', $user->id)->first();
        }

        if (!$application) {
            $application = Application::where('user_id', $user->id)
                ->where('programme_id', $request->programme_id)
                ->where('status', 'draft')->first();
        }

        if (!$application) {
            return response()->json(['success' => false, 'message' => 'Draft not found.'], 404);
        }

        $application->status = 'completed';
        $application->save();

        return response()->json(['success' => true, 'message' => 'Application submitted successfully.']);
    }

    public function getDraft($programme)
    {
        $user = \Auth::user();
        $application = Application::where('user_id', $user->id)
            ->where('programme_id', $programme)
            ->where('status', 'draft')->first();

        return response()->json([
            'success' => true,
            'data' => $application ? $application->step_data : null,
        ]);
    }

    public function communityList()
    {
        $communityExists = Community::count() > 0;
        return view('footer.community', compact('communityExists'));
    }
    public function communityView()
    {
        $community = Community::where('status', 'active')->first();
        return view('footer.community_view', compact('community'));
    }
    public function communityEdit($id)
    {
        $community = Community::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $community
        ]);
    }

    public function communitySave(Request $post)
    {
        $post->validate([
            'title'             => 'required|string',
            'subtitle'          => 'nullable|string',
            'feature_heading'   => 'nullable|string',
            'discussion_heading' => 'nullable|string',
            'contributer_heading' => 'nullable|string',
            'cta_title'         => 'nullable|string',
            'cta_subtitle'      => 'nullable|string',
            'cta_button_text'   => 'nullable|string',
            'status'            => 'nullable|string'
        ]);


        $exists = Community::first();

        if (!$post->id && $exists) {
            return response()->json([
                'status' => false,
                'message' => 'Record already exists. Please edit the existing record.'
            ]);
        }

        $id = $post->id;

        $featureCategories = [];
        if ($post->has('feature_categories')) {
            foreach ($post->feature_categories as $item) {
                $featureCategories[] = [
                    'title'       => $item['title'] ?? '',
                    'description' => $item['description'] ?? '',
                ];
            }
        }

        $trendingDiscussions = [];
        if ($post->has('trending_discussions')) {
            foreach ($post->trending_discussions as $item) {
                $trendingDiscussions[] = [
                    'title'   => $item['title'] ?? '',
                    'replies' => $item['replies'] ?? 0,
                    'views'   => $item['views'] ?? 0,
                ];
            }
        }

        $contributors = [];

        if ($post->has('contributors')) {
            foreach ($post->contributors as $item) {

                $oldImage = $item['old_image'] ?? null;
                $imageName = $oldImage;

                if (isset($item['image']) && $item['image']) {

                    $upload = ImageHelper::imageUploadHelper("contributors", $item['image']);

                    if ($upload['status']) {
                        $imageName = $upload['data']['target_file'];
                    }
                }


                $contributors[] = [
                    'name'  => $item['name'] ?? '',
                    'image' => $imageName,
                    'posts' => $item['posts'] ?? '',
                ];
            }
        }


        $data = [
            'user_id'               => $post->user_id,
            'title'                 => $post->title,
            'subtitle'              => $post->subtitle,

            'feature_heading'       => $post->feature_heading,
            'trending_heading'      => $post->discussion_heading,
            'top_contributer_heading' => $post->contributer_heading,

            'feature_categories'    => json_encode($featureCategories),
            'trending_discussions'  => json_encode($trendingDiscussions),
            'contributors'          => json_encode($contributors),

            'cta_title'             => $post->cta_title,
            'cta_subtitle'          => $post->cta_subtitle,
            'cta_button_text'       => $post->cta_button_text,
            'status'                => $post->status ?? 'active',
        ];

        if ($id) {
            Community::where('id', $id)->update($data);
            return response()->json(['status' => true, 'message' => 'Community updated successfully']);
        } else {
            Community::create($data);
            return response()->json(['status' => true, 'message' => 'Community created successfully']);
        }
    }
}
