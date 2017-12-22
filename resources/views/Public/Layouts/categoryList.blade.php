<div class="row">
    <div class="col-md-2" style="padding-right: 0px; padding-left: 0px;">
        @if(checkChilds($category))
        <div class="list-filters">
            <div class="list-filter-header">
                <h3>Category</h3>
                <i class="fa fa-plus-square"></i>
            </div>
            @foreach($allCategories->getChilds() as $child)
            <div class="checkbox">
                <label><input type="checkbox" name="category[]" value="{{$child['category']->id}}">{{$child['category']->en_name}} <span>({{$child['items']}})</span></label>
            </div>
            @endforeach
        </div>
        @endif
        <div class="list-filters">
            <div class="list-filter-header">
                <h3>Brands</h3>
                <i class="fa fa-plus-square"></i>
            </div>
            @foreach($allCategories->getBrands() as $brand)
            <div class="checkbox">
                <label><input type="checkbox" value="{{$brand->id}}" name="brand[]">{{$brand->en_name}} <span>({{count($brand->categoryItems($allCategories->getCategories_id()))}})</span></label>
            </div>
            @endforeach
        </div>
        @foreach($allCategories->getFilters() as $filter)
        <div class="list-filters">
            <div class="list-filter-header">
                <h3>{{$filter->en_name}}</h3>
                <i class="fa fa-plus-square"></i>
            </div>
            @foreach($filter->filter_items as $filter_item)
            <div class="checkbox">
                <label><input type="checkbox" value="{{$filter_item->id}}" name="filter[]">{{$filter_item->filter_en_name}} <span>({{count($filter_item->categoryItems($allCategories->getCategories_id()))}})</span></label>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    <div class="col-md-10 item-show">

        <h3>{{$category->section->en_name}} > <label>{{$category->en_name}}</label><span> ({{count($items)}} items)</span></h3>

        <div class="items-container">
            <?php $itemNo = 1; ?>
            @foreach ($allCategories->getItems()->slice(0,8)->chunk(4) as $chunk)
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
            <div id="wating-items" data-start="{{$itemNo-1}}">
                <div class="warning-gif" style="text-align: center;">
                    <img src="{{asset('images/loader4.gif')}}" alt="please wait" style="margin-top: -50px; margin-bottom: -50px;">
                </div>
            </div>
        </div>
    </div>
</div>