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
use App\ProductsImage;

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
            if(!empty($data['care'])){
                $product->care = $data['care'];
            } else{
                $product->care = '';
            }
            $product->price = $data['price'];

            //upload image    
            if($request->hasFile('image')){
                //check image path
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename  = rand(111,99999).'.'.$extension;
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
                    $filename  = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    // Resize images
                    Image::make($image_tmp)->save($large_image_path); 
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path); 
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                }        
            } else if(!empty($data['current_image'])){
                    $filename = $data['current_image'];
            } else {
                    $filename = '';
            }

            if(empty($data['product_description'])){
                $data['product_description'] = "";
            }
            if(empty($data['care'])){
                $data['care'] = "";
            }
            
            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'product_description'=>$data['product_description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$filename]);
            return redirect()->back()->with('flash_message_success','Product updated');
        }

        return view('admin.products.edit_product')->with(compact('product_details','categories_dropdown'));
    }
    // delete product image function
    public function delete_product_image($id = null){
        // get product image name
        $productImage = Product::where(['id'=>$id])->first();

        // get image path by image name
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //delete large image if not exists in folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //delete medium image if not exists in folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        //delete small image if not exists in folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        //Delete image from product table
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
                    //check sku for preventing to add same
                    $attCountSku = ProductsAttribute::where('sku',$val)->count();
                    if($attCountSku>0){
                        return redirect('admin/add_attributes/'.$id)->with('flash_message_error','"'.$val.'" SKU already exists! Please add another');
                    }

                    //check size for preventing to add same
                    $attCountSizes = ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if($attCountSizes>0){
                        return redirect('admin/add_attributes/'.$id)->with('flash_message_error','"'.$data['size'][$key].'" size already exists! Please add another');
                    }

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

    // product edit attribute functions start
    public function edit_attributes(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die();
            foreach ($data['idAttr'] as $key =>$attr) {
                ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['sku'=>$data['sku'][$key],'size'=>$data['size'][$key],'price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success','Product attributes has been updated');
        }
    }
    // delete attribute
    public function delete_attribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted');
    }

    // product alternate images functions start
    public function add_alternate_images(Request $request, $id=null){
        $product_details = Product::with('attributes')->where(['id'=>$id])->first();

        // add attributes
        if($request->isMethod('post')){
            // add alternate images
            $data = $request->all();
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach($files as $file){
                    // Upload images after resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(500,300)->save($small_image_path);
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            return redirect('admin/add_alternate_images/'.$id)->with('flash_message_success','Product alternate image added successfully');
        }
        //show alternate images
        $productsImages = ProductsImage::where(['product_id'=>$id])->get();    
        return view('admin.products.add_alternate_images')->with(compact('product_details','productsImages'));
    }

    // delete attribute
    public function delete_alternate_image($id = null){
        // get product image name
        $productImage = ProductsImage::where(['id'=>$id])->first();

        // get image path by image name
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //delete large image if not exists in folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //delete medium image if not exists in folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        //delete small image if not exists in folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        //Delete image from product table
        ProductsImage::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success','Product alternate image has been deleted');
    }

    // products function for frontend
    public function products($url = null){

        // show 404 page if category url not matched
        $countCategory = Category::where(['url'=>$url,'status'=>1])->count();
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
        
        return view('front_products.listing')->with(compact('category_details','all_product','categories'));
    }

    // single product details function for frontend
    public function product($id = null){
        //details for particular id with attributes
        $productDetails = Product::with('attributes')->where('id',$id)->first();

        //get all categories and sub categories (with relations) (recommended)
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        // get product alternate images
        $productAltImages = ProductsImage::where('product_id',$id)->get();
        // $productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>";print_r($productAltImages);die();
        
        // get all stocked product
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

        // get related product
        $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
        // $relatedProducts = json_decode(json_encode($relatedProducts));
        // echo "<pre>";print_r($relatedProducts);die();
        /*foreach($relatedProducts->chunk(3) as $chunk){
            foreach($chunk as $item){
                echo $item; echo "<br>";
            }
            echo "<be><br><br>";
        }*/

        return view('front_products.product_details')->with(compact('productDetails','categories','productAltImages','total_stock','relatedProducts'));
    }

    // ajax function for get product price on change size
    public function getProductPrice(Request $request){
        $data = $request->all();
        // echo "<pre>";print_r($data);die();
        $proArr = explode("-", $data['idSize']);
        // echo $proArr[0]; echo $proArr[1];die();
        $proAttr = ProductsAttribute::where(['product_id'=>$proArr[0], 'size'=>$proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
        
    }
}
