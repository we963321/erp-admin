
<div class="form-group">
    <label class="col-md-3 control-label">*代碼</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="code" value="{{ $code }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*車輛品牌</label>
    <div class="col-md-5">        
        <select class="form-control" name="car_brand_id">
            @forelse ($carBrands as $carBrand)
            <option value="{{ $carBrand->id }}" {{ $carBrand->id === $car_brand_id ? 'selected' : '' }}>{{ $carBrand->name }}</option>
            @empty
                <option>請先新增車輛品牌資料</option>
            @endforelse
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*名稱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">描述</label>
    <div class="col-md-5">
        <textarea class="form-control" name="description">{{ $description }}</textarea>
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
