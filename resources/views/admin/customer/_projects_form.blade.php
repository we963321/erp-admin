
<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-category" type="button">
            新增會員種類 & 專屬服務
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="category_list_frame" role="tablist" aria-multiselectable="true"></div>
    </div>
</div>

<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-project" type="button">
            新增專案資料
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="project_list_frame" role="tablist" aria-multiselectable="true"></div>
    </div>
</div>


<!-- template category -->
<div id="category_template" style="display: none">
    <div class="panel panel-info" style="padding: 10px 10px">
        <div class="form-group">
            <label class="col-md-3 control-label category_title"></label>
            <div class="col-md-5">
                <select class="form-control category_selector">
                    <option>請選擇</option>
                    @foreach($category as $key => $val)
                        <option value="{{ $val['id'] }}" >
                            {{ $val['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <span class="pull-right text-danger delete-category" data-index style="cursor: pointer;">刪除</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label service_title"></label>
            <div class="col-md-5">
                <select class="form-control service_selector">

                </select>
            </div>
        </div>
    </div>
</div>
<!-- template category -->



<!-- template project -->
<div id="project_template" style="display: none">
    <div class="panel panel-info" style="padding: 10px 10px">
        <div class="form-group">
            <label class="col-md-3 control-label project_title"></label>
            <div class="col-md-5">
                <select class="form-control project_selector">
                    <option value="">請選擇</option>
                    @foreach($project as $key => $val)
                        <option value="{{ $val['id'] }}">
                            {{ $val['name'] }}(@if( $val['target'] == '0' ) 客戶 @else 車號 @endif)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <span class="pull-right text-danger delete-project" data-index style="cursor: pointer;">刪除</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">專案時間</label>
            <div class="col-md-5">
                <input type="date" class="form-control project_date_start" >
                <input type="date" class="form-control project_date_end" >
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label project_car">專案車號</label>
            <div class="col-md-5">
                <div class="cars"></div>
            </div>
        </div>   
    </div>
</div>
<!-- template project -->

<script>
$(document).ready(function() {
    //data
    const category = {!! $category->toJson() !!};
    const service = {!! $service->toJson() !!};
    const project = {!! $project->toJson() !!};
    const cars = {!! $cars->toJson() !!};

    //title
    const category_title = '會員種類';
    const service_title = '專屬服務'
    const project_title = '專案資料';

    //frame
    const category_list_frame = $('#category_list_frame');
    const project_list_frame = $('#project_list_frame');

    //template
    const category_template = $('#category_template');
    const project_template = $('#project_template');

    //create btn
    const createCategoryButton = $('.create-category');  
    const createProjectButton = $('.create-project');  

    //delet btn  
    const deleteCategoryButton = $('.delete-category');
    const deleteProjectButton = $('.delete-project');

    //deleteModal
    const deleteModal = $("#modal-delete");

    createCategoryButton.on('click', function() {
        createCategory();
    });

    createProjectButton.on('click', function() {
        createProject();
    });

    //delete warnning
    category_list_frame.on('click', '.delete-category', function() {
        const self = $(this);
        deleteModal.attr('data-index', self.attr('data-index'));
        deleteModal.find('.title').text(category_title + '&' + service_title)
        deleteModal.modal();
    });

    project_list_frame.on('click', '.delete-project', function() {
        const self = $(this);
        deleteModal.attr('data-index', self.attr('data-index'));
        deleteModal.find('.title').text(project_title)
        deleteModal.modal();
    });

    /**
     * Confirm delete action
     */
    deleteModal.on('click', '.confirm-button', function(e) {
        deleteItem(deleteModal.attr('data-index'));
        deleteModal.modal('hide');
    })

    /**
     * category select chagne handle
     */
    category_list_frame.on('change', '.category_selector', function(e) {
        var self = $(this);
        var serviceSelector = self.closest('.panel-info').find('.service_selector'); 
        serviceSelector.html('');

        const selected = self.val();

        var categorySelected = category.find(function(category) {
            return category.id === +self.val();
        });

        categorySelected.customer_service && categorySelected.customer_service.forEach(function(item) {
            serviceSelector.append('<option value="' + item.id + '">' + item.name + '</option>');
        });

        const name = self.attr('name');
        $(`select[name="${name}"]`).find(`option[value="${selected}"]`).attr('selected', true);
    });


    /**
     * project select chagne handle
     */
    project_list_frame.on('change', '.project_selector', function(e) {
        const self = $(this);

        const selected = self.val();

        const projectSelected = project.find(function(project) {
            return project.id === +self.val();
        });

        //車子or客戶區
        const area = self.closest('.panel-info').find('.cars');

        //index
        const index = self.closest('.panel-info').attr('data-index');

        //假如選擇的專案對象是車子，要生下拉選單
        if(projectSelected.target == 1){
            let carsSelector = $(`<select name=project[${index}][customer_car_id]></select>`);
            cars.forEach(function(item) {
                carsSelector.append('<option value="' + item.id + '">' + item.number + '</option>');
            });
            area.html(carsSelector)
        }else{
            let disableInput = $('<input type="text" readonly disabled>')
            area.html(disableInput)
        }

        const name = self.attr('name');
        $(`select[name="${name}"]`).find(`option[value="${selected}"]`).attr('selected', true);
    });


    project_list_frame.on('change', '.project_date_start, .project_date_end', function(e) {
        var self = $(this);
        const name = self.attr('name');
        const value = self.val();
        $(`input[name="${name}"]`).val(value)
    });

    /** create category form list */
    function createCategory() {
        const category_num = parseInt($('.category_title').length);
        const service_num = parseInt($('.service_title').length);

        //title
        category_template.find('.category_title').text(category_title + category_num)
        category_template.find('.service_title').text(service_title + service_num)

        //delete index
        category_template.find('.delete-category').attr('data-index', 'category_'+service_num)

        //name
        category_template.find('.category_selector').attr('name', `category[${category_num}][customer_category_id]`)
        category_template.find('.service_selector').attr('name', `category[${category_num}][customer_service_id]`)

        category_list_frame.append(category_template.html())
    }

    /** create category form list */
    function createProject() {
        const project_num = parseInt($('.project_title').length);
       
        project_template.find('.panel-info').attr('data-index', project_num);

        //title
        project_template.find('.project_title').text(project_title + project_num)

        //delete index
        project_template.find('.delete-project').attr('data-index', 'project_'+project_num)

        //name
        project_template.find('.project_selector').attr('name', `project[${project_num}][customer_project_id]`)
        project_template.find('.project_date_start').attr('name', `project[${project_num}][date_start]`)
        project_template.find('.project_date_end').attr('name', `project[${project_num}][date_end]`)

        project_list_frame.append(project_template.html())
    }
    
    /** remove project form list */
    function deleteItem(id) {
        const is_category = id.indexOf('category');
        const is_project = id.indexOf('project');

        if(is_category !== -1){
            category_list_frame.find(`span[data-index=${id}]`).closest('.panel-info').remove();
        }else if(is_project !== -1){
            project_list_frame.find(`span[data-index=${id}]`).closest('.panel-info').remove();
        }
    }
});
</script>
