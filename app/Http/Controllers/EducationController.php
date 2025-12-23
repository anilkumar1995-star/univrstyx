<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\Permission;
use App\Models\Degree;
use App\Models\DegreeCategory;
use App\Models\Disclaimer;
use App\Models\Fee;
use App\Models\Header;
use App\Models\LearnerSupport;
use App\Models\Slider;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    public function index()
    {
        $universities = DB::table('universities')->where('status', 'active')->select('id', 'university_name', 'degree_name')
            ->get();
        return view('fee.fee', compact('universities'));
    }
    public function FeesList()
    {
        return view('fee.fees_list');
    }
    public function TutionFee()
    {
        return view('fee.tution_fee');
    }
    public function HostelFee()
    {
        return view('fee.hostel_fee');
    }
    public function CollegeFee()
    {
        return view('fee.college_fee');
    }
    public function HobbyFee()
    {
        return view('fee.hobby_fee');
    }

    public function DaycareFee()
    {
        return view('fee.daycare_fee');
    }
    public function EducationFee()
    {
        return view('fee.education_fee');
    }
    public function SchoolFee()
    {
        return view('fee.school_fee');
    }
    public function degreeCategoryView()
    {
        $categories = DegreeCategory::all();
        return view('degree.degree_category_list', compact('categories'));
    }
    public function getEmploymentList()
    {
        return view('education.hiring_partners');
    }



    public function FeeSubmit(Request $request)
    {

        $rules = [
            'user_id'      => 'required',
            'student_name' => 'required|string|max:255',
            'dob'          => 'required|date',
            'mobile'       => 'required',
            'college_name' => 'required|string|max:255',
            'type'         => 'required|string',
        ];

        switch ($request->type) {
            case 'hostel_fee':
                $rules = array_merge($rules, [
                    'hostel_name'   => 'required|string|max:255',
                    'room_number'   => 'required|string|max:50',
                    'session_year'  => 'required|string|max:50',
                    'amount'    => 'required|numeric|min:1',
                ]);
                break;

            case 'exam_fee':
                $rules = array_merge($rules, [
                    'student_unique_id' => 'required|string|max:100',
                    'exam_name'         => 'required|string|max:255',
                    'amount'          => 'required|numeric|min:1',
                ]);
                break;

            case 'college_fee':
                $rules = array_merge($rules, [
                    'student_unique_id' => 'required|string|max:100',
                    'amount'       => 'required|numeric|min:1',
                    'father_name'       => 'required|string|max:255',
                ]);
                break;

            case 'tuition_fee':
                $rules = array_merge($rules, [
                    'student_unique_id' => 'required|string|max:100',
                    'amount'       => 'required|numeric|min:1',
                    'father_name'       => 'required|string|max:255',
                ]);
                break;
        }


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data  = $request->all();
        //    $data = $request->only(['user_id','type', 'student_unique_id','student_name','dob','father_name','mother_name','mobile',
        //     'email','college_name','hostel_name','room_number','session_year','hostel_fee','exam_name','exam_fee','tuition_fee',
        // ]);


        Fee::create($data);

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' submitted successfully'
        ], 200);
    }

    public function getEmploymentAdd(Request $post)
    {
        $post->validate([
            'user_id'       => 'required',
            'company_name'  => 'required',
            'company_image' => $post->id ? 'nullable|file|mimes:jpg,jpeg,png|max:1024' : 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $originalFile = null;
        $message = '';

        if ($post->hasFile('company_image')) {
            $file = $post->file('company_image');
            $ImageUpload = ImageHelper::imageUploadHelper('company_image', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        if ($post->id) {

            $updateData = [
                'user_id'       => $post->user_id,
                'company_name'  => $post->company_name,
                'status'        => $post->status,
            ];

            if ($originalFile) {
                $updateData['company_image'] = $originalFile;
            }

            $hiringCompany = DB::table('hiring_company')
                ->where('id', $post->id)
                ->update($updateData);

            if ($hiringCompany) {
                return response()->json(['status' => 'success', 'message' => 'Hiring Company updated successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Hiring Company not updated'], 400);
            }
        } else {

            $hiringCompany = DB::table('hiring_company')->insert([
                'user_id'       => $post->user_id,
                'company_name'  => $post->company_name,
                'company_image' => $originalFile,
                'status'        => $post->status,
            ]);

            if ($hiringCompany) {
                return response()->json(['status' => 'success', 'message' => 'Hiring Company added successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Hiring Company not added'], 400);
            }
        }
    }
    private function convertYoutubeUrl($url)
    {
        if (str_contains($url, 'youtu.be')) {
            preg_match('/youtu\.be\/([^\?]+)/', $url, $matches);
            return "https://www.youtube.com/embed/" . ($matches[1] ?? '');
        }

        if (str_contains($url, 'watch?v=')) {
            return str_replace('watch?v=', 'embed/', $url);
        }
        return $url;
    }


    public function TestimonialAdd(Request $post)
    {
        $post->validate([
            'user_id'       => 'required',
            'name'         =>     'required',
            'designation'  => 'required',
            'message'  => 'required',
            'video_url'  => 'required',
            'video_image' => $post->id ? 'nullable|file|mimes:jpg,jpeg,png|max:1024' : 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);
        $url = $post->video_url;
        $embedUrl = $this->convertYoutubeUrl($url);
        $originalFile = null;
        $message = '';

        if ($post->hasFile('video_image')) {
            $file = $post->file('video_image');
            $ImageUpload = ImageHelper::imageUploadHelper('video_image', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        if (!empty($post->id)) {

            $updateData = [
                'user_id'       => $post->user_id,
                'name'  => $post->name,
                'designation'  => $post->designation,
                'message'  => $post->message,
                'video_url'  =>  $embedUrl,
                'status'        => $post->status,
            ];

            if ($originalFile) {
                $updateData['video_image'] = $originalFile;
            }

            $data = DB::table('learners_testimonials')
                ->where('id', $post->id)
                ->update($updateData);

            if ($data) {
                return response()->json(['status' => 'success', 'message' => 'Learners Testimonial updated successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Learners Testimonial not updated'], 400);
            }
        } else {

            $data = DB::table('learners_testimonials')->insert([
                'user_id'       => $post->user_id,
                'name'  => $post->name,
                'designation'  => $post->designation,
                'message'  => $post->message,
                'video_url'  =>  $embedUrl,
                'video_image'  => $originalFile,
                'status'        => $post->status,
            ]);

            if ($data) {
                return response()->json(['status' => 'success', 'message' => 'Learners Testimonial added successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Learners Testimonial not added'], 400);
            }
        }
    }

    public function InstructorAdd(Request $post)
    {
        $post->validate([
            'user_id'       => 'required',
            'name'          => 'required',
            'designation'   => 'required',
            'working_at'    => 'required',
            'description'   => 'required',
            'linkedin_url'  => 'required',
            'working_logo'  => $post->id ? 'nullable|file|mimes:jpg,jpeg,png|max:1024' : 'required|file|mimes:jpg,jpeg,png|max:1024',
            'profile_image' => $post->id ? 'nullable|file|mimes:jpg,jpeg,png|max:1024' : 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);


        $linkedin = preg_replace('/\s+/', '', $post->linkedin_url);

        if ($linkedin && !preg_match('/^https?:\/\//', $linkedin)) {
            $linkedin = 'https://' . $linkedin;
        }

        $originalFile = null;
        $originalprofile = null;
        $message = '';

        if ($post->hasFile('working_logo')) {
            $file = $post->file('working_logo');
            $ImageUpload = ImageHelper::imageUploadHelper('working_logo', $file);
            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        if ($post->hasFile('profile_image')) {
            $file = $post->file('profile_image');
            $ImageUpload = ImageHelper::imageUploadHelper('profile_image', $file);
            if ($ImageUpload['status']) {
                $originalprofile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        if ($post->id) {
            $updateData = [
                'user_id'      => $post->user_id,
                'name'         => $post->name,
                'designation'  => $post->designation,
                'working_at'   => $post->working_at,
                'description'  => $post->description,
                'linkedin_url' => $linkedin,
                'status'       => $post->status,
            ];

            if ($originalFile) {
                $updateData['working_logo'] = $originalFile;
            }
            if ($originalprofile) {
                $updateData['profile_image'] = $originalprofile;
            }

            $data = DB::table('instructors')->where('id', $post->id)->update($updateData);

            return $data
                ? response()->json(['status' => 'success', 'message' => 'Instructor updated successfully'], 200)
                : response()->json(['status' => 'failed', 'message' => 'Instructor not updated'], 400);
        } else {
            $data = DB::table('instructors')->insert([
                'user_id'       => $post->user_id,
                'name'          => $post->name,
                'designation'   => $post->designation,
                'working_at'    => $post->working_at,
                'description'   => $post->description,
                'linkedin_url'  => $linkedin,
                'working_logo'  => $originalFile,
                'profile_image' => $originalprofile,
                'status'        => $post->status,
            ]);

            return $data
                ? response()->json(['status' => 'success', 'message' => 'Instructor added successfully'], 200)
                : response()->json(['status' => 'failed', 'message' => 'Instructor not added'], 400);
        }
    }

   public function LearnerSupportAdd(Request $post)
{
    $post->validate([
        'learner_support_heading' => 'required|string|max:255',
        'learner_support_content' => 'required|string|max:255',
        'get_started' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',
    ]);

    DB::beginTransaction();

    try {

        $oldRecord = null;
        if ($post->id) {
            $oldRecord = DB::table('learner_support')->where('id', $post->id)->first();
        }

        $images = [];

        if ($post->hasFile('image')) {
            foreach ($post->file('image') as $file) {

                $upload = ImageHelper::imageUploadHelper("learner_support", $file);

                if ($upload['status']) {
                    $images[] = $upload['data']['target_file'];
                }
            }
        }
     
        else if ($oldRecord && $oldRecord->image) {
            $images = json_decode($oldRecord->image, true);
        }

        $imageJson = !empty($images) ? json_encode($images) : null;

        $exists = DB::table('learner_support')->first();
        if ($exists && !$post->id) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Learner Support record already exists. Please edit instead.',
            ], 400);
        }

        $data = [
            'user_id' => $post->user_id,
            'learner_support_heading' => $post->learner_support_heading,
            'learner_support_content' => $post->learner_support_content,
            'get_started' => $post->get_started,
            'status' => $post->status ?? 'active',
            'number' => $post->number ? json_encode($post->number) : null,
            'title' => $post->title ? json_encode($post->title) : null,
            'description' => $post->description ? json_encode($post->description) : null,
            'image' => $imageJson,
        ];

        if ($post->id) {
            DB::table('learner_support')->where('id', $post->id)->update($data);
            $msg = "Learner Support updated successfully";
        } else {
            DB::table('learner_support')->insert($data);
            $msg = "Learner Support added successfully";
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'failed',
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}



    public function DisclaimerAdd(Request $post)
    {
        $post->validate([
            'disclaimer' => 'required|string',
            'copyright' => 'required|string',
            'helpline' => 'required|string',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive',
        ]);

        if ($post->id) {
            $updateData = [
                'user_id'   => $post->user_id,
                'disclaimer' => $post->disclaimer,
                'copyright' => $post->copyright,
                'helpline'  => $post->helpline,
                'email'     => $post->email,
                'status'    => $post->status ?? 'active',
            ];

            $updated = DB::table('disclaimer')
                ->where('id', $post->id)
                ->update($updateData);

            if ($updated) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Disclaimer updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'No changes detected or update failed',
                ], 400);
            }
        } else {
            $exists = DB::table('disclaimer')->exists();

            if ($exists) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Disclaimer record already exists. Please edit instead.',
                ], 400);
            }
            $inserted = DB::table('disclaimer')->insert([
                'user_id'   => $post->user_id,
                'disclaimer' => $post->disclaimer,
                'copyright' => $post->copyright,
                'helpline'  => $post->helpline,
                'email'     => $post->email,
                'status'    => $post->status ?? 'active',
            ]);

            if ($inserted) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Disclaimer added successfully',
                ], 200);
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Disclaimer not added',
                ], 400);
            }
        }
    }


public function HeaderAdd(Request $post)
{
    $post->validate([
        'user_id'  => 'required',
        'header_1' => 'required',
        'header_2' => 'required',
        'header_3' => 'required',
    ]);

    $existing = DB::table('header_content')->first();

    $headerimg = $existing->header_image ?? null;
    $footerimg = $existing->footer_image ?? null;

    // ================= HEADER IMAGE =================
    if ($post->hasFile('header_image')) {
        $file = $post->file('header_image');
        $imgupload = ImageHelper::imageUploadHelper('header_image', $file);

        if (!$imgupload['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => $imgupload['message']
            ], 400);
        }

        $headerimg = $imgupload['data']['target_file'];
    }

    // ================= FOOTER IMAGE =================
    if ($post->hasFile('footer_image')) {
        $file = $post->file('footer_image');
        $imgupload = ImageHelper::imageUploadHelper('footer_image', $file);

        if (!$imgupload['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => $imgupload['message']
            ], 400);
        }

        $footerimg = $imgupload['data']['target_file'];
    }

    // ================= UPDATE =================
    if ($post->id) {

        DB::table('header_content')
            ->where('id', $post->id)
            ->update([
                'user_id'       => $post->user_id,
                'header_1'      => $post->header_1,
                'header_2'      => $post->header_2,
                'header_3'      => $post->header_3,
                'header_image'  => $headerimg,
                'footer_image'  => $footerimg,
                'status'        => $post->status ?? 'active',
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Header updated successfully'
        ], 200);
    }

    // ================= INSERT =================
    if ($existing) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Header data already exists. Please edit.'
        ], 400);
    }

    DB::table('header_content')->insert([
        'user_id'       => $post->user_id,
        'header_1'      => $post->header_1,
        'header_2'      => $post->header_2,
        'header_3'      => $post->header_3,
        'header_image'  => $headerimg,
        'footer_image'  => $footerimg,
        'status'        => $post->status ?? 'active',
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Header added successfully'
    ], 200);
}




    public function SliderAdd(Request $post)
    {
        $post->validate([
            'user_id'        => 'required',
            'title'          => 'required|string|max:255',
            'subtitle'       => 'required|string|max:255',
            'join_community' => 'required|string|max:255',
            'back_side_img'  => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
            'front_side_img' => 'nullable|array',
            'front_side_img.*' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
            'status'         => 'required|in:active,inactive',
        ]);

        $record = DB::table('main_slider')->first();

        $originalBack = null;
        $originalFront = null;

        if ($post->hasFile('back_side_img')) {
            $file = $post->file('back_side_img');
            $ImageUpload = ImageHelper::imageUploadHelper('back_side_img', $file);

            if ($ImageUpload['status']) {
                $originalBack = $ImageUpload['data']['target_file'];
            } else {
                return response()->json(['status' => 'failed', 'message' => $ImageUpload['message']], 400);
            }
        }

        if ($post->hasFile('front_side_img')) {
            $frontImages = [];
            foreach ($post->file('front_side_img') as $file) {
                $ImageUpload = ImageHelper::imageUploadHelper('front_side_img', $file);
                if ($ImageUpload['status']) {
                    $frontImages[] = $ImageUpload['data']['target_file'];
                }
            }
            $originalFront = json_encode($frontImages);
        }

        $data = [
            'user_id'  => $post->user_id,
            'title'    => $post->title,
            'subtitle' => $post->subtitle,
            'join_community' => $post->join_community,
            'status'   => $post->status,
        ];

        if ($originalBack) {
            $data['back_img'] = $originalBack;
        }

        if ($originalFront) {
            $data['front_img'] = $originalFront;
        } elseif ($record) {

            $data['front_img'] = $record->front_img;
        }

        if ($record) {
            DB::table('main_slider')->where('id', $record->id)->update($data);
            $message = 'Slider updated successfully';
        } else {
            $data['created_at'] = now();
            DB::table('main_slider')->insert($data);
            $message = 'Slider added successfully';
        }

        return response()->json(['status' => 'success', 'message' => $message], 200);
    }

    public function getAwardList(Request $post)
    {
        return view('education.award');
    }

    public function Testimonial()
    {
        return view('education.testimonial');
    }
    public function ShowInstructor()
    {
        return view('education.instructors');
    }
    public function ShowLearnerSupport()
    {
        $existsupport = LearnerSupport::count() > 0;
        return view('education.learnersupport', compact('existsupport'));
    }
    public function ShowDisclaimer()
    {
        $existdisclaimer = Disclaimer::count() > 0;
        return view('education.disclaimer', compact('existdisclaimer'));
    }
    public function Slider()
    {
        $existslider = Slider::count() > 0;
        return view('education.slider_content', compact('existslider'));
    }
    public function Header()
    {
        $existsheader = Header::count() > 0;
        return view('education.header_heading', compact('existsheader'));
    }
    public function payBill(Request $post)
    {
        // dd($post->all());
        return response()->json([
            "status" => "error",
            "message" => "Something went wrong"
        ], 200);
    }
    public function AwardAdd(Request $post)
    {
        $post->validate([
            'user_id'          => 'required',
            'award_title'      => 'required',
            'award_heading'    => 'required',
            'award_description' => 'required',
            'award_image'      => $post->id ? 'nullable|file|mimes:jpg,jpeg,png|max:1024' : 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $originalFile = null;
        $message = '';

        if ($post->hasFile('award_image')) {
            $file = $post->file('award_image');
            $ImageUpload = ImageHelper::imageUploadHelper('award_image', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        if ($post->id) {
            $existing = DB::table('award_acomplishments')->where('id', $post->id)->first();

            $updateData = [
                'user_id'          => $post->user_id,
                'award_title'      => $post->award_title,
                'award_heading'    => $post->award_heading,
                'award_description' => $post->award_description,
                'status'           => $post->status,
            ];

            if ($originalFile) {
                $updateData['award_image'] = $originalFile;
            } else {

                $updateData['award_image'] = $existing->award_image;
            }

            $data = DB::table('award_acomplishments')
                ->where('id', $post->id)
                ->update($updateData);

            if ($data) {
                return response()->json(['status' => 'success', 'message' => 'Award updated successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Award not updated'], 400);
            }
        } else {
            $data = DB::table('award_acomplishments')->insert([
                'user_id'          => $post->user_id,
                'award_title'      => $post->award_title,
                'award_heading'    => $post->award_heading,
                'award_description' => $post->award_description,
                'award_image'      => $originalFile,
                'status'           => $post->status,
            ]);

            if ($data) {
                return response()->json(['status' => 'success', 'message' => 'Award added successfully'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Award not added'], 400);
            }
        }
    }

    public function fetchFee(Request $request)
    {
        //    dd($request->all());
        $request->validate([
            // 'customer_mobile'       => 'required',
            // 'biller_id'       => 'required',
        ]);

        $dynamicFields = $request->get('dynamicFields', []);

        $headers = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("ipayment_234ef58375b8e333828046372449395:3ca73ac2ee3b5a4c761812041a65da2b828046372455367")
        ];

        $tags = [];
        foreach ($dynamicFields as $key => $value) {
            if (!empty($value)) {
                $tags[] = [
                    "name" => $key,
                    "value" => $value
                ];
            }
        }

        $query = [
            "customerMobileNo" => $request->customer_mobile,
            "billerId" => $request->biller_id,
            "customerParamsRequest" => [
                "tags" => $tags
            ]
        ];
        // dd($query);
        $url = "https://console.ipayments.in/v1/service/bbps/fetch/bill";
        try {

            $response = Permission::curl($url, "POST", json_encode($query), $headers);
            // dd($response);
            $billers = json_decode($response['response'], true);

            if (isset($billers['data']['billId'])) {
                $billId = $billers['data']['billId'];

                $billByIdUrl = "https://console.ipayments.in/v1/service/bbps/fetch/billByBillId";
                $billByIdPayload = [
                    "billId" => $billId
                ];
                // dd($billByIdPayload);
                sleep(5);
                $billByIdResponse = Permission::curl(
                    $billByIdUrl,
                    "GET",
                    json_encode($billByIdPayload),
                    $headers
                );
                // dd($billByIdResponse);
                $billByIdData = json_decode($billByIdResponse['response'], true);

                return response()->json([
                    "success" => true,
                    "billers" => $billers,
                    "billById" => $billByIdData
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "BillId not found in first response",
                "data" => $billers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function addFee(Request $post)
    {
        $post->validate([
            'user_id' => 'required',
            'categoryname' => 'required',
        ]);

        $headers = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("ipayment_234ef58375b8e333828046372449395:3ca73ac2ee3b5a4c761812041a65da2b828046372455367")
        ];

        $query = http_build_query([
            "categoryName" => $post->categoryname,
            "page" => 0,
            "pageSize" => 50000,
        ]);
        // dd($query);
        $url = "https://console.ipayments.in/v1/service/bbps/fetch/biller/category?" . $query;
        // dd($url);
        try {
            $response = Permission::curl($url, "GET", null, $headers);
            // dd($response);
            $billers = json_decode($response['response'], true);
            // dd($billers);
            return response()->json([
                "success" => true,
                "billers" => $billers['data']['billerResp'] ?? []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function getBillerDetails(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'biller_id' => 'required',
        ]);

        $headers = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("ipayment_234ef58375b8e333828046372449395:3ca73ac2ee3b5a4c761812041a65da2b828046372455367")
        ];
        $query = http_build_query([
            "billerId" => $request->biller_id,
        ]);
        $url = "https://console.ipayments.in/v1/service/bbps/fetch/biller/fetchByBillerId?" . $query;

        try {
            $response = Permission::curl($url, "GET", null, $headers);
            // dd($response);
            $result = json_decode($response['response'], true);

            return response()->json([
                "success" => true,
                "biller"  => $result['data'] ?? []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
