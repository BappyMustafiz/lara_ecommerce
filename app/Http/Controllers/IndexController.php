<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){
    	// in ascending order (by default)
    	$all_product = Product::get();

    	// in descending order 
    	// $all_product = Product::orderBy('id','DESC')->get();
    	
    	// in random order 
    	// $all_product = Product::inRandomOrder()->get();
    	
    	//get all categories and sub categories (with relations) (recommended)
    	$categories = Category::with('categories')->where(['parent_id'=>0])->get();
    	// $categories = json_decode(json_encode($categories));
    	// echo "<pre>";print_r($categories);die();
    	

    	//get all categories and sub categories (without relations)
    	/*$categories = Category::where(['parent_id'=>0])->get();
    		$categories = json_decode(json_encode($categories));
    		echo "<pre>";print_r($categories);die();
    	
    	$categories_menu = "";
    	foreach($categories as $cat){
    		$categories_menu .='<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordian" href="#'.$cat->id.'">
						<span class="badge pull-right"><i class="fa fa-plus"></i></span>
						'.$cat->name.'
					</a>
				</h4>
			</div>
			<div id="'.$cat->id.'" class="panel-collapse collapse">
				<div class="panel-body">
					<ul>';
					$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
		    		foreach($sub_categories as $subcat){
		    			$categories_menu .='<li><a href="'.$subcat->url.'">'.$subcat->name.' </a></li>';
		    		}
					$categories_menu .='</ul>
				</div>
			</div>
			';
    	}
    	put below line where you want to show
    	<?= $categories_menu;?>
    	*/
    	
    	return view('index')->with(compact('all_product','categories_menu','categories'));
    }
}
