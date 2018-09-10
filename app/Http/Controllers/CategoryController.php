<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Session;
use App\Category;

class CategoryController extends Controller
{
    public function add_category(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$category = new Category;
    		$category->name = $data['name'];
    		$category->parent_id = $data['parent_id'];
    		$category->description = $data['description'];
    		$category->url = $data['url'];
    		$category->save();
    		return redirect('/admin/view_categories')->with('flash_message_success','Category added successfully');
    	}
    	$levels = Category::where(['parent_id'=>0])->get();
    	return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function view_categories(){
    	$categories = Category::get();
    	return view('admin.categories.view_categories')->with(compact('categories'));
    }

    public function edit_category(Request $request, $id = null){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		Category::where(['id'=>$id])->update(['name'=>$data['name'],'parent_id'=>$data['parent_id'],'description'=>$data['description'],'url'=>$data['url']]);
    		return redirect('/admin/view_categories')->with('flash_message_success','Category updated successfully');
    	}
    	$category_details = Category::where(['id'=>$id])->first();
    	$levels = Category::where(['parent_id'=>0])->get();
    	return view('admin.categories.edit_category')->with(compact('category_details','levels'));
    }

    public function delete_category($id = null){
    	if(!empty($id)){
    		Category::where(['id'=>$id])->delete();
    		return redirect()->back()->with('flash_message_success','Category deleted successfully');
    	}
    }
}
