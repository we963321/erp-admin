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

<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-service" type="button">
            新增服務內容
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="service_list_frame" role="tablist" aria-multiselectable="true"></div>
    </div>
</div>

<hr>

<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-bonus" type="button">
            新增超值加碼
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="bonus_list_frame" role="tablist" aria-multiselectable="true"></div>
    </div>
</div>

<hr>

<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-gift" type="button">
            新增好禮相送
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="gift_list_frame" role="tablist" aria-multiselectable="true"></div>
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


<div id="template" style="display: none">
    <div class="panel panel-info" style="padding: 10px 10px">
        <div class="form-group">
            <label class="col-md-3 control-label title"></label>
            <div class="col-md-5">
                <select class="product_selector">
                    <option value="">請選擇</option>
                    @foreach($productAll as $key => $val)
                        <option value="{{ $val['id'] }}">
                            {{ $val['name'] }} ({{ $val['code'] }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <span class="pull-right text-danger delete" data-index style="cursor: pointer;">刪除</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label num"></label>
            <div class="col-md-5">
                <input type="text" class="form-control num_selector">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label unit"></label>
            <div class="col-md-5">
                <input type="text" class="form-control unit_selector">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    確認要刪除這個<span class="title"></span>嗎?
                </p>
                <p class="text-muted">確認之後需案下儲存才會進行刪除。</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-danger confirm-button">
                    <i class="fa fa-times-circle"></i> 確認
                </button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    //title
    const service_title = '服務內容';
    const bonus_title = '超值加碼';
    const gift_title = '好禮相送';
    const num = '數量';
    const unit = '單位';

    //for edit map_list
    const map_list = {!! json_encode($map_list ?? []) !!};

    //frame
    const service_list_frame = $('#service_list_frame');
    const bonus_list_frame = $('#bonus_list_frame');
    const gift_list_frame = $('#gift_list_frame');

    //template
    const public_template = $('#template');

    //create btn
    const createServiceButton = $('.create-service');  
    const createBonusButton = $('.create-bonus'); 
    const createGiftButton = $('.create-gift'); 

    //deleteModal
    const deleteModal = $("#modal-delete");

    createServiceButton.on('click', function() {
        createTemplate('service');
    });

    createBonusButton.on('click', function() {
        createTemplate('bonus');
    });

    createGiftButton.on('click', function() {
        createTemplate('gift');
    });

    //delete warnning
    service_list_frame.add(bonus_list_frame).add(gift_list_frame).on('click', '.delete', function() {
        const self = $(this);
        deleteModal.attr('data-index', self.attr('data-index'));
        deleteModal.find('.title').text(service_title)
        deleteModal.modal();
    });

    /**
     * Confirm delete action
     */
    deleteModal.on('click', '.confirm-button', function(e) {
        deleteItem(deleteModal.attr('data-index'));
        deleteModal.modal('hide');
    })

    /** create service form list */
    function createTemplate(type) {
        let frame, template, title;

        switch(type){
            case "service":
                frame = service_list_frame;
                title = service_title;
            break;

            case "bonus":
                frame = bonus_list_frame;
                title = bonus_title;
            break;

            case "gift":
                frame = gift_list_frame;
                title = gift_title;
            break;
        }

        template = public_template;

        template.find('.panel-info').addClass(type);

        let length = parseInt(frame.find(`.${type}`).length);

        const index = parseInt(length + 1);

        if(index > 5){
            alert(title + '最大上限5筆');
            return false;
        }

        //title
        template.find('.title').text(title + index);
        template.find('.num').text(num + index);
        template.find('.unit').text(unit + index);
        
        //delete index
        template.find(`.delete`).attr('data-index', `${type}_` + index);

        //name
        template.find('.product_selector').attr('name', `${type}_product_id${index}`).attr('required', true);
        template.find('.num_selector').attr('name', `${type}_product_num${index}`);
        template.find('.unit_selector').attr('name', `${type}_product_unit${index}`);

        //add
        frame.append(template.html());

        template.remove();
    }

    /** remove project form list */
    function deleteItem(id) {
        const is_service = id.indexOf('service');
        const is_bonus = id.indexOf('bonus');
        const is_gift = id.indexOf('gift');

        if(is_service !== -1){
            service_list_frame.find(`span[data-index=${id}]`).closest('.panel-info').remove();
        }else if(is_bonus !== -1){
            bonus_list_frame.find(`span[data-index=${id}]`).closest('.panel-info').remove();
        }else if(is_gift !== -1){
            gift_list_frame.find(`span[data-index=${id}]`).closest('.panel-info').remove();
        }
    }

    //render data
    function renderList(){
        Object.keys(map_list).forEach((key)=>{
            if(key.indexOf('id') !== -1){
                const type = key.split('_')[0];
                createTemplate(type);
            }

            renderValue(key, map_list[key]);
        });

        //新增畫面
        if(map_list.length == 0){
            createTemplate('service');
            createTemplate('bonus');
            createTemplate('gift');
        }
    }

    function renderValue(name, value){
        $(`[name="${name}"]`).val(value);
    }

    renderList();
});
</script>