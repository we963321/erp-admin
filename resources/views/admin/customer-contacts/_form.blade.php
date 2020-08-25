
<div class="form-group">
    <label class="col-md-3 control-label">*標題</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="title_text" value="{{ $title_text ?? '' }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*客戶</label>
    <div class="col-md-5">
        <input id="customer-id" list="customer-list" type="text" class="form-control" placeholder="輸入客戶名稱搜尋">
        <datalist id="customer-list"></datalist>
        <input type="hidden" name="customer_id">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">*互動內容</label>
    <div class="col-md-5">
        <textarea class="form-control" name="content">{{ $content ?? '' }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">備註</label>
    <div class="col-md-5">
        <textarea class="form-control" name="remark">{{ $remark ?? '' }}</textarea>
    </div>
</div>

<script>
    $(document).ready(function() {
        var customers = {!! $customers !!}
        var customerInput = $('#customer-id');
        var customerList = $('#customer-list');
        var customerSentInput = customerList.next();
        var listLimit = 10;

        customerInput.on('input', function(e) {
            var self = $(this)
            var value = self.val();
            customerList.html('');
            customerSentInput.val('');
            
            var filtered = customers.filter(function(customer) {
                return customer.name.includes(value);
            }).slice(0, listLimit - 1);

            filtered.forEach(function(customer) {
                customerList.append('<option value="' + customer.name + '">')
            });

            filtered.length === 1 && filtered[0].name === value && customerSentInput.val(filtered[0].id)
        });
    });
</script>