
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
    <div class="panel panel-info category" style="padding: 10px 10px">
        <div class="form-group">
            <label class="col-md-3 control-label category_title"></label>
            <div class="col-md-5">
                <select class="form-control category_selector" required>
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
                <select class="form-control service_selector" required></select>
            </div>
        </div>
    </div>
</div>
<!-- template category -->



<!-- template project -->
<div id="project_template" style="display: none">
    <div class="panel panel-info project" style="padding: 10px 10px">
        <div class="form-group">
            <label class="col-md-3 control-label project_title"></label>
            <div class="col-md-5">
                <select class="form-control project_selector" required>
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
                <input type="date" class="form-control project_date_start" required>
                <input type="date" class="form-control project_date_end" required>
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

    const service_map = {!! $service_map->toJson() !!};
    const project_map = {!! $project_map->toJson() !!};

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
        const self = $(this);
        const serviceSelector = self.closest('.panel-info').find('.service_selector'); 
        serviceSelector.html('');

        const categorySelected = category.find(function(category) {
            return category.id === +self.val();
        });

        categorySelected && categorySelected.customer_service && categorySelected.customer_service.forEach(function(item) {
            serviceSelector.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });


    /**
     * project select chagne handle
     */
    project_list_frame.on('change', '.project_selector', function(e) {
        const self = $(this);

        const projectSelected = project.find(function(project) {
            return project.id === +self.val();
        });

        //車子or客戶區
        const area = self.closest('.panel-info').find('.cars');

        //index
        const index = self.closest('.panel-info').attr('data-index');

        //假如選擇的專案對象是車子，要生下拉選單
        if(projectSelected && projectSelected.target == 1){
            let carsSelector = $(`<select name=project[${index}][car_id]></select>`);
            cars.forEach(function(item) {
                carsSelector.append('<option value="' + item.id + '">' + item.number + '</option>');
            });
            area.html(carsSelector)
        }else{
            let disableInput = $('<input type="text" readonly disabled>');
            area.html(disableInput)
        }
    });

    /** create category form list */
    function createCategory(data) {
        let index = parseInt(category_list_frame.find('.category').length);

        const template = category_template;

        //title
        template.find('.category_title').text(category_title + parseInt(index + 1));
        template.find('.service_title').text(service_title + parseInt(index + 1));

        //delete index
        template.find('.delete-category').attr('data-index', 'category_'+index);

        //name
        template.find('.category_selector').attr('name', `category[${index}][category_id]`);
        template.find('.service_selector').attr('name', `category[${index}][service_id]`);

        //add
        category_list_frame.append(template.html());

        //make old data
        if(data){
            Object.keys(data).forEach((key)=>{
                if(key == 'service'){
                    key = 'category_id';
                }
                const target =  category_list_frame.find(`[name="category[${index}][${key}]"]`);
                if(target){
                    if(key == 'category_id'){
                        target.val(data['service']['customer_category_id']);
                    }else{
                        target.val(data[key]);
                    }

                    target.change();
                }
            });
        }

        template.remove();
    }

    /** create category form list */
    function createProject(data) {
        const index = parseInt(project_list_frame.find('.project').length);

        const template = project_template;
       
        template.find('.panel-info').attr('data-index', index);

        //title
        template.find('.project_title').text(project_title + parseInt(index + 1));

        //delete index
        template.find('.delete-project').attr('data-index', 'project_'+index);

        //name
        template.find('.project_selector').attr('name', `project[${index}][project_id]`);
        template.find('.project_date_start').attr('name', `project[${index}][started_at]`);
        template.find('.project_date_end').attr('name', `project[${index}][ended_at]`);

        //add
        project_list_frame.append(template.html());

        //make old data
        if(data){
            Object.keys(data).forEach((key)=>{
                const target = project_list_frame.find(`[name="project[${index}][${key}]"]`);
                if(target){
                    target.val(data[key]);
                }

                target.change();
            });
        }

        template.remove();
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

    //render data
    function renderList(){
        service_map.map((item)=>{
            createCategory(item);
        });

        project_map.map((item)=>{
            createProject(item);
        });

        if(service_map.length == 0){
            createCategory();
        }
       
        if(project_map.length == 0){
            createProject();
        }
    }

    renderList();
});
</script>
