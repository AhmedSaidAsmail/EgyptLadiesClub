<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;

class SuppliersController extends Controller {

    public function index() {
        $suppliers = Supplier::all();
        return view('Admin.Suppliers_all', ['suppliers' => $suppliers,'activeSuppliers'=>true]);
    }
    public function show($id) {
        $supplier = Supplier::find($id);
        return view('Admin.Suppliers_preview', ['supplier' => $supplier,'activeSuppliers'=>true]);
    }

    public function update(Request $request, $id) {
        $supplier = Supplier::find($id);
        if (isset($request->cancel_confirm)) {
            $supplier->update(['confirm' => 0]);
            return redirect()->back();
        }
        $supplier->update(['confirm' => 1]);
        return redirect()->back();
    }

}
