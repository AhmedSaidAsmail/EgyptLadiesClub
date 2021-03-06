@extends('Supplier.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Products <small><a href="">Home</a> / <a href="">Products</a></small> </h1>
        <ul class="right-links list-inline">
            <li><button form="create_item" id="create_item_done" class="btn btn-info"><i class="fa fa-floppy-o"></i></button></li>
            <li><a href="" class="btn btn-warning"><i class="fa fa-reply"></i></a></li>
        </ul>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="row reviews-summary-container">
                    <h2>Customers Reviews <span>({{$item->reviews->count()}} Reviews)</span></h2>
                    <div class="row reviews-summary">
                        <div class="col-md-12">
                            <span class="reviews-summary-title">Overall rating</span>
                            <div class="overall-rating">
                                {{\App\Http\ReviewsCalc::getRateStar($item)}}
                                {{\App\Http\ReviewsCalc::calc($item)}} / 5
                            </div>
                            <span class="reviews-summary-based">based on {{$item->reviews()->where('confirm','=',1)->count()}} reviews</span>
                        </div>

                    </div>
                    <div style="margin-top:10px;">

                        <a href="{{route('suItems.show',['item'=>$item->id])}}" class="btn btn-default"><i class="fa fa-comment"></i> See all activity reviews</a>   
                    </div>
                </div>
            </div>
        </div>
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
                        <form method="post" action="{{route('suItems.update',['id'=>$item->id])}}" enctype="multipart/form-data" id="create_item">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="supplier_id" value="{{Auth::guard('supplier')->user()->id}}">
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Category<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="category_id" data-item="{{$item->id}}" data-placeholder="Select Category" data-link="{{route('item.get.filters')}}" required>
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach($categories as $category)
                                                <?php $categorySelected = ($category->id == $item->category_id) ? 'selected="selected"' : null; ?>
                                                <option value="{{$category->id}}" {{$categorySelected}}>
                                                    {{$category->analyzeName()}}
                                                </option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Brand <span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="brand_id" data-link="{{route('item.get.brands')}}" data-placeholder="Select Category" required>
                                                <option value="" disabled selected>Select Brand</option>
                                                @foreach($item->category->brands as $brand)
                                                <option value="{{$brand->id}}" {!! $brand->checkItem($item->id)?'selected="selected"':null!!}>
                                                    {{$brand->en_name}}</option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Model<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <input class="form-control" value="{{$item->model}}" name="model"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Image<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control" name="img" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Quantity<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="1" class="form-control" value="{{$item->quantity}}" name="quantity" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Minimum Quantity<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="1" value="1" class="form-control" value="{{$item->min_quantity}}" name="min_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Price<span class="text-danger">*</span></label>  
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" name="price" value="{{$item->price}}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Shipping<span class="text-danger">*</span></label>  
                                        </div>
                                        <?php
                                        if ($item->shipping) {
                                            $trueShipping = "checked";
                                            $falseShiiping = null;
                                        }
                                        else {
                                            $trueShipping = null;
                                            $falseShiiping = "checked";
                                        }
                                        ?>
                                        <div class="col-md-4">
                                            <label class="radio-inline">
                                                <input type="radio" name="shipping" value="1" {{$trueShipping}}>Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="shipping" value="0" {{$falseShiiping}}>No
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
                                                <input type="text" name="date_available" value="{{$item->date_available}}" class="form-control pull-right" id="datepicker" required>
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
                                                        <input class="form-control" value="{{$item->details->en_name}}" name="en_name" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10" id="textarea">
                                                        <textarea class="textarea"  name="en_text" style="width:100%;" required>
                                                            {{$item->details->en_text}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Title<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_title" value="{{$item->details->en_title}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Keywords<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_keywords" value="{{$item->details->en_keywords}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="en_description" value="{{$item->details->en_description}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="arabic" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Product Name<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_name" value="{{$item->details->ar_name}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10" id="textarea">
                                                        <textarea class="textarea" name="ar_text" style="width:100%;" required>
                                                            {{$item->details->ar_text}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Title<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_title" value="{{$item->details->ar_title}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Keywords<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_keywords" value="{{$item->details->ar_keywords}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"><label>Meta Description<span class="text-danger">*</span></label></div>
                                                    <div class="col-md-10">
                                                        <input class="form-control" name="ar_description" value="{{$item->details->ar_description}}" required>
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
                                            @foreach($item->discounts as $discount)
                                            <tr>
                                        <input type="hidden" value="{{$discount->id}}" name="discount_id[]">
                                        <td><input type="text" class="form-control dis_price" name="dis_price[]" value="{{$discount->dis_price}}"></td>
                                        <td><input type="number" min="1" class="form-control dis_quantity" name="dis_quantity[]" value="{{$discount->dis_quantity}}"></td>
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="date_start[]" value="{{$discount->date_start}}" class="form-control pull-right date_start" id="datepicker2">
                                            </div>  
                                        </td>
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="date_end[]" value="{{$discount->date_end}}" class="form-control pull-right date_end" id="datepicker3">
                                            </div>  
                                        </td>
                                        <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                                        </tr>
                                        @endforeach
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
                                                <select class="form-control select2" name="filters_item_id[]" data-link="{{route('item.get.filters')}}" multiple="multiple" data-placeholder="Select a Filters" style="width: 100%;" required>
                                                    @foreach($item->category->filters as $filter)
                                                    <option disabled="disabled">{{$filter->en_name}}</option>
                                                    @foreach($filter->filter_items as $filter_item)
                                                    <option value="{{$filter_item->id}}"  {!! $filter_item->checkItem($item->id)?'selected="selected"':null!!}>
                                                        {{$filter_item->filter_en_name}}</option>
                                                    @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Related Products:</label>
                                                <select class="form-control select2" name="related[]" multiple="multiple" data-placeholder="Related Products" style="width: 100%;">
                                                    @foreach($items as $related)
                                                    @if(isset($item->details))
                                                    <option value="{{$item->id}}">{{$item->details->en_name}}</option>
                                                    @endif
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
                                            <?php $image_index = 1; ?>
                                            @foreach($item->images as $item_image)
                                            <tr data-index="{{$image_index}}">
                                                <td>
                                                    <img src="{{asset('images/items/thumb/'.$item_image->item_image)}}"  class="img-thumbnail" style="width: 60px;">
                                                </td>
                                                <td><input type="number" name="image_sort_order[{{$image_index}}]" min="0" value="{{$item_image->image_sort_order}}" class="form-control"></td>
                                                <td>
                                                    <input type="hidden" value="{{$item_image->id}}" name="image_id[{{$image_index}}]">
                                                    <a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a> 
                                                </td>
                                            </tr>
                                            <?php $image_index++; ?>
                                            @endforeach
                                            <!-- insert row here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th><a href="#" id="insertRowImage" class="btn btn-primary btn-sm second-insert"><i class="fa fa-plus"></i></a></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.box-header -->

                    <div style="display: none;">
                        <a href="#" id="remove_wysihtml5">remove</a>
                        <table id="imageTable">
                            <tr>
                                <td><input type="file" class="form-control item_image" name="item_image[]"></td>
                                <td><input type="number" class="form-control image_sort_order" name="image_sort_order[]" min="0"></td>
                                <td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>
                            </tr>
                        </table>
                        <table id="discountTable">
                            <tr>
                                <td><input type="text" class="form-control dis_price" name="dis_price[]"></td>
                                <td><input type="number" min="1" class="form-control dis_quantity" name="dis_quantity[]"></td>
                                <td>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_start[]" class="form-control pull-right date_start" id="datepicker2">
                                    </div>  
                                </td>
                                <td>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_end[]" class="form-control pull-right date_end" id="datepicker3">
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

    $(".textarea").wysihtml5({
        "html": true
    });

});
$(function () {
    function getElements(inputvalue, destintionoption, item_id) {
        var link = destintionoption.attr('data-link');
        $.ajax({
            type: 'get',
            url: link,
            data: {id: inputvalue, item_id: item_id},
            success: function (response) {
                destintionoption.html(response);
            }
        });
    }
    $('select[name="category_id"').change(function () {
        var inputvalue = $(this).val();
        var item_id = $(this).attr('data-item');
        var destintionFilters = $('select[name="filters_item_id[]"]');
        var destintionBrands = $('select[name="brand_id"]');
        if (inputvalue.length) {
            getElements(inputvalue, destintionFilters, item_id);
            getElements(inputvalue, destintionBrands, item_id);
        }
    });
    $('a#insertRow').click(function (event) {
        event.preventDefault();
        var targetTable = $(this).attr('href');
        var targetRow = $('table' + targetTable).find('tr').html();
        var destinationArea = $(this).closest('table').find('tbody');
        var index = parseInt(destinationArea.find('tr:last').attr('data-index')) + 1;
        alert(index);
        destinationArea.append('<tr data-index="' + index + '">' + targetRow + '</tr>');
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
    $("a#insertRowImage").click(function (event) {
        event.preventDefault();
        var destinationArea = $(this).closest('table').find('tbody');
        var index = parseInt(destinationArea.find('tr:last').attr('data-index')) + 1;
        destinationArea.append('<tr data-index="' + index + '">\n\
<td><input type="file" class="form-control item_image" name="item_image[' + index + ']"></td>\n\
<td><input type="number" class="form-control image_sort_order" name="image_sort_order[' + index + ']" min="0"></td>\n\
<td><a href="#" id="removeRow" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td>\n\
</tr>');
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
    $("a#remove_wysihtml5").click(function (event) {
        event.preventDefault();

        $("div#textarea").each(function () {
            var input = $(this).find('textarea');
            var inputName = input.attr('name');
            if (input.hasClass('textarea')) {
                $(this).empty();
                $(this).append('<textarea class="form-control" name="' + inputName + '"></textarea>');
            }

        });
    });
});
document.getElementById("en_text").innerHTML = "Some text to enter";
</script>
@endsection

