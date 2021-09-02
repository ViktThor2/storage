<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Company;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->company){
            session()->put('company', Company::find($request->company));
        }

        if (Auth::guard($guard)->check()) {
            return redirect(route('admin.stocks.index'));
        }

        $companies = Company::all();
        session()->put('companies', $companies);

        return $next($request);
    }
}
