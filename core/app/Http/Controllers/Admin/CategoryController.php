<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\CategoryDetail;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class CategoryController extends Controller
{
    public function categories()
    {
        $page_title = 'All Categories';
        $categories = Category::latest()->with('products')->paginate(getPaginate());
        $empty_message = 'No data found';
        return view('admin.category.category',compact('page_title','categories','empty_message'));
    }

    public function storeCategory(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:191',
            'buyer_fee' => 'required|numeric|min:0',
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);
        $categoryImage = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['category']['path'];
                $size = imagePath()['category']['size'];

                $categoryImage = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $category = new Category();
        $category->name = $request->name;
        $category->buyer_fee = $request->buyer_fee;
        $category->image = $categoryImage;
        $category->status = 1;
        $category->save();

        $notify[] = ['success', 'Category has been added'];
        return back()->withNotify($notify);
    }

    public function updateCategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'buyer_fee' => 'required|numeric|min:0',
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);
        $category = Category::findOrFail($id);

        $categoryImage = $category->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['category']['path'];
                $size = imagePath()['category']['size'];
                $old = $category->image;
                $categoryImage = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $category->name = $request->name;
        $category->buyer_fee = $request->buyer_fee;
        $category->image = $categoryImage;
        $category->save();

        $notify[] = ['success', 'Category has been Updated'];
        return back()->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $category = Category::findOrFail($request->id);
        $category->status = 1;
        $category->save();

        $notify[] = ['success', $category->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $category = Category::findOrFail($request->id);
        $category->status = 0;
        $category->save();

        $notify[] = ['success', $category->name . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function searchCategory(Request $request)
    {

        $search = $request->search;
        $page_title = 'Category Search - ' . $search;
        $empty_message = 'No data found';
        $categories = Category::where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.category.category', compact('page_title', 'categories', 'empty_message'));
    }

    public function subcategories($id)
    {
        $category = Category::findOrFail($id);
        $page_title = $category->name.' - Subcategories';
        $subcategories = $category->subCategories()->paginate(getPaginate());
        $empty_message = 'No data found';
        return view('admin.category.subcategory',compact('page_title','subcategories', 'category','empty_message'));
    }

    public function storeSubcategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $category = Category::findOrFail($id);

        $subcategory = new SubCategory();
        $subcategory->category_id = $category->id;
        $subcategory->name = $request->name;
        $subcategory->status = 1;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been added'];
        return back()->withNotify($notify);
    }

    public function updateSubcategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->name = $request->name;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been updated'];
        return back()->withNotify($notify);
    }

    public function subcategoryActivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = 1;
        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function subcategoryDeactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = 0;
        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function searchSubcategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $search = $request->search;
        $page_title = 'Subcategory Search - ' . $search;
        $empty_message = 'No data found';
        $subcategories = $category->subcategories->where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.category.subcategory', compact('page_title', 'subcategories', 'category', 'empty_message'));
    }

    public function categoryDetails($id)
    {
        $page_title = 'Category Details';
        $category = Category::findOrFail($id);
        $categoryDetails = $category->categoryDetails()->with('category')->latest()->paginate(getPaginate());

        $empty_message = 'No data found';
        return view('admin.category.categoryDetails',compact('page_title','categoryDetails','category','empty_message'));
    }

    public function categoryDetailsNew($id)
    {
        $page_title = 'New Category Details';
        $category = Category::findOrFail($id);
        return view('admin.category.categoryDetailsNew',compact('page_title','category'));
    }

    public function categoryDetailsStore(Request $request)
    {

        $this->validate($request, [
            'category_id' => 'required|gt:0',
            'name' => 'required|max:191',
            'type' => 'required|numeric|gt:0|max:2',
            'options.*' => 'required|max:191',
        ],[
            'options.*.required' => 'Please add all options',
            'options.*.max' => 'Total options should not be more than 191 charecters'
        ]);

        $category = Category::findOrFail($request->category_id);

        $categoryDetails = new CategoryDetail();
        $categoryDetails->category_id = $category->id;
        $categoryDetails->name = $request->name;
        $categoryDetails->type = $request->type;
        $categoryDetails->options = array_values($request->options);
        $categoryDetails->save();

        $notify[] = ['success', 'Category details has been Added'];
        return back()->withNotify($notify);
    }

    public function CategoryDetailsEdit($c_id,$c_d_id)
    {
        $category = Category::findOrFail($c_id);
        $categoryDetails = CategoryDetail::findOrFail($c_d_id);

        if ($categoryDetails->category_id != $c_id) {
            $notify[] = ['error', 'You can not edit this'];
            return back()->withNotify($notify);
        }

        $page_title = 'Edit Category Details';
        return view('admin.category.categoryDetailsEdit',compact('page_title','categoryDetails'));
    }

    public function CategoryDetailsUpdate(Request $request, $c_d_id)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'options.*' => 'required|max:191',
        ],[
            'options.*.required' => 'Please add all options',
            'options.*.max' => 'Total options should not be more than 191 charecters'
        ]);

        $categoryDetails = CategoryDetail::findOrFail($c_d_id);

        if(!$categoryDetails->options){
            $categoryDetails->options = array_values($request->options);
        }else{
            $categoryDetails->options = $request->options;
        }

        $categoryDetails->name = $request->name;
        $categoryDetails->type = $request->type;
        $categoryDetails->save();

        $notify[] = ['success', 'Category details has been Updated'];
        return back()->withNotify($notify);
    }

}

