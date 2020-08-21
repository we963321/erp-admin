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
    protected $model;
    protected $modelNamespace = '\App\Models\CustomerProject';
    protected $resource = 'customer-project';
    protected $title = '專案資料';
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
     * Constuctor
     */
    public function __construct()
    {
        \View::share('resourceName', $this->resource);
        \View::share('title', $this->title);
        $this->model = new CustomerProject;
    }

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
            $data['recordsTotal'] = $this->model::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = $this->model::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = $this->model::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = $this->model::count();
                $data['data'] = $this->model::skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }
            
            return response()->json($data);
        }

        return view('admin.'.$this->resource.'.index');
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

        return view('admin.'.$this->resource.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $data = $this->valid($request, [
            'code'         => 'required|unique:customer_project|max:4',
            'name'         => 'required|max:40',
            'status'       => 'required|in:-1,0,1',
            'description'  => 'max:400',
            'feature'      => 'max:200',
            'target'       => 'required',
        ]);

        $model = $this->model;

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $model->$field = $request->get($field);
            }

            $model->save();

            event(new \App\Events\userActionEvent($this->modelNamespace, $model->id, 1, auth('admin')->user()->username . '新增了'.$this->title.'：' . $model->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/'.$this->resource.'')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/'.$this->resource.'')->withSuccess('新增成功！');
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
        $model = $this->model::find((int)$id);
        if (!$model) return redirect('/'.env('ADMIN_PREFIX').'/'.$this->resource.'')->withErrors("找不到該'.$this->title.'!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $model->$field);
        }

        $data['productAll'] = Product::where('status', '1')->get()->toArray();
        $data['id'] = (int)$id;
        
        return view('admin.'.$this->resource.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $data = $this->valid($request, [
            'code'         => 'required|unique:customer_project,code,' . $id . '|max:4',
            'name'         => 'required|max:40',
            'status'       => 'required|in:-1,0,1',
            'description'  => 'max:400',
            'feature'      => 'max:200',
            'target'       => 'required',
        ]);

        $model = $this->model::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $model->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $model->save();

            event(new \App\Events\userActionEvent($this->modelNamespace, $model->id, 3, auth('admin')->user()->username . '編輯了'.$this->title.'：' . $model->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/'.$this->resource.'')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/'.$this->resource.'')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model::find((int)$id);

        if ($model) {
            $model->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent($this->modelNamespace, $model->id, 2, auth('admin')->user()->username . "刪除了'.$this->title.'：" . $model->name . "(" . $model->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
