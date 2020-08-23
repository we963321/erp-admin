<div class="form-group">
    <label class="col-md-3 control-label">洗車習慣日期</label>
    <div class="col-md-5">
        <div class="radio">
            <label>
              <input class="hobby-normal-date" type="radio" name="_holiday_choice" checked>
              平日
            </label>
          </div>
        <div class="regular-normal-day">
            @for ($i = 1; $i <= 5; $i++)
                <label class="checkbox-inline">
                    <input type="checkbox" name="regular_appear_at[]" value="{{ $i }}"> 星期 {{ $i }}
                </label>
            @endfor
        </div>
        
        <div class="radio">
            <label>
              <input class="hobby-holiday-date" type="radio" name="_holiday_choice">
              假日
            </label>
        </div>
        
        <div class="regular-holiday-day">
            @for ($i = 6; $i <= 7; $i++)
                <label class="checkbox-inline">
                    <input type="checkbox" name="regular_appear_at[]" value="{{ $i }}" disabled> 星期{{ $i === 6 ? ' 6' : '天' }}
                </label>
            @endfor
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">洗車習慣時段</label>
    <div class="col-md-5">
        <div class="regular-time">
            @php
                $_times = ['0900-1200' => '早上(0900-1200)','1300-1800' => '下午(1300-1800)', '1800-2200' => '晚上(1800-2200)'];
            @endphp
            @foreach ($_times as $value => $text)
                <label class="checkbox-inline">
                    <input type="checkbox" name="regular_appear_at_time[]" value="{{ $value }}"> {{ $text }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">預約通知</label>
    <div class="col-md-5">
        <div class="reservation-notification">
            @php
                $_times = ['7' => '7日', '10' => '10日', '15' => '15日', '30'=> '30日', '45'=> '45日', '60'=> '60日'];
            @endphp
            @foreach ($_times as $value => $text)
                <label class="radio-inline">
                    <input type="radio" name="reservation_notify_date" value="{{ $value }}" {{$loop->iteration === 1 ? 'checked' : ''}}> {{ $text }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">家中車輛數</label>
    <div class="col-md-5">
        <input type="number" class="form-control" name="car_amount" value="{{ $customer->car_amount ?? 0}}">
    </div>
</div>

<div class="row" style="margin-bottom: .75rem;">
    <div class="col-md-7 col-md-offset-3">
        <button class="btn btn-primary btn-xs create-car" type="button">
            新增車輛
            <i class="fa fa-plus-circle"></i>
        </button>
    </div>
</div>

<div class="delete-area" style="display: none"></div>
{{-- card list --}}
<div class="row">
    <div class="col-md-7 col-md-offset-3 cars-list">
        <div class="panel-group car-component" id="cars_list_frame" role="tablist" aria-multiselectable="true">
            
        </div>
    </div>
</div>

{{-- main --}}
<script>
$(document).ready(function() {
    var frame = $('#cars_list_frame');
    var template = $('.car-component-template').html();
    var cars = {!! $customer->cars->toJson() !!};
    var deleteCars = [];
    var deleteModal = $("#modal-delete");
    var carBrands = {!! $brands->toJson() !!};
    var carColor = {!! $carColor->toJson() !!};
    
    var createCarButton = $('.create-car');    

    createCarButton.on('click', function() {
        createCar();
        renderList();
    });

    /**
     * Brand select chagne handle
     */
    frame.on('change', '.car_brand_selector', function(e) {
        var self = $(this);
        var seriesSelector = self.parents('.panel-body').find('.series-selector'); 
        seriesSelector.html('');

        var brandSelected = carBrands.find(function(brand) {
            return brand.id === +self.val();
        });

        brandSelected.series && brandSelected.series.forEach(function(seriesElem) {
            seriesSelector.append('<option value="' + seriesElem.id + '">' + seriesElem.name + '</option>');
        });

    });

    /**
     * Customer name handle
     */
    frame.on('change', '.customer-name-setter', function() {
        var self = $(this);
        var customerInput = self.parents('.panel-body').find('.customer_name'); 
        
        if (self.prop('checked')) {
            customerInput.val('{{ $customer->name }}');
        }
    });

    /**
     * Delete the car data action handle
     */
     frame.on('click', '.car-delete-action', function(e) {
        var self = $(this);
        
        deleteModal.attr('data-index', self.attr('data-index'));
        deleteModal.modal();
     });

    /**
     * Confirm delete action
     */
    deleteModal.on('click', '.confirm-button', function(e) {
        removeCar(deleteModal.attr('data-index'));
        renderList();
        deleteModal.modal('hide');
    })
    
    /**
     * Inintailization
     */
    if (!cars.length) {
        frame.append('<p class="text-center text-danger">尚未建立車輛。</p>');
    } else {
        renderList();
    }

    function renderList() {
        frame.html('');

        cars.map(function(car, index) {
            var isExistData = !!car.id;
            var iteraion = index + 1;

            var carNumber = isExistData ? ('(' + car.number + ')') : '';

            var carPanelId = 'car-panel--' + iteraion;
            var _template = template
                .replace(/__panel_id__/g, carPanelId)
                .replace(/__panel_head_id__/g, 'car-panel-head--' + iteraion)
                .replace(/_car_index_/g, index)
                .replace(/__panel_head__/g, '車輛 ' + iteraion + carNumber);
            
            frame.append(_template);

            /** fill column */ 
            if (isExistData) {
                for (var column in car) {   
                    switch (true) {
                        case column === 'series_id' :
                            frame
                                .find('#' + carPanelId + ' .car_brand_selector')
                                .val(car.series.brand.id)
                                .change();
                            break;
                    }
                    var inputName = "name=\"cars["+ index + "][" + column + "]\"";
                    var inputer = frame.find('[' + inputName + ']')
                    inputer.val(car[column]);
                }
            } else {
                frame.find('#' + carPanelId + ' .car_brand_selector').change();
            }
        });
    }

    /** remove car form list */
    function createCar() {
        cars.push({})
    }

    /** remove car form list */
    function removeCar(index) {
        var removeCar = cars.splice(index, 1)[0];
        removeCar.id && deleteCars.push(removeCar.id) && $('.delete-area').html('');

        deleteCars.forEach(function(removeCarElem)  {
            $('.delete-area').append('<input type="hidden" value="' + removeCarElem + '" name="delete_cars[]">')
        });
    }
    
});
</script>

{{-- customer column controll --}}

<script>
$(document).ready(function() {
    var selectInputsHoliday = $('[name=_holiday_choice]');
    var regularAppearAt = {!! collect($customer->regular_appear_at)->toJson() !!};
    var regularAppearAtTime = {!! collect($customer->regular_appear_at_time)->toJson() !!};
    var reservationDate = '{{ $customer->reservation_notify_date }}';

    selectInputsHoliday.on('change', function(e) {
        var self = $(this);
        $('.regular-normal-day, .regular-holiday-day').find('[type=checkbox]').prop('checked', false);
        if (self.hasClass('hobby-normal-date')) {
            $('.regular-holiday-day')
                .find('[type=checkbox]')
                .prop('checked', false)
                .prop('disabled', true);
                
            $('.regular-normal-day')
                .find('[type=checkbox]')
                .prop('disabled', false);

        } else if (self.hasClass('hobby-holiday-date')) {
            $('.regular-normal-day')
                .find('[type=checkbox]')
                .prop('checked', false)
                .prop('disabled', true);

            $('.regular-holiday-day')
                .find('[type=checkbox]')
                .prop('disabled', false);
        }
        
    });

    if (regularAppearAt.includes('6') || regularAppearAt.includes('7')) {
        $('.hobby-holiday-date').prop('checked', true);
        selectInputsHoliday.change()
        
        $('.regular-holiday-day').find('[type=checkbox]').each(function(_i, ele) {
            var checkbox = $(ele);
            regularAppearAt.includes(checkbox.val()) && checkbox.prop('checked', true);
        })
    } else {
        $('.regular-normal-day').find('[type=checkbox]').each(function(_i, ele) {
            var checkbox = $(ele);
            regularAppearAt.includes(checkbox.val()) && checkbox.prop('checked', true);
        });
    }

    $('.regular-time').find('[type=checkbox]').each(function(_i, ele) {
        var checkbox = $(ele);
        regularAppearAtTime.includes(checkbox.val()) && checkbox.prop('checked', true);
    });

    $('.reservation-notification').find('[type=radio]').each(function(_i, ele) {
        var radio = $(ele);
        reservationDate === radio.val() && radio.prop('checked', true);
    });
});
</script>