<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Cache, Route;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //view()->share('comData',$this->getMenu());
        $request->attributes->set('comData_menu', $this->getMenu());

        return $next($request);
    }

    /**
     * 獲取左邊菜單欄
     * @return array
     */
    function getMenu()
    {
        $openArr = [];
        $data = [];
        $data['top'] = [];
        //查找並拼接出地址的別名值
        $path_arr = explode('/', \URL::getRequest()->path());
        if (isset($path_arr[1])) {
            $urlPath = $path_arr[0] . '.' . $path_arr[1] . '.index';
        } else {
            $urlPath = $path_arr[0] . '.index';
        }
        //查找出所有的地址
        $table = Cache::store('file')->rememberForever('menus', function () {
            return \App\Models\Admin\Permission::where('name', 'LIKE', '%index')
                ->orWhere('cid', 0)
                ->get();
        });
        foreach ($table as $v) {
            if ($v->cid == 0 || \Gate::forUser(auth('admin')->user())->check($v->name) && Route::has($v->name)) {
                if ($v->name == $urlPath) {
                    $openArr[] = $v->id;
                    $openArr[] = $v->cid;
                }
                $data[$v->cid][] = $v->toarray();
            }
        }

        foreach ($data[0] as $v) {
            if (isset($data[$v['id']]) && is_array($data[$v['id']]) && count($data[$v['id']]) > 0) {
                $data['top'][] = $v;
            }
        }
        unset($data[0]);
        //ation open 可以在函數中計算給他
        $data['openarr'] = array_unique($openArr);

        return $data;

    }
}
