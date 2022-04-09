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
            <th>Mã giảm giá</th>
            <th>Số lượng</th>
            <th>Giá sản phẩm</th>
            <th>Tổng tiền</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
     @php
     $i=0;
     $total=0;
     @endphp
     @foreach ($order_details as $key => $details)
     @php
     $i++;
     $subtotal = $details->product_price*$details->product_sale_quantity;
     $total += $subtotal;
     @endphp
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
            <td>@if($details->product_coupon != 'no')
                    {{$details->product_coupon}}</td>
                    @else
                    Không mã
                @endif
            </td>
            <td>{{$details->product_sale_quantity}}</td>
            <td>{{number_format($details->product_price,0,',','.')}}</td>
            <td>{{number_format($subtotal,0,',','.')}}</td>
      
           </tr>
       @endforeach
       <tr>
       <td colspan="2">
      @php
      $total_coupon = 0;
      @endphp
       @if($coupon_condition==1)
              @php
              $total_after_coupon = ($total*$coupon_number)/100;
              echo 'Giảm giá: '.number_format($coupon_number,0,',','.').'%'.'</br>';
              echo 'Tiền giảm: '.number_format($total_after_coupon,0,',','.');
              $total_coupon = $total - $total_after_coupon;
              @endphp
        @else
              @php
         echo 'Giảm giá: '.number_format($coupon_number,0,',','.').'k'.'</br>';
              
              $total_coupon = $total - $coupon_number;
              @endphp
        @endif
        
         <td>Thanh toán : {{number_format($total_coupon,0,',','.')}}</td>
         </td>
       </tr>
        </tbody>

      </table>
    </div>
  </div>
</div>
@endsection