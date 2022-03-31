<?php

namespace App\Http\Controllers;
use App\city;
use App\province;
use App\wards;
use App\Feeship;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
    public function select_feeship(){
        $feeship = Feeship::orderby('fee_id','DESC')->get();
        $output = '';
        $output.='<div class="table-reponsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên thành phố</th>
                    <th>Tên quận huyện</th>
                    <th>Tên xã phường</th>
                    <th>Phí ship</th>
                </tr>
            </thead>
            <tbody>
            ';
            foreach($feeship as $key =>$fee){
                $output.='
                <tr>
                  <td>'.$fee->city->name_city.'</td>
                  <td>'.$fee->province->name_quanhuyen.'</td>
                  <td>'.$fee->wards->name_xaphuong.'</td>
                  <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">
                  '.number_format($fee->fee_feeship,0,',','.').'</td>
                  
                </tr>
                ';
            }
            $output.='
            </tbody>
        </table>
        </div>
    ';
        echo $output;
    }
    public function insert_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }
    public function delivery(Request $request){
        $city = City::orderby('matp','ASC')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request){
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
}
