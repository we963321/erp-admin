@php
    use App\Models\CustomerCar;
@endphp

<div class="car-component-template" style="display: none;">
    <div class="panel panel-info">
        <div class="panel-heading" role="tab" id="__panel_head_id__">
            <h4 class="panel-title">
                <a class="switch-collapse-title" role="button" data-toggle="collapse" data-parent="#cars_list_frame" href="#__panel_id__" aria-expanded="true" aria-controls="__panel_id__">
                    __panel_head__
                </a>

                <span class="pull-right text-danger car-delete-action" data-index="_car_index_" style="cursor: pointer;">刪除</span>
            </h4>
        </div>
        <div id="__panel_id__" class="panel-collapse collapse" role="tabpanel" aria-labelledby="__panel_head_id__">
            <div class="panel-body">
                <input type="hidden" name="cars[_car_index_][id]" value="">

                <div class="form-group">
                    <label class="col-md-3 control-label">車牌號碼</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cars[_car_index_][number]" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">使用人</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control customer_name" name="cars[_car_index_][customer_name]" value="">
                        
                        <label class="checkbox-inline">
                            <input class="customer-name-setter" type="checkbox"> <small class="text-info">同客戶名稱</small> 
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">購車方式</label>
                    <div class="col-md-5">
                        <select class="form-control" name="cars[_car_index_][bought_type]">
                            <option value="{{ CustomerCar::CAR_BOUGHT_NEW }}" selected>新車購入</option>
                            <option value="{{ CustomerCar::CAR_BOUGHT_RENT }}">租賃</option>
                            <option value="{{ CustomerCar::CAR_BOUGHT_OLD }}">中古購入</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">車型</label>
                    <div class="col-md-5">
                        <select class="form-control"  name="cars[_car_index_][type]">
                            <option value="{{ CustomerCar::CAR_TYPE_SMALL }}">小/中型房車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_LARGE }}">大型房車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_CRV }}">休旅車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_RV_7 }}">七人 RV 車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_SCOOTER }}">小型機車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_SCOOTER_RACE }}">中型仿賽機車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_SCOOTER_STREET }}">中型街車機車</option>
                            <option value="{{ CustomerCar::CAR_TYPE_SCOOTER_RACE_LARGE }}">公升級仿賽機車</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">年份</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cars[_car_index_][years]" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">品牌</label>
                    <div class="col-md-5">
                        <select class="car_brand_selector form-control">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">車系</label>
                    <div class="col-md-5">
                        <select class="series-selector form-control" name="cars[_car_index_][series_id]">
                            
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">型號</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cars[_car_index_][model]" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">顏色</label>
                    <div class="col-md-5">
                        <select class="form-control" name="cars[_car_index_][color_id]">
                            @foreach ($carColor as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">顏色說明</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cars[_car_index_][color_remark]" value="">
                    </div>
                </div>        

                <div class="form-group">
                    <label class="col-md-3 control-label">排氣量</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="cars[_car_index_][displacement]" value="">
                    </div>
                </div>          
                
                <div class="form-group">
                    <label class="col-md-3 control-label">鈑金/漆面檢查紀錄</label>
                    <div class="col-md-5">
                        <textarea class="form-control" name="cars[_car_index_][log_surface]" value=""></textarea>
                    </div>
                </div>   
                    {{-- inspected_at --}}
                    {{-- ci_expired_at --}}
                    {{-- insurance_expired_at --}}
                

            </div>
        </div>
    </div>
</div>