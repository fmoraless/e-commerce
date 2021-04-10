<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections() {
        Session::put('page', 'sections');
        $sections = Section::get();
        return view('admin.sections.index', compact('sections'));
    }

    public function updateSectionStatus(Request $request) {
        if ($request->ajax()){
            $data = $request->all();
            //dd($data);
            if ($data['status']=="Active"){
                $status = 0;
            }else {
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'section_id' => $data['section_id']]);
        }

    }

}
