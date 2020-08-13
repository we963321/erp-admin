<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin\Store;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class CustomerController extends Controller
{   
    protected $fields = [
        'name'      => '',
        'cust_id'   => '',
        'email'     => '',
        'sex'       => 1,
        'mobile'    => '',
        'id_number' => '',
        'counties'  => '',
        'town'      => '',
        'address'   => '',
        'birthday'  => '',
        'marriage'  => 0,
        'customer_resource' => '',
        'introducer' => '',
        'line'       => '',
        'facebook'   => '',
        'tax_number' => '',
        'stores'     => [],
    ];

    public function register(Request $request)
    {
        if(!$request->isMethod('post')){
            $data = [];
            foreach ($this->fields as $field => $default) {
                $data[$field] = old($field, $default);
            }

            $data['storesAll'] = Store::all()->toArray();

            return view('customer.register', $data);
        }else{
            return redirect('/login');
        }
    }

    public function create(Requests\UserCreateRequest $request)
    {  
        $user = new User();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $user->$field = $request->get($field);
            }

            $user->password = bcrypt($request->get('password'));
            $user->cust_id = 0;
            $user->status = 1;
            unset($user->stores);
            $user->save();

            //自產客戶編號
            $zero_num = 7 - strlen($user->id);
            $prefix = '';
            for($i = 0; $i <= $zero_num; $i++){
                $prefix .= '0';
            }
            $user->cust_id = 'a'.date('Ym').$prefix.$user->id;
            $user->save();

            if (is_array($request->get('stores'))) {
                $user->giveStoreTo($request->get('stores'));
            }

            //event(new \App\Events\userActionEvent('\App\Models\User', $user->id, 1, '新註冊客戶' . $user->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/login')->withErrors($e->getMessage());
        }

        return redirect('/login')->withSuccess('註冊成功！');
    }

    public function mydata()
    {   
        $id = (int)auth('web')->user()->id;
        $user = User::find($id);
        if (!$user) return redirect('/home')->withErrors("找不到該客戶!");

        $stores = [];
        if ($user->stores) {
            foreach ($user->stores as $v) {
                $stores[] = $v->id;
            }
        }
        $user->stores = $stores;

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }
        $data['storesAll'] = Store::all()->toArray();
        
        return view('customer.mydata', $data);
    }

    public function saveMydata(Requests\UserUpdateRequest $request)
    {  
        $id = (int)auth('web')->user()->id;
        $user = User::find($id);
        if (!$user) return redirect('/home')->withErrors("找不到該客戶!");

        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        unset($user->email);
        unset($user->cust_id);
        unset($user->stores);

        if ($request->get('password') != '') {
            $user->password = bcrypt($request->get('password'));
        }

        try{
            DB::beginTransaction();

            $user->save();

            $user->giveStoreTo($request->get('stores', []));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/customer/mydata')->withErrors($e->getMessage());
        }

        return redirect('/customer/mydata')->withSuccess('修改成功！');
    }

    public function family()
    {
        return view('welcome');
    }

    public function work()
    {
        return view('welcome');
    }
}
