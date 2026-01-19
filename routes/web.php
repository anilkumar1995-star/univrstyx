<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\BillpayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Userendontroller;
use App\Models\Application;
use Illuminate\Support\Facades\Route;



Route::get('/', [Userendontroller::class, 'index']);
// Route::get('/course/{id}', [CourseController::class, 'CourseDetails'])->name('CourseDetails');

Route::get('programmes/list', [DegreeController::class, 'showProgramme'])->name('showProgramme');
Route::get('/programme/{id}', [DegreeController::class, 'show'])->name('programme.show');
Route::get('programmes/{id}', [DegreeController::class, 'showVertical'])->name('verticals.show');
Route::post('/programmes/filter', [SettingController::class, 'filterCourses'])->name('programmes.filter');
// Route::get('/get-types', [EducationController::class, 'getTypes'])->name('get.types.by.category');
// Route::get('/get-universities', [EducationController::class, 'getUniversities'])->name('get.universities.by.type');
Route::get('/degree-category/details/{id}', [DegreeController::class, 'getDetails']);
Route::get('category/{id}/{type}', [DegreeController::class, 'showAll'])->name('category.show');
Route::get('/university/details/{id}', [DegreeController::class, 'getDetailsUniversity']);
Route::get('/programme/details/{id}', [DegreeController::class, 'getProgrammeDetails']);
Route::get('/search', [SettingController::class, 'searchData'])->name('search');
Route::get('community/view', [ApplicationController::class, 'communityView'])->name('community.view');
Route::get('learnersupport/get/{id}', [SettingController::class, 'getDataLearnerSupport']);


Route::middleware(['auth'])->group(function () {
Route::get('/employment/list', [EducationController::class, 'getEmploymentList'])->name('employmentView');
Route::get('/award/list', [EducationController::class, 'getAwardList'])->name('awardView');
Route::get('/testimonials/list', [EducationController::class, 'Testimonial'])->name('testimonial');
Route::get('/instructors/list', [EducationController::class, 'ShowInstructor'])->name('instructor');
Route::get('/learnersupport/list', [EducationController::class, 'ShowLearnerSupport'])->name('learnersupport');
Route::get('/disclaimer/list', [EducationController::class, 'ShowDisclaimer'])->name('disclaimer');
Route::post('/Disclaimer/add', [EducationController::class, 'DisclaimerAdd'])->name('addDisclaimer');
Route::get('/slider/list', [EducationController::class, 'Slider'])->name('slider');
Route::get('/header/list', [EducationController::class, 'Header'])->name('header');
Route::post('/header/add', [EducationController::class, 'HeaderAdd'])->name('addHeader');
Route::get('/announcements/list', [EducationController::class, 'Notification'])->name('Notification');
Route::post('/announcements/add', [EducationController::class, 'NotificationAdd'])->name('addNotification');
Route::post('/testimonials/add', [EducationController::class, 'TestimonialAdd'])->name('addTestimonial');
Route::post('/instructor/add', [EducationController::class, 'InstructorAdd'])->name('addInstructor');
Route::post('/learnerSupport/add', [EducationController::class, 'LearnerSupportAdd'])->name('addLearnerSupport');
Route::post('/slider/add', [EducationController::class, 'SliderAdd'])->name('addSlider');
Route::post('/employment/add', [EducationController::class, 'getEmploymentAdd'])->name('addHiringPartner');
Route::post('/add/award', [EducationController::class, 'AwardAdd'])->name('addAward');
Route::get('/primary/color', [SettingController::class, 'getPrimaryList'])->name('primary.list');
Route::post('/primaryColor/add', [SettingController::class, 'addPrimaryColor'])->name('addPrimaryColor');
Route::get('grievance/get/{id}', [ApplicationController::class, 'get']);
Route::post('grievance/reply', [ApplicationController::class, 'reply'])->name('grievance.reply');
Route::get('homepage/settings', [SettingController::class, 'homepageView'])->name('homepage.list');
Route::post('/homepage-settings/save', [SettingController::class, 'saveHomepageData'])->name('homepage.settings.save');
Route::get('community/list', [ApplicationController::class, 'communityList'])->name('community.list');
Route::post('/community/save', [ApplicationController::class, 'communitySave'])->name('community.save');
Route::get('/community/edit/{id}', [ApplicationController::class, 'communityEdit'])->name('community.edit');

});


Route::middleware(['auth'])->group(function () {
    Route::post('/applications/save-step', [ApplicationController::class, 'saveStep'])->name('applications.saveStep');
    Route::post('/applications/finalize', [ApplicationController::class, 'finalize'])->name('applications.finalize');
    Route::get('/applications/{programme}/draft', [ApplicationController::class, 'getDraft'])->name('applications.getDraft');
});

Route::group(['prefix' => 'statement', 'middleware' => ['auth', 'company']], function () {
    Route::get("export/{type}", [StatementController::class, 'export'])->name('export');
    Route::get('{type}/{id?}/{status?}', [StatementController::class, 'index'])->name('statement');
    Route::post('fetch/{type}/{id?}/{returntype?}', [CommonController::class, 'fetchData']);
    Route::group(['middleware' => ["webActivityLog"]], function () {
        Route::post('update', [CommonController::class, 'update'])->name('statementUpdate');
        Route::post('status', [CommonController::class, 'status'])->name('statementStatus');
        Route::post('delete', [CommonController::class, 'delete'])->name('statementDelete');
    });
});
Route::get('/privecy-policy', function () {
    return view('privecy-policy');
});
Route::get('/online-grievance', function () {
    return view('footer.online_grievance');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::group(['prefix' => 'auth', "middleware" => ['webActivityLog']], function () {
    Route::post('check', [UserController::class, 'login'])->name('authCheck');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('reset', [UserController::class, 'passwordReset'])->name('authReset')->middleware('CheckPasswordAndPin:password');
    Route::post('register', [UserController::class, 'registration'])->name('register');
    Route::post('getotp', [UserController::class, 'getotp'])->name('getotp');
    Route::post('setpin', [UserController::class, 'setpin'])->name('setpin')->middleware('CheckPasswordAndPin:tpin');
    Route::post('gettxnotp', [UserController::class, 'gettxnotp'])->name('gettxnotp');
});

Route::get('comingsoon', [HomeController::class, 'comingsoon'])->name('comingsoon');
Route::get('unauthorized', [HomeController::class, 'unauthorized'])->name('unauthorized');


Route::group(['middleware' => ['auth', 'company', 'webActivityLog']], function () {
    Route::get('/dashboard', [HomeController::class, 'indexNew'])->name('homeNew');

    Route::post('/dashboard', [HomeController::class, 'indexNew'])->name('homeNew');
    Route::get('student-dashboard', [Userendontroller::class, 'indexStudent']);
    Route::post('student-dashboard', [Userendontroller::class, 'indexStudent']);
});
Route::group(['prefix' => 'tools', 'middleware' => ['auth', 'company', 'webActivityLog']], function () {
    Route::get('{type}', [RoleController::class, 'index'])->name('tools');
    Route::post('{type}/store', [RoleController::class, 'store'])->name('toolsstore');
    Route::post('setpermissions', [RoleController::class, 'assignPermissions'])->name('toolssetpermission');
    Route::post('get/permission/{id}', [RoleController::class, 'getpermissions'])->name('permissions');
    Route::post('getdefault/permission/{id}', [RoleController::class, 'getdefaultpermissions'])->name('defaultpermissions');
});

Route::group(['prefix' => 'holiday', 'middleware' => ['auth', 'company']], function () {
    Route::get('list', [HolidayController::class, 'holidayView'])->name('holidayView');
    Route::post('add', [HolidayController::class, 'holidayCreate'])->name('festDetStore');
    Route::post('delete', [HolidayController::class, 'syllabusDelete'])->name('syllabusDelete');
});

Route::group(['prefix' => 'application', 'middleware' => ['auth', 'company']], function () {
    Route::get('/programme/apply/{id}', [ApplicationController::class, 'applyPage'])->name('programme.apply');
    Route::get('/screening/{id}', [ApplicationController::class, 'screening'])->name('application.screening');
    Route::post('/screening/store', [ApplicationController::class, 'storeApplication'])->name('screening.store');
    Route::get('/reserve-seat/{id}', [ApplicationController::class, 'reserveSeat'])->name('reserve.seat');
    Route::get('/checkout/{id}', [ApplicationController::class, 'checkout'])->name('checkout');
    Route::get('list', [ApplicationController::class, 'applicationView'])->name('application.list');
    Route::get('grievance', [ApplicationController::class, 'grievanceView'])->name('grievance.list');
    Route::post('add', [ApplicationController::class, 'store'])->name('application.store');
    Route::post('delete', [ApplicationController::class, 'destroy'])->name('application.destroy');
});
Route::group(['prefix' => 'degree', 'middleware' => ['auth', 'company']], function () {
    Route::get('list', [DegreeController::class, 'degreeView'])->name('degreeView');
    Route::get('categorylist', [DegreeController::class, 'degreeCategoryView'])->name('degreeCategoryView');
    Route::post('add', [DegreeController::class, 'degreeCreate'])->name('addDegree');
    Route::post('addcategory', [DegreeController::class, 'degreeCategoryCreate'])->name('addDegreeCategory');
    Route::post('addcategorytype', [DegreeController::class, 'degreeCategoryTypeCreate'])->name('addDegreeCategoryType');
    Route::post('university', [DegreeController::class, 'addUniversities'])->name('university');
    Route::post('programme', [DegreeController::class, 'addProgramme'])->name('programme');
    Route::post('delete', [DegreeController::class, 'syllabusDelete'])->name('syllabusDelete1');
});

Route::group(['prefix' => 'education', 'middleware' => ['auth', 'company']], function () {
    Route::get('/fee/list', [EducationController::class, 'index'])->name('coursefeeView');
    Route::get('/fees/list', [EducationController::class, 'FeesList'])->name('fees.list');
    Route::get('/tution/fee', [EducationController::class, 'TutionFee'])->name('tution.fee');
    Route::get('/hostel/fee', [EducationController::class, 'HostelFee'])->name('hostel.fee');
    Route::get('/college/fee', [EducationController::class, 'CollegeFee'])->name('college.fee');
    Route::get('/school/fee', [EducationController::class, 'SchoolFee'])->name('school.fee');
    Route::get('/hobby/fee', [EducationController::class, 'HobbyFee'])->name('hobby.fee');
    Route::get('/daycare/fee', [EducationController::class, 'DaycareFee'])->name('daycare.fee');
    Route::get('/educationfees', [EducationController::class, 'EducationFee'])->name('education.fee');
    Route::post('/fee/submit', [EducationController::class, 'FeeSubmit'])->name('submit.fee');
});

Route::group(['prefix' => 'billpay', 'middleware' => ['auth']], function () {
    Route::get('{type}', [BillpayController::class, 'index'])->name('bill');
     Route::post('/states', [BillpayController::class, 'states']);
    Route::post('/cities', [BillpayController::class, 'cities']);
    Route::post('payment', [BillpayController::class, 'payment'])->name('billpay')->middleware('transactionlog:billpay');
    Route::post('getprovider', [BillpayController::class, 'getprovider'])->name('getprovider');
    Route::post('providersByName', [BillpayController::class, 'getProvidersByNameSearch'])->name('providersByName');
});

// Route::group(['prefix' => 'course', 'middleware' => ['auth', 'company']], function () {
Route::group(['prefix' => 'course'], function () {
    Route::get('list', [CourseController::class, 'courseView'])->name('courseView');
    Route::get('/get-free-course-status/{userId}', [CourseController::class, 'ShowHideStatus'])->name('ShowHide');
    Route::get('categorylist', [CourseController::class, 'courseCategoryView'])->name('courseCategoryView');
    Route::post('add', [CourseController::class, 'courseCreate'])->name('addCourse');
    Route::post('showhide', [CourseController::class, 'addShowHide'])->name('addShowHide');
    Route::post('fee', [EducationController::class, 'addFee'])->name('addFee');
    Route::post('payfee', [EducationController::class, 'fetchFee'])->name('fetchFee');
    Route::post('paybill', [EducationController::class, 'payBill'])->name('billPayment');
    Route::post('getbill', [EducationController::class, 'getBillerDetails'])->name('getBillerDetails');
    Route::post('addcategory', [CourseController::class, 'courseCategory'])->name('addCategory');
    Route::post('delete', [CourseController::class, 'courseDelete'])->name('courseDelete');
    Route::get('{id}', [CourseController::class, 'CourseDetails'])->name('course.viewcourse');
    Route::get('details/{id}', [CourseController::class, 'CourseDetailsAjax'])->name('course.details.ajax');
});
Route::group(['prefix' => 'footer'], function () {
    Route::get('categorylist', [FooterController::class, 'footerView'])->name('footerCategoryView');
    Route::get('media', [FooterController::class, 'mediaView'])->name('ourpresencemedia');
    Route::get('aboutus', [FooterController::class, 'aboutUsView'])->name('aboutus');
    Route::get('contactus', [FooterController::class, 'contactUsView'])->name('contactus');
    Route::get('support/edit/{id}', [FooterController::class, 'editFooterSupport']);
    Route::get('about-us/{id}', [FooterController::class, 'show'])->name('footer.about.show');
    Route::get('contact-us/{id}', [FooterController::class, 'showContactDetails'])->name('footer.contact.show');


    Route::get('about-us/{id}/edit', [FooterController::class, 'aboutUsEdit'])->name('aboutus.edit');
    Route::get('contact-us/{id}/edit', [FooterController::class, 'contactUsEdit'])->name('contactus.edit');
    Route::get('support/{index}', [FooterController::class, 'showSupport'])->name('support.show');
    Route::post('add', [FooterController::class, 'footerSupportCreate'])->name('addSupport');
    Route::post('addaboutus', [FooterController::class, 'aboutUsCreate'])->name('addAboutUs');
    Route::post('grievance/save', [FooterController::class, 'saveGrievance'])->name('grievance.save');
    Route::post('addcontactus', [FooterController::class, 'contactUsCreate'])->name('addContactUs');
    Route::post('addMedia', [FooterController::class, 'footerMediaCreate'])->name('addMedia');
});

Route::group(['prefix' => 'goal'], function () {
    Route::get('list', [Userendontroller::class, 'goalsView'])->name('goalsView');
    Route::post('add', [Userendontroller::class, 'goalsCreate'])->name('addGoals');
});

Route::group(['prefix' => 'member', 'middleware' => ['auth', 'company']], function () {

    Route::get('salary/details', [MemberController::class, 'salaryView'])->name('salaryView');
    Route::post('salary', [MemberController::class, 'salaryCreate'])->name('salaryDetStore');

    Route::get('{type}/{action?}', [MemberController::class, 'index'])->name('member');
    Route::post('store', [MemberController::class, 'create'])->middleware('webActivityLog')->name('memberstore');
    Route::post('commission/update', [MemberController::class, 'commissionUpdate'])->middleware('webActivityLog')->name('commissionUpdate'); //->middleware('activity');
    Route::post('getcommission', [MemberController::class, 'getCommission'])->name('getMemberCommission');
    Route::post('getpackagecommission', [MemberController::class, 'getPackageCommission'])->name('getMemberPackageCommission');
});
// web.php
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/save-step', [UserController::class, 'saveStep'])->name('save.step');
Route::post('/complete-signup', [UserController::class, 'completeSignup'])->name('final.signup');



Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'company']], function () {

    Route::get('/view/{id?}', [SettingController::class, 'index'])->name('profile');
    Route::post('user_profile_update', [SettingController::class, 'profileUpdate'])->middleware('webActivityLog')->name('profileUpdate');
});

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'company', "webActivityLog"]], function () {
    Route::get('log', [ApiController::class, 'index'])->name('apilog');
});


Route::fallback(function () {
    return "url not found";
});
