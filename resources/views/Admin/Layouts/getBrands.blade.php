
@foreach($brands as $brand)
<option value="{{$brand->id}}">{{$brand->en_name}}</option>
@endforeach