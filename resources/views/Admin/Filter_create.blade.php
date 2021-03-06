@extends ('Admin.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Filters <small><a href="">Home</a> / <a href="">Filters</a></small> </h1>
        <ul class="right-links list-inline">
            <li><button form="create_filter" class="btn btn-info"><i class="fa fa-floppy-o"></i></button></li>
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
                    <form method="post" id="create_filter" action="{{route('filter.store')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label><span class="required-field">*</span>Filter Group Name</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                        <input type="text" name="ar_name" class="form-control" placeholder="Filter Group Name" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                        <input type="text" name="en_name" class="form-control" placeholder="Filter Group Name" required>
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
                                        <input type="number" min="0" name="sort_order" value="0" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table-bordered-sp">
                                        <thead>
                                        <th>Filter Name*</th>
                                        <th>Sort Order</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td><a href="#" class="btn btn-info btn-sm" id="add-row"><i class="fa fa-plus"></i></a></td>
                                            </tr>  
                                        </tfoot>                                        
                                    </table>
                                </div>

                            </div>
                        </div>   
                    </form>
                    <table id="table_containt" style="display:none;">

                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/egypt-flag.png')}}"></span>
                                        <input type="text" name="filter_ar_name[]" class="form-control" placeholder="Filter Group Name" required>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/admin/flag-eng.png')}}"></span>
                                        <input type="text" name="filter_en_name[]" class="form-control" placeholder="Filter Group Name" required>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" min="0" name="filter_sort_order[]" value="0" class="form-control">
                                </td>
                                <td><a class="btn btn-danger btn-sm" id="remove-row"><i class="fa fa-minus"></i></a></td>
                            </tr>
                        </tbody>

                    </table>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section ('Extra_Css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
<style>
    .table-bordered-sp{
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #E6E6E6;
    }
    .table-bordered-sp th,.table-bordered-sp td{
        border: 1px solid #E6E6E6;
        padding: 5px 10px;
    }
</style>
@endsection
@section('Extra_Js')
<script>
    $(function () {
        $('a#add-row').click(function (event) {
            event.preventDefault();
            var tbody = $(this).closest('table').find('tbody');
            var insert = $('#table_containt').find('tr').html();
            tbody.append('<tr>' + insert + '</tr>');
            $('a#remove-row').click(function (event) {
                var row = $(this).closest('tr');
                row.empty();
            });

        });

    });
</script>
                            <!--<script>
                            $('a.form-submit').click(function (event) {
                                event.preventDefault();
                                var form_id = $(this).attr('data-form');
                                $("form#" + form_id).trigger('submit');
                            });
                            </script>-->
@endsection