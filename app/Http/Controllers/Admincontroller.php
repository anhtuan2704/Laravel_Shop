<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Social; //sử dụng model Social
use Socialite; //sử dụng Socialite
use App\Login; //sử dụng model Login
use Illuminate\Support\Facades\Redirect;

class Admincontroller extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        //return $users->id;
        


        // $authUser = $this->findOrCreateUser($users,'google');
        // $account_name = Login::where('admin_id',$authUser->user)->first();
        // Session::put('admin_login',$account_name->admin_name);
        // Session::put('admin_id',$account_name->admin_id);
        // return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
      
       
    }
    // public function findOrCreateUser($users,$provider){
    //     $authUser = Social::where('provider_user_id', $users->id)->first();
    //     if($authUser){

    //         return $authUser;
    //     }
      
    //     $hieu = new Social([
    //         'provider_user_id' => $users->id,
    //         'provider' => strtoupper($provider)
    //     ]);

    //     $orang = Login::where('admin_email',$users->email)->first();

    //         if(!$orang){
    //             $orang = Login::create([
    //                 'admin_name' => $users->name,
    //                 'admin_email' => $users->email,
    //                 'admin_password' => '',

    //                 'admin_phone' => '',
    //                 'admin_status' => 1
    //             ]);
    //         }
    //     $hieu->login()->associate($orang);
    //     $hieu->save();

    //     $account_name = Login::where('admin_id',$authUser->user)->first();
    //     Session::put('admin_login',$account_name->admin_name);
    //     Session::put('admin_id',$account_name->admin_id);
    //     return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');


    // }

    public function index(){
        return view('admin_login');
    }

    public function show_dashboard(){
        $this->authLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            
            return Redirect::to('/dashboard');
        }
        else{
            Session::put('message','Mật khẩu hoặc tài khoản không đúng');
            return Redirect::to('/admin');
        }
    }

    public function log_out(){
        $this->authLogin();

        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
        
    }
}
