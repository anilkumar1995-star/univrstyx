<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBankAccess
{
    public function handle(Request $request, Closure $next)
    {
       $user = auth()->user();

        if ($user && ($user->department_id == 2 || \Myhelper::hasRole('admin'))) {
            return $next($request);
        }

        return redirect('unauthorized');
    }
    
}
