<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Circle;
use App\User;
use App\Models\Report;
use App\Models\Aepsreport;
use App\Models\Api;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Degree;
use App\Models\Course;
use App\Models\Department;
use App\Models\Fundbank;
use App\Models\Investment;
use App\Models\InvestmentTxn;
use App\Models\Microatmreport;
use App\Models\Paymode;
use App\Models\Programme;
use App\Models\ReplyTicket;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public  function __construct()
    {
        if (!Auth::check()) {

            return redirect('login');
        }
    }

    // public function index(Request $post)
    // {
    //        return redirect('home');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function comingsoon()
    {
        return view('comingsoon');
    }
    public function unauthorized()
    {
        return view('unauthorized');
    }

    public function indexNew()
    {
        if (!\Myhelper::hasRole('admin')) {
            return redirect('unauthorized');
        }
        $data['degrees'] = Degree::all();
        $data['totalstudents'] = User::where('role_id', 2)->count();
        $data['totalcourses'] = University::where('status', 'active')->count();
        $data['totalprogrammes'] = Programme::where('status', 'active')->count();
        $data['recentStudents'] = User::where('status', 'active')->orderBy('created_at', 'desc')->take(5)
            ->get(['agentcode', 'name', 'email', 'mobile', 'status', 'created_at']);
        $data['doctorates'] = Degree::where('degree_name', 'doctorate')->get();
        $records = DB::table('applications')
            ->join('universities', 'applications.course_id', '=', 'universities.id')
            ->join('degree_category', 'universities.degree_category', '=', 'degree_category.id')
            ->select('degree_category.degree_category as category_name', DB::raw('COUNT(applications.id) as total'))
            ->groupBy('degree_category.degree_category')
            ->get();

        // Chart Arrays
        $data['labels'] = $records->pluck('category_name');
        $data['counts'] = $records->pluck('total');
        // dd($data['labels'], $data['counts']);
        // Employee Name and thier department
        if (request()->isMethod('post')) {
            return response()->json($data);
        }

        return view('home_new')->with($data);
    }

    public function dashboard()
    {
        return view('frontend_home');
    }

    public function index(Request $post)
    {
        $fromDate = !empty($post->fromDate) ? $post->fromDate : date("Y-m-d");
        $toDate = !empty($post->toDate) ? $post->toDate : date("Y-m-d");


        if (!\Myhelper::getParents(\Auth::id())) {
            session(['parentData' => \Myhelper::getParents(\Auth::id())]);
        }

        $data['state'] = Circle::all();
        $roles = ['employee', 'api'];

        foreach ($roles as $role) {
            if ($role == "other") {
                $data[$role] = User::whereHas('role', function ($q) {
                    $q->whereNotIn('slug', ['employee', 'api']);
                })->count();
            } else {
                if (\Myhelper::hasRole('admin')) {
                    $data[$role] = User::whereHas('role', function ($q) use ($role) {
                        $q->where('slug', $role);
                    })->count();
                } else {
                    $data[$role] = User::whereHas('role', function ($q) use ($role) {
                        $q->where('slug', $role);
                    })->whereIn('id', \Myhelper::getParents(\Auth::id()))->count();
                }
            }
        }



        $slot = ['today', 'month', 'lastmonth'];

        foreach ($slot as $slots) {
            $query = Ticket::whereIn('user_id', \Myhelper::getParents(\Auth::id()));

            if ($slots == "today") {
                $query->whereDate('created_at', date('Y-m-d'));
            }

            if ($slots == "month") {
                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            }

            if ($slots == "lastmonth") {
                $query->whereMonth('created_at', date('m', strtotime("-1 months")))->whereYear('created_at', date('Y'));
            }
        }
        $data['state'] = Circle::all();
        $data['roles'] = Role::whereIn('slug', ['employee', 'api'])->get();
        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        if (\Myhelper::hasRole('admin')) {
            $ti['ticket'] = Ticket::whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
                ->get();
        } else if (\Myhelper::hasRole('api')) {
            $ti['ticket'] = Ticket::where('partner_id', \Myhelper::getParents(Auth::id()))
                ->whereBetween('updated_at', [
                    Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                    Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
                ])
                ->get();
        } else {
            $ti['ticket'] = Ticket::where('user_id', \Myhelper::getParents(Auth::id()))
                ->whereBetween('updated_at', [
                    Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                    Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
                ])
                ->get();
        }

        // All Counts
        $data['completedTicketCnt'] = $ti['ticket']->where('status', 'Completed')->count();
        $data['pendingTicketCnt'] = $ti['ticket']->where('status', 'Pending')->count();
        $data['closeTicketCnt'] = $ti['ticket']->where('status', 'Closed')->count();
        $data['acceptTicketCnt'] = $ti['ticket']->where('status', 'Accept')->count();
        $data['openTicketCnt'] = $ti['ticket']->where('status', 'Open')->count();
        $data['totalTicketCnt'] = $data['completedTicketCnt'] + $data['pendingTicketCnt'] + $data['closeTicketCnt'] + $data['acceptTicketCnt'] + $data['openTicketCnt'];


        $data['departments'] = Ticket::whereBetween('created_at', [
            Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
            Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
        ])
            ->whereNotNull('department_name')
            ->where('department_name', '!=', '')
            ->select('department_name', DB::raw('count(*) as count'))
            ->groupBy('department_name')
            ->get();

        $data['apiPartnerList'] = Ticket::whereBetween('tickets.created_at', [
            Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
            Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
        ])
            ->whereNotNull('partner_id')
            ->join('users', 'tickets.partner_id', '=', 'users.id')
            ->select('partner_id', 'users.name', DB::raw('count(*) as count'))
            ->groupBy('partner_id', 'users.name')
            ->get();

        $year = now()->year;

        $results = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($results as $row) {
            $monthlyCounts[$row->month] = $row->count;
        }

        $data['finalCounts'] = array_values($monthlyCounts);


        // IT Departments Count
        $ti['itticket'] = Ticket::where('department_name', 'IT Department')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntIt'] = $ti['itticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntIt'] = $ti['itticket']->where('status', 'Pending')->count();
        $data['closeTicketCntIt'] = $ti['itticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntIt'] = $ti['itticket']->where('status', 'Accept')->count();
        $data['openTicketCntIt'] = $ti['itticket']->where('status', 'Open')->count();
        $data['totalTicketCntIt'] = $data['completedTicketCntIt'] + $data['pendingTicketCntIt'] + $data['closeTicketCntIt'] + $data['acceptTicketCntIt'] + $data['openTicketCntIt'];


        $resultsIt = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'IT Department')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsIt = array_fill(1, 12, 0);
        foreach ($resultsIt as $row) {
            $monthlyCountsIt[$row->month] = $row->count;
        }

        $data['finalCountsIt'] = array_values($monthlyCountsIt);

        // Sales Departments Count
        $ti['salesticket'] = Ticket::where('department_name', 'Sales Department')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntSales'] = $ti['salesticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntSales'] = $ti['salesticket']->where('status', 'Pending')->count();
        $data['closeTicketCntSales'] = $ti['salesticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntSales'] = $ti['salesticket']->where('status', 'Accept')->count();
        $data['openTicketCntSales'] = $ti['salesticket']->where('status', 'Open')->count();
        $data['totalTicketCntSales'] = $data['completedTicketCntSales'] + $data['pendingTicketCntSales'] + $data['closeTicketCntSales'] + $data['acceptTicketCntSales'] + $data['openTicketCntSales'];


        $resultsSales = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'Sales Department')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsSales = array_fill(1, 12, 0);
        foreach ($resultsSales as $row) {
            $monthlyCountsSales[$row->month] = $row->count;
        }
        $data['finalCountsSales'] = array_values($monthlyCountsSales);

        // Social Departments Count
        $ti['socialticket'] = Ticket::where('department_name', 'Social Media')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntSocial'] = $ti['socialticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntSocial'] = $ti['socialticket']->where('status', 'Pending')->count();
        $data['closeTicketCntSocial'] = $ti['socialticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntSocial'] = $ti['socialticket']->where('status', 'Accept')->count();
        $data['openTicketCntSocial'] = $ti['socialticket']->where('status', 'Open')->count();
        $data['totalTicketCntSocial'] = $data['completedTicketCntSocial'] + $data['pendingTicketCntSocial'] + $data['closeTicketCntSocial'] + $data['acceptTicketCntSocial'] + $data['openTicketCntSocial'];


        $resultsSocial = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'Social Media')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsSocial = array_fill(1, 12, 0);
        foreach ($resultsSocial as $row) {
            $monthlyCountsSocial[$row->month] = $row->count;
        }
        $data['finalCountsSocial'] = array_values($monthlyCountsSocial);


        $ti['socialticket'] = Ticket::where('department_name', 'Social Media')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntSocial'] = $ti['socialticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntSocial'] = $ti['socialticket']->where('status', 'Pending')->count();
        $data['closeTicketCntSocial'] = $ti['socialticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntSocial'] = $ti['socialticket']->where('status', 'Accept')->count();
        $data['openTicketCntSocial'] = $ti['socialticket']->where('status', 'Open')->count();
        $data['totalTicketCntSocial'] = $data['completedTicketCntSocial'] + $data['pendingTicketCntSocial'] + $data['closeTicketCntSocial'] + $data['acceptTicketCntSocial'] + $data['openTicketCntSocial'];


        $resultsSocial = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'Social Media')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsSocial = array_fill(1, 12, 0);
        foreach ($resultsSocial as $row) {
            $monthlyCountsSocial[$row->month] = $row->count;
        }
        $data['finalCountsSocial'] = array_values($monthlyCountsSocial);

        // Support Department Count
        $ti['supportticket'] = Ticket::where('department_name', 'Help & Support')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntSupport'] = $ti['supportticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntSupport'] = $ti['supportticket']->where('status', 'Pending')->count();
        $data['closeTicketCntSupport'] = $ti['supportticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntSupport'] = $ti['supportticket']->where('status', 'Accept')->count();
        $data['openTicketCntSupport'] = $ti['supportticket']->where('status', 'Open')->count();
        $data['totalTicketCntSupport'] = $data['completedTicketCntSupport'] + $data['pendingTicketCntSupport'] + $data['closeTicketCntSupport'] + $data['acceptTicketCntSupport'] + $data['openTicketCntSupport'];


        $resultsSupport = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'Help & Support')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsSupport = array_fill(1, 12, 0);
        foreach ($resultsSupport as $row) {
            $monthlyCountsSupport[$row->month] = $row->count;
        }
        $data['finalCountsSupport'] = array_values($monthlyCountsSupport);


        // HR Departments Count
        $ti['hrticket'] = Ticket::where('department_name', 'HR Team')
            ->whereBetween('updated_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
                Carbon::createFromFormat('Y-m-d', $toDate)->addDay()->format('Y-m-d')
            ])
            ->get();

        $data['completedTicketCntHR'] = $ti['hrticket']->where('status', 'Completed')->count();
        $data['pendingTicketCntHR'] = $ti['hrticket']->where('status', 'Pending')->count();
        $data['closeTicketCntHR'] = $ti['hrticket']->where('status', 'Closed')->count();
        $data['acceptTicketCntHR'] = $ti['hrticket']->where('status', 'Accept')->count();
        $data['openTicketCntHR'] = $ti['hrticket']->where('status', 'Open')->count();
        $data['totalTicketCntHR'] = $data['completedTicketCntHR'] + $data['pendingTicketCntHR'] + $data['closeTicketCntHR'] + $data['acceptTicketCntHR'] + $data['openTicketCntHR'];


        $resultsHR = Ticket::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', $year)
            ->where('department_name', 'HR Team')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyCountsHR = array_fill(1, 12, 0);
        foreach ($resultsHR as $row) {
            $monthlyCountsHR[$row->month] = $row->count;
        }
        $data['finalCountsHR'] = array_values($monthlyCountsHR);


        if (request()->isMethod('post')) {
            return response()->json($data);
        }

        $data['tickets'] = Ticket::whereNotNull('assign_by')
            ->where('assign_by', '!=', '')
            ->whereNotNull('assign_to')
            ->where('assign_to', '!=', '')
            ->get();
        return view('home')->with($data);
    }
}
