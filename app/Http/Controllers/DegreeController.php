<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Application;
use App\Models\Degree;
use App\Models\DegreeCategory;
use App\Models\Programme;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DegreeController extends Controller
{
    public function degreeView()
    {
        $categories = DegreeCategory::all();
        return view('degree.degreelist', compact('categories'));
    }
    public function degreeCategoryView()
    {
        $categoriestype = DB::table('degree_category_type')->where('status', 'active')
            ->orderBy('degree_category_type', 'asc')
            ->get();

        return view('degree.degree_category_list', compact('categoriestype'));
    }

    public function degreeCategoryCreate(Request $post)
    {
        $post->validate([
            'user_id' => 'required',
            'degree_category' => 'required',
            'degree_category_slug' => 'required',
            'degree_category_type' => 'required|array',
            'degree_category_icon' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
            'degree_category_icon_2' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $isUpdate = $post->filled('id');
        // dd($isUpdate);
        if ($isUpdate) {
            $degree = DB::table('degree_category')->where('id', $post->id)->first();
            // dd($degree);
            if (!$degree) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Degree category not found!'
                ], 404);
            }
        } else {

            $exists = DB::table('degree_category')
                ->where('degree_category', $post->degree_category)
                ->orWhere('degree_category_slug', $post->degree_category_slug)
                ->exists();
            if ($exists) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category or slug already exists!'
                ], 400);
            }
        }

        $originalFile = $isUpdate ? $degree->degree_category_icon : '';
        $message = '';
        $originalFile_2 = $isUpdate ? $degree->degree_category_icon_2 : '';
        $message = '';

        if ($post->hasFile('degree_category_icon')) {
            $file = $post->file('degree_category_icon');
            $ImageUpload = ImageHelper::imageUploadHelper('degree_category_icon', $file);
            if ($ImageUpload['status']) {
                $originalFile = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }
        if ($post->hasFile('degree_category_icon_2')) {
            $file = $post->file('degree_category_icon_2');
            $ImageUpload = ImageHelper::imageUploadHelper('degree_category_icon_2', $file);
            if ($ImageUpload['status']) {
                $originalFile_2 = $ImageUpload['data']['target_file'];
            } else {
                $message = $ImageUpload['message'];
            }
        }

        $data = [
            'user_id' => $post->user_id,
            'degree_category' => $post->degree_category,
            'degree_category_slug' => $post->degree_category_slug,
            'degree_category_type' => json_encode($post->degree_category_type),
            'degree_category_icon' => $originalFile,
            'degree_category_icon_2' => $originalFile_2,
            'status' => $post->status,
        ];

        if ($isUpdate) {
            DB::table('degree_category')->where('id', $post->id)->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Degree Category updated successfully'
            ], 200);
        } else {

            DB::table('degree_category')->insert($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Degree Category added successfully'
            ], 200);
        }
    }

    public function degreeCategoryTypeCreate(Request $post)
    {
        //    dd($post->all());
        $post->validate([
            'user_id' => 'required',
            'degree_category_type' => 'required|string',
            'degree_category_type_slug' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $isUpdate = $post->filled('id');

        if ($isUpdate) {
            $degree = DB::table('degree_category_type')->where('id', $post->id)->first();

            if (!$degree) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Degree category not found!'
                ], 404);
            }

            $data = [
                'user_id' => $post->user_id,
                'degree_category_type' => $post->degree_category_type,
                'degree_category_type_slug' => $post->degree_category_type_slug,
                'status' => $post->status,
            ];

            DB::table('degree_category_type')->where('id', $post->id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Degree Category updated successfully'
            ], 200);
        } else {
            $exists = DB::table('degree_category_type')
                ->where('degree_category_type', $post->degree_category_type)
                ->orWhere('degree_category_type_slug', $post->degree_category_type_slug)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category or slug already exists!'
                ], 400);
            }

            $data = [
                'user_id' => $post->user_id,
                'degree_category_type' => $post->degree_category_type,
                'degree_category_type_slug' => $post->degree_category_type_slug,
                'status' => $post->status,
            ];

            DB::table('degree_category_type')->insert($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Degree Category added successfully'
            ], 200);
        }
    }



    public function addUniversities(Request $post)
    {
        $post->validate([
            'user_id'             => 'required',
            'degree_category'     => 'required',
            'type'                => 'required',
            'university_name'     => 'required',
            'degree_name'         => 'required',
            'degree_description'  => 'required',
            'deadline_date'       => 'required|date',
            'degree_duration'     => 'required',
            'helpline_number'     => 'required',
            'university_icon_1'   => $post->id
                ? 'nullable|file|mimes:jpg,jpeg,png|max:1024'
                : 'required|file|mimes:jpg,jpeg,png|max:1024',
            'university_icon_2'   => $post->id
                ? 'nullable|file|mimes:jpg,jpeg,png|max:1024'
                : 'required|file|mimes:jpg,jpeg,png|max:1024',
            'degree_overview'     => 'nullable',
            'newcourse_1'         => 'nullable',
            'newcourse_2'         => 'nullable',
            'bestseller'          => 'required',
            'key_highlight'       => 'nullable',
            'career_outcome'      => 'nullable',
            'course_learners'     => 'required',
            'course_hours'        => 'required',
            'compare_degree'      => 'nullable',
            'free_copilot'        => 'nullable',
            'transform_career'    => 'nullable|array',
            'course_starting_at'  => 'nullable',
            'course_total_amount' => 'nullable',
            'course_inclusions'   => 'nullable|array',
            'categories'          => 'nullable|array',
            'status'              => 'required',
        ]);

        $data = [
            'user_id'             => $post->user_id,
            'degree_category'     => $post->degree_category,
            'type'                => $post->type,
            'university_name'     => $post->university_name,
            'degree_name'         => $post->degree_name,
            'degree_description'  => $post->degree_description,
            'deadline_date'       => date('Y-m-d', strtotime($post->deadline_date)),
            'course_learners'     => $post->course_learners,
            'course_hours'        => $post->course_hours,
            'newcourse_1'         => $post->newcourse_1,
            'newcourse_2'         => $post->newcourse_2,
            'bestseller'          => $post->bestseller,
            'degree_duration'     => $post->degree_duration,
            'helpline_number'     => $post->helpline_number,
            'degree_overview'     => $post->degree_overview,
            'key_highlight'       => $post->key_highlight,
            'career_outcome'      => $post->career_outcome,
            'compare_degree'      => $post->compare_degree,
            'free_copilot'        => $post->free_copilot,
            'transform_career'    => json_encode($post->transform_career),
            'course_starting_at'  => $post->course_starting_at,
            'course_total_amount' => $post->course_total_amount,
            'course_inclusions'   => json_encode($post->course_inclusions),
            'status'              => $post->status,
        ];
        if ($post->has('categories') && is_array($post->categories)) {
            $data['faqs'] = json_encode($post->categories);
        }

        if ($post->id) {
            $university = DB::table('universities')->where('id', $post->id)->first();

            if (!$university) {
                return response()->json(['status' => 'failed', 'message' => 'University not found'], 404);
            }

            if ($post->hasFile('university_icon_1')) {
                $file = $post->file('university_icon_1');
                $upload = ImageHelper::imageUploadHelper('university_icon_1', $file);
                if ($upload['status']) {
                    $data['degree_category_icon'] = $upload['data']['target_file'];
                } else {
                    return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
                }
            } else {
                $data['degree_category_icon'] = $university->degree_category_icon;
            }

            if ($post->hasFile('university_icon_2')) {
                $file = $post->file('university_icon_2');
                $upload = ImageHelper::imageUploadHelper('university_icon_2', $file);
                if ($upload['status']) {
                    $data['university_icon_2'] = $upload['data']['target_file'];
                } else {
                    return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
                }
            } else {
                $data['university_icon_2'] = $university->university_icon_2;
            }

            $updated = DB::table('universities')->where('id', $post->id)->update($data);

            return response()->json([
                'status'  => $updated ? 'success' : 'failed',
                'message' => $updated ? 'University updated successfully' : 'University not updated',
            ], $updated ? 200 : 400);
        }

        // --- INSERT CASE ---
        if ($post->hasFile('university_icon_1')) {
            $file = $post->file('university_icon_1');
            $upload = ImageHelper::imageUploadHelper('university_icon_1', $file);
            if ($upload['status']) {
                $data['degree_category_icon'] = $upload['data']['target_file'];
            } else {
                return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
            }
        }

        if ($post->hasFile('university_icon_2')) {
            $file = $post->file('university_icon_2');
            $upload = ImageHelper::imageUploadHelper('university_icon_2', $file);
            if ($upload['status']) {
                $data['university_icon_2'] = $upload['data']['target_file'];
            } else {
                return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
            }
        }

        $inserted = DB::table('universities')->insert($data);

        return response()->json([
            'status'  => $inserted ? 'success' : 'failed',
            'message' => $inserted ? 'University added successfully' : 'University not added',
        ], $inserted ? 200 : 400);
    }



    public function addProgramme(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'degree_category' => 'required',
            'degree_title' => 'required',
            'programme_icon' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
            'degree_description' => 'required',
            'degree_inclusions' => 'required|array',
            'helpline_number' => 'required',
            'degree_overview' => 'nullable',
            'key_highlight' => 'nullable',
            'career_outcome' => 'nullable',
            'compare_degree' => 'nullable',
            'free_copilot' => 'nullable',
            'status' => 'nullable',
        ]);

        $programmeId = $request->id;
        $programme = $programmeId ? Programme::find($programmeId) : null;

        if ($request->hasFile('programme_icon')) {
            $file = $request->file('programme_icon');
            $upload = ImageHelper::imageUploadHelper('programme_icon', $file);
            if ($upload['status']) {
                $imageName = $upload['data']['target_file'];
            } else {
                return response()->json(['status' => 'failed', 'message' => $upload['message']], 400);
            }
        } else {
            $imageName = $programme ? $programme->programme_icon : null;
        }

        $data = [
            'user_id' => $request->user_id,
            'degree_category' => $request->degree_category,
            'degree_title' => $request->degree_title,
            'programme_icon' => $imageName,
            'degree_description' => $request->degree_description,
            'degree_inclusions' => json_encode($request->degree_inclusions),
            'helpline_number' => $request->helpline_number,
            'degree_overview' => $request->degree_overview,
            'key_highlight' => $request->key_highlight,
            'career_outcome' => $request->career_outcome,
            'compare_degree' => $request->compare_degree,
            'free_copilot' => $request->free_copilot,
            'status' => $request->status ?? 'active',
        ];

        if ($programme) {
            $programme->update($data);
            $message = 'Programme updated successfully';
        } else {
            Programme::create($data);
            $message = 'Programme added successfully';
        }

        return response()->json(['status' => 'success', 'message' => $message], 200);
    }

    public function showAll($id, $type)
    {
        $category = DegreeCategory::find($id);

        $data = University::where('degree_category', $id)
            ->where('type', $type)
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->get();
        // dd($data, $type, $category);
        return view('education.view_all_category', compact('category', 'data', 'type'));
    }


    public function getDetails($id)
    {
        $category = DegreeCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $category->id,
                'degree_category' => $category->degree_category,
                'degree_category_slug' => $category->degree_category_slug,
                'degree_category_type' => json_decode($category->degree_category_type),
                'status' => $category->status
            ]
        ]);
    }


    public function getDetailsUniversity($id)
    {
        $university = University::find($id);
        if (!$university) {
            return response()->json(['success' => false, 'message' => 'Not found']);
        }
        $category = DegreeCategory::find($university->degree_category);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Not found degree']);
        }
        $faqs = json_decode($university->faqs ?? '[]', true) ?? [];
        if (!empty($faqs) && is_array($faqs)) {
            $faqs = array_values($faqs);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $university->id,
                'degree_category_id' => $category ? $category->id : null,
                'degree_category' => $category->degree_category,
                'type' => $university->type,
                'university_name' => $university->university_name,
                'degree_name' => $university->degree_name,
                'status' => $university->status,
                'bestseller' => $university->bestseller,
                'newcourse_1' => $university->newcourse_1,
                'newcourse_2' => $university->newcourse_2,
                'degree_description' => $university->degree_description,
                'degree_duration' => $university->degree_duration,
                'deadline_date' => $university->deadline_date,
                'course_learners' => $university->course_learners,
                'course_hours' => $university->course_hours,
                'helpline_number' => $university->helpline_number,
                'course_starting_at' => $university->course_starting_at,
                'course_total_amount' => $university->course_total_amount,
                'degree_overview' => $university->degree_overview,
                'key_highlight' => $university->key_highlight,
                'career_outcome' => $university->career_outcome,
                'compare_degree' => $university->compare_degree,
                'free_copilot' => $university->free_copilot,
                'why_should_choose' => $university->why_should_choose,
                'transform_career' => json_decode($university->transform_career),
                'course_inclusions' => json_decode($university->course_inclusions),
                'faqs' => $faqs,
            ]
        ]);
    }

    public function getProgrammeDetails($id)
    {
        $programme = Programme::find($id);

        if (!$programme) {
            return response()->json([
                'success' => false,
                'message' => 'Programme not found'
            ]);
        }
        $category = DegreeCategory::find($programme->degree_category);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Not found degree']);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $programme->id,
                'degree_category_id' => $category ? $category->id : null,
                'degree_category' => $category->degree_category,
                'degree_title' => $programme->degree_title,
                'programme_icon' => $programme->programme_icon,
                'degree_description' => $programme->degree_description,
                'degree_inclusions' => json_decode($programme->degree_inclusions) ?? [],
                'helpline_number' => $programme->helpline_number,
                'status' => $programme->status,
                'degree_overview' => $programme->degree_overview,
                'key_highlight' => $programme->key_highlight,
                'career_outcome' => $programme->career_outcome,
                'compare_degree' => $programme->compare_degree,
                'free_copilot' => $programme->free_copilot,
                'why_should_choose' => $programme->why_should_choose,
            ]
        ]);
    }


    public function showVertical($id)
    {
        $datas = University::where('status', 'active')->where('degree_category', $id)->get();
        $data = DB::table('degree_category as dc')
            ->join('programmes as p', 'dc.id', '=', 'p.degree_category')
            ->where('dc.id', $id)
            ->where('dc.status', 'active')
            ->where('p.status', 'active')
            ->select('dc.*', 'p.*')
            ->first();
        $alldata = University::where('status', 'active')->get();
        $degreeCategories = DegreeCategory::where('status', 'active')->get();
        $programTypes = University::select('type')->where('status', 'active')->distinct()->pluck('type');
        $courses = University::where('status', 'active')->paginate(10);

        return view('degree.programme_details', compact('data', 'datas', 'alldata', 'degreeCategories', 'programTypes', 'courses'));
    }

    public function showProgramme()
    {
        $cat = DB::table('degree_category')->where('status', 'active')->get();
        return view('degree.programme_list', compact('cat'));
    }

    public function degreeCreate(Request $post)
    {
        $post->validate([
            'user_id' => 'required',
            'category' => 'required',
            'degree_name' => 'required',
            'university_name' => 'required',
            'university_icon' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $up['user_id'] = $post->user_id;
        $up['category'] = $post->category;
        $up['degree_name'] = $post->degree_name;
        $up['university_name'] = $post->university_name;
        $up['status'] = 'active';

        if ($post->hasFile('university_icon')) {
            $file = $post->file('university_icon');
            $originalFile = time() . '_' . $file->getClientOriginalName();

            $destinationPath = public_path('img');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $originalFile);
            $up['university_icon'] = 'img/' . $originalFile;
        }



        if ($post->id) {
            $degree = Degree::where('id', $post->id)->update($up);
        } else {
            $degree = Degree::create($up);
        }


        if ($degree) {
            return response()->json(['status' => 'success', 'message' => 'Degree Details added successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Degree Details not added'], 400);
        }
    }
    public function show($id)
    {
        $data['programme'] = University::where('status', 'active')->findOrFail($id);
        $data['degree'] = DegreeCategory::select('degree_category')->where('id', $data['programme']->degree_category)->where('status', 'active')->first();

        $data['categories'] = DegreeCategory::all();

        foreach ($data['categories'] as $cat) {
            $cat->programmes = University::where('degree_category', $cat->id)->where('status', 'active')
                ->get()
                ->groupBy('programme_type');
        }
        $hasPendingApplication = false;

        if (\Auth::check()) {
            $hasPendingApplication = Application::where('user_id', \Auth::id())
                ->where('course_id', $id)
                ->where('payment_status', '!=', 'paid')
                ->exists();
        }

        $data['hasPendingApplication'] = $hasPendingApplication;

        return view('degree.viewdegree')->with($data);
    }
}
