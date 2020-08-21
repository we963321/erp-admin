<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CarColor;

class VehicleColorController extends Controller
{
    protected $resource = 'vehicle-color';
    protected $fields = [
        'code' => '',
        'name' => '',
        'description' => '',
        'remark' => '',
        'status' => 1,
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

            $model = new CarColor;

            $data['recordsTotal'] = $model->count();

            if (strlen($search['value']) > 0) {

                $data['recordsFiltered'] = $model->where(function ($query) use ($search) {
                    $query->where('code', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('name', 'like', '%' . $search['value'] . '%');
                })->count();

                $data['data'] = $model->where(function ($query) use ($search) {
                    $query->where('code', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('name', 'like', '%' . $search['value'] . '%');
                })->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = $model->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            }

            return response()->json($data);
        }

        return view('admin.' . $this->resource . '.index');
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

        return view('admin.' . $this->resource . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new CarColor;
        try {
            \DB::beginTransaction();

            $data = $this->valid($request, [
                'code' => 'required|size:4|unique:car_colors',
                'name' => 'required|max:30',
                'description' => 'max:300',
                'status' => 'required|in:1,0,-1',
            ]);

            $model->fill($data);
            $model->save();

            event(new \App\Events\userActionEvent('\App\Models\User', $model->id, 1, auth('admin')->user()->username . '新增了車輛資料：' . $model->display_name));

            \DB::commit();
        } catch (\PDOException $e) {
            \DB::rollBack();
            return redirect(route('admin.' . $this->resource . '.create'))->withErrors($e->getMessage());
        }

        return redirect(route('admin.' . $this->resource . '.index'))->withSuccess('新增成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = CarColor::find((int) $id);
        if (!$model) return redirect(action('admin.' . $this->resource . '.create'))->withErrors("找不到該顏色資料! 請先新增資料。");

        $data = [];
        $data += $model->toArray();

        return view('admin.' . $this->resource . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = CarColor::find((int) $id);
        if (!$model) return redirect(action('admin.' . $this->resource . '.create'))->withErrors("找不到該顏色資料! 請先新增資料。");

        try {
            \DB::beginTransaction();

            $data = $this->valid($request, [
                'code' => 'required|size:4|unique:car_colors,code,' . $model->id,
                'name' => 'required|max:30',
                'description' => 'max:300',
                'status' => 'required|in:1,0,-1',
            ]);

            $model->fill($data);
            $model->save();

            event(new \App\Events\userActionEvent('\App\Models\User', $model->id, 3, auth('admin')->user()->username . '編輯了車輛資料：' . $model->display_name));

            \DB::commit();
        } catch (\PDOException $e) {
            \DB::rollBack();
            return  redirect(route('admin.' . $this->resource . '.edit', [$model->id]))->withErrors($e->getMessage());
        }


        return  redirect(route('admin.' . $this->resource . '.index'))->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = CarColor::find((int)$id);

        try {
            if ($model->delete()) {
            } else {
                return redirect()->back()
                    ->withErrors("刪除失敗");
            }
        } catch (\Exception $e) {

            return redirect()->back()
                ->withErrors("刪除失敗");
        }

        event(new \App\Events\userActionEvent('\App\Models\User', $model->id, 2, auth('admin')->user()->username . "刪除了車輛資料：" . $model->name . "(" . $model->display_name . ")"));

        return redirect()->back()
            ->withSuccess("刪除成功");
    }
}
