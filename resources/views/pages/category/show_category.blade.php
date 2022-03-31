@extends('welcome')
@section('content')
<div class="features_items">
<div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" 
data-action="like" data-size="small" data-share="true"></div>
	@foreach($category_by_name as $key => $name)
	<h2 class="title text-center">{{$name->category_name}}</h2>
	@endforeach
	@foreach($category_by_id as $key => $product)	
	<a href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}" class="">
	<div class="col-sm-4">
		<div class="product-image-wrapper">
			<div class="single-products">
				<div class="productinfo text-center">
					<img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
					<h2>{{number_format($product->product_price).' '.'VND'}}</h2>
					<p>{{$product->product_name}}</p>
					<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
				</div>
				
			</div>
			<div class="choose">
				<ul class="nav nav-pills nav-justified">
					<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
					<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
				</ul>
			</div>
		</div>
	</div>
</a>

	@endforeach
</div>
<div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="20"></div>
@endsection