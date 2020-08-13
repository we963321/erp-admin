<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Cache, Route;

class GetMenuWeb
{   
    //自訂路由
    const MENU = [
        [   
            'name'  => 'customer',
            'icon'  => '',
            'label' => '資料管理',
            'sub_menu' => [
                [
                    'name'  => 'mydata',
                    'icon'  => '',
                    'label' => '基本資料'
                ],
                [
                    'name'  => 'family',
                    'icon'  => '',
                    'label' => '家庭資料'
                ],
                [
                    'name'  => 'work',
                    'icon'  => '',
                    'label' => '工作資料'
                ],
            ]
        ]
    ];

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
     * 左側目錄
     * @return array
     */
    function getMenu()
    {
        $openArr = [];
        $data = [];
        $data['top'] = [];

        $path_arr = explode('/', \URL::getRequest()->path());
        if (isset($path_arr[1])) {
            $urlPath = $path_arr[0] . '.' . $path_arr[1];
        } else {
            $urlPath = $path_arr[0];
        }

        $default_menu = self::MENU;

        $customer_router = [];

        $i = 0;
        foreach ($default_menu as $key => $val) {
            $id = ++$i;

            $parent_menu = [
                'id'     => $id,
                'cid'    => 0,
                'name'   => $val['name'],
                'icon'   => $val['icon'],
                'label'  => $val['label'],
            ];

            array_push($customer_router, $parent_menu);

            foreach ($val['sub_menu'] as $sub_menu) {
                $sub_menu['id'] = ++$i;
                $sub_menu['cid'] = $id;
                $sub_menu['name'] = $parent_menu['name'].'.'.$sub_menu['name'];
                array_push($customer_router, $sub_menu);
            }
        }

        foreach ($customer_router as $v) {
            if ($v['cid'] == 0 || Route::has($v['name'])) {
                if ($v['name'] == $urlPath) {
                    $openArr[] = $v['id'];
                    $openArr[] = $v['cid'];
                }
                $data[$v['cid']][] = $v;
            }
        }

        foreach ($data[0] as $v) {
            if (isset($data[$v['id']]) && is_array($data[$v['id']]) && count($data[$v['id']]) > 0) {
                $data['top'][] = $v;
            }
        }
        unset($data[0]);

        $data['openarr'] = array_unique($openArr);

        return $data;
    }
}
