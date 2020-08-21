<div class="form-group">
    <label for="tag" class="col-md-3 control-label">角色名稱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" id="tag" value="{{ $name }}" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">角色說明</label>
    <div class="col-md-5">
        <textarea name="description" class="form-control" rows="3">{{ $description }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">角色類別</label>
    <div class="col-md-5">
        <input type="radio" name="type" value="0" {{ ((int)$type===0) ? 'checked' : '' }}>總公司 &nbsp;
        <input type="radio" name="type" value="1" {{ ((int)$type===1) ? 'checked' : '' }}>分店 &nbsp;
    </div>
</div>

{{--
<div class="form-group">
    <label class="col-md-3 control-label">狀態</label>
    <div class="col-md-5">
        <input type="radio" name="status" value="1" {{ ((int)$status===1) ? 'checked' : '' }}>啟用 &nbsp;
        <input type="radio" name="status" value="0" {{ ((int)$status===0) ? 'checked' : '' }}>停用 &nbsp;
        <input type="radio" name="status" value="-1" {{ ((int)$status===-1) ? 'checked' : '' }}>刪除 &nbsp;
    </div>
</div>
 --}}
 
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">權限列表</label>
</div>
<div class="form-group">
    <div class="form-group">
        @if($permissionAll)
            @foreach($permissionAll[0] as $v)
                <div class="form-group">
                    <label class="control-label col-md-3 all-check">
                        {{$v['label']}}：
                    </label>
                    <div class="col-md-6">
                        @if(isset($permissionAll[$v['id']]))

                            @foreach($permissionAll[$v['id']] as $vv)
                                <div class="col-md-3" style="float:left;padding-left:20px;margin-top:8px;">
                        <span class="checkbox-custom checkbox-default">
                        <i class="fa"></i>
                            <input class="form-actions"
                                   @if(in_array($vv['id'],$permissions))
                                   checked
                                   @endif
                                   id="inputChekbox{{$vv['id']}}" type="Checkbox" value="{{$vv['id']}}"
                                   name="permissions[]"> <label for="inputChekbox{{$vv['id']}}">
                                {{$vv['label']}}
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<script>
    $(function () {
        $('.all-check').on('click', function () {

        });
    });
</script>

