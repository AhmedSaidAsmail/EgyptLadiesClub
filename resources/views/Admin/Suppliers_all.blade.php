@extends('Admin.Layouts.Layout_Basic')
@section('title','Main Category Panel')
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Directory&Header -->
    <section class="content-header">
        <h1> Suppliers <small>All Suppliers</small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> C-Panel </a></li>
            <li><a href="#">All Suppliers</a></li>
        </ol>
    </section>
    <!-- end Directory&Header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Suppliers Data With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                    <th>#Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{$supplier->email}}</td>
                                    <td>{{$supplier->informations->f_name}} {{$supplier->informations->l_name}}</td>
                                    <td>{{$supplier->informations->company}}</td>
                                    <td>{{$supplier->informations->city}}</td>
                                    <td> {!! ($supplier->confirm)? '<i class="fa fa-circle text-green"></i>':'<i class="fa fa-circle text-gray"></i>' !!} </td>
                                    <td>{{$supplier->items()->count()}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                                            <div class="dropdown-menu list-group" >
                                                <a href="{{route('suppliers.show',['id'=>$supplier->id])}}" class="list-group-item">Preview</a>
                                                <?php $confirmed = (!$supplier->confirm) ? "Confirm" : "Unconfirmed"; ?>
                                                <a href="{{route('admin.supplier.confirm',['id'=>$supplier->id])}}" class="list-group-item">{{$confirmed}}</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                    <th>#Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- end content -->
</div>
@endsection
@section('Extra_Js')
<script src="{{asset('js/admin/admin.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
    $("#example1").DataTable();
});
</script>

@endsection
