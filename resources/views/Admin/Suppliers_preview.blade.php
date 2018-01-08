@extends('Admin.Layouts.Layout_Basic')
@section('title','Main Category Panel')
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Directory&Header -->
    <section class="content-header">
        <h1> Suppliers <small>{{$supplier->email}}</small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> C-Panel </a></li>
            <li><a href="#">{{$supplier->f_name}}</a></li>
        </ol>
    </section>
    <!-- end Directory&Header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>{{session('success')}}</p>
                </div>
                @endif
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Supplier Information</h3> 
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-1">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->email}}
                            </div>
                            <div class="col-md-1">
                                <label>Name:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->informations->f_name}} {{$supplier->informations->l_name}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <label>Company:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->informations->company}}
                            </div>
                            <div class="col-md-1">
                                <label>Address:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->informations->address}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <label>City:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->informations->city}}
                            </div>
                            <div class="col-md-1">
                                <label>Phone:</label>
                            </div>
                            <div class="col-md-4">
                                {{$supplier->informations->mobile}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Advanced Informations</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{route('suppliers.update',['id'=>$supplier->id])}}">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label>Supplier Categories</label>
                                <select class="form-control select2" name="category_id[]" multiple="multiple" data-placeholder="Select Categories" style="width: 100%;" required>
                                    @foreach($categories as $category)
                                    <?php $selected = (in_array($category->id, $choosenCategories)) ? ' selected="selected"' : null; ?>
                                    <option value="{{$category->id}}"{{$selected}}>{{$category->analyzeName()}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Available Items</label>
                                <input class="form-control" name="items" type="number" value="{{$supplier->items}}">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-info">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All {{$supplier->email}} Tours With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="img-td">Image</th>
                                    <th>Product Name</th>
                                    <th>Model</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplier->items()->get() as $item)
                                <tr>
                                    <td class="img-td">
                                        <img src="{{asset('images/items/thumb/'.$item->img)}}" class="img-thumbnail" style="width: 60px;"></td>
                                    <td>{!! isset($item->details)?$item->details->en_name:'----------' !!}</td>
                                    <td>{{$item->model}}</td>
                                    <td>{{$item->price}}</td>
                                    <?php $class = ($item->quantity > $item->min_quantity) ? "success" : "danger"; ?>
                                    <td><span class="btn btn-{{$class}} danger btn-sm">{{$item->quantity}}</span</td>
                                    <td>@if($item->status) <i class="fa fa-circle text-green"></i> @else <i class="fa fa-circle text-gray"></i> @endif </td>
                                    <td>
                                        <a href="{{route('suItems.edit',['id'=>$item->id])}}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th class="img-td">Image</th>
                                    <th>Product Name</th>
                                    <th>Model</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Option</th>
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
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {
    $(".select2").select2();
});
</script>
<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>

@endsection
