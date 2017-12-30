@extends('Public.Layouts.master')
@section('container')
<div class="row all-sctions">
    <div class="col-md-12" style="padding-left: 0px;">
        <ul class="list-inline">
            @foreach(\App\Models\Section::all() as $section)
            <?php
            $class = ($section->id == $category->section->id) ? "btn-primary" : "btn-default";
            ?>
            <li><a href="{{route('section.show',['$section->en_name',$section->id])}}" class="btn {{$class}}">{{$section->en_name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="loading-result">
    <img src="{{asset('images/loading.gif')}}" alt="loading">
</div>
<div class="category-result">
    @include('Public.Layouts.categoryList') 
</div>

@endsection
@section('scripts')
<script>
    $(function () {
        var form = $("form#category_filter");
        $("input[type='checkbox']").each(function () {
            $(this).click(function () {
                form.trigger('submit');
            });
        });
        function ajaxCall(url, data, result_div) {
            var loading = $('.loading-result');
            loading.show();
            $.ajax({
                type: 'get',
                url: url,
                data: data,
                success: function (response) {
                    loading.fadeOut();
                    result_div.html(response);
                }
            });
        }
        form.submit(function (event) {
            event.preventDefault();
            var result_div = $('.category-result');
            var url = $(this).attr('action');
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + form.serialize();
            window.history.pushState({path: newurl}, '', newurl);
            ajaxCall(url, form.serialize(), result_div);

        });
    }());
    (function () {

        function addSeperator(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

        function rangeInputChangeEventHandler(e) {
            var rangeGroup = $(this).attr('name'),
                    minBtn = $(this).parent().children('.min'),
                    maxBtn = $(this).parent().children('.max'),
                    range_min = $('input.min-price'),
                    range_max = $('input.max-price'),
                    minVal = parseInt($(minBtn).val()),
                    maxVal = parseInt($(maxBtn).val()),
                    origin = $(this).context.className;

            if (origin === 'min' && minVal > maxVal - 1) {
                $(minBtn).val(maxVal - 1);
            }
            var minVal = parseInt($(minBtn).val());
            $(range_min).val(minVal);


            if (origin === 'max' && maxVal - 1 < minVal) {
                $(maxBtn).val(1 + minVal);
            }
            var maxVal = parseInt($(maxBtn).val());
            $(range_max).val(maxVal);
        }

        $('input[type="range"]').on('input', rangeInputChangeEventHandler);
    })();


    $('.collapse-square').click(function () {
        var filters_options = $(this).closest('.list-filters').find('.filters-options');
        if (filters_options.height() > 0) {
            filters_options.addClass('collapse-hidden');
            $(this).empty().html('<i class="fa fa-plus"></i>');
        } else {
            filters_options.removeClass('collapse-hidden');
            $(this).empty().html('<i class="fa fa-minus"></i>');
        }

    });




</script>
@endsection
