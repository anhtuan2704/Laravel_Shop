@extends('admin_layout');
@section('admin_content');
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      THÔNG TIN ĐĂNG NHẬP
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
            <th>Tên người mua</th>
            <th>Số điện thoại</th>      
            <th>Email</th>      
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$customer->customer_name}}</td>
                <td>{{$customer->customer_phone}}</td>
                <td>{{$customer->customer_email}}</td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      THÔNG TIN VẬN CHUYỂN HÀNG
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
            <th>Tên người vận chuyển</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>      
            <th>Email</th>      
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
     
          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_note}}</td>
            <td>@if($shipping->shipping_method==0)
               Chuyển khoản
              @else
              Tiền mặt
              @endif
            </td>

        </tbody>

      </table>
    </div>
   
  </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
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
            </th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
     @php
     $i=0
     @endphp
     @foreach ($Order_details as $key => $details)
     @php
     $i++;
     @endphp
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
            <td>{{$details->product_sale_quantity}}</td>
            <td>{{$details->product_price}}</td>
            <td>{{$details->product_price*$order_by_id->product_sale_quantity}}</td>
           </tr>
       @endforeach
        </tbody>

      </table>
    </div>
  </div>
</div>

@endsection