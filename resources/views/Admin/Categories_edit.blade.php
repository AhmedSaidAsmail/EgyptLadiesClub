@extends('Admin.Layouts.Layout_Basic')
@section('title','Category Panel | Update')
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
<style>
    .table-sheet{
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #E6E6E6;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .table-sheet td{
        border: 1px solid #E6E6E6;
        padding: 7px 10px;
    }
    .table-sheet th{
        border: 1px solid #E6E6E6;
        padding: 11px 10px;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Directory&Header -->
    <section class="content-header">
        <h1>Category <small>Category Update</small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> C-Panel</a></li>
            <li><a href="#">Update Category : {{$category->analyzeName()}}</a></li>
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
                            <button type="submit" class="form-control btn-danger" >Update Category : ({{$category->analyzeName()}})</button>
                        </div>
                        @if(Session::has('errorMsg'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-ban"></i> {{Session('errorMsg')}}
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

                    <form method="post" action="{{route('categories.update',['id'=>$category->id])}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="box-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                                <li><a href="#filters" data-toggle="tab">Filters</a></li>
                                <li><a href="#brands" data-toggle="tab">Brands</a></li>
                                <li><a href="#data" data-toggle="tab">Data</a></li>
                                <li><a href="#links" data-toggle="tab">Links</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            if ($category->parent_id !== 0) {
                                                $disabled = 'disabled="disabled"';
                                                $disabledParent = null;
                                            }
                                            else {
                                                $disabled = null;
                                                $disabledParent = 'disabled="disabled"';
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label>Section Name:</label>
                                                <select class="form-control" name="section_id" {{ $disabled }} data-link="{{route('section.brnads')}}">
                                                    <option value="">Select Section</option>
                                                    @foreach (App\Models\Section::all() as $section)
                                                    <option value="{{$section->id}}" {!!$section->id==$category->section_id?'selected="selected"':'null'!!}>{{$section->en_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Parent:</label>
                                                <select class="form-control" name="parent_id" {{$disabledParent}} data-link="{{route('category.brnads')}}">
                                                    <option value="">--- None ---</option>
                                                    @foreach (\App\Models\Category::all() as $categoryResult)
                                                    <option value="{{$categoryResult->id}}" {!!$categoryResult->id==$category->parent_id?'selected="selected"':'null'!!}>{{$categoryResult->analyzeName()}}</option>
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
                                                    <input type="text" name="en_name" value="{{$category->en_name}}" class="form-control" placeholder="Category Name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                                    <input type="text" name="ar_name" value="{{$category->ar_name}}" class="form-control" placeholder="Category Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="filters" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Filters:</label>
                                                <select class="form-control select2" name="filters[]" multiple="multiple" data-placeholder="Select a Filters" style="width: 100%;" required>
                                                    @foreach(\App\Models\Filter::all() as $filter)
                                                    <option value="{{$filter->id}}" {!! ($category->checkFilter($filter->id))?'selected="selected"':null !!}>{{$filter->en_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="brands" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Brands:</label>
                                                <select id="brandsInput" class="form-control select2" name="brnads[]" multiple="multiple" data-placeholder="Select a Brands" style="width: 100%;" required>
                                                    @foreach($category->section->brands as $brand)
                                                    <option value="{{$brand->id}}" {!! ($category->checkBrand($brand->id))?'selected="selected"':null !!}>{{$brand->en_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="data" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="1" >enabled</option>
                                                    <option value="0" {!! (! $category->status)?'selected="selected"':'' !!}>disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Home Shortcut</label>

                                                <select class="form-control" name="recommended">
                                                    <option value="1">Show</option>
                                                    <option value="0" {!! (! $category->recommended)?'selected="selected"':'' !!}>Hidden</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group {{$errors->has('arrangement')?'has-error':''}}">
                                                <label>Arrangment</label>
                                                <input  value="{{$category->arrangement}}" name="arrangement" class="form-control">
                                                @if($errors->has('arrangement'))
                                                <span class="help-block">The Arrangment has to be Integer</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{$errors->has('img')?'has-error':''}}">
                                                <label>Image</label>
                                                <input type="file" class="form-control" name="img">
                                                @if($errors->has('img'))
                                                <span class="help-block">It has to be an Image File</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Meta Title:</label>
                                                <input class="form-control" value="{{$category->title}}" name="title" placeholder="Page Title" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Keywords:</label>
                                                <input class="form-control" value="{{$category->keywords}}" name="keywords" placeholder="-- Keywords --" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Description:</label>
                                                <input class="form-control" value="{{$category->description}}" name="description" placeholder="-- Description --" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Text</label>
                                                <textarea class="form-control" name="txt">{{$category->txt}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="links" class="tab-pane fade">
                                    <table class="table-sheet">
                                        <thead>
                                            <tr>
                                                <th>Link</th>
                                                <th>Image</th>
                                                <th>Sort Order</th>
                                                <th>Header 1</th>
                                                <th>Header 2</th>
                                                <th></th>
                                            </tr>
                                            @foreach($category->category_links as $link)
                                            <tr>
                                                <td>
                                                    <div class="form-inline">
                                                        <input type="hidden" value="{{$link->id}}" name="link_id[]">
                                                        <input class="form-control" disabled="disabled" value="%paths.base%">
                                                        <input value="{{$link->link}}" class="form-control" name="link[]">   
                                                    </div>
                                                </td>
                                                <td><input type="file" class="form-control" name="link_img[]"></td>
                                                <td><input type="number" value="{{$link->link_sort_order}}" min="0" class="form-control" name="link_sort_order[]"></td>
                                                <td><input class="form-control" value="{{$link->header1}}" name="header1[]"></td>
                                                <td><input class="form-control" value="{{$link->header2}}" name="header2[]"></td>
                                                <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5"></th>
                                                <th><a href="#linkTable" id="insertRow" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <button class="btn btn-danger"><i class="fa fa-pencil-square"></i> Update {{$category->name}}</button>
                            </div>
                            <div class="form-group"> </div>
                        </div>
                    </form>

                </div>
                <div style="display: none">
                    <table id="linkTable">
                        <tr>
                            <td>
                                <div class="form-inline">
                                    <input class="form-control" disabled="disabled" value="%paths.base%"><input class="form-control" name="link[]">   
                                </div>
                            </td>
                            <td><input type="file" class="form-control" name="link_img[]"></td>
                            <td><input type="number" value="0" min="0" class="form-control" name="link_sort_order[]"></td>
                            <td><input class="form-control" name="header1[]"></td>
                            <td><input class="form-control" name="header2[]"></td>
                            <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                        </tr>
                    </table>
                </div>
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
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {
    $(".select2").select2();
});
</script>
<script>
    function getBrands(url, value) {
        $.ajax({
            type: 'get',
            url: url,
            data: {id: value},
            success: function (response) {
                $("#brandsInput").html(response);

            }
        });
    }
    $('select[name="section_id"]').change(function () {
        var inputvalue = $(this).val();
        var url = $(this).attr('data-link');
        var parentinput = $(this).closest('form').find('select[name="parent_id"]');
        if (inputvalue) {
            parentinput.prop('disabled', true);
            getBrands(url, inputvalue);
        } else {
            parentinput.prop('disabled', false);
        }
    });
    $('select[name="parent_id"]').change(function () {
        var inputvalue = $(this).val();
        var url = $(this).attr('data-link');
        var sectioninput = $(this).closest('form').find('select[name="section_id"]');
        if (inputvalue) {
            sectioninput.prop('disabled', true);
            getBrands(url, inputvalue);
        } else {
            sectioninput.prop('disabled', false);
        }
    });
    $('a#insertRow').click(function (event) {
        event.preventDefault();
        var targetTable = $(this).attr('href');
        var targetRow = $('table' + targetTable).find('tr').html();
        var destinationArea = $(this).closest('table').find('tbody');
        destinationArea.append('<tr>' + targetRow + '</tr>');
        $("a#removeRow").click(function (event) {
            event.preventDefault();
            var linkRow = $(this).closest('tr');
            linkRow.empty();
        });
    });
    $("a#removeRow").click(function (event) {
        event.preventDefault();
        var linkRow = $(this).closest('tr');
        linkRow.empty();
    });
</script>
@endsection