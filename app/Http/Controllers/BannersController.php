<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Auth;
use Session;
use App\Banner;

class BannersController extends Controller
{
    //add banner
   	public function add_banner(Request $request){
   		if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            $banner = new Banner;
            $banner->title = $data['title'];
            $banner->subtitle = $data['subtitle'];
            if(!empty($data['description'])){
                $banner->description = $data['description'];
            } else{
                $banner->description = '';
            }
            $banner->link = $data['link'];

            //upload image    
            if($request->hasFile('image')){
                //check image path
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename  = rand(111,99999).'.'.$extension;
                    $banner_path = 'images/frontend_images/banners/'.$filename;

                    // Resize images 
                    Image::make($image_tmp)->resize(484,441)->save($banner_path);

                    // store image name in product tables 
                    $banner->image = $filename;

                }

            }
            $banner->status = $status;
            $banner->save();
            return redirect()->back()->with('flash_message_success', 'Slider added successfully');
        }
   		return view('admin.banners.add_banner');
   	}

   	// view all bannnrs
   	public function view_banners(){
   		$banners = Banner::get();
   		return view('admin.banners.view_banners')->with(compact('banners'));
   	}

   	// edit banner
   	public function edit_banner(Request $request, $id = null){
   		$banner_details = Banner::where(['id'=>$id])->first();

   		// update product
        if($request->isMethod('post')){
            $data = $request->all();
            // check product enable or disable
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            // echo "<pre>";print_r($data);die();
            //upload and update image    
            if($request->hasFile('image')){
                //check image path
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename  = rand(111,99999).'.'.$extension;
                    $banner_image_path = 'images/frontend_images/banners/'.$filename;

                    // Resize images 
                    Image::make($image_tmp)->resize(484,441)->save($banner_image_path);
                }        
            } else if(!empty($data['current_image'])){
                    $filename = $data['current_image'];
            } else {
                    $filename = '';
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }
            
            Banner::where(['id'=>$id])->update(['title'=>$data['title'],'subtitle'=>$data['subtitle'],'description'=>$data['description'],'link'=>$data['link'],'image'=>$filename,'status'=>$status]);
            return redirect()->back()->with('flash_message_success','Slider updated');
        }

   		return view('admin.banners.edit_banner')->with(compact('banner_details'));
   	}

   	// delete banner image function
    public function delete_banner_image($id = null){
        // get banner image name
        $bannerImage = Banner::where(['id'=>$id])->first();

        // get image path by image name
        $banner_image_path = 'images/frontend_images/banners/';

        //delete large image if not exists in folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        //Delete image from product table
        Banner::where(['id'=>$id])->update(['image'=>'']);

        return redirect()->back()->with('flash_message_success','Slider image has been deleted');
    }

    // delete banner function
    public function delete_banner($id = null){
        Banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Slider has been deleted');
    }

}
