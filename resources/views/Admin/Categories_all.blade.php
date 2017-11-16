@extends('Admin.Layouts.Layout_Basic')
@section('title','Main Category Panel')
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Directory&Header -->
    <section class="content-header">
        <h1> Cities <small>Cities tables</small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> C-Panel</a></li>
            <li><a href="#">Cities</a></li>
        </ol>
    </section>
    <!-- end Directory&Header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- box -->
                <div class="box">
                    <div class="box-header with-border">
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-danger" id="addNew">
                                <i class="fa fa-database"></i> Add New Category</button>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-ban"></i> {{session('success')}}
                        </div>
                        @endif
                        @if(Session::has('errorMsg'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> {{Session('errorMsg')}} </h4>
                            ..<a href="#" id="errorDetails">Details</a>
                            {!! (Session::has('errorDetails'))?'<p id="ErrorMsgDetails">'.Session('errorDetails').'</p>':'' !!}
                        </div>
                        @elseif(count($errors)>0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div id="basicToggle">
                        <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section Name:</label>
                                            <select class="form-control" name="section_id" >
                                                <option value="">Select Section</option>
                                                @foreach (App\Models\Section::all() as $section)
                                                <option value="{{$section->id}}">{{$section->en_name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Parent:</label>
                                            <select class="form-control" name="parent_id" >
                                                <option value="">--- None ---</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($category->id)}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category Name:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                                <input type="text" name="en_name" class="form-control" placeholder="Category Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category Name:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                                <input type="text" name="ar_name" class="form-control" placeholder="Category Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Filters:</label>
                                            <select class="form-control select2" name="filters[]" multiple="multiple" data-placeholder="Select a Filters" style="width: 100%;">
                                                @foreach($filters as $filter)
                                                <option value="{{$filter->id}}">{{$filter->en_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1">Show</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Recommended</label>
                                            <select class="form-control" name="recommended">
                                                <option value="1">Confirm</option>
                                                <option value="0">Pause</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Arrangement</label>
                                            <input  value="0" name="arrangement"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="img">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Meta Title:</label>
                                            <input class="form-control" name="title" placeholder="Page Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <input class="form-control" name="keywords" placeholder="-- Keywords --" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <input class="form-control" name="description" placeholder="-- Description --" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Text</label>
                                            <textarea class="form-control" name="txt"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <button class="btn btn-danger"><i class="fa fa-location-arrow"></i> Add new city</button>
                                </div>
                                <div class="form-group"> </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end box 1 -->
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categories Data With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Recommended</th>
                                    <th>#Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->section->en_name}}</td>
                                    <td>{{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($category->id)}}</td>
                                    <td>{{$category->title}}</td>
                                    <td> @if($category->status) <i class="fa fa-circle text-green"></i> @else <i class="fa fa-circle text-gray"></i> @endif </td>
                                    <td> @if($category->recommended) <i class="fa fa-circle text-green"></i> @else <i class="fa fa-circle text-gray"></i> @endif </td>
                                    <td>
                                        <a  href="{{route('categories.edit',['id'=>$category->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Section</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Recommended</th>
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
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {
    $(".select2").select2();
    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });
});
</script>
<script>
    $('select[name="section_id"]').change(function () {
        var inputvalue = $(this).val();
        var parentinput = $(this).closest('form').find('select[name="parent_id"]');
        if (inputvalue) {
            parentinput.prop('disabled', true);
        } else {
            parentinput.prop('disabled', false);
        }
    });
    $('select[name="parent_id"]').change(function () {
        var inputvalue = $(this).val();
        var sectioninput = $(this).closest('form').find('select[name="section_id"]');
        if (inputvalue) {
            sectioninput.prop('disabled', true);
        } else {
            sectioninput.prop('disabled', false);
        }
    });
</script>
@endsection