<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feeship;
use App\Order;
use App\Order_details;
use App\Shipping;
use App\Customer;
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

        return view('admin.view_order')->with(compact('order_details', $order_details, 'customer',$customer,'shipping',$shipping));
    }
    public function manager_order(){
        $order = Order::orderby('created_at', 'DESC')->get();
        return view('admin.manager_order')->with(compact('order'));
    }
    
}
