<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomerCategory;
use App\Models\CustomerService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class CustomerServiceController extends Controller
{
    protected $fields = [
        'customer_category_id'  => '',
        'code'                  => '',
        'name'                  => '',
        'description'           => '',
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
            $data['recordsTotal'] = CustomerService::count();
            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = CustomerService::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = CustomerService::with(['customer_category'])->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('code', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();

            } else {
                $data['recordsFiltered'] = CustomerService::count();
                $data['data'] = CustomerService::with(['customer_category'])->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.customer-service.index');
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

        $data['categoryAll'] = CustomerCategory::where('status', '1')->get()->toArray();

        return view('admin.customer-service.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CustomerServiceCreateRequest $request)
    {  
        $customer_service = new CustomerService();

        try{
            DB::beginTransaction();

            foreach (array_keys($this->fields) as $field) {
                $customer_service->$field = $request->get($field);
            }

            $customer_service->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerService', $customer_service->id, 1, auth('admin')->user()->username . '新增了專屬服務：' . $customer_service->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-service')->withErrors($e->getMessage());
        }

        return redirect('/'.env('ADMIN_PREFIX').'/customer-service')->withSuccess('新增成功！');
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
        $customer_service = CustomerService::find((int)$id);
        if (!$customer_service) return redirect('/'.env('ADMIN_PREFIX').'/customer-service')->withErrors("找不到該專屬服務!");

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $customer_service->$field);
        }

        $data['categoryAll'] = CustomerCategory::where('status', '1')->get()->toArray();
        $data['id'] = (int)$id;
        
        return view('admin.customer-service.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CustomerServiceUpdateRequest $request, $id)
    {
        $customer_service = CustomerService::find((int)$id);

        foreach (array_keys($this->fields) as $field) {
            $customer_service->$field = $request->get($field);
        }

        try{
            DB::beginTransaction();

            $customer_service->save();

            event(new \App\Events\userActionEvent('\App\Models\CustomerService', $customer_service->id, 3, auth('admin')->user()->username . '編輯了專屬服務：' . $customer_service->name));

            DB::commit();
        }catch(\PDOException $e){
            DB::rollBack();
            return redirect('/'.env('ADMIN_PREFIX').'/customer-service')->withErrors($e->getMessage());
        }


        return redirect('/'.env('ADMIN_PREFIX').'/customer-service')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = CustomerService::find((int)$id);

        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\CustomerService', $tag->id, 2, auth('admin')->user()->username . "刪除了專屬服務：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
