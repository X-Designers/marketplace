<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Level;
use App\Product;
use App\Reply;
use App\Rules\FileTypeValidate;
use App\SubCategory;
use App\TempProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function allProduct()
    {
        $page_title = 'All Products';
        $empty_message = 'No data found';
        $products = Product::where('status', '!=', 4)->where('user_id',auth()->user()->id)->with(['category','subcategory'])->latest()->paginate(getPaginate());

        return view($this->activeTemplate.'user.product.index',compact('page_title','empty_message','products'));
    }

    public function newProduct()
    {
        $page_title = 'New Product';
        $categories = Category::where('status','1')->with(['subcategories'=>function($q){
            $q->where('status',1)->get();
        },'categoryDetails'])->latest()->get();

        return view($this->activeTemplate.'user.product.new',compact('page_title','categories'));
    }

    public function storeProduct(Request $request)
    {

        $validation_rule = [
            'category_id' => 'required|numeric|gt:0',
            'sub_category_id' => 'required|numeric|gt:0',
            'regular_price' => 'required|numeric|gt:0',
            'extended_price' => 'required|numeric|gt:0',
            'support' => 'required|integer|max:1',
            'support_discount' => 'sometimes|required|numeric|max:100',
            'support_charge' => 'sometimes|required|numeric|max:100',
            'name' => 'required|max:191',
            'image' => ['required','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'file' => ['required','mimes:zip', new FileTypeValidate(['zip'])],
            'screenshot' => 'required|array|min:3',
            'screenshot.*' => ['required','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'demo_link' => 'required|url|max:255',
            'message' => 'nullable|max:255',
            'tag.*' => 'required|max:255',
        ];


        $category = Category::where('status',1)->findOrFail($request->category_id);

        $subcategory = SubCategory::where('status',1)->findOrFail($request->sub_category_id);

        $subcategoryId = SubCategory::where('category_id',$request->category_id)->where('status',1)->pluck('id')->toArray();

        if (!in_array($subcategory->id,$subcategoryId)) {
            $notify[] = ['error', 'Something goes wrong'];
            return back()->withNotify($notify);
        }

        $categoryDetails = $category->categoryDetails;
        $categoryDetailsInput = $request['c_details'];

        $minPrice = $category->buyer_fee + (($category->buyer_fee * auth()->user()->levell->product_charge)/100);

        if (($request->regular_price < $minPrice) || ($request->extended_price < $minPrice)) {
            $notify[] = ['error', 'Minimum price is '.$minPrice];
            return back()->withNotify($notify);
        }

        if (count($categoryDetailsInput) != count($categoryDetails)) {
            $notify[] = ['error', 'Something goes wrong. Please contact with developer'];
            return back()->withNotify($notify);
        }

        foreach ($categoryDetails->pluck('name') as $item) {
            $validation_rule['c_details.'.str_replace(' ','_',strtolower($item))] = 'required';
        }

        $request->validate($validation_rule, [
            'tag.*.required' => 'Add at least one tag',
            'tag.*.max' => 'Total options should not be more than 191 charecters'
        ]);


        $pImage = '';
        if($request->hasFile('image')) {
            try{
                $location = imagePath()['p_image']['path'];
                $size = imagePath()['p_image']['size'];
                $thumb = imagePath()['p_image']['thumb'];
                $pImage = uploadImage($request->image, $location , $size, '', $thumb);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the image'];
                return back()->withNotify($notify);
            }
        }

        $pFile = '';
        if ($request->hasFile('file')){
            try{
                $location = imagePath()['p_file']['path'];
                $pFile = str_replace(' ','_',strtolower($request->name)).'_'.uniqid().time().'.zip';
                $request->file->move($location, $pFile);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the file'];
                return back()->withNotify($notify);
            }
        }

        $pScreenshot = [];
        if ($request->hasFile('screenshot')){
            foreach ($request->screenshot as $item) {
                try{
                    $location = imagePath()['p_screenshot']['path'];
                    $pScreenshot[] = uploadImage($item, $location);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the image'];
                    return back()->withNotify($notify);
                }
            }
        }

        $product = new Product();
        $product->user_id = auth()->user()->id;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->regular_price = $request->regular_price + $category->buyer_fee;
        $product->extended_price = $request->extended_price + $category->buyer_fee;
        $product->support = $request->support;
        $product->support_charge = $request->support_charge ?? 0;
        $product->support_discount = $request->support_discount ?? 0;
        $product->name = $request->name;
        $product->image = $pImage;
        $product->file = $pFile;
        $product->screenshot = array_values($pScreenshot);
        $product->demo_link = $request->demo_link;
        $product->description = $request->description;
        $product->tag = array_values($request->tag);
        $product->message = $request->message;
        $product->category_details = $categoryDetailsInput;
        $product->save();

        $notify[] = ['success', 'Product successfully submitted'];
        return redirect()->route('user.product.all')->withNotify($notify);
    }

    public function editProduct($id)
    {
        $page_title = 'Edit Product';
        $product = Product::findOrFail(Crypt::decrypt($id));

        if ($product->user_id != auth()->user()->id) {
            $notify[] = ['error', 'Yor are not authorized to edit this product'];
            return back()->withNotify($notify);
        }


        return view($this->activeTemplate.'user.product.edit',compact('page_title','product'));
    }

    public function updateProduct(Request $request,$id)
    {
        $validation_rule = [
            'regular_price' => 'required|numeric|gt:0',
            'extended_price' => 'required|numeric|gt:0',
            'support' => 'required|integer|max:1',
            'support_discount' => 'sometimes|required|numeric|max:100',
            'support_charge' => 'sometimes|required|numeric|max:100',
            'name' => 'required|max:191',
            'image' => ['nullable','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'file' => ['nullable','mimes:zip', new FileTypeValidate(['zip'])],
            'screenshot' => 'nullable|array|min:3',
            'screenshot.*' => ['nullable','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'demo_link' => 'required|url|max:255',
            'message' => 'nullable|max:255',
            'tag.*' => 'required|max:255',
        ];


        $product = Product::findOrFail(Crypt::decrypt($id));

        if ($product->status != 1) {
            $notify[] = ['error', 'This product is not upgradable'];
            return back()->withNotify($notify);
        }

        if ($product->user_id != auth()->user()->id) {
            $notify[] = ['error', 'You are not authorized to edit this product'];
            return back()->withNotify($notify);
        }


        $checkProduct = TempProduct::where('user_id',auth()->user()->id)->where('product_id',$id)->where('type',2)->first();

        if($checkProduct){
            $notify[] = ['error', 'Previous update of this product is pending'];
            return back()->withNotify($notify);
        }

        if($checkProduct == null){

            $category = Category::findOrFail($product->category_id);
            $categoryDetails = $category->categoryDetails;
            $categoryDetailsInput = $request['c_details'];

            $minPrice = $category->buyer_fee + (($category->buyer_fee * auth()->user()->levell->product_charge)/100);

            if (($request->regular_price < $minPrice) || ($request->extended_price < $minPrice)) {
                $notify[] = ['error', 'Minimum price is '.$minPrice];
                return back()->withNotify($notify);
            }

            if (count($categoryDetailsInput) != count($categoryDetails)) {
                $notify[] = ['error', 'Something goes wrong. Please contact with developer'];
                return back()->withNotify($notify);
            }

            foreach ($categoryDetails->pluck('name') as $item) {
                $validation_rule['c_details.'.str_replace(' ','_',strtolower($item))] = 'required';
            }

            $request->validate($validation_rule, [
                'tag.*.required' => 'Add at least one tag',
                'tag.*.max' => 'Total options should not be more than 191 charecters'
            ]);


            $pImage = '';
            if($request->hasFile('image')) {
                try{
                    $location = imagePath()['temp_p_image']['path'];
                    $size = imagePath()['temp_p_image']['size'];
                    $thumb = imagePath()['temp_p_image']['thumb'];
                    $pImage = uploadImage($request->image, $location , $size , '', $thumb);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the image'];
                    return back()->withNotify($notify);
                }
            }

            $pFile = '';
            if ($request->hasFile('file')){
                try{
                    $location = imagePath()['temp_p_file']['path'];
                    $pFile = str_replace(' ','_',strtolower($request->name)).'_'.uniqid().time().'.zip';
                    $request->file->move($location, $pFile);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the file'];
                    return back()->withNotify($notify);
                }
            }

            $pScreenshot = [];
            if ($request->hasFile('screenshot')){
                foreach ($request->screenshot as $item) {
                    try{
                        $location = imagePath()['temp_p_screenshot']['path'];
                        $pScreenshot[] = uploadImage($item, $location);

                    }catch(\Exception $exp) {
                        $notify[] = ['error', 'Could not upload the image'];
                        return back()->withNotify($notify);
                    }
                }
            }

            $product->update_status = 1;
            $product->save();

            $tempProduct = new TempProduct();
            $tempProduct->user_id = auth()->user()->id;
            $tempProduct->product_id = $product->id;
            $tempProduct->category_id = $product->category_id;
            $tempProduct->sub_category_id = $product->sub_category_id;
            $tempProduct->regular_price = $request->regular_price + $product->category->buyer_fee;
            $tempProduct->extended_price = $request->extended_price + $product->category->buyer_fee;
            $tempProduct->support = $request->support;
            $tempProduct->support_charge = $request->support_charge ?? 0;
            $tempProduct->support_discount = $request->support_discount ?? 0;
            $tempProduct->name = $request->name;
            $tempProduct->image = $pImage;
            $tempProduct->file = $pFile;
            $tempProduct->screenshot = $pScreenshot;
            $tempProduct->demo_link = $request->demo_link;
            $tempProduct->description = $request->description;

            $tempProduct->tag = array_values($request->tag);

            $tempProduct->message = $request->message;
            $tempProduct->category_details = $categoryDetailsInput;
            $tempProduct->type = 2;
            $tempProduct->save();

            $notify[] = ['success', 'You action is on process. Wait for the approval'];
            return redirect()->route('user.product.all')->withNotify($notify);
        }

    }

    public function resubmitProduct($id)
    {
        $page_title = 'Resubmit Product';
        $product = Product::where('status',2)->findOrFail(Crypt::decrypt($id));

        if ($product->user_id != auth()->user()->id) {
            $notify[] = ['error', 'Yor are not authorized to resubmit this product'];
            return back()->withNotify($notify);
        }

        return view($this->activeTemplate.'user.product.resubmit',compact('page_title','product'));
    }

    public function resubmitProductStore(Request $request,$id)
    {
        $validation_rule = [
            'regular_price' => 'required|numeric|gt:0',
            'extended_price' => 'required|numeric|gt:0',
            'support' => 'required|integer|max:1',
            'support_discount' => 'sometimes|required|numeric|max:100',
            'support_charge' => 'sometimes|required|numeric|max:100',
            'name' => 'required|max:191',
            'image' => ['nullable','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'file' => ['nullable','mimes:zip', new FileTypeValidate(['zip'])],
            'screenshot' => 'nullable|array|min:3',
            'screenshot.*' => ['nullable','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'demo_link' => 'required|url|max:255',
            'message' => 'nullable|max:255',
            'tag.*' => 'required|max:255',
        ];

        $product = Product::findOrFail(Crypt::decrypt($id));

        if ($product->status != 2) {
            $notify[] = ['error', 'This product is not resubmittable'];
            return back()->withNotify($notify);
        }

        if ($product->user_id != auth()->user()->id) {
            $notify[] = ['error', 'You are not authorized to resubmit this product'];
            return back()->withNotify($notify);
        }

        $checkProduct = TempProduct::where('user_id',auth()->user()->id)->where('product_id',$id)->where('type',1)->first();

        if($checkProduct){
            $notify[] = ['error', 'Previous resubmission of this product is pending'];
            return back()->withNotify($notify);
        }

        if($checkProduct == null){

            $category = Category::findOrFail($product->category_id);
            $categoryDetails = $category->categoryDetails;
            $categoryDetailsInput = $request['c_details'];

            $minPrice = $category->buyer_fee + (($category->buyer_fee * auth()->user()->levell->product_charge)/100);

            if (($request->regular_price < $minPrice) || ($request->extended_price < $minPrice)) {
                $notify[] = ['error', 'Minimum price is '.$minPrice];
                return back()->withNotify($notify);
            }

            if (count($categoryDetailsInput) != count($categoryDetails)) {
                $notify[] = ['error', 'Something goes wrong. Please contact with developer'];
                return back()->withNotify($notify);
            }

            foreach ($categoryDetails->pluck('name') as $item) {
                $validation_rule['c_details.'.str_replace(' ','_',strtolower($item))] = 'required';
            }

            $request->validate($validation_rule, [
                'tag.*.required' => 'Add at least one tag',
                'tag.*.max' => 'Total options should not be more than 191 charecters'
            ]);


            $pImage = '';
            if($request->hasFile('image')) {
                try{
                    $location = imagePath()['temp_p_image']['path'];
                    $size = imagePath()['temp_p_image']['size'];
                    $thumb = imagePath()['temp_p_image']['thumb'];
                    $pImage = uploadImage($request->image, $location , $size , '', $thumb);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the image'];
                    return back()->withNotify($notify);
                }
            }

            $pFile = '';
            if ($request->hasFile('file')){
                try{
                    $location = imagePath()['temp_p_file']['path'];
                    $pFile = str_replace(' ','_',strtolower($request->name)).'_'.uniqid().time().'.zip';
                    $request->file->move($location, $pFile);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the file'];
                    return back()->withNotify($notify);
                }
            }

            $pScreenshot = [];
            if ($request->hasFile('screenshot')){
                foreach ($request->screenshot as $item) {
                    try{
                        $location = imagePath()['temp_p_screenshot']['path'];
                        $pScreenshot[] = uploadImage($item, $location);

                    }catch(\Exception $exp) {
                        $notify[] = ['error', 'Could not upload the image'];
                        return back()->withNotify($notify);
                    }
                }
            }

            $product->status = 5;
            $product->save();

            $tempProduct = new TempProduct();
            $tempProduct->user_id = auth()->user()->id;
            $tempProduct->product_id = $product->id;
            $tempProduct->category_id = $product->category_id;
            $tempProduct->sub_category_id = $product->sub_category_id;
            $tempProduct->regular_price = $request->regular_price + $product->category->buyer_fee;
            $tempProduct->extended_price = $request->extended_price + $product->category->buyer_fee;
            $tempProduct->support = $request->support;
            $tempProduct->support_charge = $request->support_charge ?? 0;
            $tempProduct->support_discount = $request->support_discount ?? 0;
            $tempProduct->name = $request->name;
            $tempProduct->image = $pImage;
            $tempProduct->file = $pFile;
            $tempProduct->screenshot = $pScreenshot;
            $tempProduct->demo_link = $request->demo_link;
            $tempProduct->description = $request->description;

            $tempProduct->tag = array_values($request->tag);

            $tempProduct->message = $request->message;
            $tempProduct->category_details = $categoryDetailsInput;
            $tempProduct->type = 1;
            $tempProduct->save();

            $notify[] = ['success', 'You action is on process. Wait for the approval'];
            return redirect()->route('user.product.all')->withNotify($notify);
        }

    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail(Crypt::decrypt($request->product_id));

        $product->status = 4;
        $product->save();

        $notify[] = ['success', 'Product successfuly deleted'];
        return back()->withNotify($notify);
    }

    public function commentStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'comment' => 'required'
        ]);

        $product = Product::where('status',1)->findOrFail(Crypt::decrypt($request->product_id));

        $comment = new Comment();
        $comment->product_id = $product->id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        $notify[] = ['success', 'Your comment added successfuly'];
        return back()->withNotify($notify);
    }

    public function replyStore(Request $request)
    {
        $request->validate([
            'comment_id' => 'required',
            'reply' => 'required'
        ]);

        $comment = Comment::findOrFail(Crypt::decrypt($request->comment_id));

        $reply = new Reply();
        $reply->comment_id = $comment->id;
        $reply->user_id = auth()->user()->id;
        $reply->reply = $request->reply;
        $reply->save();

        $notify[] = ['success', 'Your reply added successfuly'];
        return back()->withNotify($notify);
    }

}
