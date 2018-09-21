<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Auth;
use Session;
use App\Product;
use App\Category;
use App\ProductsAttribute;

class ProductsController extends Controller
{
    // add product function
    public function add_product(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Product under category is missing');
            }
            // echo "</pre>";
            // print_r($data);die();
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['product_description'])){
                $product->product_description = $data['product_description'];
            } else{
                $product->product_description = '';
            }
            $product->price = $data['price'];

            //upload image    
            if($request->hasFile('image')){
                //check image path
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename  = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    // Resize images
                    Image::make($image_tmp)->save($large_image_path); 
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path); 
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // store image name in product tables 
                    $product->image = $filename;

                }

            }

            $product->save();
            return redirect('/admin/view_products')->with('flash_message_success', 'Product added successfully');
        }

        // category dropdown start    
    	$categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach($sub_categories as $sub_cat){
    			$categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
    		} 
    	}
        // category dropdown end
        
    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    // view product function
    public function view_products(){
        $products = Product::get();
        foreach($products as $key => $val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name['name'];
        }
        return view('admin.products.view_products')->with(compact('products'));
    }
    // edit and update product function
    public function edit_product(Request $request, $id = null){
        // get product details
        $product_details = Product::where(['id'=>$id])->first();
        // category dropdown start    
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach($categories as $cat){
            if ($cat->id == $product_details->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if ($sub_cat->id == $product_details->category_id){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            } 
        }
        // category dropdown end
        // update product
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die();
            //upload and update image    
            if($request->hasFile('image')){
                //check image path
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename  = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    // Resize images
                    Image::make($image_tmp)->save($large_image_path); 
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path); 
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                } else{
                    $filename = $data['current_image'];
                }

            }

            if(empty($data['product_description'])){
                $data['product_description'] = "";
            }
            if(empty($filename)){
                $filename = "";
            }

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'product_description'=>$data['product_description'],'price'=>$data['price'],'image'=>$filename]);
            return redirect()->back()->with('flash_message_success','Product updated');
        }

        return view('admin.products.edit_product')->with(compact('product_details','categories_dropdown'));
    }
    // delete product image function
    public function delete_product_image($id = null){
        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Product image has been deleted');
    }

    // delete product function
    public function delete_product($id = null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted');
    }


    // product attribute functions start
    public function add_attributes(Request $request, $id=null){
        $product_details = Product::with('attributes')->where(['id'=>$id])->first();
        // $product_details = json_decode(json_encode($product_details));
            // echo "<pre>";print_r($product_details);die();

        // add attributes
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['sku'] as $key=>$val){
                if(!empty($val)){
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();                
                }
            }
            return redirect('admin/add_attributes/'.$id)->with('flash_message_success','Product attributes added successfully');
        }    
        return view('admin.products.add_attributes')->with(compact('product_details'));
    }

    // delete attribute
    // delete product function
    public function delete_attribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted');
    }

    // products function for frontend
    public function products($url = null){

        // show 404 page if category url not matched
        $countCategory = Category::where(['url'=>$url])->count();
        // print_r($countCategory);die();
        if($countCategory==0){
            abort(404);
        }

        //get all categories and sub categories (with relations) (recommended)
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();


        $category_details = Category::where(['url'=>$url])->first();
        if($category_details->parent_id==0){
            // if url is maincategory url
            $subCategories = Category::where(['parent_id'=>$category_details->id])->get();
            foreach ($subCategories as $subcat) {
                $cat_ids[] = $subcat->id;
            }
            $all_product = Product::whereIn('category_id',$cat_ids)->get();
        } else{
            // if url is subcategory url
            $all_product = Product::where(['category_id'=>$category_details->id])->get();
        }
        
        return view('products.listing')->with(compact('category_details','all_product','categories'));
    }
}
