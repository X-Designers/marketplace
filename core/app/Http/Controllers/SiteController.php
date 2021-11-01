<?php

namespace App\Http\Controllers;

use App\Category;
use App\Frontend;
use App\Language;
use App\Level;
use App\Page;
use App\Product;
use App\Rating;
use App\Sell;
use App\SubCategory;
use App\Subscriber;
use App\SupportAttachment;
use App\SupportMessage;
use App\SupportTicket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function demo(){
        $page_title = 'Demo';
        return view($this->activeTemplate . 'demo',compact('page_title'));
    }


    public function index(){

        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $data['page_title'] = 'Home';
        $data['categories'] = Category::where('status',1)->with('products')->get();

        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($this->activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->image = uploadImage($image, $path);
                    $attachment->save();

                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $categories = Category::where('status', 1)->latest()->get();
        $recentBlogs = Frontend::where('data_keys', 'blog.element')->get();
        $page_title = 'Blog Details';
        return view($this->activeTemplate.'blogDetails',compact('blog','page_title','recentBlogs','categories'));
    }

    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function blogs()
    {
        $page_title = 'Blogs';
        $blogElements = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'blogs',compact('page_title','blogElements'));
    }

    public function usernameSearch($username)
    {
        $user = User::where('status',1)->where('username',$username)->firstOrFail();
        $page_title = $user->username;
        $totalSell = Sell::where('author_id',$user->id)->where('status',1)->count();
        $totalProduct = Product::where('user_id',$user->id)->where('status',1)->count();
        $levels = Level::get();

        return view($this->activeTemplate.'author_profile',compact('page_title','user','totalSell','totalProduct','levels'));
    }

    public function productSearch(Request $request)
    {

        $page_title = 'Products for '.$request->search;
        $empty_message = 'No data Found';
        $search = $request->search;

        $products = Product::where('status', 1)->where(function($q) use ($search) {
            $q->where('name', 'LIKE',  "%$search%")->orWhereHas('category', function($category) use($search){
                $category->where('name', 'LIKE',  "%$search%");
            })->orWhereHas('subcategory', function($subcategory) use($search){
                $subcategory->where('name', 'LIKE',  "%$search%");
            })->orWhereHas('user', function($user) use($search){
                $user->where('username',$search);
            })->orwhereJsonContains('tag',$search);
        })->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['category','user','subcategory'])->latest()->paginate(getPaginate());


        $tags = $this->getTags($products->pluck('tag'));
        $categoryForSearchPage = Category::where('status',1)->latest()->get();

        $min = floor($products->min('regular_price'));
        $max = ceil($products->max('regular_price'));

        return view($this->activeTemplate.'search',compact('page_title','empty_message','products', 'tags','categoryForSearchPage','min','max'));
    }

    public function categorySearch($id)
    {
        $category = Category::where('status',1)->findOrFail($id);
        $page_title = 'Products from '.$category->name;
        $empty_message = 'No data Found';
        $products = $category->products()->where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['category','user','subcategory'])->latest()->paginate(getPaginate());

        $tags = $this->getTags($products->pluck('tag'));
        $categoryForSearchPage = Category::where('status',1)->latest()->get();

        $min = floor($products->min('regular_price'));
        $max = ceil($products->max('regular_price'));

        return view($this->activeTemplate.'search',compact('page_title','empty_message','products', 'tags','categoryForSearchPage','min','max'));
    }

    public function subcategorySearch($id)
    {
        $subcategory = SubCategory::where('status',1)->findOrFail($id);
        $page_title = 'Products from '.$subcategory->name;
        $empty_message = 'No data Found';
        $products = $subcategory->products()->where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['category','user','subcategory'])->latest()->paginate(getPaginate());

        $tags = $this->getTags($products->pluck('tag'));

        $categoryForSearchPage = Category::where('status',1)->latest()->get();

        $min = floor($products->min('regular_price'));
        $max = ceil($products->max('regular_price'));

        return view($this->activeTemplate.'search',compact('page_title','empty_message','products', 'tags', 'categoryForSearchPage','min','max'));
    }

    public function tagSearch($tag)
    {
        $page_title = 'Products from '.$tag;
        $empty_message = 'No data Found';
        $products = Product::where('status',1)->whereJsonContains('tag',$tag)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['category','user','subcategory'])->latest()->paginate(getPaginate());

        $tags = $this->getTags($products->pluck('tag'));
        $categoryForSearchPage = Category::where('status',1)->latest()->get();

        $min = floor($products->min('regular_price'));
        $max = ceil($products->max('regular_price'));

        return view($this->activeTemplate.'search',compact('page_title','empty_message','products','tags','categoryForSearchPage','min','max'));
    }

    public function productFilter(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'min'       => 'required|numeric',
            'max'       => 'required|numeric'
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $categories = $request->categories??null;
        $tags = $request->tags??null;
        $search = $request->search;

        $query =  Product::where('status', 1)->whereHas('user', function ($query) {
            $query->where('status',1);
        });

        if($search){

            $query = $query ->where(function($q) use ($search) {
                $q->where('name', 'LIKE',  "%$search%")->orWhereHas('category', function($category) use($search){
                    $category->where('name', 'LIKE',  "%$search%");
                })->orWhereHas('subcategory', function($subcategory) use($search){
                    $subcategory->where('name', 'LIKE',  "%$search%");
                })->orWhereHas('user', function($user) use($search){
                    $user->where('status',1)->where('username',$search);
                })->orwhereJsonContains('tag',$search);
            });
        }

        if($categories){
            $query = $query->whereIn('category_id', $request->categories);
        }

        if($tags){
            $query = $query->whereJsonContains('tag', $request->tags);
        }


        $products = $query->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->where('regular_price', '>=', $request->min)->where('regular_price', '<=' ,$request->max)->get();



        $empty_message = 'No product found';
        $view = view($this->activeTemplate.'filtered_search',compact('products', 'empty_message', 'tags', 'categories'))->render();
        return response()->json([
            'html' => $view
        ]);
    }

    public function getTags($tagsArray)
    {
        $tags = [];
        foreach ($tagsArray as $value) {
            $tags = array_merge($value, $tags);
        }
        $tags = array_unique($tags);

        return $tags;
    }

    public function productDetails($slug,$id)
    {
        $page_title = 'Product Details';
        $product = Product::where('status',1)->with(['category','user','ratings'])->findOrFail($id);

        $moreProducts = Product::where('user_id',$product->user_id)->where('status',1)->with(['subcategory','user','ratings'])->limit(6)->inRandomOrder()->get();
        $levels = Level::get();


        return view($this->activeTemplate.'productDetails',compact('page_title','product','moreProducts','levels'));
    }

    public function productReviews($slug,$id)
    {
        $page_title = 'Product Review';
        $product = Product::where('status',1)->with(['category','user','ratings'])->findOrFail($id);
        $moreProducts = Product::where('user_id',$product->user_id)->where('status',1)->with(['subcategory','user','ratings'])->limit(6)->inRandomOrder()->get();
        $levels = Level::get();
        $ratings = $product->ratings()->with('user')->paginate(getPaginate());


        return view($this->activeTemplate.'productReviews',compact('page_title','product','moreProducts','levels','ratings'));
    }

    public function productComments($slug,$id)
    {
        $page_title = 'Product Comments';
        $product = Product::where('status',1)->with(['category','user','ratings'])->findOrFail($id);
        $moreProducts = Product::where('user_id',$product->user_id)->where('status',1)->with(['subcategory','user','ratings'])->limit(6)->inRandomOrder()->get();

        $comments = $product->comments()->with(['replies','user','replies.user'])->paginate(getPaginate());
        $levels = Level::get();

        $purchased = Sell::where('product_id',$product->id)->where('status',1)->pluck('user_id')->toArray();

        return view($this->activeTemplate.'productComments',compact('page_title','product','moreProducts','comments','levels','purchased'));
    }

    public function featured()
    {
        $page_title = 'Featured Products';
        $products = Product::where('featured',1)->where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['subcategory','user'])->latest()->paginate(getPaginate());

        return view($this->activeTemplate.'products',compact('page_title','products'));
    }

    public function allProducts()
    {
        $page_title = 'All Products';
        $empty_message = 'No data Found';
        $products = Product::where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['subcategory','user'])->latest()->paginate(getPaginate());

        $tags = $this->getTags($products->pluck('tag'));
        $categoryForSearchPage = Category::where('status',1)->latest()->get();

        $min = floor($products->min('regular_price'));
        $max = ceil($products->max('regular_price'));

        return view($this->activeTemplate.'search',compact('page_title','empty_message','products', 'tags','categoryForSearchPage','min','max'));
    }

    public function bestSell()
    {
        $page_title = 'Best Sold Products';
        $products = Product::where('status', 1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->orderBy('total_sell', 'desc')->with(['subcategory','user'])->latest()->paginate(getPaginate());

        return view($this->activeTemplate.'products',compact('page_title','products'));
    }

    public function bestAuthor()
    {
        $page_title = 'Best Author Products';
        $products = Product::where('status', 1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->orderBy('avg_rating', 'desc')->with(['subcategory','user'])->paginate(getPaginate());

        return view($this->activeTemplate.'products',compact('page_title','products'));
    }

    public function authorProducts($username)
    {
        $user = User::where('status',1)->where('username',$username)->firstOrFail();
        $page_title = $user->username.'- Products';

        $products = Product::where('status', 1)->where('user_id',$user->id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->whereHas('category', function ($query) {
            $query->where('status',1);
        })->whereHas('subcategory', function ($query) {
            $query->where('status',1);
        })->with(['subcategory','user'])->paginate(getPaginate());

        return view($this->activeTemplate.'products',compact('page_title','products'));
    }

    public function subscriberStore(Request $request) {


        $validate = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => 'Subscribed Successfully!']);
    }

    public function policy($id, $heading) {
        $policy = Frontend::where('data_keys','policy.element')->findOrFail($id);
        $page_title = $heading;

        return view($this->activeTemplate.'policy',compact('page_title','policy'));
    }

    public function suppotDetails() {
        $policy = Frontend::where('data_keys','support.content')->first();
        $page_title = 'Support Details';

        return view($this->activeTemplate.'policy',compact('page_title','policy'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cockie accepted successfully']);
    }

}
