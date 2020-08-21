<?php

namespace App\Http\Middleware;

use Closure;
use Route, URL, Auth;

class AuthenticateAdmin
{

    protected $except = [
        'admin/index',
    ];

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->user()->id === 1) {
            return $next($request);
        }

        $previousUrl = URL::previous();
        //$routeName = starts_with(Route::currentRouteName(), 'admin.') ? Route::currentRouteName() : 'admin.' . Route::currentRouteName();

        $routeName = Route::currentRouteName();

        //不再使用admin前綴
        $routeName = str_replace('admin.', '', $routeName);

        //ㄋㄇㄉ
        if($request->getMethod() != 'GET'){
            if(strpos($routeName, 'datatable')){
                $routeName = str_replace('datatable', 'index', $routeName);
            }
            if(strpos($routeName, 'store')){
                $routeName = str_replace('store', 'create', $routeName);
            }
            if(strpos($routeName, 'update')){
                $routeName = str_replace('update', 'edit', $routeName);
            }
        }

        if (!\Gate::forUser(auth('admin')->user())->check($routeName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code'   => 403,
                    'msg'    => '您沒有權限執行此操作',
                ]);
            } else {
                if($routeName == 'index'){
                    return response()->view('admin.index.home');
                }
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }

        return $next($request);
    }
}
