<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\ChatTemplate;
use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\Company;
use App\Models\Provider;
use App\Models\Commission;
use App\Models\Companydata;
use App\Models\ContactList;
use App\Models\Packagecommission;
use App\Models\Package;
use App\Services\ChatServices;
use App\User;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function index()
    {
       if(!\Myhelper::hasRole('admin')){
         return redirect('unauthorized');
        }
        return view('api.index');
    }
}
