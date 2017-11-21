@extends('auth_supplier.Layouts.master')
@section('container')
@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="supplier-register-form-container">
    <div class="row">
        <div class="col-md-6">
            <h2>Register</h2>
        </div>
        <div class="col-md-6 text-right">
            Register as a Supplier
        </div>
    </div>
    <div class="row supplier-register-form-holder">
        <div class="row">
            <div class="col-md-8">
                <h3>Register as a Supplier</h3>
            </div>
            <div class="col-md-4 text-right">
                Registration Details
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <span class="fa fa-stack-1x fa-inverse">1</span>
                </span>
                <span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <span class="fa fa-stack-1x fa-inverse">2</span>
                </span>
            </div>
        </div>
        <div class="row">
            <div class='col-md-8'>
                <!-- form container -->
                <form method="post" action="{{route('supplier.register')}}">
                    {{csrf_field()}}
                    <div class="form-section">
                        <div class="section-label">
                            <span class="section-label-arrow">
                                <i class="fa fa-caret-left sp-2x"></i>
                                <i class="fa fa-caret-left sp-1x"></i>
                            </span>
                            This <label>company name</label> will be visible on your public product pages. For example: "A2ZTravelMarket" Please do not use special characters such as commas.
                        </div>
                        <div class="form-section-title">1 · Company Name</div>
                        <div class="form-group sort-1">
                            <input type="text" class="form-control" name="company" required>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="section-label">
                            <span class="section-label-arrow">
                                <i class="fa fa-caret-left sp-2x"></i>
                                <i class="fa fa-caret-left sp-1x"></i>
                            </span>
                            Your contact details will not be public.

                            For the name, please enter the <label>name of the person who will administrate</label> your A2ZTravelMarket account.
                        </div>
                        <div class="form-section-title">2 · Contact Details</div>
                        <div class="form-group sort-2">
                            <label>Title:</label>
                            <select class="form-control" name="title">
                                <option value="mr">Mr</option>
                                <option value="ms">Ms</option>
                            </select>
                        </div>
                        <div class="form-group sort-2">
                            <label>First Name:</label>
                            <input class="form-control" name="f_name" required>
                        </div>
                        <div class="form-group sort-2 end-sector">
                            <label>Last Name:</label>
                            <input class="form-control" name="l_name" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>Address:</label>
                            <input class="form-control" name="address" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>City:</label>
                            <input class="form-control" name="city" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>State:</label>
                            <input class="form-control" name="state" >
                            <span>(optional)</span>
                        </div>
                        <div class="form-group sort-2 end-sector">
                            <label>Country:</label>
                            <input class="form-control" name="country" required>
                        </div>
                        <div class="section-label">
                            <span class="section-label-arrow">
                                <i class="fa fa-caret-left sp-2x"></i>
                                <i class="fa fa-caret-left sp-1x"></i>
                            </span>
                            Please include the <label>country code</label> for your phone and fax numbers.
                            For example: "+49 (0)30 544 459 44".
                        </div>
                        <div class="form-group sort-2">
                            <label>Phone:</label>
                            <input class="form-control" name="phone" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>Fax:</label>
                            <input class="form-control" name="fax" >
                            <span>(optional)</span>
                        </div>
                        <div class="form-group sort-2">
                            <label>Website:</label>
                            <input class="form-control" name="website" >
                            <span>(optional)</span>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="section-label">
                            <span class="section-label-arrow">
                                <i class="fa fa-caret-left sp-2x"></i>
                                <i class="fa fa-caret-left sp-1x"></i>
                            </span>
                            The email address is also your <label>login</label>. You need your email address and password to log in to your A2ZTravelMarket account.
                        </div>
                        <div class="form-section-title">3 · Administrator Login</div>
                        <div class="form-group sort-2 end-sector">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group sort-2">
                            <label>Confirm Password:</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <button class="btn btn-success btn-large">
                            Continue Registration
                        </button>
                    </div>
                </form>
                <!-- form container end -->
            </div>
        </div>
    </div>
</div>
@endsection
