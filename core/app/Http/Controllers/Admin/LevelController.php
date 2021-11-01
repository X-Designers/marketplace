<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Level;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function levels()
    {
        $page_title = 'All levels';
        $levels = Level::paginate(getPaginate());
        $empty_message = 'No data found';
        return view('admin.level',compact('page_title','levels','empty_message'));
    }

    public function storeLevel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:90',
            'earning' => 'required|numeric',
            'product_charge' => 'required|numeric',
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);

        $levelImage = '';
        if($request->hasFile('image')) {

            try{
                $location = imagePath()['level']['path'];
                $size = imagePath()['level']['size'];

                $levelImage = uploadImage($request->image, $location , $size);
            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $level = new Level();
        $level->name = $request->name;
        $level->image = $levelImage;
        $level->earning = $request->earning;
        $level->product_charge = $request->product_charge;
        $level->save();

        $notify[] = ['success', 'Level details has been added'];
        return back()->withNotify($notify);
    }

    public function updateLevel(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:90',
            'earning' => 'required|numeric',
            'product_charge' => 'required|numeric',
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        $level = Level::findOrFail($id);

        $levelImage = $level->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['level']['path'];
                $size = imagePath()['level']['size'];
                $old = $level->image;
                $levelImage = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $level->name = $request->name;
        $level->image = $levelImage;
        if ($level->default_status == 0) {
            $level->earning = $request->earning;
        }
        $level->product_charge = $request->product_charge;
        $level->save();

        $notify[] = ['success', 'Level details has been updated'];
        return back()->withNotify($notify);
    }

    public function searchLevel(Request $request)
    {
        $search = $request->search;
        $page_title = 'Level Search - ' . $search;
        $empty_message = 'No data found';
        $levels = Level::where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.level', compact('page_title', 'levels', 'empty_message'));
    }
}
