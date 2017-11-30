
@foreach($filters as $filter)
<option disabled="disabled">{{$filter->en_name}}</option>
@foreach($filter->filter_items as $filter_item)
<option value="{{$filter_item->id}}">{{$filter_item->filter_en_name}}</option>
@endforeach
@endforeach