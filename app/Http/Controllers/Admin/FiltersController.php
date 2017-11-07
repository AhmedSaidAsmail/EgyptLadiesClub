<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Models\Filter;

class FiltersController extends Controller {

    public function index() {
        $data = Filter::all();
        return view('Admin.Filter_all', ['activeFilter' => true, 'filters' => $data]);
    }

    public function create() {
        return view('Admin.Filter_create', ['activeFilter' => true]);
    }

    public function store(Request $request) {
        $this->itValidate($request);
        $data = $request->all();
        try {
            Filter::create($data);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('filter.index')->with('success', ' Filter has been inserted');
    }

    public function destroy($id) {
        $filter = Filter::find($id);
        try {
            $filter->delete();
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
    }

    public function destroySelected(Request $request) {
        $rows = $request->filter_id;
        if(count($rows)<=0){
            return redirect()->back()->with('errorMsg','No Filters selected');
        }
        foreach ($rows as $row) {
             $this->destroy($row);
        }
        return redirect()->route('filter.index')->with('success', ' Filters has been deleted');
    }

    private function itValidate(Request $request) {
        return $this->validate($request, [
                    'sort_order' => 'required|integer',
                    'ar_name' => 'required',
                    'en_name' => 'required',
        ]);
    }

}
