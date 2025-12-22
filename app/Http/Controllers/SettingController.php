<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ImageHelper;
use App\Helpers\WhatsAppSend;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Circle;
use App\Models\Community;
use App\Models\DegreeCategory;
use App\Models\Department;
use App\Models\Grievance;
use App\Models\HomePageSetting;
use App\Models\LearnerSupport;
use App\Models\Programme;
use App\Models\Role;
use App\Models\SalaryDetail;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\University;
use App\Models\User as ModelsUser;
use App\Services\BankServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    protected $bankVerification;
    public function __construct()
    {
        $this->bankVerification = new BankServices;
    }
    public function getmembers($id)
    {
        $data['teamMembers'] = TeamMember::where('team_id', $id)->get();

        // $userIds = $teamMembers->pluck('user_id');
        // $data['teamMember'] = $teamMembers;
        // $userData =  User::whereIn('id', $userIds)->get();
        // $departmentIds =  $userData->pluck('department_id');

        // $data['user'] =  $userData;
        // $data['team'] = Team::where('id', $id)->get();
        // $data['department'] = Department::where('id', $departmentIds)->get();
        return view('master.members')->with($data);
    }

    public function targetstore(Request $request)
    {

        $validated = $request->validate([
            'type' => 'required|in:Fixed,Percentage',
            'min_value' => 'required|numeric|min:0',
            'max_value' => 'required|numeric|gt:min_value',
            'commission' => 'required|numeric|min:0',
        ], [
            'type.required' => 'Target type is required.',
            'type.in' => 'Invalid target type selected.',
            'min_value.required' => 'Minimum value is required.',
            'max_value.gt' => 'Maximum value must be greater than minimum value.',
            'commission.min' => 'Commission must be a positive number.',
        ]);
        DB::table('team_member_target')->updateOrInsert(
            [
                'member_id' => $request->member_id,
                'team_name' => $request->team_name,
            ],
            [
                'user_id' => $request->user_id,
                'member_id' => $request->member_id,
                'type' => $request->type,
                'team_id' => $request->team_id,
                'member_name' => $request->member_name,
                'min_value' => $request->min_value,
                'max_value' => $request->max_value,
                'commission' => $request->commission,

            ]
        );

        return response()->json(['status' => 'success', 'message' => 'Target Set successfully!']);
    }
    public function index(Request $get, $id = 0)
    {
        $data = [];
        $data['tab'] = $get->tab;
        if ($id != 0) {
            $data['user'] = User::find($id);
        } else {
            $data['user'] = \Auth::user();
        }


        if (\Myhelper::hasRole('admin')) {
            $data['parents'] = User::whereHas('role', function ($q) {
                $q->where('slug', '!=', 'employee');
            })->get(['id', 'name', 'role_id', 'mobile']);

            $data['roles'] = Role::where('slug', '!=', 'admin')->get();
        } else if (\Myhelper::hasRole('employee')) {
            $data['salaryDet'] = SalaryDetail::where('emp_id', Auth::user()->agentcode)->get();
            $data['parents'] = [];
            $data['roles'] = [];
        } else {
            $data['parents'] = [];
            $data['roles'] = [];
        }

        $data['state'] = Circle::all(['state']);

        return view('profile.index')->with($data);
    }

    public function certificate()
    {
        return view('certificate');
    }
    public function getPrimaryList()
    {
        return view('goals.primary_color');
    }

    public function saveHomepageData(Request $request)
    {
        $setting = HomePageSetting::first();
        if (!$request->id && $setting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record already exists. Please edit.'
            ]);
        }

        if ($request->id) {

            $setting = HomePageSetting::find($request->id);
            $setting->update($request->all());
        } else {

            HomePageSetting::create($request->all());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Homepage Settings Saved Successfully'
        ]);
    }


    public function homepageView()
    {
        $settingExists = HomePageSetting::count() > 0;
        return view('tools.homepage_settings', compact('settingExists'));
    }
    
            public function getDataLearnerSupport($id)
        {
            $data = LearnerSupport::findOrFail($id);
            return response()->json(['data' => $data]);
        }


    public function searchData(Request $request)
    {
        $query = $request->input('query');


        $degreeCategories = DegreeCategory::where('status', 'active')->get();

        $universities = University::where('status', 'active')
            ->distinct()
            ->pluck('university_name');

        $courses = University::where('status', 'active')->paginate(10);
        // dd($courses);
        $programTypes = University::select('type')
            ->where('status', 'active')
            ->distinct()
            ->pluck('type');
        $query = $request->input('query');

        $courses = University::query()
            ->where('status', 'active')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('university_name', 'LIKE', "%{$query}%")
                        ->orWhere('degree_name', 'LIKE', "%{$query}%")
                        ->orWhere('type', 'LIKE', "%{$query}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);



        return view('goals.search_result', compact('universities', 'degreeCategories', 'courses', 'programTypes'))->render();
    }

    public function filterCourses(Request $request)
    {
        // dd($request->all());
        $query = University::query()->where('status', 'active');

        if ($request->has('degree_category') && !empty($request->degree_category)) {
            $query->whereIn('degree_category', $request->degree_category);
        }

        if ($request->has('university') && !empty($request->university)) {
            $query->whereIn('university_name', $request->university);
        }

        if ($request->has('program_type') && !empty($request->program_type)) {
            $query->whereIn('type', $request->program_type);
        }

        if ($request->has('duration') && !empty($request->duration)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->duration as $duration) {
                    switch ($duration) {
                        case '1-3':
                            $q->orWhereBetween('degree_duration', [1, 3]);
                            break;
                        case '3-6':
                            $q->orWhereBetween('degree_duration', [3, 6]);
                            break;
                        case '6-12':
                            $q->orWhereBetween('degree_duration', [6, 12]);
                            break;
                        case '12-18':
                            $q->orWhereBetween('degree_duration', [12, 18]);
                            break;
                        case '18+':
                            $q->orWhere('degree_duration', '>', 18);
                            break;
                    }
                }
            });
        }


        $courses = $query->orderBy('id', 'desc')->paginate(10);

        return view('goals.course_search_list', compact('courses'))->render();
    }


    public function addPrimaryColor(Request $request)
    {
        $request->validate([
            'primary_color' => 'required|string'
        ]);

        $color = $request->primary_color;
        $path = base_path('.env');

        $updated = false;

        if (file_exists($path)) {
            $env = file_get_contents($path);


            if (preg_match('/^PRIMARY_COLOR=.*$/m', $env)) {
                $env = preg_replace('/^PRIMARY_COLOR=.*$/m', "PRIMARY_COLOR='{$color}'", $env);
            } else {
                $env .= "\nPRIMARY_COLOR='{$color}'";
            }

            file_put_contents($path, $env);
            $updated = true;
        }

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Primary color updated successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Color. Please try again.',
            ]);
        }
    }



    public function department()
    {
        if (!\Myhelper::hasRole('admin')) {
            return redirect('unauthorized');
        }
        return view('master.department');
    }
    public function team(Request $request)
    {
        if (!\Myhelper::hasRole('admin')) {
            return redirect('unauthorized');
        }
        $data['salesUser'] = User::where('department_id', 2)->get();

        return view('master.team')->with($data);
    }
    public function banklist(Request $request)
    {
        $bank = Bank::where('is_verify', 'yes')->where('user_id', Auth::user()->id)->get();
        //    dd($bank);
        return view('bank.banklist', compact('bank'));
    }

    public function deleteBank($id)
    {
        try {
            $bank = Bank::findOrFail($id);
            $bank->delete();

            return response()->json([
                'status' => true,
                'message' => 'Bank deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete bank: ' . $e->getMessage()
            ], 500);
        }
    }
    public function upicollect()
    {

        return view('bank.upicollect');
    }
    public function vanlist(Request $request)
    {
        $bank = Bank::where('is_verify', 'yes')->where('user_id', Auth::user()->id)->get();
        //    dd($bank);
        return view('bank.vanlist', compact('bank'));
    }


    public function verifybank(Request $request)
    {

        $request->validate([
            'ac' => 'required|digits_between:9,18',
            'ifsc' => 'required|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/',
        ]);

        $request['clientrefId'] = 'REF' . mt_rand(100000000, 999999999);

        $result = $this->bankVerification->doBankVerify($request);
        $resp = json_decode($result['response']);
        // dd($resp);
        if ($result['code'] == 200 && isset($resp->data)) {

            DB::table('user_banks')
                ->where('account_number', $resp->data->accountNumber)
                ->update([
                    'verify_name' => $resp->data->accountHolderName,
                    'is_verify' => 'yes',
                ]);

            return response()->json([
                'status' => $resp->status ?? "SUCCESS",
                'data' => $resp->data,
                'message' => $resp->message ?? "Bank Verified Successfully"
            ]);
        } else {
            return response()->json([
                'status' => "failed",
                'message' => $result['message'] ?? "Bank not verified, try again"
            ]);
        }
    }

    // public function createVirtual(Request $request)
    // {
    //     $request->validate([
    //         'ac' => 'required|digits_between:9,18', 
    //         'ifsc' => 'required|regex:/^[A-Za-z]{4}[a-zA-Z0-9]{7}$/', 
    //     ]);

    //     $request['clientrefId'] = 'REF' . mt_rand(100000000, 999999999);

    //     $result = $this->virtualAccount->createVirtual($request);
    //     $resp = json_decode($result['response']);

    // }


    public function teamlist(Request $request)
    {
        $data['team'] = Team::all();
        $data['salesUser'] = User::where('department_id', 2)->get();
        return view('master.teamlist')->with($data);
    }

    public function commission($id)
    {

        $commissions = $id->commissions()->get();
        return view('master.commission', compact('commissions', 'id'));
    }

    public function destroy($id)
    {

        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not found.'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Department deleted successfully.'
        ]);
    }



    public function createTeam(Request $request)
    {
        $request->validate([
            'team' => 'required|string|max:255|unique:teams,team_name',
        ]);

        $inst = Team::create([
            'user_id' => auth()->id(),
            'team_name' => $request->team,
        ]);

        TeamMember::create([
            'team_id' => $inst->id,
            'user_id' => $inst->user_id,
        ]);
        if ($inst) {
            return response()->json(['status' => 'success', 'message' => 'Team added successfully!']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Team not Added']);
        }
    }

    public function createBank(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required',
            'bank_name' => 'required|string',
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'status' => 'required',
        ], [
            'type.required' => 'Please select type',
            'type.in' => 'Invalid target type selected.',
            'bank_name.required' => 'Please enter bank name',
            'account_number.required' => 'Please enter bank account no.',
            'ifsc_code.required' => 'IFSC code is required.',
        ]);

        $userId = \Auth::id();
        $isUpdate = false;

        if ($request->filled('id')) {
            $existing = DB::table('user_banks')->where('id', $request->id)->where('user_id', $userId)->first();
            if ($existing) {
                $isUpdate = true;
            }
        }

        $duplicate = DB::table('user_banks')
            ->where('user_id', $userId)
            ->where('account_number', $request->account_number)
            ->when($isUpdate, function ($query) use ($request) {
                return $query->where('id', '!=', $request->id);
            })
            ->first();

        if ($duplicate) {
            return response()->json(['status' => 500, 'message' => 'Account already exists']);
        }


        DB::table('user_banks')->updateOrInsert(
            ['id' => $request->id],
            [
                'user_id' => $userId,
                'name' => $request->name,
                'type' => $request->type,
                'bank_name' => $request->bank_name,
                'is_verify' => 'no',
                'added_van_details' => 'no',
                'van_created' => 'no',
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'status' => $request->status,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => $isUpdate ? 'Bank updated successfully!' : 'Bank added successfully!'
        ]);
    }



    public function createcommission(Request $request)
    {
        $request->validate([
            'team' => 'required|string|max:255|unique:teams,team_name',
        ]);

        $inst = Team::create([
            'user_id' => auth()->id(),
            'team_name' => $request->team,
        ]);

        TeamMember::create([
            'team_id' => $inst->id,
            'user_id' => $inst->user_id,
        ]);
        if ($inst) {
            return response()->json(['status' => 'success', 'message' => 'Team added successfully!']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Team not Added']);
        }
    }


    public function addteamMember(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'team_member_id' => 'required|exists:users,id',
        ]);

        $exists = TeamMember::where('team_id', $request->team_id)
            ->where('user_id', $request->team_member_id)
            ->exists();


        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'User is already a member of this team.']);
        }

        $inst = TeamMember::create([
            'team_id' => $request->team_id,
            'user_id' => $request->team_member_id,
        ]);
        if ($inst) {
            return response()->json(['status' => 'success', 'message' => 'Team Member added successfully!']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Team Member not Added']);
        }
    }


    public function addForm(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        if ($request->has('id') && !empty($request->id)) {
            DB::table('department')
                ->where('id', $request->id)
                ->update([
                    'department_name' => $request->department,
                ]);

            return response()->json(['status' => 'success', 'message' => 'Department updated successfully!']);
        } else {
            DB::table('department')->insert([
                'user_id' => auth()->id(),
                'department_name' => $request->department,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Department added successfully!']);
        }
    }


    public function profileUpdate(Request $post)
    {
        if ($post->actiontype != "password" && (\Auth::id() != $post->id) && !in_array($post->id, \Myhelper::getParents(\Auth::id()))) {
            //  return response()->json(['status' => "Permission Not Alloweds"], 400);  //&& \Myhelper::hasNotRole('admin') && \Myhelper::hasNotRole('admin')
        }
        // dd($post->actiontype ,\Auth::id());
        switch ($post->actiontype) {
            case 'password':

                if (($post->id != \Auth::id()) && !\Myhelper::can('member_password_reset')) {
                    return response()->json(['status' => "Permission Not Allowed"], 400);
                }

                if (($post->id == \Auth::id()) && !\Myhelper::can('password_reset')) {
                    return response()->json(['status' => "Permission Not Allowed"], 400);
                }

                if (\Myhelper::hasNotRole('admin')) {
                    $credentials = [
                        'mobile' => \Auth::user()->mobile,
                        'password' => ($post->oldpassword)
                    ];

                    if (!\Auth::validate($credentials)) {
                        return response()->json(['errors' => ['oldpassword' => 'Please enter corret old password']], 422);
                    }
                }

                $post['passwordold'] = bcrypt($post->password);
                $post['password'] = bcrypt($post->password);
                $post['resetpwd'] = "changed";

                break;

            case 'profile':
                if (($post->id != \Auth::id()) && !\Myhelper::can('member_profile_edit')) {
                    return response()->json(['status' => "Permission Not Allowed"], 400);
                }

                if (($post->id == \Auth::id()) && !\Myhelper::can('profile_edit')) {
                    return response()->json(['status' => "Permission Not Allowed"], 400);
                }


                if ($post->hasFile('profiles')) {
                    $file = request()->file('profiles');
                    $ImageUpload = ImageHelper::imageUploadHelper('profiles', $file);
                    if ($ImageUpload['status']) {
                        $post['profile'] = @$ImageUpload['data']['target_file'];
                    } else {
                        return response()->json(['status' => @$ImageUpload['message'] ?? "Task Failed, please try again"], 200);
                    }
                }
                break;
        }

        unset($post->mobile);
        unset($post->name);
        unset($post->email);
        // unset($post->password);
        // unset($post->oldpassword);

        if (@$post->actiontype == 'kyc') {
            if (!in_array(@$post->kyc, ['pending', 'verified'])) {
                unset($post->kyc);
            }
            // $getUser = User::where('id', $post->id)->first();
            // if ($getUser) {
            //     $arr = ["mobile" => $getUser->mobile, "var2" => $getUser->mobile, "var3" => $post->kyc];
            //     $sms = AndroidCommonHelper::sendEmailAndOtp("kycApproved", $arr);
            // }
        }



        $response = User::where('id', $post->id)->updateOrCreate(['id' => $post->id], $post->all());
        if ($response) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'fail'], 400);
        }
    }
    private static function _curlCall($url, $params_array, $method, $header)
    {
        //    dd($url, $params_array, $method, $header);
        $cURL = curl_init();

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        curl_setopt_array(
            $cURL,
            array(
                CURLOPT_URL => $url,
                CURLOPT_POST => $method,
                CURLOPT_POSTFIELDS => $params_array,

                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => $header
            )
        );

        $result = curl_exec($cURL);

        if (curl_errno($cURL)) {
            $cURL_error = curl_error($cURL);
            if (empty($cURL_error))
                $cURL_error = 'Server Error';

            return array(
                'curl_status' => 0,
                'error' => $cURL_error
            );
        }

        $result = trim($result);
        $result_response = json_decode($result);

        return $result_response;
    }
}
