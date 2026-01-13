<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Android\MatmController;
use App\Http\Controllers\Android\StatusCheckController;
use Illuminate\Http\Request;
use App\Models\Utiid;
use Carbon\Carbon;
use App\Models\Report;
use App\Models\Aepsreport;
use App\Models\Aepsfundrequest;
use App\Models\Microatmreport;
use App\Models\User;
use App\Models\Provider;
use App\Models\Agents;
use App\Models\Announcements;
use App\Models\PortalSetting;
use App\Models\Api;
use App\Models\BeneRegistration;
use App\Models\Adminprofit;
use App\Models\AepsTxnReports;
use App\Models\Aepsuser;
use App\Repo\AEPSRepo;
use App\Repo\BillPaymentRepo;
use App\Repo\MATMRepo;
use App\Repo\RechargeRepo;
use App\Services\AEPS\IydaAEPSService;
use App\Services\BillPayments\IYDABillPaymentService;
use App\Services\Payout\IYDAPayoutService;
use App\Services\Recharge\IYDARechargeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;

class CommonController extends Controller
{
	protected $rechargeService, $recodemaker,
		$billpayrepo, $callIydaBillpay, $payoutService, $aepsService,
		$billpayService, $statusCheckController, $matmController, $aepsRepo, $roleId;
	function __construct()
	{
		//$this->rechargeService = new IYDARechargeService;
		// $this->recodemaker = new RechargeRepo;
		// $this->billpayrepo = new BillPaymentRepo;
		// $this->callIydaBillpay = new IYDABillPayController;
		// $this->payoutService = new IYDAPayoutService;
		// $this->aepsService = new IydaAEPSService;
		// $this->billpayService = new IYDABillPaymentService;
		// $this->statusCheckController = new StatusCheckController;
		// $this->matmController = new MatmController;
		// $this->aepsRepo = new AEPSRepo;


	}


	public function index(Request $post)
	{
		return view('matchingpercent');
	}

	public function store(Request $post)
	{
		$rules = array(
			'match' => 'required|numeric|min:1|max:100'
		);

		$validator = \Validator::make($post->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}
		$action = DB::table('beneregistrations')->where('id', $post->id)->where('name_match_percent', '<=', 70)->update(['name_match_percent' => $post->match]);
		return response()->json(['status' => "success", 'message' => 'Updated Successfully'], 200);
	}

	public function fetchData(Request $request, $type, $id = 0, $returntype = "all")
	{
		$request['return'] = 'all';
		$this->roleId = $id;
		$request['returntype'] = $returntype;
		$parentData = \Myhelper::getParents($id);
		// dd($type);
		switch ($type) {

			case 'tickets':
				$request['table'] = '\App\Models\Ticket';
				$request['searchdata'] = [
					'id',
					'ticket_id',
					'name',
					'email',
					'plateform',
					'subject',
					'priority',
					'status',
					'user_id',
					'description',
					'assign_by',
					'assign_to'
				];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else if (\Myhelper::hasRole('api')) {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'partner_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'assigntickets':
				$request['table'] = '\App\Models\AssignTicket';
				$request['searchdata'] = ['id', 'ticket_id', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else if (\Myhelper::hasRole('api')) {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'replytickets':
				$request['table'] = '\App\Models\ReplyTicket';
				$request['searchdata'] = ['id', 'ticket_id', 'assign_to', 'emp_id', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else if (\Myhelper::hasRole('api')) {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'partner_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'festivaldetails':
				$request['table'] = '\App\Models\FestivalDetail';
				$request['searchdata'] = ['id', 'emp_id', 'festival_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'chatTemplate':
				$request['table'] = '\App\Models\ChatTemplate';
				$request['searchdata'] = ['id', 'template_id', 'template_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'salarydetails':
				$request['table'] = '\App\Models\SalaryDetail';
				$request['searchdata'] = ['id', 'emp_id', 'basic_salary'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'emp_id';

				break;

			case 'getmembers':

				$request['table'] = '\App\Models\TeamMember';
				$request['searchdata'] = ['id', 'user_id', 'team_id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';

				break;
			case 'getstatus':

				$request['table'] = '\App\Models\Ticket';
				$request['searchdata'] = ['id', 'ticket_id', 'assign_to', 'plateform', 'priority', 'description', 'status', 'created_at'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';

				break;

			case 'team':
				$request['table'] = '\App\Models\Team';
				$request['searchdata'] = ['id', 'user_id', 'team_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}

				break;
			case 'banklist':
				$request['table'] = '\App\Models\Bank';
				$request['searchdata'] = ['id', 'bank_name', 'name', 'verify_name', 'type', 'bank_name', 'account_number', 'ifsc_code'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;
			case 'degree':
				$request['table'] = '\App\Models\University';
				$request['searchdata'] = ['id', 'degree_name', 'description'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}

				break;

			case 'announcements':
				$request['table'] = '\App\Models\Announcements';
				$request['searchdata'] = ['id', 'header_1', 'btn_text'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}

				break;

			case 'degreecategory':
				$request['table'] = '\App\Models\DegreeCategory';
				$request['searchdata'] = ['id', 'degree_category'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'slider':
				$request['table'] = '\App\Models\Slider';
				$request['searchdata'] = ['id', 'title', 'subtitle'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'course':
				$request['table'] = '\App\Models\Course';
				$request['searchdata'] = ['id', 'title', 'learners', 'hours'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}

				break;

			case 'coursecategory':
				$request['table'] = '\App\Models\CourseCategory';
				$request['searchdata'] = ['id', 'course_category', 'course_category_slug', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'programmes':
				$request['table'] = '\App\Models\Programme';
				$request['searchdata'] = ['id', 'course_category', 'course_category_slug', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'testimonials':
				$request['table'] = '\App\Models\Testimonial';
				$request['searchdata'] = ['id', 'name', 'designation', 'status', 'message', 'video_image', 'video_url'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'goals':
				$request['table'] = '\App\Models\Goals';
				$request['searchdata'] = ['id', 'goals_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'vanlist':
				$request['table'] = '\App\Models\Van';
				$request['searchdata'] = ['id', 'root_type', 'account_holder_name', 'vpa_address', 'account_number', 'ifsc'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'upicollect':
				$request['table'] = '\App\Models\UpiCollect';
				$request['searchdata'] = ['id', 'event', 'account_holder_name', 'remitter_full_name', 'remitter_account_number', 'remitter_ifsc'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'instructors':
				$request['table'] = '\App\Models\Instructors';
				$request['searchdata'] = ['id',  'user_id', 'name', 'designation', 'status', 'working_at', 'working_logo', 'linkedin_url', 'description', 'profile_image'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'learnsupport':
				$request['table'] = '\App\Models\LearnerSupport';
				$request['searchdata'] = ['id',  'user_id', 'name', 'designation', 'status', 'working_at', 'working_logo', 'linkedin_url', 'description', 'profile_image'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'footersupport':
				$request['table'] = '\App\Models\FooterSupport';
				$request['searchdata'] = ['id',  'user_id', 'name', 'designation', 'status', 'working_at', 'working_logo', 'linkedin_url', 'description', 'profile_image'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'employment':
				$request['table'] = '\App\Models\HiringPartner';
				$request['searchdata'] = ['id', 'company_name', 'company_image', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'disclaimer':
				$request['table'] = '\App\Models\Disclaimer';
				$request['searchdata'] = ['id', 'disclaimer', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'award':
				$request['table'] = '\App\Models\Award';
				$request['searchdata'] = ['id', 'award_title', 'award_heading', 'award_description', 'award_image', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'header':
				$request['table'] = '\App\Models\Header';
				$request['searchdata'] = ['id', 'header_1', 'header_2', 'header_3', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'fees':
				$request['table'] = '\App\Models\Fee';
				$request['searchdata'] = ['id', 'header_1', 'header_2', 'header_3', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'footermedia':
				$request['table'] = '\App\Models\FooterMedia';
				$request['searchdata'] = ['id', 'media_heading', 'media_description', 'media_date', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'applications':
				$request['table'] = '\App\Models\Application';
				$request['searchdata'] = ['id', 'user_id', 'course_id', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'aboutus':
				$request['table'] = '\App\Models\AboutUs';
				$request['searchdata'] = ['id', 'heading', 'description', 'button_text', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'contactus':
				$request['table'] = '\App\Models\ContactUs';
				$request['searchdata'] = ['id', 'heading', 'description', 'button_text', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'homepagesettings':
				$request['table'] = '\App\Models\HomePageSetting';
				$request['searchdata'] = [
					'id',
					'trending_title',
					'trending_subtitle',
					'verticals_title',
					'verticals_subtitle',
					'free_courses_title',
					'free_courses_subtitle',
					'testimonials_title',
					'testimonials_subtitle',
					'awards_title',
					'support_title',
					'support_subtitle',
					'status'
				];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'communities':
				$request['table'] = '\App\Models\Community';
				$request['searchdata'] = [
					'id',
					'title',
					'subtitle',
					'feature_categories',
					'trending_discussions',
					'contributors',
					'feature_heading',
					'trending_heading',
					'top_contributer_heading',
					'cta_title',
					'cta_subtitle',
					'cta_button_text',
					'status'
				];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'grievance':
				$request['table'] = '\App\Models\Grievance';
				$request['searchdata'] = ['id', 'name', 'email', 'mobile', 'alt_mobile', 'subject', 'message', 'attachment', 'status'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [\Auth::id()];
					$request['whereIn'] = 'user_id';
				}
				break;

			case 'department':
				$request['table'] = '\App\Models\Department';
				$request['searchdata'] = ['id', 'user_id', 'department_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				//$request['whereIn'] = 'user_id';

				break;
			case 'group_list':
				$request['table'] = '\App\Models\Group';
				$request['searchdata'] = ['id', 'user_id', 'group_name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				//$request['whereIn'] = 'user_id';

				break;

			case 'permissions':
				$request['table'] = '\App\Models\Permission';
				$request['searchdata'] = ['name', 'slug'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				break;

			case 'roles':
				$request['table'] = '\App\Models\Role';
				$request['searchdata'] = ['name', 'slug'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				break;
			case 'apilogs':
				$request['table'] = '\App\Models\Apilog';
				$request['searchdata'] = ['url', 'header'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				break;

			case 'setupadminprofit':
				$request['table'] = '\App\Models\Adminprofit';
				$request['searchdata'] = ['type', 'api_id', 'provider_id', 'commissiontype', 'commission'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'asc'];
				$request['parentData'] = 'all';
				break;

			case 'sprintpayoutusers':
				$request['table'] = '\App\Models\Sprintpayoutuser';
				$request['searchdata'] = ['account', 'name', 'user_id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole(['admin', 'subadmin'])) {
					$request['parentData'] = 'all';
				} else {
					$request['parentData'] = [\Auth::id()];
				}
				$request['whereIn'] = 'user_id';
				break;


			case 'support':
			case 'student':
				$request['table'] = '\App\User';
				$request['searchdata'] = ['id', 'name', 'mobile', 'email', 'agentcode'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];

				if (\Auth::user()->role_id == '2') {
					$request['parentData'] = [\Auth::id()];
				} else {
					$request['parentData'] = 'all';
				}

				$request['whereIn'] = 'parent_id';
				break;



			case 'allmember':
				$request['table'] = '\App\User';
				$request['searchdata'] = ['id', 'name', 'mobile', 'email', 'agentcode'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				if (\Myhelper::hasRole(['support', 'student'])) {
					$request['parentData'] = [\Auth::id()];
				} else {
					$request['parentData'] = 'all';
				}
				$request['whereIn'] = 'parent_id';

				break;

			case 'setupbank':
				$request['table'] = '\App\Models\Fundbank';
				$request['searchdata'] = ['name', 'account', 'ifsc', 'branch'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];

				$request['parentData'] = [\Auth::id()];
				$request['whereIn'] = 'user_id';
				break;

			case 'setupapi':
				$request['table'] = '\App\Models\Api';
				$request['searchdata'] = ['name', 'account', 'ifsc', 'branch'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'setupoperator':
				$request['table'] = '\App\Models\Provider';
				$request['searchdata'] = ['name', 'recharge1', 'recharge2', 'type'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'setupcomplaintsub':
				$request['table'] = '\App\Models\Complaintsubject';
				$request['searchdata'] = ['name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'resourcescheme':
				$request['table'] = '\App\Models\Scheme';
				$request['searchdata'] = ['name', 'user_id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = [\Auth::id()];
				$request['whereIn'] = 'user_id';
				break;

			case 'resourcepackage':
				$request['table'] = '\App\Models\Package';
				$request['searchdata'] = ['name', 'user_id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = [\Auth::id()];
				$request['whereIn'] = 'user_id';
				break;

			case 'resourcecompany':
				$request['table'] = '\App\Models\Company';
				$request['searchdata'] = ['companyname'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'setuplinks':
				$request['table'] = '\App\Models\Link';
				$request['searchdata'] = ['name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				$request['parentData'] = 'all';
				$request['whereIn'] = 'user_id';
				break;

			case 'accountstatement':
			case 'commissionstatement':
				$request['table'] = '\App\Models\Report';
				$request['searchdata'] = ['txnid', 'user_id', 'credited_by', 'id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if ($id == 0) {
					$request['parentData'] = [\Auth::id()];
				} else {
					if (in_array($id, $parentData)) {
						$request['parentData'] = [$id];
					} else {
						$request['parentData'] = [\Auth::id()];
					}
				}
				$request['whereIn'] = 'user_id';

				break;

			case 'awalletstatement':
				$request['table'] = '\App\Models\Aepsreport';
				$request['searchdata'] = ['mobile', 'txnid', 'refno', 'payid', 'amount', 'mytxnid', 'id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if ($id == 0) {
					$request['parentData'] = [\Auth::id()];
				} else {
					if (in_array($id, $parentData)) {
						$request['parentData'] = [$id];
					} else {
						$request['parentData'] = [\Auth::id()];
					}
				}
				$request['whereIn'] = 'user_id';
				break;
			case 'supportdata':
				$request['table'] = '\App\Models\Support';
				$request['searchdata'] = ['title', 'discrption', 'user_id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if ($id == 0 || $returntype == "all") {
					if ($id == 0) {
						if (\Myhelper::hasRole(['retailer', 'apiuser'])) {
							$request['parentData'] = [\Auth::id()];
						} elseif (\Myhelper::hasRole('employee', ['md', 'distributor', 'whitelable'])) {
							$request['parentData'] = $parentData;
						} else {
							$request['parentData'] = 'all';
						}
					} else {
						if (in_array($id, $parentData)) {
							$request['parentData'] = \Myhelper::getParents($id);
						} else {
							$request['parentData'] = [\Auth::id()];
						}
					}
					$request['whereIn'] = 'user_id';
				} else {
					$request['parentData'] = [$id];
					$request['whereIn'] = 'id';
					$request['return'] = 'single';
				}
				break;

			case 'apitoken':
				$request['table'] = '\App\Models\Apitoken';
				$request['searchdata'] = ['ip'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'desc'];
				if (\Myhelper::hasRole('admin')) {
					$request['parentData'] = 'all';
				} else {
					$request['parentData'] = [\Auth::id()];
				}
				$request['whereIn'] = 'user_id';
				break;

			case 'securedata':
				$request['table'] = '\App\Models\Securedata';
				$request['searchdata'] = ['user_id', 'id'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'DESC'];
				if (\Myhelper::hasRole('admin') || \Myhelper::hasRole('subadmin')) {
					$request['parentData'] = 'all';
				} else {
					$request['parentData'] = [\Auth::id()];
				}
				$request['whereIn'] = 'user_id';
				break;

			case 'loginslide':
				$request['table'] = '\App\Models\PortalSetting';
				$request['searchdata'] = ['name'];
				$request['select'] = 'all';
				$request['order'] = ['id', 'DESC'];
				$request['parentData'] = ['slides'];
				$request['whereIn'] = 'code';
				break;

			default:
				# code...
				break;
		}


		$request['where'] = 0;
		$request['type'] = $type;

		try {
			$totalData = $this->getData($request, 'count');
		} catch (\Exception $e) {
			$totalData = 0;
		}

		// dd($request->all());

		if (
			(isset($request->searchtext) && !empty($request->searchtext)) ||
			(isset($request->todate) && !empty($request->todate)) ||
			(isset($request->product) && !empty($request->product)) ||
			(isset($request->status) && $request->status != '') ||
			(isset($request->agent) && !empty($request->agent))
		) {
			$request['where'] = 1;
		}

		try {
			$totalFiltered = $this->getData($request, 'count');
		} catch (\Exception $e) {
			$totalFiltered = 0;
		}

		try {
			$data = $this->getData($request, 'data');
		} catch (\Exception $e) {
			$data = [$e];
		}

		if ($request->return == "all" || $returntype == "all") {
			$json_data = array(
				"draw" => intval($request['draw']),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalFiltered),
				"data" => $data
			);
			echo json_encode($json_data);
		} else {
			return response()->json($data);
		}
	}

	public function getData($request, $returntype)
	{

		$table = $request->table;

		$data = $table::query();

		$data->orderBy($request->order[0], $request->order[1]);

		if ($request->parentData != 'all') {
			if (!is_array($request->whereIn)) {
				$data->whereIn($request->whereIn, $request->parentData);
			} else {
				$data->where(function ($query) use ($request) {
					$query->where($request->whereIn[0], $request->parentData)
						->orWhere($request->whereIn[1], $request->parentData);
				});
			}
		}

		if (
			$request->type != "roles" &&
			$request->type != "permissions" &&
			$request->type != "fundrequestview" &&
			$request->type != "fundrequest" &&
			$request->type != "setupbank" &&
			$request->type != "setupapi" &&
			$request->type != "setuplinks" &&
			$request->type != "setupoperator" &&
			$request->type != "resourcecompany" &&
			$request->type != "affiliateList" &&
			$request->type != "resourcepackage" &&
			$request->type != "aepsfundrequestview" &&
			$request->type != "fundrequestview" &&
			$request->type != "loginslide" &&
			$request->type != "instructors" &&
			$request->type != "raepsagentstatement" &&
			$request->type != "assigntickets" &&
			$request->type != "replytickets" &&
			$request->type != "tickets" &&
			$request->type != "communities" &&
			$request->type != "homepagesettings" &&
			$request->type != "footersupport" &&
			$request->type != "group_list" &&
			$request->type != "goals" &&
			$request->type != "slider" &&
			$request->type != "header" &&
			$request->type != "grievance" &&
			$request->type != "contactus" &&
			$request->type != "disclaimer" &&
			$request->type != "learnsupport" &&
			$request->type != "programmes" &&
			$request->type != "award" &&
			$request->type != "fees" &&
			$request->type != "aboutus" &&
			$request->type != "applications" &&
			$request->type != "course" &&
			$request->type != "web" &&
			$request->type != "testimonials" &&
			$request->type != "degreecategory" &&
			$request->type != "degree" &&
			$request->type != "employment" &&
			$request->type != "coursecategory" &&
			$request->type != "allmember" &&
			$request->type != "student" &&
			$request->type != "banklist" &&
			$request->type != "vanlist" &&
			$request->type != "salarydetails" &&
			$request->type != "festivaldetails" &&
			$request->type != "support" &&
			$request->type != "api" &&
			$request->type != "apilog" &&
			$request->type != "apilogs" &&
			$request->type != "team" &&
			$request->type != "fastagstatement" &&
			$request->type != "sprintpayoutusers" &&
			!in_array($request->type, ['api', 'employee']) &&
			$request->where != 1
		) {
			if (!empty($request->fromdate)) {
				$data->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $request->fromdate)->format('Y-m-d'));
			}

			if (!empty($request->todate)) {
				$data->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $request->todate)->format('Y-m-d'));
			}
		}

		switch ($request->type) {

			case 'getmembers':
				$data->where('team_id', $this->roleId);
				break;

			case 'student':
			case 'support':
				$data->whereHas('role', function ($q) {
					$q->whereIn('slug', ['student', 'support']);
				});

				if (auth()->user()->role_id == 1) {
				} elseif (auth()->user()->role_id == 3 || auth()->user()->role_id == 5) {

					$data->where('parent_id', auth()->id());
				} elseif (auth()->user()->role_id == 2) {
					$data->where('id', auth()->id());
				} else {
					abort(403, 'Unauthorized access.');
				}
				break;

			case 'allmember':
				$data->whereHas('role', function ($q) {
					$q->whereIn('slug', ['student', 'support', 'employee']);
				});

				if (\Myhelper::hasRole(['support', 'student'])) {
					$data->where('id', auth()->id());
				} elseif (auth()->user()->role_id == 1) {
				} else {
					$data->where('parent_id', auth()->id());
				}
				break;
			default:
				break;
		}



		if ($request->where) {
			if (
				(isset($request->fromdate) && !empty($request->fromdate))
				&& (isset($request->todate) && !empty($request->todate))
			) {
				if ($request->fromdate == $request->todate) {
					// Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d')
					$data->whereDate('created_at', '=', Carbon::createFromFormat('m/d/Y', $request->fromdate)->format('Y-m-d'));
				} else {
					$data->whereBetween('created_at', [Carbon::createFromFormat('m/d/Y', $request->fromdate)->format('Y-m-d'), Carbon::createFromFormat('m/d/Y', $request->todate)->addDay(1)->format('Y-m-d')]);
				}
			}
			// if (isset($request->department_id) && !empty($request->department_id)) {
			// 	$data->where('department_name', $request->department_id);
			// }
			if (isset($request->status) && !empty($request->status)) {
				$data->where('status', $request->status);
			}

			if (isset($request->agent) && !empty($request->agent)) {
				switch ($request->type) {

					case 'support':
					case 'web':
					case 'student':
						$data->whereIn('id', $this->agentFilter($request));
						break;
					default:
						$data->whereIn('user_id', $this->agentFilter($request));
						break;
				}
			}
			if (!empty($request->searchtext)) {
				$data->where(function ($q) use ($request) {
					foreach ($request->searchdata as $value) {
						$q->orWhere($value, 'like', $request->searchtext . '%');
						$q->orWhere($value, 'like', '%' . $request->searchtext . '%');
						$q->orWhere($value, 'like', '%' . $request->searchtext);
					}
				});
			}
		}

		if ($request->return == "all" || $request->returntype == "all") {
			if ($returntype == "count") {
				return $data->count();
			} else {
				if ($request['length'] != -1) {
					$data->skip($request['start'])->take($request['length']);
				}

				if ($request->select == "all") {
					$data = $data->get();
					//dd(\DB::getQueryLog());
					foreach ($data as $key => $value) {
						if (isset($value->created_at)) {
							$carbonDate = Carbon::createFromFormat('d M y - h:i A', $value->created_at);
							$value->new_created_at = $carbonDate->format('Y-m-d H:i:s');
						}

						if (isset($value->updated_at)) {
							$carbonDate = Carbon::createFromFormat('d M y - h:i A', $value->created_at);
							$value->new_updated_at = $carbonDate->format('Y-m-d H:i:s');
						}
					}

					return $data;
				} else {
					return $data->select($request->select)->get();
				}
			}
		} else {
			if ($request->select == "all") {
				return $data->first();
			} else {
				return $data->select($request->select)->first();
			}
		}
	}

	public function agentFilter($post)
	{
		if ($post->type == "raepsagentstatement" || \Myhelper::hasRole('admin') || in_array($post->agent, session('parentData'))) {
			return \Myhelper::getParents($post->agent);
		} else {
			return [];
		}
	}

	public function update(Request $post)
	{
		switch ($post->actiontype) {
			case 'utiid':
				$permission = "Utiid_statement_edit";
				break;
			case 'updateaccount':
			case 'raepsid':
			case 'aepsid':
				$permission = "aepsid_statement_edit";
				break;

			case 'utipancard':
				$permission = "utipancard_statement_edit";
				break;

			case 'recharge':
				$permission = "recharge_statement_edit";
				break;

			case 'billpay':
				$permission = "billpay_statement_edit";
				break;

			case 'money':
				$permission = "money_statement_edit";
				break;

			case 'aepstxnreport':
				$permission = "aepstxn_statement_edit";
				break;

			case 'aeps':
				$permission = "aeps_statement_edit";
				break;

			case 'payout':
				$permission = "payout_statement_edit";
				break;
			case 'admincommission':
				$permission = "payout_statement_edit";
				break;
		}

		if (isset($permission) && !\Myhelper::can($permission) && $post->actiontype != "raepsid" && $post->actiontype != "aepsid") {
			return response()->json(['status' => "Permission Not Allowed"], 400);
		}

		switch ($post->actiontype) {
			case 'utiid':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'vleid' => 'required|unique:utiids,vleid' . ($post->id != "new" ? "," . $post->id : ''),
					'vlepassword' => 'required',
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}
				$action = Utiid::where('id', $post->id)->update($post->except(['id', '_token', 'actiontype', 'actiontype']));
				if ($action) {
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'updateaccount':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}
				$action = DB::table('sprintpayoutusers')->where('id', $post->id)->update($post->except(['id', '_token', 'actiontype']));
				if ($action) {
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}

				break;


			case 'admincommission':
				$rules = array(

					'type' => 'required',
					'api_id' => 'required',
					'provider_id' => 'required',
					'commissiontype' => 'required',
					'commission' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}



				$action = Adminprofit::updateOrCreate(['id' => $post->id], $post->all());
				if ($action) {


					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'aepsid':
				$rules = array(
					'id' => 'required',
					'bbps_agent_id' => 'required',
					'bbps_id' => 'required',
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}
				$action = Agents::where('id', $post->id)->update($post->except(['id', '_token', 'actiontype']));
				if ($action) {
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'utipancard':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'number' => 'required',
					'remark' => 'required',
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$report = Report::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending', 'success'])) {
					return response()->json(['status' => "Utipancard Editing Not Allowed"], 400);
				}

				$action = Report::updateOrCreate(['id' => $post->id], $post->all());
				if ($action) {
					if ($post->status == "reversed") {
						\Myhelper::transactionRefund($post->id);
					}

					if ($report->user->role->slug == "apiuser" && $report->status == "pending" && $post->status != "pending") {
						\Myhelper::callback($report, 'utipancard');
					}

					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;
			case 'raepsid':
				$rules = array(
					'id' => 'required',
					'merchantLoginId' => 'required',
					'merchantLoginPin' => 'required',
					'status' => 'required',
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}
				$action = Aepsuser::where('id', $post->id)->update($post->except(['id', '_token', 'actiontype']));
				if ($action) {
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;
			case 'recharge':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'txnid' => 'required',
					'refno' => 'required',
					'payid' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$report = Report::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending', 'success'])) {
					return response()->json(['status' => "Recharge Editing Not Allowed"], 400);
				}

				$post['udf4'] = "Txn Edited by: " . \Auth::id();
				unset($post->txnid);

				$action = Report::updateOrCreate(['id' => $post->id], $post->all());
				if ($action) {
					if ($post->status == "reversed") {
						CommonHelper::refundTxnAndTakeCommissionBack($post->id);
						// \Myhelper::transactionRefund($post->id);
					}

					// if ($report->user->role->slug == "apiuser" && $report->status != "reversed" && $post->status != "pending") {
					// 	\Myhelper::callback($report, 'recharge');
					// }

					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'billpay':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'txnid' => 'required',
					'refno' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$report = Report::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending', 'success'])) {
					return response()->json(['status' => "Recharge Editing Not Allowed"], 400);
				}

				$post['udf4'] = "Txn Edited by: " . \Auth::id();
				unset($post->txnid);



				$action = Report::updateOrCreate(['id' => $post->id], $post->all());
				if ($action) {
					if ($post->status == "reversed") {
						CommonHelper::refundTxnAndTakeCommissionBack($post->id);
						// \Myhelper::transactionRefund($post->id);
					}
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'money':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'txnid' => 'required',
					'refno' => 'required',
					'payid' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$report = Aepsreport::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending', 'initiated'])) {
					return response()->json(['status' => "Transfer Editing Not Allowed"], 400);
				}
				$post['udf4'] = "Txn Edited by: " . \Auth::id();
				unset($post->txnid);


				$action = Aepsreport::updateOrCreate(['id' => $post->id], $post->all());
				if ($action) {
					if ($post->status == "reversed") {
						CommonHelper::refundTxnPayout($post->id);
						// \Myhelper::transactionRefund($post->id);
					}
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'aepstxnreport':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'txnid' => 'required',
					'refno' => 'required',
					'payid' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				return response()->json(['status' => "AEPS Editing Not Allowed"], 400);
				$post['udf4'] = "Txn Edited by: " . \Auth::id();
				unset($post->txnid);


				$report = AepsTxnReports::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending', 'PENDING'])) {
					return response()->json(['status' => "AEPS Editing Not Allowed"], 400);
				}

				$makeUpdateParam = [
					'status' => $post->status,
					'operator_ref_id' => $post->txnid,
					'order_ref_id' => $post->refno,
					'rrn' => $post->payid,
					"description" => $post->remarks,

				];
				$this->aepsRepo->updateTxnViaStatusCheck($makeUpdateParam, $report->txn_id);

				return response()->json(['status' => "success"], 200);
				break;

			case 'aeps':
				$rules = array(
					'id' => 'required',
					'status' => 'required',
					'txnid' => 'required',
					'refno' => 'required',
					'payid' => 'required'
				);

				$validator = \Validator::make($post->all(), $rules);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				return response()->json(['status' => "AEPS Editing Not Allowed"], 400);
				$post['udf4'] = "Txn Edited by: " . \Auth::id();
				unset($post->txnid);


				$report = Aepsreport::where('id', $post->id)->first();
				if (!$report || !in_array($report->status, ['pending'])) {
					return response()->json(['status' => "AEPS Editing Not Allowed"], 400);
				}
				if ($post->status == "success") {
					$post['status'] = "complete";
				}
				$action = Aepsreport::where('id', $post->id)->update($post->except(['id', '_token', 'actiontype']));
				if ($action) {
					if ($report->status == "pending" && $post->status == "complete") {
						$user = User::where('id', $report->user_id)->first();
						$insert = [
							"mobile" => $report->mobile,
							"aadhar" => $report->aadhar,
							"api_id" => $report->api_id,
							"txnid" => $report->txnid,
							"refno" => "Txnid - " . $report->id . " Cleared",
							"amount" => $report->amount,
							"bank" => $report->bank,
							"user_id" => $report->user_id,
							"balance" => $user->aepsbalance,
							'aepstype' => $report->aepstype,
							'status' => 'success',
							'authcode' => $report->authcode,
							'payid' => $report->payid,
							'mytxnid' => $report->mytxnid,
							'terminalid' => $report->terminalid,
							'TxnMedium' => $report->TxnMedium,
							'credited_by' => $report->credited_by,
							'type' => 'credit'
						];
						if ($report->amount >= 100 && $report->amount <= 3000) {
							$provider = Provider::where('recharge1', 'aeps1')->first();
						} elseif ($report->amount > 3000 && $report->amount <= 10000) {
							$provider = Provider::where('recharge1', 'aeps2')->first();
						}
						$post['provider_id'] = $provider->id;
						$post['service'] = $provider->type;

						if ($report->aepstype == "CW") {
							if ($report->amount >= 100) {
								$usercommission = \Myhelper::getCommission($report->amount, $user->scheme_id, $post->provider_id, $user->role->slug);
							} else {
								$usercommission = 0;
							}
						} else {
							$usercommission = 0;
						}

						$insert['charge'] = $usercommission;
						$action = User::where('id', $report->user_id)->increment('aepsbalance', $report->amount + $usercommission);
						if ($action) {
							$aeps = Aepsreport::create($insert);
							$post['reportid'] = $aeps->id;
							$post['precommission'] = $usercommission;
							if ($report->amount > 500) {
								\Myhelper::commission($aeps);
							}
						}
					}
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			case 'payout':
				// $rules = array(
				// 	'id' => 'required',
				// 	'status' => 'required',
				// 	'payoutref' => 'required'
				// );

				// $validator = \Validator::make($post->all(), $rules);
				// if ($validator->fails()) {
				// 	return response()->json(['errors' => $validator->errors()], 422);
				// }

				// $fundreport = Aepsfundrequest::where('id', $post->id)->first();
				// if (!$fundreport || !in_array($fundreport->status, ['pending', 'approved'])) {
				// 	return response()->json(['status' => "Transaction Editing Not Allowed"], 400);
				// }

				// $action = Aepsfundrequest::where('id', $post->id)->update($post->except(['id', '_token', 'actiontype']));
				// if ($action) {
				// 	if ($post->status == "rejected") {
				// 		$report = Aepsreport::where('txnid', $fundreport->payoutid)->update(['status' => "reversed"]);
				// 		$report = Aepsreport::where('payid', $fundreport->id)->first();
				// 		$aepsreports['api_id'] = $report->api_id;
				// 		$aepsreports['payid'] = $report->payid;
				// 		$aepsreports['mobile'] = $report->mobile;
				// 		$aepsreports['refno'] = $report->refno;
				// 		$aepsreports['aadhar'] = $report->aadhar;
				// 		$aepsreports['amount'] = $report->amount;
				// 		$aepsreports['charge'] = $report->charge;
				// 		$aepsreports['bank'] = $report->bank;
				// 		$aepsreports['txnid'] = $report->id;
				// 		$aepsreports['user_id'] = $report->user_id;
				// 		$aepsreports['credited_by'] = $report->credited_by;
				// 		$aepsreports['balance'] = $report->user->aepsbalance;
				// 		$aepsreports['type'] = "credit";
				// 		$aepsreports['transtype'] = 'fund';
				// 		$aepsreports['status'] = 'refunded';
				// 		$aepsreports['remark'] = "Bank Settlement";
				// 		Aepsreport::create($aepsreports);
				// 		User::where('id', $aepsreports['user_id'])->increment('aepsbalance', $aepsreports['amount'] + $aepsreports['charge']);
				// 	}
				// 	return response()->json(['status' => "success"], 200);
				// } else {
				// 	return response()->json(['status' => "Task Failed, please try again"], 200);
				// }
				break;
		}
	}

	public function status(Request $post)
	{

		if (!\Myhelper::can($post->type . "_status") && $post->type != "ragentstatus") {
			return response()->json(['status' => "Permission Not Allowed"], 400);
		}

		// if (\Myhelper::hasNotRole('admin') && $post->type != "ragentstatus") {
		// 	return response()->json(['status' => "Permission Not Allowed1"], 400);
		// }

		switch ($post->type) {
			case 'recharge':
			case 'billpayment':
			case 'utipancard':
			case 'licbillpayment':
			case 'commStatusCheck':
				$report = Report::where('id', $post->id)->first();
				break;

			case 'utiid':
				$report = Utiid::where('id', $post->id)->first();
				break;

			case 'aeps':
			case 'money':
				$report = Aepsreport::where('id', $post->id)->first();
				break;

			case 'aepstxnreport':
				$report = AepsTxnReports::where('id', $post->id)->first();
				break;

			case 'matm':
				$report = Microatmreport::where('id', $post->id)->first();
				break;

			case 'bcstatus':
				$report = Agents::where('id', $post->id)->first();
				break;
			case 'ragentstatus2':
			case 'ragentstatus3':
			case 'ragentstatus':
				$report = Aepsuser::where('id', $post->id)->first();
				break;
			default:
				return response()->json(['status' => "Status Not Allowed"], 400);
				break;
		}

		if (!$report || !in_array($post->type, ["ragentstatus", "aepstxnreport"]) && !in_array($report->status, ['pending', 'PENDING', 'INITIATED', 'initiated', 'initiate'])) {
			return response()->json(['status' => "Only pending transaction status check allowed"], 400);
		}

		if (in_array($post->type, ['aeps', 'aepstxnreport']) && (!$report || !in_array($report->status, ['pending', 'PENDING', 'INITIATED', 'initiated', 'initiate']))) {
			return response()->json(['status' => "Only pending aeps transaction status check allowed"], 400);
		}

		switch ($post->type) {
			case 'recharge':
				switch ($report->api->code) {
					case 'iydaRecharge':
						// return response()->json(['status' => "Recharge Status Not Allowed"], 400);

						$sendRequest = $this->rechargeService->rechargeStatusCheck($report);
						$resp = json_decode($sendRequest['response']);
						if ($sendRequest['code'] == 200) {
							// Transaction Successful
							if ($resp->code == "0x0200" && $resp->status == "SUCCESS") {
								$update['status'] = "success";
							} else if ($resp->status == "FAILURE") {
								$update['status'] = "reversed";
							} else {
								$update['status'] = "pending";
							}
							$update['apitxnid'] = @$resp->data->txnId;
							$update['option1'] = @$resp->data->venderId;
							$update['description'] = @$resp->data->remarks;
						} else {
							$update['status'] = "Unknown";
						}
						if ($update['status'] != "Unknown") {
							$reportupdate = Report::where('id', $report->id)->first();
							Report::where('id', $report->id)->update($update);
							if ($reportupdate->status == 'pending' && $update['status'] == "success" && $reportupdate) {
								CommonHelper::giveCommissionToAll($reportupdate);
							}


							if ($reportupdate->status == 'pending' && $update['status'] == "reversed" && $reportupdate) {
								CommonHelper::refundTxnAndTakeCommissionBack($report->id);
								// \Myhelper::transactionRefund($post->id);
							}
						}

						if ($update['status'] != "Unknown") {
							// $updateTxnStatus = $this->recodemaker->updateRechargeRecord($update, $report->txnid, $report->user_id);
						}
						$update['txnid'] = $report->txnid;
						return response()->json($update);
						break;
					default:
						return response()->json(['status' => "Recharge Status Not Allowed"], 400);
						break;
				}
				break;
			case 'licbillpayment':
				//	$url = "https://api.paysprint.in/api/v1/service/bill-payment/bill/licstatus";
				$url = 'https://api.paysprint.in/api/v1/service/bill-payment/bill/licstatus';
				$method = "POST";
				$parameter = json_encode(
					array(
						'referenceid' => $report->txnid,
					)
				);

				$payload = [
					"timestamp" => time(),
					"partnerId" => $report->api->username,
					"reqid" => $report->user_id . Carbon::now()->timestamp
				];

				$key = $report->api->password;
				$signer = new HS256($key);
				$generator = new JwtGenerator($signer);
				$header = array(
					"Cache-Control: no-cache",
					"Content-Type: application/json",
					"Token: " . $generator->generate($payload),
					"Authorisedkey: " . $report->api->optional1

				);
				break;
			case 'billpayment':

				// switch ($report->api->code) {
				// return response()->json(['status' => "Bill Pay Status Not Allowed"], 400);

				// {
				// 	"code":"0x0202",
				// 	"status":"FAILURE",
				// 	"message":"Bank fund transfer api failed",
				// 	"data":{
				// 	   "agentNpciId":"FE41FE15INTU00000002",
				// 	   "fundRespRemarks":"Bank fund transfer api failed",
				// 	   "fundStatus":"FUND_TRANSFER_FAILED",
				// 	   "billStatus":"BILL_PAYMENT_FAILED",
				// 	   "fundTxnAmt":377,
				// 	   "fundTxnDate":null,
				// 	   "fundTxnReferenceId":"BDEUUHQ99XL7CW5",
				// 	   "fundTxnRemarks":"BBPS-AGENT/BDEUUHQ99XL7CW5",
				// 	   "fundUTR":null,
				// 	   "billerId":"APDCL0000ASM02",
				// 	   "billerName":"Assam Power Distribution Company Ltd (NON-RAPDR)",
				// 	   "txnRefId":"d813f743-248a-4b99-a3c9-9fa2e3460bb5",
				// 	   "customerMobNo":"7208822572",
				// 	   "txnNpciId":null
				// 	}
				//  }


				$callPaymentsAPI = $this->callIydaBillpay->checkStatus($report);
				if (!$callPaymentsAPI['status']) {
					$update['status'] = "Unknown";
				} else {
					$resp = $callPaymentsAPI['data'];

					if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
						if (isset($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_SUCCESS") {
							$update['status'] = "success";
							$output['statuscode'] = "TXN";
						}
					} else if ($resp->status == 'FAILURE') {
						if (isset($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_FAILED") {
							$update['status'] = "reversed";
							$output['statuscode'] = "TXF";
						}
					} else {
						$update['status'] = "pending";
						$output['statuscode'] = "TUP";
					}

					$update['payid'] = @$resp->data->agentNpciId;
					$update['description'] = @$resp->message;
					$update['remark'] = @$resp->data->fundTxnRemarks ?? @$resp->message;
				}
				// }
				$output['txnid'] = @$report->txnid;
				$output['rrn'] = @$update['payid'];
				$output['txnStatus'] = @$update['status'];
				$output['remarks'] = @$update['remark'];
				$output['description'] = @$update['remark'];
				$output['message'] = @$update['description'];
				// $output['result'] = $update;


				if ($update['status'] != "Unknown") {
					$reportupdate = Report::where('id', $report->id)->first();
					$updateTxn = Report::where('id', $report->id)->update($update);
					if ($reportupdate->status == 'pending' && $update['status'] == "success" && $reportupdate) {
						CommonHelper::giveCommissionToAll($reportupdate);
					}

					if ($reportupdate->status == 'pending' && $update['status'] == "reversed" && $reportupdate) {
						$refund = CommonHelper::refundTxnAndTakeCommissionBack($report->id);
						// \Myhelper::transactionRefund($post->id);
					}
				}
				return response()->json($output);


				// 	default:
				// 		return response()->json(['status' => "Recharge Status Not Allowed"], 400);
				// 		break;
				// }
				break;

			case 'utipancard':
				$url = $report->api->url . 'UATUTICouponRequestStatus';
				$method = "POST";
				$parameter['securityKey'] = $report->api->password;
				$parameter['createdby'] = $report->api->username;
				$parameter['requestid'] = $report->payid;
				$header = [];
				break;

			case 'utiid':
				$url = $report->api->url . '/status?token=' . $report->api->username . '&vleid=' . $report->vleid;
				$method = "GET";
				$parameter = "";
				$header = [];
				break;
			case 'commStatusCheck':

				if ($report->option2 != 'auto' && $report->option1 != 'bank') {
					return response()->json(
						['statuscode' => "ERR", 'message' => 'Only bank settlement txn can status check'],
						400
					);
				}
				$resp = $this->payoutService->payoutStatusCheck($report);
				$post['txnId'] = $report->txnid;
				if ($resp['code'] == 200) {
					$data = json_decode($resp['response']);
					if ($data->status == "SUCCESS") {
						if ($data->data->status == 'processed') {
							$updateTxn['txnStatus'] = 'success';
						} else if ($data->data->status == 'failed') {
							$updateTxn['txnStatus'] = 'reversed';
							// } //else if ($data->data->status == 'reversed') {
							// $updateTxn['status'] = 'reversed';
						} else if ($data->data->status == 'processing') {
							$updateTxn['txnStatus'] = 'pending';
						} else {
							$updateTxn['txnStatus'] = 'pending';
						}
						$updateTxn['bankRef'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['description'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['remarks'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['orderRefId'] = isset($data->data->orderRefId) ? $data->data->orderRefId : null;
						$up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus'], "refno" => $updateTxn['orderRefId']];
						$this->statusCheckController->updateStatusCheckResponseOfCommSettlement($post, $up);
						$updateTxn["statuscode"] = "TXN";
						$updateTxn["message"] = "Status Fetched Successfully";
						return response()->json($updateTxn, 200);
					} else {
						if ($data->status == "FAILURE" && $data->message == "No orders found.") {
							$updateTxn['txnStatus'] = 'reversed';
							$updateTxn['bankRef'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
							$up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
							$this->statusCheckController->updateStatusCheckResponseOfCommSettlement($post, $up);
						}
						return response()->json(["statuscode" => "ERR", "message" => $data->message ?? "Status check is under maintenence,Please try after sometimes"], 400);
					}
				} else {
					return response()->json(["statuscode" => "ERR", "message" => "Status check is under maintenence,Please try after sometimes"], 400);
				}


				break;


			case 'money':
				$resp = $this->payoutService->payoutStatusCheck($report);
				$post['txnId'] = $report->txnid;

				if ($resp['code'] == 200) {
					$data = json_decode($resp['response']);
					if ($data->status == "SUCCESS") {
						if ($data->data->status == 'processed') {
							$updateTxn['txnStatus'] = 'success';
						} else if ($data->data->status == 'failed') {
							$updateTxn['txnStatus'] = 'reversed';
							// } //else if ($data->data->status == 'reversed') {
							// $updateTxn['status'] = 'reversed';
						} else if ($data->data->status == 'processing') {
							$updateTxn['txnStatus'] = 'pending';
						} else {
							$updateTxn['txnStatus'] = 'pending';
						}
						$updateTxn['bankRef'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['description'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['remarks'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
						$updateTxn['orderRefId'] = isset($data->data->orderRefId) ? $data->data->orderRefId : null;
						$up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus'], "terminalid" => $updateTxn['orderRefId']];
						$this->statusCheckController->updateStatusCheckResponse($post, $up);
						$updateTxn["statuscode"] = "TXN";
						$updateTxn["message"] = "Status Fetched Successfully";
						return response()->json($updateTxn, 200);
					} else {
						if ($data->status == "FAILURE" && $data->message == "No orders found.") {
							$updateTxn['txnStatus'] = 'reversed';
							$updateTxn['bankRef'] = isset($data->data->bankReference) ? $data->data->bankReference : null;
							$up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
							$this->statusCheckController->updateStatusCheckResponse($post, $up);
						}
						return response()->json(["statuscode" => "ERR", "message" => $data->message ?? "Status check is under maintenence,Please try after sometimes"], 400);
					}
				} else {
					return response()->json(["statuscode" => "ERR", "message" => "Status check is under maintenence,Please try after sometimes"], 400);
				}
				break;

			case 'aepstxnreport':
			case 'aeps':
				// {
				// 	"code":"0x0200",
				// 	"message":"Transaction Successfully.",
				// 	"status":"SUCCESS",
				// 	"data":{
				// 	   "orderRefId":"CWBT5918971150224142823954I",
				// 	   "clientRefId":"DP17835320",
				// 	   "bankName":"State Bank of India",
				// 	   "rrn":"404614873214",
				// 	   "transactionStatus":true,
				// 	   "transactionStatusMessage":"Success",
				// 	   "accountNumber":"",
				// 	   "ipaymentId":"730822",
				// 	   "transactionMode":"",
				// 	   "transactionValue":500,
				// 	   "bankAccountBalance":0
				// 	}
				//  }

				$getBc_Id = DB::table('agents')->where('user_id', @$report->user_id)->first();
				$report['bc_id'] = @$getBc_Id->bc_id;
				$report['txnId'] = $report->txnid;
				$resp = $this->aepsService->transactionStatus($report);
				$data = json_decode($resp['response']);
				$refId = @$data->data->clientRefId;
				if ($resp['code'] == 200) {
					if ($data->status == 'SUCCESS' && $data->code == '0x0200') {
						if (isset($data->data->transactionStatus) && $data->data->transactionStatus == true) {
							$updateTxn['txnStatus'] = 'success';
						}
					} else if ($data->status == 'FAILURE' && $data->code == '0x0202') {
						if (isset($data->data->transactionStatus) && $data->data->transactionStatus == false) {
							$updateTxn['txnStatus'] = 'failed';
						}
					} else if ($data->status == 'PENDING') {
						$updateTxn['txnStatus'] = 'pending';
					} else {
						$updateTxn['txnStatus'] = 'pending';
					}

					$updateTxn['stanno'] = @$data->data->orderRefId;
					$updateTxn['rrnno'] = @$data->data->rrn;
					$updateTxn['description'] = @$data->data->transactionStatusMessage;
					$up = [
						'operator_ref_id' => $updateTxn['rrnno'],
						"status" => strtoupper($updateTxn['txnStatus']),
						"rrn" => $updateTxn['stanno'],
						"description" => $updateTxn['description'],
						"bankName" => @$data->data->bankName
					];
					// $up = ['payid' => @$updateTxn['rrnno'], "status" => @$updateTxn['txnStatus'], "refno" => @$updateTxn['stanno'], "description" => @$updateTxn['description']];
					// fingpayTransactionId
				} else {
					if ($data->status == "FAILURE" && $data->message == "No orders found.") {
						$updateTxn['txnStatus'] = 'failed';
						$updateTxn['bankRef'] = isset($data->data->transactionStatus) ? $data->data->transactionStatus : null;
						$up = ['operator_ref_id' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];

						// $up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
					} else {
						$up = [
							'operator_ref_id' => "",
							"status" => "Unknown",
							"rrn" => "",
							"description" => "",
							"bankName" => ""
						];
						$updateTxn['txnStatus'] = @$report->status;
					}
				}
				if ($up['status'] != "Unknown") {
					$this->aepsRepo->updateTxnViaStatusCheck($up, $refId);
				}
				$updateTxn['statuscode'] = 'TXN';

				return response()->json($updateTxn);
				break;

			case 'matm':
				$getBc_Id = DB::table('agents')->where('user_id', @$report->user_id)->first();
				$report['bc_id'] = @$getBc_Id->bc_id;
				$report['txnId'] = $report->txnid;
				$resp = $this->matmController->getCheckMatmStatus($report);
				$data = json_decode($resp['response']);
				$refId = @$data->data->merchantTranId;
				if ($resp['code'] == 200) {
					if ($data->status == 'SUCCESS' && $data->code == '0x0200') {
						if (isset($data->data->transactionStatus) && $data->data->transactionStatus == true) {
							$updateTxn['txnStatus'] = 'success';
						}
					} else if ($data->status == 'FAILURE' && $data->code == '0x0202') {
						if (isset($data->data->transactionStatus) && $data->data->transactionStatus == false) {
							$updateTxn['txnStatus'] = 'failed';
						}
					} else if ($data->status == 'PENDING') {
						$updateTxn['txnStatus'] = 'pending';
					} else {
						$updateTxn['txnStatus'] = 'pending';
					}

					$updateTxn['stanno'] = @$data->stan;
					$updateTxn['rrnno'] = @$data->bankRRN;
					// $insertData['rrnno'] = @$data->bankRRN;
					$up = ['payid' => $updateTxn['rrnno'], "status" => $updateTxn['txnStatus'], "refno" => $updateTxn['stanno']];
					// fingpayTransactionId
				} else {
					if ($data->status == "FAILURE" && $data->message == "No orders found.") {
						$updateTxn['txnStatus'] = 'failed';
						$updateTxn['bankRef'] = isset($data->data->transactionStatus) ? $data->data->transactionStatus : null;
						$up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
					}
				}

				MATMRepo::updateTxnViaStatusCheck($up, $refId);
				return response()->json($updateTxn);
				break;

			case 'bcstatus':
				$api = Api::where('code', 'aeps')->first();
				$method = "POST";
				$parameter = json_encode(
					array(
						'Secretkey' => $api->password,
						'Saltkey' => $api->username,
						'bc_id' => $report->bc_id
					)
				);

				$header = array(
					"Accept: application/json",
					"Cache-Control: no-cache",
					"Content-Type: application/json"
				);
				break;
			case 'ragentstatus':
				//$url = 'https://paysprint.in/service-api/api/v1/service/onboard/onboard/getonboardstatus' ;	    
				$url = "https://api.paysprint.in/api/v1/service/onboard/onboard/getonboardstatus";
				$method = "POST";
				$token = $this->getPToken($report->user_id . Carbon::now()->timestamp);
				$header = array(
					"Cache-Control: no-cache",
					"Content-Type: application/json",
					"Accept: application/json",
					"Token: " . $token['token'],
					"Authorisedkey: OWU3ZjExYjI1YmVhYjkyMGU5ZWRkMmMxYTVmZTYzOWE="
				);
				$parameter = json_encode(
					array(
						'merchantcode' => $report->merchantLoginId,
						'mobile' => $report->merchantPhoneNumber,
						'pipe' => "bank1",

					)
				);

				break;
			case 'ragentstatus2':
				//$url = 'https://paysprint.in/service-api/api/v1/service/onboard/onboard/getonboardstatus' ;	    
				$url = "https://api.paysprint.in/api/v1/service/onboard/onboard/getonboardstatus";
				$method = "POST";
				$token = $this->getPToken($report->user_id . Carbon::now()->timestamp);
				$header = array(
					"Cache-Control: no-cache",
					"Content-Type: application/json",
					"Accept: application/json",
					"Token: " . $token['token'],
					"Authorisedkey: OWU3ZjExYjI1YmVhYjkyMGU5ZWRkMmMxYTVmZTYzOWE="
				);
				$parameter = json_encode(
					array(
						'merchantcode' => $report->merchantLoginId,
						'mobile' => $report->merchantPhoneNumber,
						'pipe' => "bank2",

					)
				);

				break;
			case 'ragentstatus3':
				//$url = 'https://paysprint.in/service-api/api/v1/service/onboard/onboard/getonboardstatus' ;	    
				$url = "https://api.paysprint.in/api/v1/service/onboard/onboard/getonboardstatus";
				$method = "POST";
				$token = $this->getPToken($report->user_id . Carbon::now()->timestamp);
				$header = array(
					"Cache-Control: no-cache",
					"Content-Type: application/json",
					"Accept: application/json",
					"Token: " . $token['token'],
					"Authorisedkey: OWU3ZjExYjI1YmVhYjkyMGU5ZWRkMmMxYTVmZTYzOWE="
				);
				$parameter = json_encode(
					array(
						'merchantcode' => $report->merchantLoginId,
						'mobile' => $report->merchantPhoneNumber,
						'pipe' => "bank3",

					)
				);

				break;
			default:
				# code...
				break;
		}

		$result = \Myhelper::curl($url, $method, $parameter, $header);
		//   dd($result,$url, $method, $parameter, $header) ;
		if ($result['response'] != '') {
			switch ($post->type) {
				case 'recharge':
					// switch ($report->api->code) {
					// 	case 'recharge1':
					// 		$doc = json_decode($result['response']);
					// 		if ($doc->statuscode == "TXN" && ($doc->trans_status == "success" || $doc->trans_status == "pending")) {
					// 			$update['refno'] = $doc->refno;
					// 			$update['status'] = "success";
					// 		} elseif ($doc->statuscode == "TXN" && $doc->trans_status == "reversed") {
					// 			$update['status'] = "reversed";
					// 			$update['refno'] = $doc->refno;
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 			$update['refno'] = $doc->message;
					// 		}
					// 		break;

					// 	case 'recharge2':
					// 		DB::table('rp_log')->insert([
					// 			'ServiceName' => "RechargeStatus",
					// 			'header' => json_encode($header),
					// 			'body' => json_encode($parameter),
					// 			'response' => $result['response'],
					// 			'url' => $url,
					// 			'created_at' => date('Y-m-d H:i:s')
					// 		]);

					// 		$doc = json_decode($result['response']);
					// 		// dd($doc,$result['response'],$url, $method, $parameter, $header) ;
					// 		if (isset($doc->data->status) && $doc->data->status == "1") {
					// 			$update['refno'] = $doc->data->operatorid ?? $report->refno;
					// 			$update['status'] = "success";
					// 		} elseif (isset($doc->data->status) && $doc->data->status == "0") {
					// 			$update['status'] = "reversed";
					// 			$update['refno'] = (isset($doc->data->operatorid)) ? $doc->data->operatorid : "failed";
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 			$update['refno'] = (isset($doc->data->operatorid)) ? $doc->data->operatorid : "Unknown";
					// 		}
					// 		break;
					// 	case 'recharge5':

					// 		$doc = json_decode($result['response']);
					// 		// dd($doc,$result['response'],$url, $method, $parameter, $header) ;
					// 		//dd($doc->status);
					// 		if ($doc->status == "2") {
					// 			$update['status'] = "success";
					// 			$update['payid'] = $doc->rpid;
					// 			$update['refno'] = $doc->opid;
					// 			$update['description'] = "Recharge Accepted";
					// 		} elseif ($doc->status == "3") {
					// 			$update['status'] = "reversed";
					// 			$update['payid'] = $doc->rpid;
					// 			$update['refno'] = $doc->opid;
					// 			$update['description'] = (isset($doc->MSG)) ? $doc->MSG : "Failed";
					// 		} elseif ($doc->status == "1") {
					// 			$update['status'] = "pending";
					// 			$update['payid'] = $doc->rpid;
					// 			$update['refno'] = $doc->opid;
					// 			$update['description'] = (isset($doc->MSG)) ? $doc->MSG : "Pending";
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 			$update['refno'] = (isset($doc->data->operatorid)) ? $doc->data->operatorid : "Unknown";
					// 		}
					// 		//dd($update,$doc,$result['response'],$url, $method, $parameter, $header) ;
					// 		break;
					// }
					$product = "recharge";
					break;

				case 'billpayment':

					// $doc = json_decode($result['response']);

					// switch ($report->api->code) {
					// 	case 'billpayment':
					// 		if (isset($doc->statuscode)) {
					// 			if (($doc->statuscode == "TXN" && $doc->data->status == "success") || ($doc->statuscode == "TXN" && $doc->data->status == "pending")) {
					// 				$update['refno'] = $doc->data->ref_no;
					// 				$update['status'] = "success";
					// 			} elseif ($doc->statuscode == "TXN" && $doc->data->status == "reversed") {
					// 				$update['status'] = "reversed";
					// 			} else {
					// 				$update['status'] = "Unknown";
					// 			}
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 		}
					// 		break;

					// 	case 'paysprintbill':
					// 		DB::table('rp_log')->insert([
					// 			'ServiceName' => "BillpayStatus",
					// 			'header' => json_encode($header),
					// 			'body' => json_encode($parameter),
					// 			'response' => $result['response'],
					// 			'url' => $url,
					// 			'created_at' => date('Y-m-d H:i:s')
					// 		]);

					// 		if (isset($doc->response_code) && in_array($doc->response_code, [1])) {
					// 			$update['status'] = "success";
					// 			$update['refno'] = $doc->data->operatorid;
					// 		} elseif (isset($doc->response_code) && in_array($doc->response_code, [0])) {
					// 			$update['status'] = "reversed";
					// 			$update['refno'] = $doc->message;
					// 		} elseif (isset($doc->response_code) && in_array($doc->response_code, [12])) {
					// 			$update['status'] = "Unknown";
					// 		} else {
					// 			$update['status'] = "pending";
					// 			//$update['refno']  = "Please wait for status change or contact service provider";
					// 		}
					// }


					// $product = "billpay";
					break;
				case 'licbillpayment':
					DB::table('rp_log')->insert([
						'ServiceName' => "BillpayStatus",
						'header' => json_encode($header),
						'body' => json_encode($parameter),
						'response' => $result['response'],
						'url' => $url,
						'created_at' => date('Y-m-d H:i:s')
					]);

					$doc = json_decode($result['response']);
					//dd($doc);

					if (($doc->status) == true && $doc->data->status == "1") {
						$update['refno'] = (isset($doc->txnid)) ? $doc->txnid : "null";
						$update['status'] = "success";
						$update['description'] = (isset($doc->message)) ? $doc->message : "null";
					} elseif (($doc->status) == true && $doc->data->status == "0") {
						$update['status'] = "reversed";
						$update['refno'] = (isset($doc->txnid)) ? $doc->txnid : "null";
						$update['description'] = (isset($doc->message)) ? $doc->message : "null";
					} else {

						$update['status'] = "pending";
						$update['refno'] = (isset($doc->txnid)) ? $doc->txnid : "null";
						$update['description'] = (isset($doc->message)) ? $doc->message : "null";
					}

					$product = "licbillpay";

					break;

				case 'utipancard':
					$doc = json_decode($result['response']);
					if (isset($doc[0]->StatusCode) && $doc[0]->StatusCode == "000") {
						$update['status'] = "success";
					} else {
						$update['status'] = "Unknown";
					}
					$product = "utipancard";
					break;

				case 'money':
					// $doc = json_decode($result['response']);
					//dd($doc);
					// switch ($report->api->code) {
					// 	case 'dmt1':
					// 		if (isset($doc->statuscode) && $doc->statuscode == "000") {
					// 			if (isset($doc->Data[0]) && isset($doc->Data[0]->status)) {
					// 				if (strtolower($doc->Data[0]->status) == "success") {
					// 					$update['status'] = "success";
					// 					$update['refno'] = $doc->Data[0]->opt_rrn;
					// 				} elseif (strtolower($doc->Data[0]->status) == "failure") {
					// 					$update['status'] = "failed";
					// 					$update['refno'] = isset($doc->Data[0]->opt_rrn) ? $doc->Data[0]->opt_rrn : "Failed";
					// 				} elseif (strtolower($doc->Data[0]->status) == "pending") {
					// 					$update['status'] = "pending";
					// 				} else {
					// 					$update['status'] = "Unknown";
					// 				}
					// 			} else {
					// 				$update['status'] = "Unknown";
					// 			}
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 		}
					// 		break;

					// 	case 'pdmt':
					// 		DB::table('rp_log')->insert([
					// 			'ServiceName' => "Status",
					// 			'header' => json_encode($header),
					// 			'body' => json_encode($parameter),
					// 			'response' => $result['response'],
					// 			'url' => $url,
					// 			'created_at' => date('Y-m-d H:i:s')
					// 		]);
					// 		$doc = json_decode($result['response']);
					// 		if (isset($doc->response_code) && ($doc->response_code == "1")) {
					// 			if (in_array($doc->txn_status, ["0", "5"])) {
					// 				$update['status'] = "reversed";
					// 				$update['refno'] = (isset($doc->message)) ? $doc->message : 'failed';

					// 			} else {
					// 				$update['status'] = "success";
					// 				$update['payid'] = (isset($doc->ackno)) ? $doc->ackno : 'success';
					// 				$update['refno'] = (isset($doc->utr)) ? $doc->utr : 'success';

					// 			}
					// 		} elseif (isset($doc->response_code) && in_array($doc->response_code, ["0", "2", "5"])) {
					// 			$update['status'] = "reversed";
					// 			$update['refno'] = (isset($doc->message)) ? $doc->message : 'failed';
					// 		} else {
					// 			$update['status'] = "pending";
					// 		}
					// 		break;
					// }
					$product = "aeps";
					break;

				case 'utiid':
					$doc = json_decode($result['response']);
					//dd($doc);
					if (isset($doc->statuscode) && $doc->statuscode == "TXN") {
						$update['status'] = "success";
						$update['remark'] = $doc->message;
					} elseif (isset($doc->statuscode) && $doc->statuscode == "TXF") {
						$update['status'] = "reversed";
						$update['remark'] = $doc->message;
					} elseif (isset($doc->statuscode) && $doc->statuscode == "TUP") {
						$update['status'] = "pending";
						$update['remark'] = $doc->message;
					} else {
						$update['status'] = "Unknown";
					}
					$product = "utiid";
					break;
				case 'aepstxnreport':
				case 'aeps':

					// $doc = json_decode($result['response']);
					// //dd($doc);
					// switch ($report->api->code) {

					// 	case 'raeps':
					// 		DB::table('rp_log')->insert([
					// 			'ServiceName' => 'Check status',
					// 			'header' => json_encode($header),
					// 			'body' => json_encode([$parameters, $request]),
					// 			'response' => $result['response'],
					// 			'url' => $url,
					// 			'created_at' => date('Y-m-d H:i:s')
					// 		]);
					// 		if (isset($doc->response_code) && ($doc->response_code == "1")) {
					// 			$update['status'] = "complete";
					// 			$update['refno'] = $doc->bankrrn;

					// 		} elseif (isset($doc->response_code) && ($doc->response_code == "0")) {
					// 			$update['status'] = "failed";
					// 			$update['refno'] = isset($doc->message) ? $doc->message : "Failed";

					// 		} elseif (isset($doc->response_code) && ($doc->response_code == "2")) {
					// 			$update['status'] = "pending";
					// 			$update['remark'] = isset($doc->message) ? $doc->message : "pending";
					// 		} else {
					// 			$update['status'] = "Unknown";
					// }

					break;
					// 	default:
					// 		if (isset($doc->statuscode) && $doc->statuscode == "000") {
					// 			if (isset($doc->Data[0]) && isset($doc->Data[0]->status)) {
					// 				if ($doc->Data[0]->status == "SUCCESS") {
					// 					$update['status'] = "complete";
					// 					$update['refno'] = $doc->Data[0]->rrn;
					// 					$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "Success";
					// 				} elseif ($doc->Data[0]->status == "FAILURE") {
					// 					$update['status'] = "failed";
					// 					$update['refno'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "Failed";
					// 					$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "Failed";
					// 				} elseif ($doc->Data[0]->status == "PENDING") {
					// 					$update['status'] = "pending";
					// 					$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "pending";
					// 				} else {
					// 					$update['status'] = "Unknown";
					// 				}
					// 			} else {
					// 				$update['status'] = "Unknown";
					// 			}
					// 		} else {
					// 			$update['status'] = "Unknown";
					// 		}
					// 		break;
					// }
					$product = "aeps";
					break;

				case 'matm':
					$doc = json_decode($result['response']);
					if (isset($doc->statuscode) && $doc->statuscode == "000") {
						if (isset($doc->Data[0]) && isset($doc->Data[0]->status)) {
							if (strtolower($doc->Data[0]->status) == "success") {
								$update['status'] = "complete";
								$update['amount'] = $doc->Data[0]->amount;
								$update['refno'] = $doc->Data[0]->rrn;
								$update['aadhar'] = $doc->Data[0]->cardno;
								$update['payid'] = isset($doc->Data[0]->stanno) ? $doc->Data[0]->stanno : "Failed";
								$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "Success";
							} elseif (strtolower($doc->Data[0]->status) == "failed") {
								$update['status'] = "failed";
								$update['amount'] = $doc->Data[0]->amount;
								$update['refno'] = isset($doc->Data[0]->rrn) ? $doc->Data[0]->rrn : "Failed";
								$update['payid'] = isset($doc->Data[0]->stanno) ? $doc->Data[0]->stanno : "Failed";
								$update['aadhar'] = $doc->Data[0]->cardno;
								$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "Failed";
							} elseif (strtolower($doc->Data[0]->status) == "pending") {
								$update['status'] = "pending";
								$update['amount'] = $doc->Data[0]->amount;
								$update['payid'] = isset($doc->Data[0]->stanno) ? $doc->Data[0]->stanno : "Failed";
								$update['refno'] = isset($doc->Data[0]->rrn) ? $doc->Data[0]->rrn : "Failed";
								$update['remark'] = isset($doc->Data[0]->bankmessage) ? $doc->Data[0]->bankmessage : "pending";
							} else {
								$update['status'] = "Unknown";
							}
						} else {
							$update['status'] = "Unknown";
						}
					} else {
						$update['status'] = "Unknown";
					}
					$product = "matm";
					break;

				case 'bcstatus':
					$doc = json_decode($result['response']);
					//dd($doc);

					if (isset($doc[0]->status) && $doc[0]->status == "Active") {
						$update['status'] = "success";
					} elseif (isset($doc[0]->status) && $doc[0]->status == "Rejected") {
						$update['status'] = "rejected";
						$update['remark'] = isset($doc[0]->remarks) ? $doc[0]->remarks : "Failed";
					} else {
						$update['status'] = "Unknown";
					}
					break;
				case 'ragentstatus':
				case 'ragentstatus2':
				case 'ragentstatus2':
					DB::table('rp_log')->insert([
						'ServiceName' => "check status ",
						'header' => json_encode($header),
						'body' => json_encode($parameter),
						'response' => $result['response'],
						'url' => $url,
						'created_at' => date('Y-m-d H:i:s')
					]);
					$doc = json_decode($result['response']);

					//dd( $doc,$result['response']);
					if (isset($doc->status) && $doc->status == true) {
						if (isset($doc->is_approved) && $doc->is_approved == "Accepted") {
							$update['status'] = "approved";
							$update['remark'] = isset($doc->message) ? $doc->message : "success";
						} else if (isset($doc->is_approved) && $doc->is_approved == "Pending") {
							$update['status'] = "pending";
							$update['remark'] = isset($doc->message) ? $doc->message : "Pending";
						} else {
							$update['status'] = "pending";
							$update['remark'] = isset($doc->message) ? $doc->message : "Failed";
						}
					} elseif (isset($doc->status) && $doc->status == false) {
						$update['status'] = "rejected";
						$update['remark'] = isset($doc->message) ? $doc->message : "Failed";
					} else {
						$update['status'] = "Unknown";
					}
					break;
			}

			if ($update['status'] != "Unknown") {
				switch ($post->type) {
					case 'recharge':
					case 'billpayment':
					case 'utipancard':
					case 'licbillpayment':
						// case 'money':
						$reportupdate = Report::updateOrCreate(['id' => $post->id], $update);
						if ($reportupdate && $update['status'] == "reversed") {
							\Myhelper::transactionRefund($post->id);
						}
						break;

					case 'bcstatus':
						$reportupdate = Agents::where('id', $post->id)->update($update);
						break;

					case 'aepstxnreport':
					case 'aeps':
						// $reportupdate = Aepsreport::updateOrCreate(['id' => $post->id], $update);

						// if ($report->status == "pending" && in_array($update['status'], ["complete", "success"])) {
						// 	$user = User::where('id', $report->user_id)->first();
						// 	$insert = [
						// 		"mobile" => $report->mobile,
						// 		"aadhar" => $report->aadhar,
						// 		"api_id" => $report->api_id,
						// 		"txnid" => $report->txnid,
						// 		"refno" => "Txnid - " . $report->id . " Cleared",
						// 		"amount" => $report->amount,
						// 		"bank" => $report->bank,
						// 		"user_id" => $report->user_id,
						// 		"balance" => $user->aepsbalance,
						// 		'aepstype' => $report->aepstype,
						// 		'status' => 'success',
						// 		'authcode' => $report->authcode,
						// 		'payid' => $report->payid,
						// 		'mytxnid' => $report->mytxnid,
						// 		'terminalid' => $report->terminalid,
						// 		'TxnMedium' => $report->TxnMedium,
						// 		'credited_by' => $report->credited_by,
						// 		'type' => 'credit'
						// 	];
						// 	if ($report->aepstype == "CW") {
						// 		if ($report->amount >= 500 && $report->amount <= 999) {
						// 			$provider = Provider::where('recharge1', 'aeps1')->first();
						// 		} elseif ($report->amount >= 1000 && $report->amount <= 1499) {
						// 			$provider = Provider::where('recharge1', 'aeps2')->first();
						// 		} elseif ($report->amount >= 1500 && $report->amount <= 1999) {
						// 			$provider = Provider::where('recharge1', 'aeps3')->first();
						// 		} elseif ($report->amount >= 2000 && $report->amount <= 2499) {
						// 			$provider = Provider::where('recharge1', 'aeps4')->first();
						// 		} elseif ($report->amount >= 2500 && $report->amount <= 2999) {
						// 			$provider = Provider::where('recharge1', 'aeps5')->first();
						// 		} elseif ($report->amount >= 3000 && $report->amount <= 5999) {
						// 			$provider = Provider::where('recharge1', 'aeps6')->first();
						// 		} elseif ($report->amount >= 6000 && $report->amount <= 10000) {
						// 			$provider = Provider::where('recharge1', 'aeps7')->first();
						// 		}
						// 	} else {
						// 		$provider = Provider::where('recharge1', 'aadharpay')->first();
						// 	}

						// 	$post['provider_id'] = $provider->id;
						// 	$post['service'] = $provider->type;

						// 	if ($report->aepstype == "CW") {
						// 		if ($report->amount >= 500) {
						// 			$usercommission = \Myhelper::getCommission($report->amount, $user->scheme_id, $post->provider_id, $user->role->slug);
						// 		} else {
						// 			$usercommission = 0;
						// 		}
						// 	} elseif ($report->aepstype == "AP") {
						// 		$usercommission = \Myhelper::getCommission($report->amount, $user->scheme_id, $post->provider_id, $user->role->slug);
						// 	} else {
						// 		$usercommission = 0;
						// 	}

						// 	$insert['charge'] = $usercommission;
						// 	if ($report->aepstype == "CW") {
						// 		$action = User::where('id', $report->user_id)->increment('aepsbalance', $report->amount + $usercommission);
						// 	} else {
						// 		$action = User::where('id', $report->user_id)->increment('aepsbalance', $report->amount - $usercommission);
						// 	}

						// 	if ($action) {
						// 		$aeps = Aepsreport::create($insert);
						// 		if ($report->amount > 500) {
						// 			\Myhelper::commission(Aepsreport::find($aeps->id));
						// 		}
						// 	}
						// }
						break;

					case 'matm':
						// $reportupdate = Microatmreport::where('id', $post->id)->update($update);

						// if ($report->status == "pending" && $update['status'] == "complete") {
						// 	$user = User::where('id', $report->user_id)->first();
						// 	$myreport = Microatmreport::where('id', $post->id)->first();

						// 	$insert = [
						// 		"mobile" => $myreport->mobile,
						// 		"aadhar" => $myreport->aadhar,
						// 		"api_id" => $myreport->api_id,
						// 		"txnid" => $myreport->txnid,
						// 		"refno" => "Txnid - " . $myreport->id . " Cleared",
						// 		"amount" => $myreport->amount,
						// 		"bank" => $myreport->bank,
						// 		"user_id" => $myreport->user_id,
						// 		"balance" => $user->aepsbalance,
						// 		'aepstype' => $myreport->aepstype,
						// 		'status' => 'success',
						// 		'authcode' => $myreport->authcode,
						// 		'payid' => $myreport->payid,
						// 		'mytxnid' => $myreport->mytxnid,
						// 		'terminalid' => $myreport->terminalid,
						// 		'TxnMedium' => $myreport->TxnMedium,
						// 		'credited_by' => $myreport->credited_by,
						// 		'type' => 'credit'
						// 	];

						// 	if ($myreport->amount > 0) {
						// 		if ($myreport->amount >= 500 && $myreport->amount <= 999) {
						// 			$provider = Provider::where('recharge1', 'matm1')->first();
						// 		} elseif ($myreport->amount > 1000 && $myreport->amount <= 1499) {
						// 			$provider = Provider::where('recharge1', 'matm2')->first();
						// 		} elseif ($myreport->amount > 1500 && $myreport->amount <= 1999) {
						// 			$provider = Provider::where('recharge1', 'matm3')->first();
						// 		} elseif ($myreport->amount > 2000 && $myreport->amount <= 2999) {
						// 			$provider = Provider::where('recharge1', 'matm4')->first();
						// 		} elseif ($myreport->amount > 3000 && $myreport->amount <= 3499) {
						// 			$provider = Provider::where('recharge1', 'matm5')->first();
						// 		} elseif ($myreport->amount > 3500 && $myreport->amount <= 4999) {
						// 			$provider = Provider::where('recharge1', 'matm6')->first();
						// 		} elseif ($myreport->amount > 5000 && $myreport->amount <= 10000) {
						// 			$provider = Provider::where('recharge1', 'matm7')->first();
						// 		}

						// 		$insert['provider_id'] = $provider->id;
						// 		if ($myreport->amount > 500) {
						// 			$insert['charge'] = \Myhelper::getCommission($myreport->amount, $user->scheme_id, $insert['provider_id'], $user->role->slug);
						// 		} else {
						// 			$insert['charge'] = 0;
						// 		}
						// 	} else {
						// 		$insert['provider_id'] = 0;
						// 		$insert['charge'] = 0;
						// 	}

						// 	$action = User::where('id', $report->user_id)->increment('aepsbalance', $myreport->amount + $insert['charge']);
						// 	if ($action) {
						// 		$matm = Aepsreport::create($insert);

						// 		if ($report->amount > 500) {
						// 			\Myhelper::commission(Aepsreport::find($matm->id));
						// 		}
						// 	}
						// }
						break;

					case 'utiid':
						$reportupdate = Utiid::updateOrCreate(['id' => $post->id], $update);
						break;
					case 'ragentstatus':
						$reportupdate = Aepsuser::where('id', $post->id)->update($update);
						break;
				}
			}
			return response()->json($update, 200);
		} else {
			return response()->json(['status' => "Status Not Fetched , Try Again."], 400);
		}
	}

	public function delete(Request $post)
	{
		if (\Myhelper::hasNotRole(['admin', 'whitelable'])) {
			return response()->json(['status' => "Permission Not Allowed"], 400);
		}

		switch ($post->type) {
			case 'slide':
				try {
					\Storage::delete($post->slide);
				} catch (\Exception $e) {
				}
				$action = true;
				if ($action) {
					PortalSetting::where('value', $post->slide)->delete();
					return response()->json(['status' => "success"], 200);
				} else {
					return response()->json(['status' => "Task Failed, please try again"], 200);
				}
				break;

			default:
				return response()->json(['status' => "Permission Not Allowed"], 400);
				break;
		}
	}

	public function getPToken($uniqueid)
	{
		$payload = [
			"timestamp" => time(),
			"partnerId" => 'PS003380', //$this->pdmt->username,
			"reqid" => $uniqueid
		];

		$key = "UFMwMDMzODBjZTI1ZjZkYzM4MGEzMDUzZTVmZjY0MDE4YjlkYzU3YQ=="; //$this->api->password;
		$signer = new HS256($key);
		$generator = new JwtGenerator($signer);
		return ['token' => $generator->generate($payload), 'payload' => $payload];
	}
}
