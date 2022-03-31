<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Coupon;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_avaiable =0;
                    if($is_avaiable==0){
                        $cou[]= array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        session::put('coupon',$cou);
                    }
                }else{
                    $cou[]= array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    session::put('coupon',$cou);
                }
                session::save();
                return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
            }
        }else{
            return redirect()->back()->with('error', 'Thêm mã giảm giá không đúng');

        }
    }
    public function gio_hang(Request $request){
        $cate_product = DB::table('category_product')
        ->where('category_status', '0')
        ->orderby('category_id','desc')
        ->get();

        $brand_product = DB::table('tbl_brand')
        ->where('brand_status', '0')
        ->orderby('brand_id','desc')
        ->get();
        $meta_desc = "Giỏ hàng ajax";
        $meta_keywords = "Giỏ hàng ajax";
        $meta_title = "Giỏ hàng ajax";
        $url_canonical = $request->url();
       
        return view('pages.cart.show_cart2')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaible++; 
                }
            }
            if($is_avaiable==0){
                $cart[]=array(
                    'session_id'=>$session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image'=>$data['cart_product_image'],
                    'product_price'=>$data['cart_product_price'],
                    'product_qty'=>$data['cart_product_qty'],
                );
            Session::put('cart', $cart);
            }
        }else{
            $cart[]=array(
                'session_id'=>$session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image'=>$data['cart_product_image'],
                'product_price'=>$data['cart_product_price'],
                'product_qty'=>$data['cart_product_qty'],
            );
        }
        Session::put('cart', $cart);
        Session::save();
    }
    public function delete_cart($session_id){
        $cart = Session::get('cart');  
        if($cart == true){
            foreach($cart as $key =>$val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Xóa sản phẩm thành công');

        }else{
            return redirect()->back()->with('message','Xóa sản phẩm thất bại');

        }
    }
    public function update_cart(Request $request){
        $data = $request->all();
        $cart = session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key =>$qty){
                foreach($cart as $session =>$val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty']=$qty;
                    }
                }
            }
            session::put('cart',$cart);
            return redirect()->back()->with('message','Cập nhật số lượng thành công');
        }else{
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');

        }
    }
    public function del_all_product(){
        $cart = session::get('cart');
        if($cart==true){
            session::forget('cart');
            session::forget('coupon');
            return redirect()->back()->with('message','Xóa giỏ hàng thành công');
        }
    }
    public function savecart(Request $request){
            
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')
        ->where('product_id',$productId)
        ->first();

        $data['id']= $product_info->product_id;
        $data['qty']= $quantity;
        $data['name']= $product_info->product_name;
        $data['price']= $product_info->product_price;
        $data['weight']= '123';
        $data['options']['image']= $product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(5);
        return Redirect::to('/show-cart');

        // Cart::destroy();
        //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
    }
    public function show_cart(Request $request){

        $cate_product = DB::table('category_product')
        ->where('category_status', '0')
        ->orderby('category_id','desc')
        ->get();

        $brand_product = DB::table('tbl_brand')
        ->where('brand_status', '0')
        ->orderby('brand_id','desc')
        ->get();
        $meta_desc = "Giỏ hàng";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
       
        return view('pages.cart.show_cart')->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }

    public function delete_to_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');

    }

    public function update_cart_quatity(Request $request){

        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
         return Redirect::to('/show-cart');
    }
}
