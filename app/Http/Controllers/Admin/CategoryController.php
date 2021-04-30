<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Image;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page', 'categories');
        $categories = Category::with(['section','parentcategory'])->get();
        $categories = json_decode(json_encode($categories));
        //dd($categories);
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

    public function addEditCategory(Request $request, $id=null){
        if ($id==""){
            $title = "Añadir Categoría";
            //Add Category functionallity
            $category = new Category;
            $categorydata = array();
            $categories = array();
            $message = "Categoría añadida correctamente";
        }else {
            $title = "Editar Categoría";
            //Edit Category functionallity
            $categorydata = Category::where('id', $id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);

            /*Comprobar que vienen todos los datos en el edit*/
            //dd($categorydata);

            $categories = Category::with('subcategories')->where([
                'parent_id'  =>0,
                'section_id' => $categorydata['section_id']
            ])->get();

            $categories = json_decode(json_encode($categories), true);
            //dd($categories);

            //Ahora el Update Category
            $category = Category::find($id);
            $message = "Categoría actualizada correctamente";

        }


        if ($request->isMethod('post')){
            $data = $request->all();
            //Ver si la data viene
            //dd($data);


            /*
             * CATEGORY VALIDATIONS
             */

            $rules = [
                'category_name'          => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id'             => 'required',
                'url'                    => 'required',
                'category_image'         => 'image'
            ];
            $customMessages = [
                'category_name.required' => 'Se requiere un nombre de categoría.',
                'category_name.regex'    => 'Se requiere un nombre válido.',
                'section_id.required'    => 'La sección es requerida.',
                'url.required'           => 'La url es requerida.',
                'category_image.image'   => 'Se requiere una imágen válida.'
            ];
            $this->validate($request, $rules, $customMessages);

            //upload Category image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //Get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //generate new image
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/category_images/' . $imageName;
                    //Upload image
                    Image::make($image_tmp)->save($imagePath);
                    //Save Category Image
                    $category->category_image = $imageName;
                }
            }


            if (empty($data['category_discount'])){
                $data['category_discount']=0;
            }
            if (empty($data['description'])){
                $data['description']="";
            }
            if (empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if (empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if (empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }


            $category->parent_id         = $data['parent_id'];
            $category->section_id        = $data['section_id'];
            $category->category_name     = $data['category_name'];
            //$category->category_image    = $data['category_image'];
            $category->category_discount = $data['category_discount'];
            $category->description       = $data['description'];
            $category->url               = $data['url'];
            $category->meta_title        = $data['meta_title'];
            $category->meta_description  = $data['meta_description'];
            $category->meta_keywords     = $data['meta_keywords'];
            $category->status            = 1;
            $category->save();

            session()->flash('success_message', $message);
            return redirect('admin/categories');
        }


        //Get all sections
        $sections = Section::get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'sections', 'categorydata', 'categories'));
    }

    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()){
            $data= $request->all();
            //dd($data);
            $categories = Category::with('subcategories')->where(['section_id' => $data['section_id'], 'parent_id' => 0, 'status' => 1])->get();
            $categories = json_decode(json_encode($categories), true);
            //dd($categories);
            return view('admin.categories.append_categories_level', compact('categories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        //Get category image
        //dd($id);
        $categoryImage = Category::select("category_image")->where('id', $id)->first();

        // get category image path
        $category_image_path = 'images/category_images/';

        //delete category image drm category_images folder if exits.
        if (file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        //delete image from categories table
        Category::where('id',$id)->update(['category_image' => '']);

        session::flash('success_message', "Imagen de categoría eliminada correctamente.");
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        Category::where('id',$id)->delete();
        session::flash('success_message', "Categoría eliminada correctamente.");
        return redirect()->back();
    }
}
