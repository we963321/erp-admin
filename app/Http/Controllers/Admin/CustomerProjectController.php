<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\CustomerProject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class CustomerProjectController extends Controller
{
    protected $fields = [
        'code'                    => '',
        'name'                    => '',
        'description'             => '',
        'feature'                 => '',
        'target'                  => '',

        'service_product_id1'     => '',
        'service_product_num1'    => '',
        'service_product_unit1'   => '',
        'service_product_id2'     => '',
        'service_product_num2'    => '',
        'service_product_unit2'   => '',
        'service_product_id3'     => '',
        'service_product_num3'    => '',
        'service_product_unit3'   => '',
        'service_product_id4'     => '',
        'service_product_num4'    => '',
        'service_product_unit4'   => '',
        'service_product_id5'     => '',
        'service_product_num5'    => '',
        'service_product_unit5'   => '',

        'bonus_product_id1'     => '',
        'bonus_product_num1'    => '',
        'bonus_product_unit1'   => '',
        'bonus_product_id2'     => '',
        'bonus_product_num2'    => '',
        'bonus_product_unit2'   => '',
        'bonus_product_id3'     => '',
        'bonus_product_num3'    => '',
        'bonus_product_unit3'   => '',
        'bonus_product_id4'     => '',
        'bonus_product_num4'    => '',
        'bonus_product_unit4'   => '',
        'bonus_product_id5'     => '',
        'bonus_product_num5'    => '',
        'bonus_product_unit5'   => '',

        'gift_product_id1'      => '',
        'gift_product_num1'     => '',
        'gift_product_unit1'    => '',
        'gift_product_id2'      => '',
        'gift_product_num2'     => '',
        'gift_product_unit2'    => '',
        'gift_product_id3'      => '',
        'gift_product_num3'     => '',
        'gift_product_unit3'    => '',
        'gift_product_id4'      => '',
        'gift_product_num4'     => '',
        'gift_product_unit4'    => '',
        'gift_product_id5'      => '',
        'gift_product_num5'     => '',
        'gift_product_unit5'    => '',

        'remark'                => '',
        'status'                => 1,
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
            $data['recordsTotal'] = CustomerProject::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = CustomerProject::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = CustomerProject::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = CustomerProject::count();
                $data['data'] = CustomerProject::skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }
            
            return response()->json($data);
        }

        return view('admin.customer-project.index');
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

        $data['productAll'] = Product::where('status', '1')->get()->toArray();

        return view('admin.customer-project.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CustomerProjectCreateRequest $request)
    {  
        $customer_project = new CustomerProject();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $customer_project->$field = $request->get($field);
            }

            $customer_project->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerProject', $customer_project->id, 1, auth('admin')->user()->username . '新增了專案資料：' . $customer_project->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-project')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/customer-project')->withSuccess('新增成功！');
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
        $customer_project = CustomerProject::find((int)$id);
        if (!$customer_project) return redirect('/'.env('ADMIN_PREFIX').'/customer-project')->withErrors("找不到該專案資料!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $customer_project->$field);
        }

        $data['productAll'] = Product::where('status', '1')->get()->toArray();
        $data['id'] = (int)$id;
        
        return view('admin.customer-project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CustomerProjectUpdateRequest $request, $id)
    {
        $customer_project = CustomerProject::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $customer_project->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $customer_project->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerProject', $customer_project->id, 3, auth('admin')->user()->username . '編輯了專案資料：' . $customer_project->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-project')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/customer-project')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = CustomerProject::find((int)$id);

        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\CustomerProject', $tag->id, 2, auth('admin')->user()->username . "刪除了專案資料：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
