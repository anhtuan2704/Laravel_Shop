<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function send_mail(){
        $to_name = "Anh Tuan";
        $to_email = "anhtuan2704222@gmail.com";

        $data = array("name" => "Mail từ tài khoản khách hàng", "body"=>"
        Mail gửi về vấn đề hàng hóa");
        Mail::send('pages.send_mail', $data, function($message) use 
        ($to_name, $to_email){
            $message->to($to_email)->subject('Test thử mail google');
            $message->from($to_email, $to_name);
        });
        return redirect::to('/')->with('message', '');
    }
    public function index(Request $request){

        //Seo
        $meta_desc = "Chuyên bán quần áo và phụ kiện người dùng";
        $meta_keywords = "Quấn áo dành cho giới trẻ";
        $meta_title = "Shop quần áo dành cho giới trẻ";
        $url_canonical = $request->url();
        //Seo

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
        
        // $allproduct = DB::table('tbl_product')
        // ->join('category_product','category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand', 'tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')
        ->where('product_status', '0')
        ->orderby('product_id','desc')
        ->limit(10)->get();
        
        return view('pages.home')->with('category', $cate_product)
        ->with('brand', $brand_product)->with('all_product', $all_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }

    public function search(Request $request){

        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();

        $keywords = $request->keywords_submit;
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();

        $search_product = DB::table('tbl_product')
        ->where('product_name', 'like', '%'.$keywords.'%')      
       ->get();
        
        return view('pages.product.search')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('search_product', $search_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }

    
} 