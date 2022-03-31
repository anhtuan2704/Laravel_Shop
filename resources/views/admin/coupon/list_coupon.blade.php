@extends('admin_layout');
@section('admin_content');
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê mã giảm giá
    </div>
    
    <div class="table-responsive">
                          <?php
                            $messages = Session::get('message');
                            if($messages){
                                echo '<span class="text-alert">',$messages. '</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên mã giảm giá</th>
            <th>Mã giảm giá</th>
            <th>Số lượng giảm giá</th>
            <th>Điều kiện giảm giá</th>
            <th>Số giảm</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cou->coupon_name}}</td>
            <td>{{$cou->coupon_code}}</td>
            <td>{{$cou->coupon_time}}</td>

            <td><span class="text-ellipsis">
            <?php
              if($cou->coupon_condition==1){
                ?>
                  Giảm theo %
                <?php
              }else{
              ?>
                  Giảm theo tiền
              <?php
              }
              ?>
            </span></td>
            <td><span class="text-ellipsis">
            <?php
              if($cou->coupon_condition==1){
                ?>
                  Giảm {{$cou->coupon_number}} %
                <?php
              }else{
              ?>
                   Giảm {{$cou->coupon_number}} k
              <?php
              }
              ?>
            </span></td>
            <td>
              <a onclick="return (confirm('Bạn có muốn xóa mã này không?'))" href="{{URL::to('/delete-coupon', $cou->coupon_id)}}" class="active styling-detele" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          @endforeach
        </tbody>

      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection