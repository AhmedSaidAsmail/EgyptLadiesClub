<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;
use App\Models\Category;
class SuppliersController extends Controller {

    public function index() {
        $suppliers = Supplier::all();
        return view('Admin.Suppliers_all', ['suppliers' => $suppliers, 'activeSuppliers' => true]);
    }

    public function show($id) {
        $supplier = Supplier::find($id);
        $categories = Category::all();
        return view('Admin.Suppliers_preview', [
            'supplier' => $supplier,
            'choosenCategories'=> $this->supplierCategoriesArray($supplier),
            'categories' => hierarchicalData($categories, 'flatten'),
            'activeSuppliers' => true]);
    }
    private function supplierCategoriesArray(Supplier $supplier){
        $return=[];
        foreach ($supplier->categories as $category){
            $return[]=$category->id;
        }
        return $return;
    }

    public function confirm($id) {
        $supplier = Supplier::find($id);
        if (!$supplier->confirm) {
            $supplier->update(['confirm' => 1]);
        }
        else {
            $supplier->update(['confirm' => 0]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $supplier = Supplier::find($id);
        $data=$request->all();
        $supplier->update($data);
        $supplier->categories()->sync($data['category_id']);
        return redirect()->back()->with('success','data has been updated');
    }

}
