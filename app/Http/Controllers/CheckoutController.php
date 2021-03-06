<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\City;
use App\province;
use App\wards;
use App\Feeship;
use App\Order;
use App\Order_details;
use App\Shipping;
session_start();

class CheckoutController extends Controller
{
    public function conform_order(Request $request){
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if(session::get('cart')){
            foreach(session::get('cart') as $key => $cart){
                $order_details = new Order_details();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sale_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        session::forget('coupon');
        session::forget('fee');
        session::forget('cart');
    }
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function del_fee(){
        session::forget('fee');
        return redirect()->back();
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])
            ->where('fee_xaid', $data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                    foreach($feeship as $key => $fee){
                        session::put('fee', $fee->fee_feeship);
                        session::save();
                    }
                }else{
                    session::put('fee',30000);
                    session::save();
                }
            }
            
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output ='';
            if($data['action'] == "city"){
                $select_province = province::where('matp', $data['ma_id'])
                ->orderby('maqh', 'ASC')->get();
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            
            }else{
                $select_wards = wards::where('maqh', $data['ma_id'])
                ->orderby('xaid', 'ASC')->get();
             
                foreach($select_wards as $key => $ward){
                    $output.= '<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                } 
            }
        }
        echo $output;
    }
   
    public function login_check_out(Request $request){
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
        $meta_desc = "Login";
        $meta_keywords = "Login";
        $meta_title = "Login";
        $url_canonical = $request->url();

        return view('pages.checkout.login_checkout')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name']=$request->customer_name;
        $data['customer_phone']=$request->customer_phone;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);

        $customer_id = DB::table('tbl_customers')->insertGetId($data);
        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name)
        ;

        return Redirect::to('/checkout');
    }

    public function check_out(Request $request){

        //SEO
        $meta_desc = "Check Out";
        $meta_keywords = "Check Out";
        $meta_title = "Check Out";
        $url_canonical = $request->url();
        //SEO
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();

        $city = City::orderby('matp','ASC')->get();
        return view('pages.checkout.checkout')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('city',$city);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_note']=$request->shipping_note;
        $data['shipping_address']=$request->shipping_address;


        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return Redirect::to('/payment');

    }

    public function payment(Request $request){
          //SEO
          $meta_desc = "Payment";
          $meta_keywords = "Payment";
          $meta_title = "Payment";
          $url_canonical = $request->url();
          //SEO
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
        
    }

    public function order_place(Request $request){
         //SEO
         $meta_desc = "Order Place";
         $meta_keywords = "Order Place";
         $meta_title = "Order Place";
         $url_canonical = $request->url();
         //SEO

        //insert payment
        $data = array();
        $data['payment_method']= $request->payment_option;
        $data['payment_status']= '??ang ch???';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = '??ang ch??? x??? l??';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sale_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 1 ){
            echo 'Thanh to??n ATM';
        }elseif($data['payment_method'] == 2){
            Cart::destroy();
            $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

            $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
            return view('pages.checkout.handcash')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
        }else{
            echo 'Thanh to??n Visa';
            
        }
    }

    public function logout_check_out(){
        
        Session::flush();
        return Redirect::to('/login-check-out');
    }

    public function login_customer(Request $request){
      

        $url_canonical = $request->url();
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result =   DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        
        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');

        }else{
            return Redirect::to('/login-check-out');

        }

       
    }

    // public function manager_order(){
    //     $this->authLogin();
    //     $all_order = DB::table('tbl_order')
    //     ->join('tbl_customers','tbl_customers.customer_id','=','tbl_customers.customer_id')
    //     ->select('tbl_order.*', 'tbl_customers.customer_name')
    //     ->orderby('tbl_order.order_id','desc')->get();
    //     $manager_order = view('admin.manager_order')->with('all_order',$all_order);
    //     return view('admin_layout')->with('admin.manager_order', $manager_order);
    // }
}
