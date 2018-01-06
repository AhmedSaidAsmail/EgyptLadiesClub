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
        $this->validateData($request);
        $data = $request->all();
        $filter_items = collectData(['request' => $request, 'table' => 'filters_items']);
        try {
            $filter = Filter::create($data);
            $filter->filter_items()->createMany($filter_items);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('filter.index')->with('success', ' Filter has been inserted');
    }

    public function edit($id) {
        $filter = Filter::find($id);
        return view('Admin.Filter_edit', ['filter' => $filter, 'activeFilter' => true]);
    }

    public function update(Request $request, $id) {
        $this->validateData($request);
        $data = $request->all();
        $filter = Filter::find($id);
        $filter_items = collectData(['request' => $request, 'table' => 'filters_items', 'primaryKey' => 'filter_item_id']);
        try {
            $filter->update($data);
            sync($filter, 'filter_items', $filter_items);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('filter.index')->with('success', ' Filter has been updated');
    }

    private function validateData(Request $request) {
        return $this->validate($request, [
                    'sort_order' => 'required|integer',
                    'ar_name' => 'required',
                    'en_name' => 'required',
        ]);
    }

}
