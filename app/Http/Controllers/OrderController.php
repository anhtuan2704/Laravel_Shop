<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feeship;
use App\Order;
use App\Order_details;
use App\Shipping;
use App\Customer;
use App\Coupon;
class OrderController extends Controller
{
    public function view_order($order_code){
        $order_details = Order_details::where('order_code', $order_code)->get();
        $order = order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        
        $Order_details = Order_details::with('product')->where('order_code',$order_code)->get();

        foreach($Order_details as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition=2;
            $coupon_number=0; 
        }
      
      

        return view('admin.view_order')->with(compact('order_details', $order_details, 'customer',$customer,'shipping',$shipping,
        'coupon_condition',$coupon_condition,'coupon_number',$coupon_number));
    }
    public function manager_order(){
        $order = Order::orderby('created_at', 'DESC')->get();
        return view('admin.manager_order')->with(compact('order'));
    }
    
}
