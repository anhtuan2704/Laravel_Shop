@extends('admin_layout');
@section('admin_content');

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm vận chuyển
                        </header>
                    <?php
                            $messages = Session::get('message');
                            if($messages){
                                echo '<span class="text-alert">',$messages. '</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form>
                                    @csrf()
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                    <select id="city" name="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="">------------Chọn tỉnh/thành phố-----------</option>
                                        @foreach($city as $key => $ci)
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        @endforeach
                                       
                                     </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                    <select id="province" name="province"  class="form-control input-sm m-bot15 choose province">
                                            <option value="">------------Chọn quận huyện-----------</option>
                                         
                                     </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn phường xã</label>
                                    <select id="wards" name="wards"  class="form-control input-sm m-bot15 wards">
                                            <option value="">-----------Chọn phường xã-------------</option>
                                         
                                     </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phí vận chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm</button>
                            </form>
                        </div>
                            <div id="load_delivery">

                            </div>  
            </div>  
            </section>
</div>

@endsection