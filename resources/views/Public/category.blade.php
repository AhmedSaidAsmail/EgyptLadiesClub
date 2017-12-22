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
@include('Public.Layouts.categoryList')
@endsection

