@extends('welcome')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="register-req">
				<p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Điền thông tin gửi hàng</p>
							<div class="form-one">
								<form method="post">
                                    @csrf
									<input type="text" name="shipping_email" class="shipping_email" placeholder="Email">
									<input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên">
									<input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ">									
									<input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone">
                                    <textarea name="shipping_note" class="shipping_note" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>
									
									@if(Session::get('fee'))
									<input type="hidden" name = "order_fee" class="order_fee" value="{{Session::get('fee')}}">
									@else
									<input type="hidden" name = "order_fee" class="order_fee" value="30000">
									@endif

									@if(Session::get('coupon'))
									@foreach(Session::get('coupon') as $key =>$cou)
									<input type="hidden" name = "order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
									@endforeach
									@else
									<input type="hidden" name = "order_coupon" class="order_coupon" value="no">
									@endif
									
									<div class="">
										<div class="form-group">
											<label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
											<select name = "payment_select" class="form-control input-sm m-bot15 payment_select">
												<option value="0">Thanh Toán Trực Tuyến</option>
												<option value="1">Thanh Toán Trực Tiếp</option>
											</select>
										</div>
									</div>	
                                    <input type="button" value="Xác nhận đon hàng" name="send_oder" class="btn btn-primary btn-sm send_order"></input>							
								</form>

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
                                
								<input type="button" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery"></input>							
                               
                            </form>
							
							</div>
							
						</div>
					</div>
					<div class="col-sm-12 clearfix">
							@if(session()->has('message'))
							<div class="alert alert-success">
							{{session()->get('message')}}
							</div>
							@elseif(session()->has('error'))
							<div class="alert alert-danger">
							{{session()->get('error')}}
							</div>
						@endif
					<div class="table-responsive cart_info">
			<form action="{{URL::to('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
				
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Mô tả</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng tiền</td>
							
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
								@php
									$total = 0;
								@endphp
								
								@foreach(Session::get('cart') as $key =>$cart)

								@php
									$subtotal = $cart['product_price']*$cart['product_qty'];
									$total += $subtotal
								@endphp
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" 
								width="50" alt="{{$cart['product_name']}}"></a>
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
								
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"
											 >
																
									</div>

							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}đ
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL('/delete-cart/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						
						</tr>
						

						@endforeach
						<tr>
							<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"> </td>					
							<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
						<td>
						<li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>
						@if(Session::get('coupon'))
						<li>
							
									@foreach(Session::get('coupon') as $key =>$cou)
										@if($cou['coupon_condition']==1)
											Mã giảm: {{$cou['coupon_number']}} %
											<p>
											@php
												$total_coupon =($total*$cou['coupon_number'])/100;
											
											@endphp
											</p>
											<p>
												@php 
													$total_after_coupon = $total-$total_coupon;
												@endphp
											</p>
										@elseif($cou['coupon_condition']==2)
										Mã giảm: {{number_format($cou['coupon_number'],0,',','.')}} 
										<p>
											@php
												$total_coupon = $total - $cou['coupon_number'];		
											@endphp
										</p>
										<p>
											@php
												$total_after_coupon = $total_coupon;
											@endphp
										</p>
											@endif
									@endforeach
							
							</li>
							@endif
							@if(session::get('fee'))
							<li>
							<a class="cart_quantity_delete" href="{{URL('/del-fee')}}"><i class="fa fa-times"></i></a>

							Phí vận chuyển <span>{{number_format(session::get('fee'),0,',','.')}}đ</span>
							@php $total_after_fee = $total + session::get('fee'); @endphp</li>	
							@endif
									
						
						<li>Tổng cộng: 
						@php
							if(session::get('fee') && !session::get('coupon')){
								$total_after = $total_after_fee;
								echo number_format($total_after,0,',','.').'đ';
							}elseif(!session::get('fee') && session::get('coupon')){
								$total_after = $total_after_coupon;
								echo number_format($total_after,0,',','.').'đ';
							}elseif(session::get('fee') && session::get('coupon')){
								$total_after = $total_after_coupon;
								$total_after = $total_after + session::get('fee');
								echo number_format($total_after,0,',','.').'đ';
							}elseif(!session::get('fee') && !session::get('coupon')){
								$total_after = $total;
								echo number_format($total_after,0,',','.').'đ';
							}
						@endphp
						</li>
						</td>
						</tr>
						@else
						<tr>
							<td>
								@php
								echo 'Thêm sản phẩm vào giỏ hang';
								@endphp
							</td>
						</tr>
						@endif
					</tbody>
					</form>
						@if(session::get('cart'))
						<tr>
						<td >	
						<form method="POST" action="{{URL('/check-coupon')}}">
							@csrf
							<input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá">
							<br>
							<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">
						
						</form>
						</td>
						</tr>
						@endif
				</table>
			</div>
					</div>
					</div>							
				</div>
			</div>
			
		</div>
	</section> <!--/#cart_items-->
    @endsection