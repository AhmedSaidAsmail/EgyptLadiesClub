<option value="">Select Brand</option>
@foreach($brands as $brand)
<option value="{{$brand->id}}" {!! !is_null($item_id) && $brand->checkItem($item_id)?'selected="selected"':null!!}>
    {{$brand->en_name}}</option>
@endforeach
