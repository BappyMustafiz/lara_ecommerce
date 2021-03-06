@extends('layouts.adminLayout.admin_design')
@section('content')

	<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">View Categories</a> </div>
  </div>
  <div class="container-fluid">
    <hr>
    @if(Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
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
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Categories</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category Id</th>
                  <th>Category Name</th>
                  <th>Category Level</th>
                  <th>Category URL</th>
                  <th>Category status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				@foreach($categories as $category)
                <tr class="gradeX">
                  <td>{{$category->id}}</td>
                  <td>{{$category->name}}</td>
                  <td>{{$category->category_level}}</td>
                  <td>{{$category->url}}</td>
                  <td>{{$category->status=="1" ? 'active' : 'deactive' }}</td>
                  <td class="center">
                    <a href="{{url('/admin/edit_category/'.$category->id)}}" class="btn btn-primary btn-mini">Edit</a>
                    <a rel="{{$category->id}}" rel1="delete_category" <?php /*id="delCat" href="{{url('/admin/delete_category/'.$category->id)}}"*/?> class="btn btn-danger btn-mini deleteRecord">Delete</a>
                  </td>
                </tr>
				@endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection