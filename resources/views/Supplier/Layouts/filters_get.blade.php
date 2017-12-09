
@foreach($filters as $filter)
<option disabled="disabled">{{$filter->en_name}}</option>
@foreach($filter->filter_items as $filter_item)
<?php
$selectedFilter = null;
if (!is_null($item_filters)) {
    if (\App\Http\Controllers\Supplier\ItemController::checkFilter($item_filters, $filter_item->id)):
        $selectedFilter = 'selected="selected"';
    endif;
}
?>
<option value="{{$filter_item->id}}" {!! $selectedFilter !!}>{{$filter_item->filter_en_name}}</option>
@endforeach
@endforeach