@if(!empty($cust_id))
<div class="form-group">
    <label class="col-md-3 control-label">客戶編號</label>
    <div class="col-md-5">
       <label class="control-label">{{ $cust_id }}</label>
    </div>
</div>
@endif

<div class="form-group">
    <label class="col-md-3 control-label">*信箱(登入帳號)</label>
    <div class="col-md-5">
        @if(empty($email))
        <input type="text" class="form-control" name="email" value="{{ $email }}">
        @else
        <label class="control-label">{{ $email }}</label>
        @endif
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
    <label class="col-md-3 control-label">*姓名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}">
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
    <label class="col-md-3 control-label">*生日</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="birthday" id="datepicker" value="{{ $birthday }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*婚姻</label>
    <div class="col-md-5">
        <input type="radio" name="marriage" value="0" {{ ((int)$marriage===0) ? 'checked' : '' }}>未婚&nbsp;
        <input type="radio" name="marriage" value="1" {{ ((int)$marriage===1) ? 'checked' : '' }}>已婚
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">客戶來源</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="customer_resource" value="{{ $customer_resource }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">介紹人</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="introducer" value="{{ $introducer }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">Line ID</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="line" value="{{ $line }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">facebook</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="facebook" value="{{ $facebook }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">統一編號</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="tax_number" value="{{ $tax_number }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">常去店別</label>
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