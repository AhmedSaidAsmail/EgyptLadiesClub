@extends ('Admin.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Brands <small><a href="">Home</a> / <a href="">Brands</a></small> </h1>
        <ul class="right-links list-inline">
            <li><button form="create_brands" class="btn btn-info"><i class="fa fa-floppy-o"></i></button></li>
            <li><a href="" class="btn btn-warning"><i class="fa fa-reply"></i></a></li>
        </ul>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session('errorMsg'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>Oops </h4>
                    ..<a href="#" id="errorDetails">Details</a>
                    <p id="ErrorMsgDetails">{{session('errorMsg')}}</p>
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
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-pencil"></i> Add Filter</h3>
                    </div>
                    <!-- /.box-header -->
                    <form method="post" id="create_brands" action="{{route('brands.update',['id'=>$brand->id])}}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label><span class="required-field">*</span>Brand Name</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                        <input type="text" value="{{$brand->ar_name}}" name="ar_name" class="form-control" placeholder="Filter Group Name" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                        <input type="text" value="{{$brand->en_name}}" name="en_name" class="form-control" placeholder="Filter Group Name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body with-border-sp">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Sort Order</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="number" min="0" name="sort_order" value="{{$brand->sort_order}}" class="form-control" required>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Image</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="file" name="img"  class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>   
                    </form>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section ('Extra_Css')

<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('Extra_Js')
<!--<script>
    $('a.form-submit').click(function (event) {
        event.preventDefault();
        var form_id = $(this).attr('data-form');
        $("form#" + form_id).trigger('submit');
    });
</script>-->
@endsection