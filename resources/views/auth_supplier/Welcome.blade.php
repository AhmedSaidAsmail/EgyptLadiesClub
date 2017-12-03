@extends('auth_supplier.Layouts.master')
@section('container')
<div class="row supplier-body-holder">
    <div class="col-md-6 supplier-body-bg">
    </div>
    <div class="col-md-6">
        <span class="supplier-title-intro">
            <label>Want to Sell Your Items</label>
            on <label>Egypt Ladies Club</label>
            and <label>Start selling</label>
        </span>
        <span class="supplier-intro-help">
            Start selling where millions of customers are shopping every day.
            You’re just a few steps away from becoming a seller on Egypt Ladies Club
        </span>

        <a href="{{route('supplier.reigister')}}" id="reigister" class="btn btn-success btn-lg">Register for free</a>
        <span class="or">or</span>
        <a href="{{route('supplier.login')}}" class="supplier-intro-login">Login</a>
        <span class="take-less">it takes less than 5 minutes</span>

    </div>
</div>
<div class="row supplier-intro-body">
    <div class="row">
        <div class="col-md-6 supplier-body-title">
            <span>
                <i class="fa fa-users"></i>
                Reach millions of customers
            </span>
            More customers will find your products, which means more sales, right?
        </div>
        <div class="col-md-6 supplier-body-title">
            <span>
                <i class="fa fa-bullseye"></i>
                Local customer and marketing support
            </span>
            Our professional customer support and business development teams will support you to become more successful.
        </div>
    </div> 
    <div class="row">
        <div class="col-md-6 supplier-body-title">
            <span>
                <i class="fa fa-upload"></i>
                Easy and free listing
            </span>
            Create your seller account and list all your products in few steps and absolutely for free.
        </div>
        <div class="col-md-6 supplier-body-title">
            <span>
                <i class="fa fa-hand-peace-o"></i>
                Payment & Shipping handled
            </span>
            Let us handle all this hassle for you. We will pick up your products, deliver them to your customers, and eventually send you the money, as easy as it sounds.
        </div>
    </div> 
</div>
@endsection