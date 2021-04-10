<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page', 'categories');
        $categories = Category::get();
        return view('admin.categories.index', compact('categories'));
    }

    public function updateCategoryStatus(Request $request) {
        if ($request->ajax()){
            $data = $request->all();
            //dd($data);
            if ($data['status']=="Active"){
                $status = 0;
            }else {
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }

    }
}
