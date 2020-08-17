<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\AdminUser;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = User::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = User::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = User::with(['stores'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = User::count();
                $data['data'] = User::with(['stores'])->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['storesAll'] = Store::all()->toArray();

        return view('admin.customer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserCreateRequest $request)
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

            event(new \App\Events\userActionEvent('\App\Models\User', $user->id, 1, '新增了客戶' . $user->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/admin/customer')->withErrors($e->getMessage());
        }

        return redirect('/admin/customer')->withSuccess('新增成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find((int)$id);
        if (!$user) return redirect('/admin/customer')->withErrors("找不到該客戶!");

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
        $data['id'] = (int)$id;
        
        return view('admin.customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserUpdateRequest $request, $id)
    {
        $user = User::find((int)$id);

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

            event(new \App\Events\userActionEvent('\App\Models\User', $user->id, 3, '編輯了客戶' . $user->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/admin/customer')->withErrors($e->getMessage());
        }


        return redirect('/admin/customer')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = User::find((int)$id);

        foreach ($tag->stores as $v) {
            $tag->stores()->detach($v);
        }

        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
