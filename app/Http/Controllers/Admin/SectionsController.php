<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Section;

class SectionsController extends Controller {

    protected $_path = "/images/sections/";

    public function index() {
        $sections = Section::all();
        return view('Admin.Sections_all', ['sections' => $sections, 'activeSections' => true]);
    }

    public function store(Request $request) {
        $this->validatedData($request);
        $item = $request->all();
        $item['img'] = uploadImage(['image' => $item['img'], 'path' => $this->_path]);
        try {
            $section = Section::create($item);
            $section->brands()->sync($item['brands']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('sections.index')->with('success', $request->en_name . ' has been inserted');
    }

    public function edit($id) {
        $section = Section::find($id);
        $sections = Section::all();
        return view('Admin.Sections_edit', ['sections' => $sections, 'section' => $section, 'activeSections' => true]);
    }

    public function update(Request $request, $id) {
        $this->validatedData($request);
        $item = $request->all();
        $section = Section::find($id);
        if (isset($item['img'])) {
            $item['img'] = uploadImage(['image' => $item['img'], 'path' => $this->_path, 'exImage' => $section->img]);
        }

        try {
            $section->update($item);
            $section->brands()->sync($item['brands']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('sections.index')->with('success', 'Section has been updated');
    } 
    private function validatedData(Request $request) {
        return $this->validate($request, [
                    'en_name' => 'required',
                    'ar_name' => 'required',
                    'title' => 'required',
                    'arrangement' => 'required|integer',
                    'img' => 'image'
        ]);
    }

}
