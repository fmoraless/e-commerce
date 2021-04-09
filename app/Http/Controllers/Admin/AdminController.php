<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Image;
use function PHPUnit\Framework\isReadable;


class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];
            $customMessages = [
                'email.required' => 'Se requiere un correo.',
                'email.email' => 'Ingrese un correo válido.',
                'password.required' => 'Se requiere un password.'
            ];
            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'Correo o Password incorrectos');
                return redirect()->back();
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function settings()
    {
        Session::put('page', 'settings');
        //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        //$admin = Auth::guard('admin')->user();
        //dd($admin);
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkCurrentPassword(Request $request)
    {
        $data = $request->all();
        //echo "<pre>"; print_r($data);
        //echo "<pre>"; print_r(Auth::guard('admin')->user()->password); die;
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }

    }
    public function updateCurrentPassword(Request $request)
    {
       if ($request->isMethod('post')){
           $data = $request->all();
           //dd($data);
           //echo "<pre>"; print_r($data); die;
           //Chequea si el password actual es correcto
           if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
               //Chequea si new password y confirmar pass coinciden
               if ($data['new_pwd'] == $data['confirm_pwd']){
                   Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                   Session::flash('success_message','La contraseña ha sido actualizada');
               }else{
                   Session::flash('error_message', 'Nueva contraseña y confirmación no coinciden');
               }
           }else{
               Session::flash('error_message', 'Tu contraseña actual es incorrecta');
           }
           return redirect()->back();
       }
    }

    public function updateAdminDetails(Request $request) {
        Session::put('page', 'update-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $rules = [
                'admin_name'   => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image'  => 'image',
            ];
            $customMessages = [
                'admin_name.required'   => 'Nombre de usuario es requerido.',
                'admin_name.alpha'      => 'Ingrese un nombre válido.',
                'admin_mobile.required' => 'Celular es requerido.',
                'admin_mobile.numeric'  => 'Ingrese un celular válido.',
                'admin_image.image'     => 'Ingrese un archivo de imágen válido.',

            ];
            $this->validate($request, $rules, $customMessages);

            //upload image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //generate new image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_img/admin_photos/'.$imageName;
                    //Upload image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{
                    $imageName = "";
                }
            }
            //dd($data);
            //update admin details  - ** Error video 15 "Undefined variable: imageName"  /***

            Admin::where('email', Auth::guard('admin')->user()->email)
                ->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            session::flash('success_message', 'Detalles de administrador actualizados satisfactoriamente');
            return redirect()->back();

        }
        return view('admin.update_admin_details');
    }
}


