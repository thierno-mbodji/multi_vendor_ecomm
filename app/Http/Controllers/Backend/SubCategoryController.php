<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    public function AllSubCategory(){

        $subcategories = SubCategory::latest()->get(); // je recuperes les categories ds ma BDD
        return view('backend.subcategory.subcategory_all',compact('subcategories')); // je retourne avec la liste des categories sur une page web creeé
    }


    public function AddSubCategory(){

        $categories = Category::orderBy('category_name','ASC')->get();
      return view('backend.subcategory.subcategory_add',compact('categories'));

    }// End Method


    public function StoreSubCategory(Request $request){

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
        ]);

       $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    }// End Method

    public function EditSubCategory($id){

        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.subcategory.subcategory_edit',compact('categories','subcategory'));

      }// End Method



      public function UpdateSubCategory(Request $request){

          $subcat_id = $request->id;

           SubCategory::findOrFail($subcat_id)->update([
              'category_id' => $request->category_id,
              'subcategory_name' => $request->subcategory_name,
              'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
          ]);

         $notification = array(
              'message' => 'SubCategory Updated Successfully',
              'alert-type' => 'success'
          );

          return redirect()->route('all.subcategory')->with($notification);


      }// End Method


      public function DeleteSubCategory($id){

          SubCategory::findOrFail($id)->delete();

           $notification = array(
              'message' => 'SubCategory Deleted Successfully',
              'alert-type' => 'success'
          );

          return redirect()->back()->with($notification);


      }// End Method

      public function GetSubCategory($category_id){

        $subCat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();

        // on retourne un json car dans le javascript on attends un json

        return json_encode($subCat);

      }// End Method
}
