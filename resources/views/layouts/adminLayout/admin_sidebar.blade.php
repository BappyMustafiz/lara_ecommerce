<?php $url = url()->current();?>
<!--sidebar-menu-->
<div id="sidebar"><a href="{{url('/admin/dashboard')}}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if(preg_match("/dashboard/i", $url)):?> class="active" <?php endif;?>>
      <a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> 
        <span>Dashboard</span>
      </a> 
    </li>
    <!--category menu-->
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/categor/i", $url)):?> style="display: block;" <?php endif;?>>
        <li <?php if(preg_match("/add_category/i", $url)):?> class="active" <?php endif;?> ><a href="{{url('/admin/add_category')}}">Add Category</a></li>
        <li <?php if(preg_match("/view_categories/i", $url)):?> class="active" <?php endif;?> ><a href="{{url('/admin/view_categories')}}">View Categories</a></li>
      </ul>
    </li>
    <!--products menu-->
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/product/i", $url)):?> style="display: block;" <?php endif;?>>
        <li <?php if(preg_match("/add_product/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/add_product')}}">Add Product</a></li>
        <li <?php if(preg_match("/view_products/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/view_products')}}">View Products</a></li>
      </ul>
    </li>
    <!-- coupons -->
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/coupon/i", $url)):?> style="display: block;" <?php endif;?>>
        <li <?php if(preg_match("/add_coupon/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/add_coupon')}}">Add Coupon</a></li>
        <li <?php if(preg_match("/view_coupons/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/view_coupons')}}">View Coupons</a></li>
      </ul>
    </li>
    <!-- banners -->
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Sliders</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/banner/i", $url)):?> style="display: block;" <?php endif;?>>
        <li <?php if(preg_match("/add_banner/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/add_banner')}}">Add slider</a></li>
        <li <?php if(preg_match("/view_banners/i", $url)):?> class="active" <?php endif;?>><a href="{{url('/admin/view_banners')}}">View sliders</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->