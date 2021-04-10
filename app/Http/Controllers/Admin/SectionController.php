<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class SectionController extends Controller
{
    public function sections() {
        $sections = Section::get();
        return view('admin.sections.index', compact('sections'));
    }
}
