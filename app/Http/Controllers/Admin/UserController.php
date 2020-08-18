<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\AdminUser as User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{
    protected $fields = [
        'emp_id'    => '',
        'name'      => '',
        'email'     => '',
        'sex'       => 1,
        'mobile'    => '',
        'id_number' => '',
        'address'   => '',
        'birthday'  => '',
        'status'    => 1,
        'roles'     => [],
        'stores'    => [],
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
                })->where('id', '!=', 1)->count();

                $data['data'] = User::with(['roles'])->with(['stores'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })->where('id', '!=', 1)->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = User::count();
                $data['data'] = User::with(['roles'])->with(['stores'])->
                where('id', '!=', 1)->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.user.index');
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
        $data['rolesAll'] = Role::all()->toArray();

        $data['storesAll'] = Store::all()->toArray();

        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AdminUserCreateRequest $request)
    {
        $user = new User();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $user->$field = $request->get($field);
            }

            $user->password = bcrypt($request->get('password'));
            $user->emp_id = 0;
            unset($user->roles);
            unset($user->stores);
            $user->save();

            //自產員工編號
            $zero_num = 7 - strlen($user->id);
            $prefix = '';
            for($i = 0; $i <= $zero_num; $i++){
                $prefix .= '0';
            }
            $user->emp_id = 'z'.date('Ym').$prefix.$user->id;
            $user->save();

            if(\Gate::forUser(auth('admin')->user())->check('admin.role.edit')){
                if(empty($request->get('roles'))){
                    return redirect('/admin/user')->withErrors("請先新增角色!");
                }

                if (is_array($request->get('roles'))) {
                    $user->giveRoleTo($request->get('roles'));
                }
            }

            if (is_array($request->get('stores'))) {
                $user->giveStoreTo($request->get('stores'));
            }

            event(new \App\Events\userActionEvent('\App\Models\Admin\AdminUser', $user->id, 1, auth('admin')->user()->username . '新增了用戶：' . $user->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/admin/user')->withErrors($e->getMessage());
        }

        return redirect('/admin/user')->withSuccess('新增成功！');
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
        if (!$user) return redirect('/admin/user')->withErrors("找不到該用戶!");
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = $v->id;
            }
        }
        $user->roles = $roles;

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
        $data['rolesAll'] = Role::all()->toArray();
        $data['storesAll'] = Store::all()->toArray();
        $data['id'] = (int)$id;
        $data['store_manager'] = Store::where('admin_user_id', $id)->get()->toArray();
        
        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\AdminUserUpdateRequest $request, $id)
    {
        $user = User::find((int)$id);

        //禁止他人修改最高權限
        if($id == 1 && $id != auth('admin')->user()->id){
            return redirect('/admin/user')->withErrors("您沒有權限修改!");
        }

        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        unset($user->emp_id);
        unset($user->roles);
        unset($user->stores);

        if ($request->get('password') != '') {
            $user->password = bcrypt($request->get('password'));
        }

         try{
            DB::beginTransaction();

            $user->save();
            
            if(\Gate::forUser(auth('admin')->user())->check('admin.role.edit')){
                $user->giveRoleTo($request->get('roles', []));
            }

            if(\Gate::forUser(auth('admin')->user())->check('admin.store.edit')){
                $user->giveStoreTo($request->get('stores', []));
            }

            event(new \App\Events\userActionEvent('\App\Models\Admin\AdminUser', $user->id, 3, auth('admin')->user()->username . '編輯了用戶：' . $user->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/admin/user')->withErrors($e->getMessage());
        }


        return redirect('/admin/user')->withSuccess('修改成功！');
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
        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v);
        }

        foreach ($tag->stores as $v) {
            $tag->stores()->detach($v);
        }

        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\Admin\AdminUser', $tag->id, 2, auth('admin')->user()->username . "刪除了用戶：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
