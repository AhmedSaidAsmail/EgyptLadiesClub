@extends('Supplier.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Products <small><a href="">Home</a> / <a href="">Products</a></small> </h1>
        <ul class="right-links list-inline">
            <li><button form="create_item" class="btn btn-info"><i class="fa fa-floppy-o"></i></button></li>
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
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-pencil"></i> Add Product</h3>
                    </div>
                    <div class="box-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                            <li><a href="#data" data-toggle="tab">Data</a></li>
                            <li><a href="#discounts" data-toggle="tab">Discounts</a></li>
                            <li><a href="#links" data-toggle="tab">Links</a></li>
                            <li><a href="#images" data-toggle="tab">Images</a></li>
                        </ul>
                        <form method="post" action="{{route('suItems.store')}}" enctype="multipart/form-data" id="create_item">
                            {{csrf_field()}}
                            <input type="hidden" name="supplier_id" value="{{Auth::guard('supplier')->user()->id}}">
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Category<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="categorie_id" data-placeholder="Select Category" data-link="{{route('item.get.filters')}}" required>
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{App\Http\Controllers\Admin\CategoriesController::analyzeCatgoryName($category->id)}}</option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Brand <span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="brand_id" data-placeholder="Select Category" required>
                                                <option value="" disabled selected>Select Brand</option>
                                                @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->en_name}}</option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Model<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <input class="form-control" name="model"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Image<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control" name="img" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Quantity<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="1" class="form-control" name="quantity" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Minimum Quantity<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="1" value="1" class="form-control" name="min_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Price<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" name="price" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Shipping<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <label class="radio-inline">
                                                <input type="radio" name="shipping" value="1" checked>Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="shipping" value="0" >No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Date Available</label>  
                                        </div>
                                        <div class="col-md-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="date_available" class="form-control pull-right" id="datepicker" required>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="data" class="tab-pane fade">
                                    <div class="row">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#english">
                                                    <img class="lang-icon" src="{{asset('images/admin/flag-eng.png')}}" alt="english"> English</a></li>
                                            <li><a data-toggle="tab" href="#arabic">
                                                    <img class="lang-icon" src="{{asset('images/admin/egypt-flag.png')}}" alt="arabic"> Arabic</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="english" class="tab-pane fade in active">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Product Name<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_name" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <textarea class="textarea" name="en_text" style="width:100%;" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Title<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_title" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Keywords<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_keywords" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_description" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="arabic" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Product Name<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_name" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <textarea class="textarea" name="ar_text" style="width:100%;" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Title<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_title" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Keywords<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_keywords" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_description" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="discounts">
                                    <table class="table-sheet">
                                        <thead>
                                            <tr>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th><a href="#discountTable" id="insertRow" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div id="links" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Filters<span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="filters_item_id[]" multiple="multiple" data-placeholder="Select a Filters" style="width: 100%;" required>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Related Products:</label>
                                                <select class="form-control select2" name="related[]" multiple="multiple" data-placeholder="Related Products" style="width: 100%;">
                                                    @foreach($items as $item)
                                                    <option value="{{$item->id}}">{{$item->details->en_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="images" class="tab-pane fade">
                                    <table class="table-sheet">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Sort Order</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- insert row here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th><a href="#imageTable" id="insertRow" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.box-header -->
                    <div style="display: none;">
                        <table id="imageTable">
                            <tr>
                                <td><input type="file" class="form-control" name="item_image[]"></td>
                                <td><input type="number" class="form-control" name="image_sort_order[]" min="0"></td>
                                <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                            </tr>
                        </table>
                        <table id="discountTable">
                            <tr>
                                <td><input type="text" class="form-control" name="dis_price[]"</td>
                                <td><input type="number" min="1" class="form-control" name="dis_quantity[]"</td>
                                <td>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_start[]" class="form-control pull-right" id="datepicker2">
                                    </div>  
                                </td>
                                <td>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_end[]" class="form-control pull-right" id="datepicker3">
                                    </div>  
                                </td>
                                <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section ('Extra_Css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/select2.min.css')}}">

<style>
    select:required:invalid {
        color: gray;
    }
    option[value=""][disabled] {
        display: none;
    }
    option {
        color: black;
    }
    .tab-content{
        padding: 10px 30px;
    }
    .tab-content .row{
        margin-top: 10px;
    }
    img.lang-icon{
        height: 19px;
        width: 24px;
    }
    .table-sheet{
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #E6E6E6;
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
@section('Extra_Js')
<script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {
    $(".select2").select2();
    $('#datepicker').datepicker({
        autoclose: true
    });

    $(".textarea").wysihtml5();

});
$(function () {
    $('select[name="categorie_id"').change(function () {
        var inputvalue = $(this).val();
        var link = $(this).attr('data-link');
        var destintionoption = $('select[name="filters_item_id[]"]');
        if (inputvalue.length) {
            $.ajax({
                type: 'get',
                url: link,
                data: {id: inputvalue},
                success: function (response) {
                    destintionoption.html(response);
                }
            });
        }
    });
    $('a#insertRow').click(function (event) {
        event.preventDefault();
        var targetTable = $(this).attr('href');
        var targetRow = $('table' + targetTable).find('tr').html();
        var destinationArea = $(this).closest('table').find('tbody');
        destinationArea.append('<tr>' + targetRow + '</tr>');
        $('#datepicker2').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            todayHighlight: true,
            weekStart: 1,
            autoclose: true
        }).on('changeDate', function (e) {
            var newDate = new Date(e.date.setMonth(e.date.getMonth()));
            $('#datepicker3').datepicker('setDate', newDate);
        });
        $('#datepicker3').datepicker({
            autoclose: true
        });
        $("a#removeRow").click(function (event) {
            event.preventDefault();
            var linkRow = $(this).closest('tr');
            linkRow.empty();
        });
    });
});
</script>
@endsection

