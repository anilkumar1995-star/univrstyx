<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\FestivalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterController extends Controller
{
    public function footerView()
    {
        return view('footer.footer_list');
    }
    public function mediaView()
    {
        return view('footer.media_list');
    }
    public function aboutUsView()
    {
        return view('footer.about_us');
    }
    public function contactUsView()
    {
        return view('footer.contact_us');
    }

    public function footerSupportCreate(Request $post)
    {
        $post->validate([
            'user_id'    => 'required|integer',
            'categories' => 'nullable|array',
            'status'     => 'required|string',
        ]);

        $data = [
            'user_id' => $post->user_id,
            'status'  => $post->status,
        ];

        if ($post->has('categories') && is_array($post->categories)) {
            $data['support_heading'] = json_encode($post->categories);
        }

        if (!empty($post->id)) {
            $exists = DB::table('footer_support')->where('id', $post->id)->exists();

            if (!$exists) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Footer support not found',
                ], 404);
            }

            $updated = DB::table('footer_support')->where('id', $post->id)->update($data);

            return response()->json([
                'status'  => $updated ? 'success' : 'failed',
                'message' => $updated ? 'Footer support updated successfully' : 'Footer support not updated',
            ], $updated ? 200 : 400);
        }

        $inserted = DB::table('footer_support')->insert($data);

        return response()->json([
            'status'  => $inserted ? 'success' : 'failed',
            'message' => $inserted ? 'Footer support added successfully' : 'Footer support not added',
        ], $inserted ? 200 : 400);
    }
    public function aboutUsCreate(Request $post)
    {

        $post->validate([
            'title'       => 'required|string',
            'main_heading' => 'nullable|string',
            'heading'     => 'required|string',
            'description' => 'nullable|string',
            'button_text'      => 'nullable|string',
            'button_number'    => 'nullable|string',
            'status'           => 'required|string',
        ]);


        $existing = null;
        if (!empty($post->id)) {
            $existing = DB::table('about_us')->where('id', $post->id)->first();
        }

        $heroImage = $existing->hero_image ?? null;

        if ($post->hasFile('hero_image')) {
            $file = $post->file('hero_image');
            $upload = ImageHelper::imageUploadHelper('about_hero', $file);
            if ($upload['status']) {
                $heroImage = $upload['data']['target_file'];
            } else {
                return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
            }
        }

        $founders = [];

        if ($post->has('founders')) {
            foreach ($post->founders as $key => $founder) {
                $founderImage = null;

                if (!empty($existing->founders)) {
                    $oldFounders = json_decode($existing->founders, true);
                    if (isset($oldFounders[$key]['image'])) {
                        $founderImage = $oldFounders[$key]['image'];
                    }
                }

                if (isset($founder['image']) && $founder['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $upload = ImageHelper::imageUploadHelper('founders', $founder['image']);
                    if ($upload['status']) {
                        $founderImage = $upload['data']['target_file'];
                    }
                }

                $founders[] = [
                    'name'  => $founder['name'] ?? null,
                    'role'  => $founder['role'] ?? null,
                    'award' => $founder['award'] ?? null,
                    'image' => $founderImage,
                ];
            }
        }

        $data = [
            'user_id'         => $post->user_id,
            'title'           => $post->title,
            'main_heading'    => $post->main_heading,
            'heading'         => $post->heading,
            'description'     => $post->description,
            'button_text'     => $post->button_text,
            'button_number'   => $post->button_number,
            'hero_image'      => $heroImage,
            'founders'        => json_encode($founders),
            'status'          => $post->status,
        ];

        if ($existing) {
            DB::table('about_us')->where('id', $post->id)->update($data);
            $msg = 'About Us updated successfully';
        } else {
            DB::table('about_us')->insert($data);
            $msg = 'About Us added successfully';
        }

        return response()->json([
            'status'  => 'success',
            'message' => $msg
        ]);
    }

    public function saveGrievance(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'alt_mobile'    => 'nullable|numeric',
            'subject'       => 'required',
            'message'       => 'required|string',
            'attachment'    => 'nullable|file|mimes:jpg,jpeg,png|max:1024',

        ]);

        $user = DB::table('users')->where('mobile', $request->mobile)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your mobile number is not registered'
            ], 404);
        }

        $user_id = $user->id;


        $originalFile = null;
        $message = '';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ImageUpload = ImageHelper::imageUploadHelper('attachment', $file);

            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        $inserted  =    DB::table('grievances')->insert([
            'user_id'      => $user_id,
            'name'         => $request->name,
            'email'        => $request->email,
            'mobile'       => $request->mobile,
            'alt_mobile'   => $request->alt_mobile,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'attachment'   => $originalFile,
            'status'       => 'pending',

        ]);
        if ($inserted) {
            return response()->json(['status' => 'success', 'message' => 'Grievance details saved successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Grievance details Not saved'], 400);
        }
    }

    public function contactUsCreate(Request $post)
    {
        $post->validate([
            'heading'       => 'required|string',
            'description'   => 'nullable|string',
            'button_text'   => 'nullable|string',
            'button_number' => 'nullable|string',
            'status'        => 'required|string',
        ]);


        $existingRecord = DB::table('contacts')->first();


        if (empty($post->id) && $existingRecord) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Contact record already exists. Please edit the existing record.',
            ]);
        }

        $existing = null;
        if (!empty($post->id)) {
            $existing = DB::table('contacts')->where('id', $post->id)->first();
        }

        $contactImage = $existing->contact_image ?? null;

        if ($post->hasFile('contact_image')) {
            $upload = ImageHelper::imageUploadHelper('contact_image', $post->file('contact_image'));
            if ($upload['status']) {
                $contactImage = $upload['data']['target_file'];
            }
        }

        $programs = [];

        if ($post->has('programs') && is_array($post->programs)) {
            foreach ($post->programs as $p) {
                $programs[] = [
                    'text'  => $p['text'] ?? '',
                    'phone' => $p['phone'] ?? '',
                    'email' => $p['email'] ?? '',
                ];
            }
        }

        $officesArray = [];

        $oldOffices = [];
        if (!empty($existing->offices)) {
            $oldOffices = json_decode($existing->offices, true);
            if (!is_array($oldOffices)) $oldOffices = [];
        }

        if ($post->has('offices') && is_array($post->offices)) {

            foreach ($post->offices as $index => $item) {
                $officeImage = $oldOffices[$index]['image'] ?? null;

                if (!empty($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $upload = ImageHelper::imageUploadHelper('offices', $item['image']);
                    if ($upload['status']) {
                        $officeImage = $upload['data']['target_file'];
                    }
                }

                $officesArray[] = [
                    'city'    => $item['city'] ?? '',
                    'address' => $item['address'] ?? '',
                    'image'   => $officeImage,
                ];
            }
        }


        $data = [
            'user_id'       => $post->user_id,
            'heading'       => $post->heading,
            'description'   => $post->description,
            'button_text'   => $post->button_text,
            'button_number' => $post->button_number,
            'contact_image' => $contactImage,
            'programs'      => json_encode($programs),
            'offices'       => json_encode($officesArray),
            'status'        => $post->status,
        ];

        if ($existing) {
            DB::table('contacts')->where('id', $post->id)->update($data);
            $msg = "Contact updated successfully.";
        } else {

            DB::table('contacts')->insert($data);
            $msg = "Contact created successfully.";
        }

        return response()->json([
            'status'  => 'success',
            'message' => $msg,
        ]);
    }



    public function footerMediaCreate(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|integer',
            'media_heading'    => 'nullable|string|max:255',
            'media_name'       => 'required|string|max:255',
            'media_description' => 'required|string|max:500',
            'media_date'       => 'nullable|date',
            'status'           => 'required|string|in:active,inactive',
        ]);

        $data = [
            'user_id'           => $request->user_id,
            'media_heading'     => $request->media_heading,
            'media_name'        => $request->media_name,
            'media_description' => $request->media_description,
            'media_date'        => $request->media_date,
            'status'            => $request->status,
        ];

        if (!empty($request->id)) {
            $exists = DB::table('footer_media')->where('id', $request->id)->exists();

            if (!$exists) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Media record not found',
                ], 404);
            }

            $updated = DB::table('footer_media')->where('id', $request->id)->update($data);

            return response()->json([
                'status'  => $updated ? 'success' : 'failed',
                'message' => $updated ? 'Media updated successfully' : 'No changes made',
            ], $updated ? 200 : 400);
        }

        $data['created_at'] = now();
        $inserted = DB::table('footer_media')->insert($data);

        return response()->json([
            'status'  => $inserted ? 'success' : 'failed',
            'message' => $inserted ? 'Media added successfully' : 'Media not added',
        ], $inserted ? 200 : 400);
    }


    public function aboutUsEdit($id)
    {
        $data = DB::table('about_us')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $data->founders = !empty($data->founders) ? json_decode($data->founders, true) : [];
        if (!empty($data->hero_image)) {
            $data->hero_image = asset($data->hero_image);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function contactUsEdit($id)
    {
        $data = DB::table('contacts')->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        $data->programs = !empty($data->programs) ? json_decode($data->programs, true) : [];

        $data->offices = !empty($data->offices) ? json_decode($data->offices, true) : [];
        if (!empty($data->contact_image)) {
            $data->contact_image = asset($data->contact_image);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function show($id)
    {
        $about = AboutUs::findOrFail($id);
        $about->founders = json_decode($about->founders, true);
        return view('footer.aboutus_details', compact('about'));
    }
    public function showContactDetails($id)
    {
        $contact = ContactUs::findOrFail($id);
        $programs = json_decode($contact->programs, true);

        if (!is_array($programs)) {
            $programs = [];
        }

        $offices = json_decode($contact->offices, true);

        if (!is_array($offices)) {
            $offices = [];
        }
        return view('footer.contactus_details', compact('contact', 'programs', 'offices'));
    }


    public function showSupport($index)
    {
        // Get all active footer records
        $footers = DB::table('footer_support')->where('status', 'active')->get();

        if ($footers->isEmpty()) {
            abort(404, 'Support data not found');
        }

        $allCategories = [];
        foreach ($footers as $footer) {
            if (!empty($footer->support_heading)) {
                $decoded = json_decode($footer->support_heading, true);
                if (is_array($decoded)) {
                    $allCategories = array_merge($allCategories, $decoded);
                }
            }
        }

        // Now check if category index exists
        if (!isset($allCategories[$index])) {
            abort(404, 'Category not found');
        }

        $category = $allCategories[$index];

        return view('footer.support_details', compact('category'));
    }

    public function editFooterSupport($id)
    {
        $data = DB::table('footer_support')->find($id);

        if (!$data) {
            return response()->json(['status' => 'failed', 'message' => 'Record not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
