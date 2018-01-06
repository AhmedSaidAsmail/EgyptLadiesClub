@extends ('Admin.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Filters <small><a href="">Home</a> / <a href="">Filters</a></small> </h1>
        <ul class="right-links list-inline">
            <li><a href="{{route('filter.create')}}" class="btn btn-info" id="add_new"><i class="fa fa-plus"></i></a></li>
            <li><button form="filters_delete" class="btn btn-danger"><i class="fa fa-trash"></i></button></li>
        </ul>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session('errorMsg'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>Oops </h4>
                    <p>{{session('errorMsg')}}</p>
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <p>{{session('success')}}</p>
                </div>
                @endif
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filters Data With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" id="filters_delete" action="{{route('filter.destroy.selected')}}">
                            {{csrf_field()}}
                            <input type="hidden" value="DELETE" name="_method">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="filter_all"></th>
                                        <th>Filters Group</th>
                                        <th>Sort Order</th>
                                        <th>#Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filters as $filter)
                                    <tr>
                                        <td><input type="checkbox" name="filter_id[]" class="checkbox" value="{{$filter->id}}"></td>
                                        <td>{{$filter->en_name}}</td>
                                        <td>{{$filter->sort_order}}</td>
                                        <td><a href="{{route('filter.edit',['filter'=>$filter->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Filters Group</th>
                                        <th>Sort Order</th>
                                        <th>#Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section ('Extra_Css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/admin/style.css')}}">
@endsection
@section('Extra_Js')
<script src="{{asset('js/admin/admin.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
    $("#example1").DataTable();
});
$('input[name="filter_all"').click(function (event) {
    if (this.checked) {
        $(':checkbox').each(function () {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function () {
            this.checked = false;
        });
    }

});
</script>
@endsection