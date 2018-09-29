@extends('layouts.frontLayout.front_design')
@section('content')
		
	<section>
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{asset('./')}}">Home</a></li>
				  <li class="active">Product details</li>
				</ol>
			</div>
			<div class="row">
				@if(Session::has('flash_message_error'))
		            <div class="alert alert-danger alert-block">
		                <button type="button" class="close" data-dismiss="alert">x</button>
		                <strong>{!! session('flash_message_error')!!}</strong>
		            </div>
	            @endif
				<div class="col-sm-3">
					@include('layouts.frontLayout.front_sidebar')
				</div>
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
									<a href="{{asset('images/backend_images/products/large/'.$productDetails->image)}}">
										<img style="width: 300px;" class="mainImage" src="{{asset('images/backend_images/products/medium/'.$productDetails->image)}}" alt="" />
									</a>
								</div>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
							    <div class="carousel-inner">
									<div class="item active thumbnails">
										@foreach($productAltImages as $altImages)
											<a href="{{asset('images/backend_images/products/large/'.$altImages->image)}}" data-standard="{{asset('images/backend_images/products/medium/'.$altImages->image)}}">
										  		<img class="changeImage" style="width: 80px; cursor: pointer;" src="{{asset('images/backend_images/products/medium/'.$altImages->image)}}" alt="">
										  	</a>	
									  	@endforeach
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-7">
							<form action="{{url('/cart/add_to_cart')}}" name="addToCartForm" id="addToCartForm">
								@csrf
								<!-- hidden fields for cart -->
								<input type="hidden" name="product_id" value="{{$productDetails->id}}">
								<input type="hidden" name="product_name" value="{{$productDetails->product_name}}">
								<input type="hidden" name="product_code" value="{{$productDetails->product_code}}">
								<input type="hidden" name="product_color" value="{{$productDetails->product_color}}">
								<input type="hidden" name="product_price" id="productPrice" value="{{$productDetails->price}}">
								<!-- hidden fields for cart -->
								<div class="product-information">
									<img src="{{asset('images/frontend_images/product-details/new.jpg')}}" class="newarrival" alt="" />
									<h2>{{$productDetails->product_name}}</h2>
									<p>Code: {{$productDetails->product_code}}</p>

									<p>
										<select name="size" id="selSize" style="width: 150px;">
											<option value="">Select size</option>
												@foreach($productDetails->attributes as $sizes)
													<option value="{{$productDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
												@endforeach
										</select>
									</p>
									<span>
										<span id="getPrice">BDT {{$productDetails->price}}</span>
										<label>Quantity:</label>
										<input type="text" name="quantity" value="1" />
										@if($total_stock > 0)
											<button type="submit" class="btn btn-fefault cart" id="cartButton">
												<i class="fa fa-shopping-cart"></i>
												Add to cart
											</button>
										@endif
									</span>
									<p><b>Availability:</b><span id="Availability"> @if($total_stock > 0) In Stock @else Out of Stock @endif</span></p>
									<p><b>Condition:</b> New</p>
									<a href=""><img src="{{asset('images/frontend_images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
								</div><!--/product-information-->
							</form>	
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Material & Care</a></li>
								<li><a href="#delivary" data-toggle="tab">Delivar Options</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="description" >
								<div class="col-sm-12">
									<p>{{$productDetails->product_description}}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="care" >
								<div class="col-sm-12">
									<p>{{$productDetails->care}}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="delivary" >
								<div class="col-sm-12">
									<p>100% original product <br>
										Cash on delivery	
									</p>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php $count = 1;?>
								@foreach($relatedProducts->chunk(3) as $chunk)
									<div <?php if($count==1){ ?> class="item active" <?php } else{?> class="item" <?php }?>>
										@foreach($chunk as $item)
											<div class="col-sm-4">
												<div class="product-image-wrapper">
													<div class="single-products">
														<div class="productinfo text-center">
															<img src="{{asset('images/backend_images/products/small/'.$item->image)}}" alt="" />
															<h2>BDT {{$item->price}}</h2>
															<p>{{$item->product_name}}</p>
															<a href="{{url('product/'.$item->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
															<!-- <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button> -->
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								<?php $count++;?>	
								@endforeach
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>

			</div>
		</div>
	</section>
@endsection