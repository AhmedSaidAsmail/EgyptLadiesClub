@extends ('Admin.Layouts.Layout_Basic')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1> Brands <small><a href="">Home</a> / <a href="">Brands</a></small> </h1>
        <ul class="right-links list-inline">
            <li><a href="{{route('brands.create')}}" class="btn btn-info"><i class="fa fa-plus"></i></a></li>
            <li><button form="brands_delete" class="btn btn-danger"><i class="fa fa-trash"></i></button></li>
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
                        <h3 class="box-title">Brands Data With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" id="brands_delete" action="{{route('brand.destroy.selected')}}">
                            {{csrf_field()}}
                            <input type="hidden" value="DELETE" name="_method">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="brands_all"></th>
                                        <th>Brands Name</th>
                                        <th>Sort Order</th>
                                        <th>#Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $brand)
                                    <tr>
                                        <td><input type="checkbox" name="brand_id[]" class="checkbox" value="{{$brand->id}}"></td>
                                        <td>{{$brand->en_name}}</td>
                                        <td>{{$brand->sort_order}}</td>
                                        <td><a href="{{route('filter.show',['filter'=>$brand->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a></td>
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
$('input[name="brands_all"').click(function (event) {
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