<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponsController extends Controller
{
	/*method for add coupons*/
    public function add_coupon(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		// echo "<pre>";die(print_r($data));
    		$coupon = new Coupon;
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		$coupon->status = $data['status'];
    		$coupon->save();
    		return redirect('/admin/view_coupons')->with('flash_message_success', 'Coupon has been added successfully');
    	}
    	return view('admin.coupons.add_coupon');
    }

    /*method for view coupons*/
    public function view_coupons(){
    	$coupons = Coupon::get();
    	return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }

    /*method for edit and update coupons*/
    public function edit_coupon(Request $request, $id = null){
    	// update coupon
        if($request->isMethod('post')){
        	$data = $request->all();

        	$coupon = Coupon::find($id);
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		// check product enable or disable
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
    		$coupon->status = $status;
    		$coupon->save();
    		return redirect('/admin/view_coupons')->with('flash_message_success', 'Coupon has been updated successfully');
        }
    	// get coupon details
        $coupon_details = Coupon::where(['id'=>$id])->first();

    	return view('admin.coupons.edit_coupon')->with(compact('coupon_details'));
    }

    /*method for delete coupons*/
    public function delete_coupon($id = null){
        Coupon::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Coupon has been deleted');
    }
}
