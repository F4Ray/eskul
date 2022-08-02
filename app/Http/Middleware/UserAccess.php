<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$userType)
    {
        // Session::flush();

        // Auth::logout();

        // return redirect('login');

        // if (auth()->user()->role->role == $userType) {
        //     return $next($request);
        // }
        // var_dump($userType);
        // dd(auth()->user()->role->role);
        // return response()->json(['You do not have permission to access for this page.']);
        /* return response()->view('errors.check-permission'); */

    //     dd($userType);
    //     $permissionRules = explode(',', $userType);

    // $userPermissions = $permissionRules['user']['permissions']; //Assuming this is an array of the Auth'ed user permissions. 

    // // If the user does not have every permission defined via route parameters, deny.
    // foreach ($permissionRules as $permission) {
    //     if (in_array($permission, $permissionRules)) {
    //         // Change this to see if the permission is in the array, opposed to NOT in the array
    //         return $next($request);
    //     }
    // }

    if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
        return redirect('login');

    $user = Auth::user();

    // if($user->isAdmin())
    //     return $next($request);
    // dd($userType);

    foreach($userType as $role) {
        // Check if user has the role This check will depend on how your roles are set up
        // if($user->hasRole($role))
        // {
        //     dd($user->hasRole($role));
        //     return $next($request);
        // }
        if (auth()->user()->role->role == $role) {
                return $next($request);
            }
    }

    return redirect('login');

    return response()->json(['You do not have permission to access for this page.']);
    }
}