@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Coupons</a> <a href="#" class="current">Edit Coupon</a> </div>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Coupon</h5>
          </div>
          <div class="widget-content nopadding">
          	@if(Session::has('flash_message_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! session('flash_message_error')!!}</strong>
            </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! session('flash_message_success')!!}</strong>
                </div>
            @endif 
            <form class="form-horizontal" method="post" action="{{url('/admin/edit_coupon/'.$coupon_details->id)}}" name="add_coupon" id="add_coupon">
            @csrf
              <div class="control-group">
                <label class="control-label">Coupon code</label>
                <div class="controls">
                  <input type="text" name="coupon_code" id="coupon_code" minlength="5" maxlength="15" required="" value="{{$coupon_details->coupon_code }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Amount</label>
                <div class="controls">
                  <input type="number" name="amount" id="amount" required="" min="1" value="{{$coupon_details->amount }}">
                </div>
              </div>
              <div class="control-group">
                  <label class="control-label">Amount type</label>
                  <div class="controls">
                    <select name="amount_type" id="amount_type" style="width: 220px;">
                      <option @if($coupon_details->amount_type=="Percentage") selected @endif value="Percentage">Percentage</option>
                      <option @if($coupon_details->amount_type=="Fixed") selected @endif  value="Fixed">Fixed</option>
                    </select>
                  </div>  
              </div>
              <div class="control-group">
                <label class="control-label">Expiry Date</label>
                <div class="controls">
                  <input type="text" name="expiry_date" id="expiry_date" autocomplete="off" required="" value="{{$coupon_details->expiry_date }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($coupon_details->status=="1") checked @endif value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Update Coupon" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection