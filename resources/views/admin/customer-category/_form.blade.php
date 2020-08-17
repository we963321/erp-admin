
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
    <label class="col-md-3 control-label">狀態</label>
    <div class="col-md-5">
        <input type="radio" name="status" value="1" {{ ((int)$status===1) ? 'checked' : '' }}>啟用 &nbsp;
        <input type="radio" name="status" value="0" {{ ((int)$status===0) ? 'checked' : '' }}>停用 &nbsp;
        <input type="radio" name="status" value="-1" {{ ((int)$status===-1) ? 'checked' : '' }}>刪除 &nbsp;
    </div>
</div>
