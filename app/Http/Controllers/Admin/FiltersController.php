<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Models\Filter;
use App\Models\Filters_item;

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
            $filter=Filter::create($data);
            $data['filter_id']=$filter->id;
            $this->storeFiltersItems($data);
        } catch (Exception $ex) {
            return redirect()->back()->with('errorMsg', $ex->getMessage());
        }
        return redirect()->route('filter.index')->with('success', ' Filter has been inserted');
    }
    private function storeFiltersItems(array $data){
        if(!empty($data['filter_en_name'])){
            for($i=0;$i<count($data['filter_en_name']);$i++){
                $item=new Filters_item;
                $item->filter_id=$data['filter_id'];
                $item->filter_en_name=$data['filter_en_name'][$i];
                $item->filter_ar_name=$data['filter_ar_name'][$i];
                $item->filter_sort_order=$data['filter_sort_order'][$i];
                $item->save();
            }
        }
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
        if (count($rows) <= 0) {
            return redirect()->back()->with('errorMsg', 'No Filters selected');
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
