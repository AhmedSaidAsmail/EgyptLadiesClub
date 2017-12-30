<div class="row">
    <div class="col-md-2" style="padding-right: 0px; padding-left: 0px;">
        <form method="get" action="{{route('category.show',[$category->en_name,$category->id])}}" id="category_filter">

            @if(count($childs))
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>Category</h3>
                    <i class="fa fa-plus-square"></i>
                </div>
                @foreach($childs as $child)
                <?php
                if (isset($request->category) && in_array($child['category']->id, $request->category)) {
                    $check = 'checked="checked"';
                }
                else {
                    $check = null;
                }
                ?>
                <div class="checkbox">
                    <label><input type="checkbox"  name="category[]" value="{{$child['category']->id}}" {{$check}}>
                        {{$child['category']->en_name}} <span>({{$child['items']}})</span></label>
                </div>
                @endforeach
            </div>
            @endif
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>Brands</h3>
                    <i class="fa fa-plus-square"></i>
                </div>
                @foreach($brands as $brand)
                <?php
                if (isset($request->brand) && in_array($brand->id, $request->brand)) {
                    $checkBrand = 'checked="checked"';
                }
                else {
                    $checkBrand = null;
                }
                ?>
                <div class="checkbox">
                    <label><input type="checkbox" value="{{$brand->id}}" name="brand[]" {{$checkBrand}}>
                        {{$brand->en_name}} <span>({{count($brand->categoryItems($categories_id))}})</span></label>
                </div>
                @endforeach
            </div>
            @foreach($filters as $filter)
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>{{$filter->en_name}}</h3>
                    <i class="fa fa-plus-square"></i>
                </div>
                @foreach($filter->filter_items as $filter_item)
                <div class="checkbox">
                    <label><input type="checkbox" value="{{$filter_item->id}}" name="filter[]">
                        {{$filter_item->filter_en_name}} 
                        <span>({{count($filter_item->categoryItems($categories_id))}})</span></label>
                </div>
                @endforeach
            </div>
            @endforeach
        </form>
    </div>
    <div class="col-md-10 item-show">

        <h3>{{$category->section->en_name}} > <label>{{$category->en_name}}</label><span> ({{count($items)}} items)</span></h3>

        <div class="items-container">
<?php $itemNo = 1; ?>
            @foreach ($allCategories->getItems()->chunk(4) as $chunk)
            <div class="row">
                @foreach($chunk as $item)
                <div class="col-md-3" data-no="{{$itemNo}}">
                    <div class="list-item-img">
                        <div class="cover">
                            <a href="" class="btn btn-primary">QUICK VIEW</a>
                        </div>
<!--                        <img class="list-label" src="images/1495467490_4g-Lte-voice-calls-en.png">-->
                        <img class="list-img" src="{{asset('images/items/thumb/'.$item->img)}}">
                    </div>
                    <div class="list-item-details">
                        <h3>{{isset($item->details->en_name)?$item->details->en_name:null}}</h3>
                        <div class="row">
                            <div class="col-md-7">
                                <span class="price-list-active">2,099.00 <label>EGP</label></span>
                                <span class="price-list-deleted">2,099.00 EGP</span>
                            </div>
                            <div class="col-md-5 text-right">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <span class="fa-stack">
                                    <i class="fa fa-star-half fa-stack-1x"></i>
                                    <i class="fa fa-star fa-stack-1x"></i>
                                </span>
                                <i class="fa fa-star fa-empty"></i> 
                            </div>
                        </div>
                        <div class="row list-second-row">
                            <div class="col-md-7">
                                <span class="free-shipping">FREE Shipping</span>
                            </div>
                            <div class="col-md-5 text-right">
                                <img src="images/verifed.png" alt="verived" class="verifed-supplier">
                            </div>
                        </div>
                    </div>
                    <a href="" class="list-add-to-cart btn btn-success">add to cart</a>
                </div>
<?php $itemNo++; ?>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>
</div>
@section('scripts')
<script>
    $(function () {
        var form = $("form#category_filter");
        $("input[name='category[]']").each(function () {
            $(this).click(function () {
                form.trigger('submit');
            });
        });
        form.submit(function (event) {
            event.preventDefault();
            var url = $(this).attr('action');
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + form.serialize();
            window.history.pushState({path: newurl}, '', newurl);
        });
    }());
</script>
@endsection