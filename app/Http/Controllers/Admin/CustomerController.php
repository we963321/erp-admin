<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\AdminUser;
use App\Models\Admin\Store;
use App\Models\CarBrand;
use App\Models\CarColor;
use App\Models\CustomerCar;

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

        try {
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
            for ($i = 0; $i <= $zero_num; $i++) {
                $prefix .= '0';
            }
            $user->cust_id = 'a' . date('Ym') . $prefix . $user->id;
            $user->save();

            if (is_array($request->get('stores'))) {
                $user->giveStoreTo($request->get('stores'));
            }

            event(new \App\Events\userActionEvent('\App\Models\User', $user->id, 1, auth('admin')->user()->username . '新增了客戶：' . $user->name));

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect('/' . env('ADMIN_PREFIX') . '/customer')->withErrors($e->getMessage());
        }

        return redirect('/' . env('ADMIN_PREFIX') . '/customer')->withSuccess('新增成功！');
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
        if (!$user) return redirect('/' . env('ADMIN_PREFIX') . '/customer')->withErrors("找不到該客戶!");

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

        try {
            DB::beginTransaction();

            $user->save();

            $user->giveStoreTo($request->get('stores', []));

            event(new \App\Events\userActionEvent('\App\Models\User', $user->id, 3, auth('admin')->user()->username . '編輯了客戶：' . $user->name));

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect('/' . env('ADMIN_PREFIX') . '/customer')->withErrors($e->getMessage());
        }


        return redirect('/' . env('ADMIN_PREFIX') . '/customer')->withSuccess('修改成功！');
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

        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\User', $tag->id, 2, auth('admin')->user()->username . "刪除了客戶：" . $tag->name . "(" . $tag->id . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }

    /**
     * Cars edit page
     */
    public function cars(Request $request, $id)
    {
        $customer = User::find((int)$id);
        if (!$customer) return redirect(route('admin.customer.index'))->withErrors("找不到該客戶!");

        $data = [
            'customer' => $customer,
            'brands' => CarBrand::with('series')->get(),
            'carColor' => CarColor::all()
        ];

        return view('admin.customer.cars', $data);
    }

    public function carsUpdate(Request $request, $id)
    {
        $customer = User::find((int)$id);
        if (!$customer) return redirect(route('admin.customer.index'))->withErrors("找不到該客戶!");

        $data = $this->valid($request, [
            'regular_appear_at_time' => 'nullable|array',
            'regular_appear_at' => 'nullable|array',
            'reservation_notify_date' => 'required|numeric',
            'car_amount' => 'nullable|numeric',
        ]);

        $carData = $this->valid($request, [
            'cars' => 'nullable|array',
            'cars.*.id' => 'nullable|exists:customer_cars,id',
            'cars.*.number' => 'required|string',
            'cars.*.customer_name' => 'required|string',
            'cars.*.bought_type' => 'nullable|in:1,2,3',
            'cars.*.years' => 'nullable',
            'cars.*.series_id' => 'nullable|exists:car_series,id',
            'cars.*.type' => 'nullable|in:1,2,3,4,5,6,7,8',
            'cars.*.color_id' => 'nullable|exists:car_colors,id',
            'cars.*.color_remark' => 'nullable|string',
            'cars.*.model' => 'nullable|string',
            'cars.*.displacement' => 'nullable|string',
            'cars.*.log_surface' => 'nullable|string',
            'delete_cars' => 'nullable|array',
            'delete_cars.*' => 'integer',
        ]);

        $customer->fill($data);
        $customer->save();

        $cars = $carData['cars'] ?? [];

        $deleteCars = $carData['delete_cars'] ?? [];

        DB::beginTransaction();

        try {
            foreach ($cars as $car) {
                $car['customer_id'] = $customer->id;

                $carModel = new CustomerCar;
                @$car['id'] && $carModel = CustomerCar::find($car['id']) ?? $carModel;

                unset($car['id']);

                $carModel->fill($car);
                $carModel->save();
            }

            !empty($deleteCars) and CustomerCar::whereIn('id', $deleteCars)->update(['customer_id' => null]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        event(new \App\Events\userActionEvent('\App\Models\User', $customer->id, 2, auth('admin')->user()->username . "修改了客戶車輛資料：" . $customer->name . "(" . $customer->id . ")"));


        return redirect(route('admin.customer.cars', [$id]))->withSuccess('修改成功');
    }
}
