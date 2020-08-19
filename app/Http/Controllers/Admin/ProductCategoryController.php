<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ProductCategoryController extends Controller
{
    protected $fields = [
        'code'          => '',
        'name'          => '',
        'description'   => '',
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
            $data['recordsTotal'] = ProductCategory::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = ProductCategory::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = ProductCategory::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = ProductCategory::count();
                $data['data'] = ProductCategory::skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.product-category.index');
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

        return view('admin.product-category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProductCategoryCreateRequest $request)
    {  
        $product_category = new ProductCategory();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $product_category->$field = $request->get($field);
            }

            $product_category->save();

            event(new \App\Events\userActionEvent('\App\Models\ProductCategory', $product_category->id, 1, auth('admin')->user()->username . '新增了產品類別：' . $product_category->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/product-category')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/product-category')->withSuccess('新增成功！');
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
        $product_category = ProductCategory::find((int)$id);
        if (!$product_category) return redirect('/'.env('ADMIN_PREFIX').'/product-category')->withErrors("找不到該產品類別!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $product_category->$field);
        }

        $data['id'] = (int)$id;
        
        return view('admin.product-category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ProductCategoryUpdateRequest $request, $id)
    {
        $product_category = ProductCategory::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $product_category->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $product_category->save();

            event(new \App\Events\userActionEvent('\App\Models\ProductCategory', $product_category->id, 3, auth('admin')->user()->username . '編輯了產品類別：' . $product_category->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/product-category')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/product-category')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = ProductCategory::find((int)$id);

        $used = CustomerService::where('product_category_id', $id)->first();

        if($used){
            return redirect()->back()
                ->withErrors("尚有專屬服務使用[".$used->name."]，刪除失敗");
        }

        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\ProductCategory', $tag->id, 2, auth('admin')->user()->username . "刪除了產品類別：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
