@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="slider"><!--slider-->
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div id="slider-carousel" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
								<li data-target="#slider-carousel" data-slide-to="1"></li>
								<li data-target="#slider-carousel" data-slide-to="2"></li>
							</ol>
							
							<div class="carousel-inner">
								<div class="item active">
									<div class="col-sm-6">
										<h1><span>E</span>-SHOPPER</h1>
										<h2>Free E-Commerce Template</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<button type="button" class="btn btn-default get">Get it now</button>
									</div>
									<div class="col-sm-6">
										<img src="{{asset('images/frontend_images/home/girl1.jpg')}}" class="girl img-responsive" alt="" />
										<img src="{{asset('images/frontend_images/home/pricing.png')}}"  class="pricing" alt="" />
									</div>
								</div>
								<div class="item">
									<div class="col-sm-6">
										<h1><span>E</span>-SHOPPER</h1>
										<h2>100% Responsive Design</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<button type="button" class="btn btn-default get">Get it now</button>
									</div>
									<div class="col-sm-6">
										<img src="{{asset('images/frontend_images/home/girl2.jpg')}}" class="girl img-responsive" alt="" />
										<img src="{{asset('images/frontend_images/home/pricing.png')}}"  class="pricing" alt="" />
									</div>
								</div>
								
								<div class="item">
									<div class="col-sm-6">
										<h1><span>E</span>-SHOPPER</h1>
										<h2>Free Ecommerce Template</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<button type="button" class="btn btn-default get">Get it now</button>
									</div>
									<div class="col-sm-6">
										<img src="{{asset('images/frontend_images/home/girl3.jpg')}}" class="girl img-responsive" alt="" />
										<img src="{{asset('images/frontend_images/home/pricing.png')}}" class="pricing" alt="" />
									</div>
								</div>
								
							</div>
							
							<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							</a>
							<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						
					</div>
				</div>
			</div>
	</section><!--/slider-->
		
	<section>
		<div class="container">
			<div class="row">
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
							<div class="product-information"><!--/product-information-->
								<img src="{{asset('images/frontend_images/product-details/new.jpg')}}" class="newarrival" alt="" />
								<h2>{{$productDetails->product_name}}</h2>
								<p>Code: {{$productDetails->product_code}}</p>

								<p>
									<select name="size" id="selSize" style="width: 150px;">
										<option value="">Select</option>
											@foreach($productDetails->attributes as $sizes)
												<option value="{{$productDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
											@endforeach
									</select>
								</p>
								<span>
									<span id="getPrice">BDT {{$productDetails->price}}</span>
									<label>Quantity:</label>
									<input type="text" value="3" />
									@if($total_stock > 0)
										<button type="button" class="btn btn-fefault cart" id="cartButton">
											<i class="fa fa-shopping-cart"></i>
											Add to cart
										</button>
									@endif
								</span>
								<p><b>Availability:</b><span id="Availability"> @if($total_stock > 0) In Stock @else Out of Stock @endif</span></p>
								<p><b>Condition:</b> New</p>
								<a href=""><img src="{{asset('images/frontend_images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
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