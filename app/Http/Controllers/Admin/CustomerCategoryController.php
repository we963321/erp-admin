<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomerCategory;
use App\Models\CustomerService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class CustomerCategoryController extends Controller
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
            $data['recordsTotal'] = CustomerCategory::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = CustomerCategory::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = CustomerCategory::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = CustomerCategory::count();
                $data['data'] = CustomerCategory::skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.customer-category.index');
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

        return view('admin.customer-category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CustomerCategoryCreateRequest $request)
    {  
        $customer_category = new CustomerCategory();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $customer_category->$field = $request->get($field);
            }

            $customer_category->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerCategory', $customer_category->id, 1, auth('admin')->user()->username . '新增了會員種類：' . $customer_category->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-category')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/customer-category')->withSuccess('新增成功！');
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
        $customer_category = CustomerCategory::find((int)$id);
        if (!$customer_category) return redirect('/'.env('ADMIN_PREFIX').'/customer-category')->withErrors("找不到該會員種類!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $customer_category->$field);
        }

        $data['id'] = (int)$id;
        
        return view('admin.customer-category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CustomerCategoryUpdateRequest $request, $id)
    {
        $customer_category = CustomerCategory::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $customer_category->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $customer_category->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerCategory', $customer_category->id, 3, auth('admin')->user()->username . '編輯了會員種類：' . $customer_category->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-category')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/customer-category')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = CustomerCategory::find((int)$id);

        $used = CustomerService::where('customer_category_id', $id)->first();

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

        event(new \App\Events\userActionEvent('\App\Models\CustomerCategory', $tag->id, 2, auth('admin')->user()->username . "刪除了會員種類：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
