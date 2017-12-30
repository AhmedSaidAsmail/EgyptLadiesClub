<div class="row">
    <div class="col-md-2" style="padding-right: 0px; padding-left: 0px;">
        <form method="get" action="{{route('category.show',[$category->en_name,$category->id])}}" id="category_filter">

            @if(count($childs))
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>Category</h3>
                    <div  class="collapse-square">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div class="filters-options">
                    @foreach($childs as $child)
                    <?php
                    if (isset($request['categories']) && in_array($child['category']->id, $request['categories'])) {
                        $check = 'checked="checked"';
                    }
                    else {
                        $check = null;
                    }
                    ?>
                    <div class="checkbox">
                        <label><input type="checkbox"  name="categories[]" value="{{$child['category']->id}}" {{$check}}>
                            {{$child['category']->en_name}} <span>({{$child['items']}})</span></label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>Brands</h3>
                    <div  class="collapse-square">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div class="filters-options">
                    @foreach($brands as $brand)
                    <?php
                    if (isset($request['brands']) && in_array($brand['brand']->id, $request['brands'])) {
                        $checkBrand = 'checked="checked"';
                    }
                    else {
                        $checkBrand = null;
                    }
                    ?>
                    <div class="checkbox">
                        <label><input type="checkbox" value="{{$brand['brand']->id}}" name="brands[]" {{$checkBrand}}>
                            {{$brand['brand']->en_name}} <span>({{$brand['items']}})</span></label>
                    </div>
                    @endforeach
                </div>
            </div>
            @foreach($filters as $filter)
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>{{$filter->en_name}}</h3>
                    <div  class="collapse-square">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div class="filters-options">
                    @foreach($filter->filter_items as $filter_item)
                    <?php
                    if (isset($request['filters']) && in_array($filter_item->id, $request['filters'])) {
                        $checkFilter = 'checked="checked"';
                    }
                    else {
                        $checkFilter = null;
                    }
                    ?>
                    <div class="checkbox">
                        <label><input type="checkbox" value="{{$filter_item->id}}" name="filters[]" {{$checkFilter}}>
                            {{$filter_item->filter_en_name}} 
                            <span>({{$filter_item->countItems($items_id)}})</span></label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
            <div class="list-filters">
                <div class="list-filter-header">
                    <h3>Price</h3>
                    <div  class="collapse-square">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div class="filters-options">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From (EGP)</label>
                                <input class="form-control min-price" value="{{$items->min('price')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>To (EGP)</label>
                                <input class="form-control max-price" value="{{$items->max('price')}}">
                            </div>
                        </div>
                    </div>
                    <div class="rangeslider">
                        <input class="min"  type="range" min="{{$items->min('price')}}" max="{{$items->max('price')}}" value="{{$items->min('price')}}" />
                        <input class="max"  type="range" min="{{$items->min('price')}}" max="{{$items->max('price')}}" value="{{$items->max('price')}}" />
                    </div>
                </div>
                <button class="btn btn-block btn-primary" style="margin-bottom: 20px;">Apply</button>
            </div>
        </form>
    </div>
    <div class="col-md-10 item-show">

        <h3>{{$category->section->en_name}} > <label>{{$category->en_name}}</label><span> ({{count($items)}} items)</span></h3>

        <div class="items-container">
            <?php $itemNo = 1; ?>
            @foreach ($items->chunk(4) as $chunk)
            <div class="row">
                @foreach($chunk as $item)
                <div class="col-md-3" data-no="{{$itemNo}}">
                    <div class="list-item-img">
                        <div class="cover">
                            <a href="" class="btn btn-primary">QUICK VIEW</a>
                        </div>
<!--                        <img class="list-label" src="images/1495467490_4g-Lte-voice-calls-en.png">-->
                        <img class="list-img" src="{{asset('images/items/thumb/'.$item['item']->img)}}">
                    </div>
                    <div class="list-item-details">
                        <h3>{{isset($item['item']->details->en_name)?$item['item']->details->en_name:$item['item']->id}}</h3>
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
                                <img src="{{asset('images/verifed.png')}}" alt="verived" class="verifed-supplier">
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
@if(isset($ajax) && $ajax)
<script>
    var form = $("form#category_filter");
    $("input[type='checkbox']").each(function () {
        $(this).click(function () {
            form.trigger('submit');
        });
    });
</script>
@endif