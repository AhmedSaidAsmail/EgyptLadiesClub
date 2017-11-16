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
        <h1> Sections <small><a href="">Home</a> / <a href="">Sections</a></small> </h1>
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
                            <button type="submit" class="form-control btn btn-default" id="addNew"><i class="fa fa-globe"></i> Add New Section</button>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <i class="icon fa fa-ban"></i> {{session('success')}}
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Oops!! </h4>
                            {{session('error')}}
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
                        <form method="post" action="{{route('sections.store')}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section Name:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                                <input type="text" name="en_name" class="form-control" placeholder="Section Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section Name:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                                <input type="text" name="ar_name" class="form-control" placeholder="Section Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1">Show</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Top 10 List</label>
                                            <select class="form-control" name="top_list">
                                                <option value="1">True</option>
                                                <option value="0">False</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>List Arrangement</label>
                                            <input  value="0" name="arrangement"  class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="img" required>
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
                                <div class="form-group"> <button class="btn btn-success"><i class="fa fa-globe"></i> Add new section</button></div>
                                <div class="form-group"> </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end box 1 -->
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sections Data With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Top List</th>
                                    <th>#Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <td>{{$section->en_name}}</td>
                                    <td>{{$section->title}}</td>
                                    <td> {!! ($section->status)? '<i class="fa fa-circle text-green"></i>':'<i class="fa fa-circle text-gray"></i>' !!} </td>
                                    <td> {!! ($section->top_list)? '<i class="fa fa-circle text-green"></i>':'<i class="fa fa-circle text-gray"></i>' !!} </td>
                                    <td><div class="btn-group">
                                            <button type="button" class="btn btn-default">Action</button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                                            <div class="dropdown-menu list-group" >
                                                <a href="{{route('sections.edit',['id'=>$section->id])}}" class="list-group-item">Change</a>
                                                <form action="{{route('sections.destroy',['id'=>$section->id])}}" method="post">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="deleteItem list-group-item" title="{{$section->name}}">Delete</a>
                                                </form>
                                            </div>
                                        </div></td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Section</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Top List</th>
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