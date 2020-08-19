<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ProductController extends Controller
{
    protected $fields = [
        'product_category_id'   => '',
        'code'                  => '',
        'name'                  => '',
        'description'           => '',
        'car1'                  => 0,
        'car2'                  => 0,
        'car3'                  => 0,
        'car4'                  => 0,
        'car5'                  => 0,
        'car6'                  => 0,
        'car7'                  => 0,
        'car8'                  => 0,
        'car9'                  => 0,
        'car10'                 => 0,
        'car11'                 => 0,
        'car12'                 => 0,
        'car13'                 => 0,
        'car14'                 => 0,
        'car15'                 => 0,
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
            $data['recordsTotal'] = Product::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = Product::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = Product::with(['product_category'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = Product::count();
                $data['data'] = Product::with(['product_category'])->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.product.index');
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

        $data['categoryAll'] = ProductCategory::where('status', '1')->get()->toArray();

        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProductCreateRequest $request)
    {  
        $product = new Product();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $product->$field = $request->get($field);
            }

            $product->save();

            event(new \App\Events\userActionEvent('\App\Models\Product', $product->id, 1, auth('admin')->user()->username . '新增了產品資料：' . $product->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/product')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/product')->withSuccess('新增成功！');
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
        $product = Product::find((int)$id);
        if (!$product) return redirect('/'.env('ADMIN_PREFIX').'/product')->withErrors("找不到該產品資料!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $product->$field);
        }

        $data['categoryAll'] = ProductCategory::where('status', '1')->get()->toArray();
        $data['id'] = (int)$id;
        
        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ProductUpdateRequest $request, $id)
    {
        $product = Product::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $product->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $product->save();

            event(new \App\Events\userActionEvent('\App\Models\Product', $product->id, 3, auth('admin')->user()->username . '編輯了產品資料：' . $product->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/product')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/product')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Product::find((int)$id);

        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\Product', $tag->id, 2, auth('admin')->user()->username . "刪除了產品資料：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
