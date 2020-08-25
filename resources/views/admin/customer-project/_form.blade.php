<div class="form-group">
    <label class="col-md-3 control-label">*代碼</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="code" value="{{ $code }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*名稱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">內容說明</label>
    <div class="col-md-5">
        <textarea class="form-control" name="description" value="{{ $description }}">{{  $description }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">特色</label>
    <div class="col-md-5">
        <textarea class="form-control" name="feature" value="{{ $feature }}">{{  $feature }}</textarea>
    </div>
</div>

<!--
<div class="form-group">
    <label class="col-md-3 control-label">*對象</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="target" value="{{ $target }}">
    </div>
</div>
-->

<div class="form-group">
    <label class="col-md-3 control-label">*對象</label>
    <div class="col-md-5">
        <input type="radio" name="target" value="0" {{ ((int)$target===0) ? 'checked' : '' }}>客戶 &nbsp;
        <input type="radio" name="target" value="1" {{ ((int)$target===1) ? 'checked' : '' }}>車號 &nbsp;
    </div>
</div>

<hr>

<div class="form-group">
    <label class="col-md-3 control-label">服務內容1</label>
    <div class="col-md-5">
        <select name="service_product_id1">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $service_product_id1) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_num1" value="{{ $service_product_num1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_unit1" value="{{ $service_product_unit1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">服務內容2</label>
    <div class="col-md-5">
        <select name="service_product_id2">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $service_product_id2) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_num2" value="{{ $service_product_num2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_unit2" value="{{ $service_product_unit2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">服務內容3</label>
    <div class="col-md-5">
        <select name="service_product_id3">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $service_product_id3) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_num3" value="{{ $service_product_num3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_unit3" value="{{ $service_product_unit3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">服務內容4</label>
    <div class="col-md-5">
        <select name="service_product_id4">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $service_product_id4) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_num4" value="{{ $service_product_num4 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_unit4" value="{{ $service_product_unit4 }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">服務內容5</label>
    <div class="col-md-5">
        <select name="service_product_id5">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $service_product_id5) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_num5" value="{{ $service_product_num5 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="service_product_unit5" value="{{ $service_product_unit5 }}">
    </div>
</div>

<hr>

<div class="form-group">
    <label class="col-md-3 control-label">超值加碼1</label>
    <div class="col-md-5">
        <select name="bonus_product_id1">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $bonus_product_id1) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_num1" value="{{ $bonus_product_num1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_unit1" value="{{ $bonus_product_unit1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">超值加碼2</label>
    <div class="col-md-5">
        <select name="bonus_product_id2">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $bonus_product_id2) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_num2" value="{{ $bonus_product_num2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_unit2" value="{{ $bonus_product_unit2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">超值加碼3</label>
    <div class="col-md-5">
        <select name="bonus_product_id3">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $bonus_product_id3) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_num3" value="{{ $bonus_product_num3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_unit3" value="{{ $bonus_product_unit3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">超值加碼4</label>
    <div class="col-md-5">
        <select name="bonus_product_id4">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $bonus_product_id4) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_num4" value="{{ $bonus_product_num4 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_unit4" value="{{ $bonus_product_unit4 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">超值加碼5</label>
    <div class="col-md-5">
        <select name="bonus_product_id5">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $bonus_product_id5) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_num5" value="{{ $bonus_product_num5 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="bonus_product_unit5" value="{{ $bonus_product_unit5 }}">
    </div>
</div>

<hr>

<div class="form-group">
    <label class="col-md-3 control-label">好禮相送1</label>
    <div class="col-md-5">
        <select name="gift_product_id1">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $gift_product_id1) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_num1" value="{{ $gift_product_num1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位1</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_unit1" value="{{ $gift_product_unit1 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">好禮相送2</label>
    <div class="col-md-5">
        <select name="gift_product_id2">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $gift_product_id2) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_num2" value="{{ $gift_product_num2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位2</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_unit2" value="{{ $gift_product_unit2 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">好禮相送3</label>
    <div class="col-md-5">
        <select name="gift_product_id3">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $gift_product_id3) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_num3" value="{{ $gift_product_num3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位3</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_unit3" value="{{ $gift_product_unit3 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">好禮相送4</label>
    <div class="col-md-5">
        <select name="gift_product_id4">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $gift_product_id4) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_num4" value="{{ $gift_product_num4 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位4</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_unit4" value="{{ $gift_product_unit4 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">好禮相送5</label>
    <div class="col-md-5">
        <select name="gift_product_id5">
            @foreach($productAll as $key => $val)
                <option value="{{ $val['id'] }}" @if($val['id'] == $gift_product_id5) selected @endif >
                    {{ $val['name'] }} ({{ $val['code'] }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">數量5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_num5" value="{{ $gift_product_num5 }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">單位5</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="gift_product_unit5" value="{{ $gift_product_unit5 }}">
    </div>
</div>

<hr>

<div class="form-group">
    <label class="col-md-3 control-label">備註</label>
    <div class="col-md-5">
        <textarea class="form-control" name="remark" value="{{ $remark }}">{{  $remark }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">狀態</label>
    <div class="col-md-5">
        <input type="radio" name="status" value="1" {{ ((int)$status===1) ? 'checked' : '' }}>啟用 &nbsp;
        <input type="radio" name="status" value="0" {{ ((int)$status===0) ? 'checked' : '' }}>停用 &nbsp;
        <input type="radio" name="status" value="-1" {{ ((int)$status===-1) ? 'checked' : '' }}>刪除 &nbsp;
    </div>
</div>
