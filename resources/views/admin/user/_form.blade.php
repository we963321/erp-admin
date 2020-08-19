@if(!empty($emp_id))
<div class="form-group">
    <label class="col-md-3 control-label">員工編號</label>
    <div class="col-md-5">
       <label class="control-label">{{ $emp_id }}</label>
    </div>
</div>
@endif

@if(!empty($store_manager))
<div class="form-group">
    <label class="col-md-3 control-label">管理分店</label>
    <div class="col-md-5">
        @foreach($store_manager as $key => $val)
        <a href="/{{env('ADMIN_PREFIX')}}/store/{{$val['id']}}/edit" class="control-label">{{ $val['name'] }}</a>
        @if($val !== end($store_manager))
        ,&nbsp;
        @endif
        @endforeach
    </div>
</div>
@endif

<div class="form-group">
    <label class="col-md-3 control-label">*姓名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">*信箱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="email" value="{{ $email }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">密碼</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password" value="">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">密碼確認</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password_confirmation" value="">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*性別</label>
    <div class="col-md-5">
        <input type="radio" name="sex" value="1" {{ ((int)$sex===1) ? 'checked' : '' }}>男 &nbsp;
        <input type="radio" name="sex" value="0" {{ ((int)$sex===0) ? 'checked' : '' }}>女
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*電話</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="mobile" value="{{ $mobile }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*身分証號</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="id_number" value="{{ $id_number }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">地址</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="address" value="{{ $address }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*生日</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="birthday" id="datepicker" value="{{ $birthday }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">狀態</label>
    <div class="col-md-5">
        <input type="radio" name="status" value="1" {{ ((int)$status===1) ? 'checked' : '' }}>啟用 &nbsp;
        <input type="radio" name="status" value="0" {{ ((int)$status===0) ? 'checked' : '' }}>停用
    </div>
</div>


@if(Gate::forUser(auth('admin')->user())->check('role.edit'))
<div class="form-group">
    <label class="col-md-3 control-label">角色列表</label>
    @if(isset($id)&&$id==1)
        <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;"><h2>超級管理員</h2></div>
    @else
        <div class="col-md-6">
        @foreach($rolesAll as $val)
            <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
            <span class="checkbox-custom checkbox-default">
                <i class="fa"></i>
                    <input class="form-actions"
                           @if(in_array($val['id'],$roles))
                           checked
                           @endif
                           id="roles{{$val['id']}}" type="Checkbox" value="{{$val['id']}}"
                           name="roles[]"> <label for="roles{{$val['id']}}">
                    {{$val['name']}}
                </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
            </div>
        @endforeach
            </div>
    @endif

</div>
@endif

<div class="form-group">
    <label class="col-md-3 control-label">分店列表</label>
    <div class="col-md-6">
    @foreach($storesAll as $val)
        <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
        <span class="checkbox-custom checkbox-default">
            <i class="fa"></i>
                <input class="form-actions"
                       @if(in_array($val['id'],$stores))
                       checked
                       @endif
                       id="stores{{$val['id']}}" type="Checkbox" value="{{$val['id']}}"
                       name="stores[]"> <label for="stores{{$val['id']}}">
                {{$val['name']}}
            </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </span>
        </div>
    @endforeach
    </div>
</div>

