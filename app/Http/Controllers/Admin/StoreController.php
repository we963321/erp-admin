<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Store;
use App\Models\Admin\AdminUser as User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class StoreController extends Controller
{
    protected $fields = [
        'admin_user_id' => '',
        'code'          => '',
        'name'          => '',
        'short_name'    => '',
        'description'   => '',
        'mobile'        => '',
        'counties'      => '',
        'town'          => '',
        'address'       => '',
        'remark'        => '',
        'status'        => 1,
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
            $data['recordsTotal'] = Store::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = Store::with(['admin_user'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('short_name', 'like', '%' . $search['value'] . '%')
                        ->orWhere('mobile', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = Store::with(['admin_user'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('short_name', 'like', '%' . $search['value'] . '%')
                        ->orWhere('mobile', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = Store::count();
                $data['data'] = Store::with(['admin_user'])->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.store.index');
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

        $admin_user = User::select(['id', 'name', 'emp_id', 'mobile'])->where('status', '1')->get()->toArray();
        if(empty($admin_user)){
            return redirect('/'.env('ADMIN_PREFIX').'/store')->withErrors("請您先新增管理員");
        }

        $data['admin_user'] = $admin_user;

        return view('admin.store.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreCreateRequest $request)
    {
        $store = new Store();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $store->$field = $request->get($field);
            }

            $store->code = 0;
            $store->save();

            //自產編號
            $zero_num = 5 - strlen($store->id);
            $prefix = '';
            for($i = 0; $i <= $zero_num; $i++){
                $prefix .= '0';
            }
            $store->code = 'A'.$prefix.$store->id;
            $store->save();

            event(new \App\Events\userActionEvent('\App\Models\Admin\Store', $store->id, 1, auth('admin')->user()->username . '新增了店別：' . $store->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }

        return redirect('/'.env('ADMIN_PREFIX').'/store')->withSuccess('新增成功！');
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
        $store = Store::find((int)$id);
        if (!$store) return redirect('/'.env('ADMIN_PREFIX').'/store')->withErrors("找不到該店別!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $store->$field);
        }

        $admin_user = User::select(['id', 'name', 'emp_id', 'mobile'])->where('status', '1')->get()->toArray();
        $data['admin_user'] = $admin_user;

        $data['id'] = (int)$id;

        return view('admin.store.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreUpdateRequest $request, $id)
    {
        $store = Store::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $store->$field = $request->get($field);
        }

        $store->save();

        event(new \App\Events\userActionEvent('\App\Models\Admin\Store', $store->id, 3, auth('admin')->user()->username . '編輯了店別：' . $store->name));

        return redirect('/'.env('ADMIN_PREFIX').'/store')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Store::find((int)$id);

        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\Admin\Store', $tag->id, 2, auth('admin')->user()->username . "刪除了分店：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
