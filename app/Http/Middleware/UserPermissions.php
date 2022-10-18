<?php

namespace App\Http\Middleware;

use App\Models\PageUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class UserPermissions
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
    public function handle(Request $request, Closure $next)
    {
        $AuthUser = Session::get('user-session');
        $user_id = $AuthUser['uid'];
        
        $pages = PageUser::join('page', 'page.page_id', '=', 'page_user.page_id')
        ->where('page_user.user_id', '=', $user_id)
        ->select('page.name')->orderBy('position')->get();

        // dd($pages);
        foreach($pages as $page) {
            if(Route::current()->getName() == $page->name) {
                return $next($request);
            }
        }
        
        return redirect()->back()->with('error', "You do not have access to this page!");
    }
}
