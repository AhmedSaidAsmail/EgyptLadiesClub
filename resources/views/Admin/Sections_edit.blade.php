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
                            <button type="submit" class="form-control btn btn-default" id="addNew">
                                <i class="fa fa-info-circle"></i> {{$section->en_name}} Data</button>
                        </div>
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
                    <form method="post" action="{{route('sections.update',['id'=>$section->id])}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Name:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                            <input type="text" value="{{$section->en_name}}" name="en_name" class="form-control" placeholder="Section Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Name:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                            <input type="text" value="{{$section->ar_name}}" name="ar_name" class="form-control" placeholder="Section Name" required>
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
                                            <option value="0"{!! !$section->status?' selected="sslected"':null !!}>Hidden</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Top 10 List</label>
                                        <select class="form-control" name="top_list">
                                            <option value="1">True</option>
                                            <option value="0"{!! !$section->top_list?' selected="sslected"':null !!}>False</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input value="{{$section->arrangement}}" name="arrangement"  class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Symbol</label>
                                        <input type="text" value="{{$section->symbol}}" class="form-control" name="symbol" list="symbols" />
                                        <datalist id="symbols">
                                            @foreach($sections->pluck('symbol')->toArray() as $symbol)
                                            <option value="{{$symbol}}">{{$symbol}}</option>
                                            @endforeach
                                        </datalist> 
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Brands:</label>
                                        <select class="form-control select2" name="brands[]" multiple="multiple" data-placeholder="Select Brands" style="width: 100%;">
                                            @foreach(\App\Models\Brand::all() as $brand)
                                            <option value="{{$brand->id}}" {!! $section->checkBrand($brand->id)?'selected="selected"':null !!}>{{$brand->en_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Meta Title:</label>
                                        <input class="form-control" value="{{$section->title}}" name="title" placeholder="Page Title" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input class="form-control" value="{{$section->keywords}}" name="keywords" placeholder="-- Keywords --" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <input class="form-control" value="{{$section->description}}" name="description" placeholder="-- Description --" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"> <button class="btn btn-success"><i class="fa fa-pencil"></i> Update {{$section->en_name}}</button></div>
                            <div class="form-group"> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end content -->
</div>
@endsection
@section('Extra_Js')
<script src="{{asset('js/admin/admin.js')}}"></script>
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {
    $(".select2").select2();
});
</script>
@endsection