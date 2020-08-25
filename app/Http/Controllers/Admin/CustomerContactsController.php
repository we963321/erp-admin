<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerContactsController extends Controller
{
    //
    protected $model;
    protected $modelNamespace = \App\Models\CustomerContact::class;
    protected $resource = 'customer-contacts';
    protected $title = '聯絡資料';

    /**
     * Constuctor
     */
    public function __construct()
    {
        \View::share('resourceName', $this->resource);
        \View::share('title', $this->title);
        $this->model = new $this->modelNamespace;
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

            $this->model = $this->model->rootContact();

            $data['recordsTotal'] = $this->model->count();

            if (strlen($search['value']) > 0) {

                $this->model->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('content', 'like', '%' . $search['value'] . '%')
                        ->orWhereHas('customer', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search['value'] . '%');
                        });
                });

                $data['recordsFiltered'] = $this->model->count();

                $data['data'] = $this->model->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get()->toArray();
            } else {
                $data['recordsFiltered'] = $this->model->count();
                $data['data'] = $this->model->skip($start)->take($length)
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

        $fields = ['title_text' => '', 'customer_id' => '', 'content' => '', 'remark' => ''];
        foreach ($fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['customers'] = User::all();

        return view('admin.' . $this->resource . '.create', $data);
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
            'title_text' => 'required|string',
            'customer_id' => 'required|exists:users,id',
            'content' => 'required|string|max:500',
            'remark' => 'nullable|string|max:300',
        ]);

        $model = $this->model;
        $currenUser = auth('admin')->user();

        try {
            \DB::beginTransaction();

            $data['title'] = $data['title_text'];
            $data['created_by'] = $currenUser->id;
            unset($data['title_text']);
            $model->fill($data);
            $model->save();

            event(new \App\Events\userActionEvent($this->modelNamespace, $model->id, 1, auth('admin')->user()->username . '新增了' . $this->title . '：' . $model->title));

            \DB::commit();
        } catch (\PDOException $e) {
            \DB::rollBack();
            return redirect(route('admin.' . $this->resource . '.create'))->withInput()->withErrors($e->getMessage());
        }

        return redirect(route('admin.' . $this->resource . '.index'))->withSuccess('新增成功！');
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

        if (!$model) return redirect(action('admin.' . $this->resource . '.create'))->withErrors("找不到該'.$this->title.'!");

        $model->load('actions');

        $data = [];
        $data += $model->toArray();
        $data['title_text'] = $data['title'];
        unset($data['title']);

        return view('admin.' . $this->resource . '.edit', $data);
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
        $model = $this->model::find((int)$id);
        if (!$model) return redirect(action('admin.' . $this->resource . '.create'))->withErrors("找不到該品牌車系! 請先新增資料。");

        try {
            \DB::beginTransaction();

            $data = $this->valid($request, [
                'content' => 'required|string|max:500',
            ]);

            $currenUser = auth('admin')->user();

            $data['created_by'] = $currenUser->id;
            $data['contact_id'] = $id;

            $createModel = new $this->modelNamespace;

            $createModel->fill($data);
            $createModel->save();

            event(new \App\Events\userActionEvent($this->modelNamespace, $model->id, 3, auth('admin')->user()->username . '編輯了' . $this->title . '：' . $model->title));

            \DB::commit();
        } catch (\PDOException $e) {
            \DB::rollBack();
            return  redirect(route('admin.' . $this->resource . '.edit', [$model->id]))->withErrors($e->getMessage());
        }


        return  redirect(route('admin.' . $this->resource . '.edit', [$model->id]))->withSuccess('發送成功');
    }
}
