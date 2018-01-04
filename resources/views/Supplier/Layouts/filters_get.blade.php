
@foreach($filters as $filter)
<option disabled="disabled">{{$filter->en_name}}</option>
@foreach($filter->filter_items as $filter_item)
<option value="{{$filter_item->id}}" {!! !is_null($item_id) && $filter_item->checkItem($item_id)?'selected="selected"':null!!}>
    {{$filter_item->filter_en_name}}</option>
@endforeach
@endforeach