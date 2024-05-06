<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function store(Request $request){
        $category = Category::create([
            'name'=>$request->name,
            'ar_name'=>$request->ar_name,
            'image'=> ImageHelper::saveImage($request->image,'images/categories')
        ]);
        if($category){
            toastr()->success('Add Category','Success');
            return redirect()->back();
        }
        else{
            toastr()->error('Category Not Added','Opps!');
            return redirect()->back();
        }
    }
    public function index(){
        $categories = Category::all();
        return view('admin.category.index',)->with('categories',$categories);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category = $category->delete();
        if ($category) {
            toastr()->info('Category Delete', 'Success');
            return redirect()->back();
        } else {
            toastr()->error('Category Not Delete', 'Oops!');
        }
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit')->with('category', $category);
    }
    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $categories =  $category->update([
            'name' => $request->name,
            'ar_name' => $request->ar_name,
            'image' => ImageHelper::saveImage($request->image, 'Images/categories'),
        ]);
        if ($categories) {
            toastr()->success('Update Succussfully', 'Congrats');
            return redirect()->route('category.index');
        } else {
            toastr()->error('Category Not Update', 'Oops!');
            return redirect()->route('category.index');

        }
    }

}
