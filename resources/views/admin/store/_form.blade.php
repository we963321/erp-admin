@if(!empty($code))
<div class="form-group">
    <label class="col-md-3 control-label">代碼</label>
    <div class="col-md-5">
       <label class="control-label">{{ $code }}</label>
    </div>
</div>
@endif

<div class="form-group">
    <label class="col-md-3 control-label">*名稱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">*簡稱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="short_name" value="{{ $short_name }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">說明</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="description" value="{{ $description }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*電話</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="mobile" value="{{ $mobile }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*縣市</label>
    <div class="col-md-5">
        <select name="counties">
            <option value="">請選擇</option>
            @foreach(config('params_config') as $key => $val)
                <option value="{{ $key }}" @if($counties == $key) selected @endif >
                    {{ $key }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*鄉鎮區</label>
    <div class="col-md-5">
        <select name="town">
            <option value="">請選擇</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">地址</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="address" value="{{ $address }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">管理員</label>
    <div class="col-md-5">
        <select name="admin_user_id" autofocus>
            <option value="">請選擇 (名稱 / 員工編號 / 電話)</option>

             @foreach($admin_user as $val)
                <option value="{{ $val['id'] }}" @if($admin_user_id == $val['id']) selected @endif >
                    {{ $val['name'] }} / {{ $val['emp_id'] }} / {{ $val['mobile'] }}
                </option>
             @endforeach

        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">備註</label>
    <div class="col-md-5">
        <textarea class="form-control" name="remark" value="{{ $remark }}">{{ $remark }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">狀態</label>
    <div class="col-md-5">
        <input type="radio" name="status" value="1" {{ ((int)$status===1) ? 'checked' : '' }}>啟用 &nbsp;
        <input type="radio" name="status" value="0" {{ ((int)$status===0) ? 'checked' : '' }}>停用
    </div>
</div>

<script type="text/javascript">
    $('select[name=counties]').on('change', function(){
        let towns = {!! json_encode(config('params_config')) !!}[this.value];

        let town = '';

        let default_town = "{!! $town !!}";

        for(i in towns){
            if(towns[i] == default_town){
                town += `<option value=${towns[i]} selected>${towns[i]}</option>`;
            }else{
                town += `<option value=${towns[i]}>${towns[i]}</option>`;
            }
        }
        
        $('select[name=town] option').remove();
        $('select[name=town]').append(town);
    });

    $('select[name=counties]').trigger('change');
</script>