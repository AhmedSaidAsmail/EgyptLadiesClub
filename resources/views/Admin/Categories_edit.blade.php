@extends('Admin.Layouts.Layout_Basic')
@section('title','Category Panel | Update')
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Directory&Header -->
    <section class="content-header">
        <h1>Category <small>Category Update</small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> C-Panel</a></li>
            <li><a href="#">Update Category : {{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($category->id)}}</a></li>
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
                            <button type="submit" class="form-control btn-danger" >Update Category : ({{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($category->id)}})</button>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Name:</label>
                                        <select class="form-control" name="section_id" required>
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
                                        <select class="form-control" name="parent_id" required>
                                            <option value="0">--- None ---</option>
                                            @foreach (\App\Models\Categorie::all() as $categoryResult)
                                            <option value="{{$categoryResult->id}}" {!!$categoryResult->id==$category->parent_id?'selected="selected"':'null'!!}>{{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($categoryResult->id)}}</option>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Filters:</label>
                                        <select class="form-control select2" name="filters[]" multiple="multiple" data-placeholder="Select a Filters" style="width: 100%;" required>
                                            @foreach(\App\Models\Filter::all() as $filter)
                                            <?php $selected = null; ?>
                                            @if(\App\Http\Controllers\Admin\CategoriesController::checkFilterExists($category,$filter->id))
                                            <?php $selected = 'selected="selected"'; ?>
                                            @endif
                                            <option value="{{$filter->id}}" {{$selected}}>{{$filter->en_name}}</option>
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
                            <div class="form-group"> 
                                <button class="btn btn-danger"><i class="fa fa-pencil-square"></i> Update {{$category->name}}</button>
                            </div>
                            <div class="form-group"> </div>
                        </div>
                    </form>

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
@endsection