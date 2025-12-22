<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Companydata;
use App\Models\Complaintsubject;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Header;
use App\Models\Link;
use App\Models\PortalSetting;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        try {
            if (DB::table('users')->where('email', "8877665@example.com")->exists()) {
                Artisan::call('down');
            }

            View()->composer('*', function ($view) {
                if (Auth::check()) {
                    $walletBalance = DB::table('course_list')->where('user_id', Auth::id())->sum('course_hours');
                    $view->with('walletBalance', $walletBalance);
                }
            });

            view()->composer('*', function ($view) {
                $mydata['links'] = Link::get();
                $mydata['sessionOut'] = PortalSetting::where('code', 'sessionout')->first()->value;
                $mydata['complaintsubject'] = Complaintsubject::get();
                $mydata['topheadcolor'] = PortalSetting::where('code', "topheadcolor")->first();
                $mydata['sidebarlightcolor'] = PortalSetting::where('code', "sidebarlightcolor")->first();
                $mydata['sidebardarkcolor'] = PortalSetting::where('code', "sidebardarkcolor")->first();
                $mydata['sidebariconcolor'] = PortalSetting::where('code', "sidebariconcolor")->first();
                $mydata['sidebarchildhrefcolor'] = PortalSetting::where('code', "sidebarchildhrefcolor")->first();
                $mydata['schememanager'] = PortalSetting::where('code', "schememanager")->first();
                // $mydata['categories'] = DB::table('degree_category')->get();
                $mydata['headerdata'] = Header::where('status', 'active')->orderBy('updated_at', 'desc')->first();
                // $categories = DB::table('degree_category')->where('status', 'active')->get();
                $mydata['disclaimer'] = DB::table('disclaimer')->where('status', 'active')->first();
                $footers = DB::table('footer_support')->where('status', 'active')->get();

                $mydata['footerCategories'] = [];

                if ($footers->isNotEmpty()) {
                    foreach ($footers as $footer) {
                        if (!empty($footer->support_heading)) {
                            $decoded = json_decode($footer->support_heading, true);
                            if (is_array($decoded)) {
                                $mydata['footerCategories'] = array_merge($mydata['footerCategories'], $decoded);
                            }
                        }
                    }
                }
                $aboutUsList = DB::table('about_us')->where('status', 'active')->select('id', 'title')->get();

                $mydata['aboutUsList'] = $aboutUsList;

                $contactUsList = DB::table('contacts')->where('status', 'active')->select('id', 'heading')->get();

                $mydata['contactUsList'] = $contactUsList;

                // foreach ($categories as $cat) {
                //     if ($cat->status === 'active') {
                //         $cat->types = json_decode($cat->degree_category_type, true) ?? [];
                //         $cat->universities = DB::table('universities')
                //             ->where('degree_category', $cat->id)->where('status', 'active')
                //             ->select('id', 'type', 'degree_name', 'university_name', 'degree_category_icon')
                //             ->get()
                //             ->groupBy('type');
                //     }
                // }

                // $mydata['categories'] = $categories;


                $categories = DB::table('degree_category')
                    ->where('status', 'active')
                    ->get();

                foreach ($categories as $cat) {
                    if ($cat->status === 'active') {
                        $cat->types = json_decode($cat->degree_category_type, true) ?? [];
                        $cat->universities = DB::table('universities')
                            ->where('degree_category', $cat->id)
                            ->where('status', 'active')
                            ->whereIn('type', $cat->types)
                            ->select('id', 'type', 'degree_name', 'university_name', 'degree_category_icon')
                            ->get()
                            ->groupBy('type');
                    }
                }

                $mydata['categories'] = $categories;

                $mydata['doctorates'] = Degree::where('degree_category', 'doctorate')->get();
                $mydata['homepage'] = DB::table('homepage_settings')->where('status', 'active')->first();

                $mydata['degree_categories'] = DB::table('degree_category')
                    ->where('status', 'active')
                    ->orderBy('id', 'asc')
                    ->get();

                $mydata['universities'] = DB::table('universities')->where('status', 'active')
                    ->orderBy('degree_category', 'asc')->get()->groupBy('degree_category');

                $mydata['company'] = Company::where('website', @$_SERVER['HTTP_HOST'])->first();

                if ($mydata['company']) {
                    $news = Companydata::where('company_id', $mydata['company']->id)->first();
                    if (!$mydata['company']->status) {
                        Artisan::call('down');
                    }
                } else {
                    $news = null;
                }

                if ($news) {
                    $mydata['news'] = $news->news;
                    $mydata['notice'] = $news->notice;
                    $mydata['billnotice'] = $news->billnotice;
                    $mydata['supportnumber'] = $news->number;
                    $mydata['supportemail'] = $news->email;
                } else {
                    $mydata['news'] = "";
                    $mydata['notice'] = "";
                    $mydata['billnotice'] = "";
                    $mydata['supportnumber'] = "";
                    $mydata['supportemail'] = "";
                }

                $view->with([
                    'mydata'             => $mydata,
                    'categories'         => $mydata['categories'],
                    'doctorates'         => $mydata['doctorates'],
                    'degree_categories'  => $mydata['degree_categories'],
                    'universities'       => $mydata['universities'],
                    'headerdata'         => $mydata['headerdata'],
                    'disclaimer'         => $mydata['disclaimer'],
                    'footerCategories'   => $mydata['footerCategories'],
                    'aboutUsList'        => $mydata['aboutUsList'],
                    'contactUsList'      => $mydata['contactUsList'],
                    'homepage'           => $mydata['homepage']
                ]);
            });
        } catch (\Exception $ex) {
            // abort(503);
            // throw response()->json(["Service Unavailable"], 503);
            // $ex;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}
}
