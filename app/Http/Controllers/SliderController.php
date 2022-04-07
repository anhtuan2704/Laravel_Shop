<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
class SliderController extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function manager_slider(){
        $all_slider = Slider::orderby('slider_id','DESC')->get();
        return view('admin.slider.listSlider')->with(compact('all_slider'));
    }
    public function add_slider(){
        return view('admin.slider.add_Slider');
    }
    public function insert_slider(Request $request){
        $data = $request->all();
       
       $this->authLogin();
  
        $get_image = $request -> file('slider_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(base_path().'/public/uploads/slider', $new_image);
            
            $slider = new slider();
            $silder->slider_name = $data['slider_name'];
            $silder->slider_image = $name_image;
            $silder->slider_status = $data['slider_status'];
            $silder->slider_desc = $data['slider_desc'];
            $slider->save();
            Session::put('message','Thêm silder thành công');
            return Redirect::to('add-slider');

        }else{
            Session::put('message','Thêm hình ảnh');
            return Redirect::to('add-slider');
        }
    }
}
