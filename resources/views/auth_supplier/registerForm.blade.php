<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Become Our Vendor</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{asset('css/register.css')}}">
    </head>
    <body>
        <div class="container">
            <h1>Shop Details</h1>
            <h2 class="form-header">Name*</h2>
            <form method="post" action="{{route('supplier.register')}}">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="f_name" class="form-control" required>
                            <span>First Name</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="l_name" class="form-control" required>
                            <span>Last Name</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email / الايميل *</label>
                            <input type="text" name="email" class="form-control" required>
                            <span>Will be used to send you a verification and activation email / سيتم استخدام الايميل في ارسال بريد التحقق وتأكيد المعلومات</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobile phone number/رقم الهاتف المحمول*</label>
                            <input type="text" name="mobile" class="form-control" required>
                            <span>ex: 01xx xxx xxxx / xxxx xxx xx10: مثال</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company name/اسم الشركة*</label>
                            <input type="text" name="company" class="form-control" required>
                            <span>The name of your company / اسم متجرك</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prefered  store name / أسم متجرك على الموقع </label>
                            <input type="text" name="store_name" class="form-control" required>
                            <span>This will become the name of your shop on our website (system shows default ending as marketplace) / Case sensitive field, please use english only /سوف يصبح هذا اسم متجرك علي الموقع</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Company address/العنوان الشركه*</label>
                            <input type="text" name="address" class="form-control" required>
                            <span>The registered Egyptian address of the company must be a physical address (can be either a residential or commercial address) and cannot be a P.O. Box</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City/ مدينة*</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Postal code/ الرقم البريدي</label>
                            <input type="text" name="postal_code" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="terms-conditions">I understand and agree to the terms of Egypt Ladies Club/ أوافق وأفهم شروط ايجبت لاديز كلوب*</span>
                        <div class="checkbox">
                            <label class="read-terms"><input type="checkbox" value="1" name="agree" required>I hereby agree that I have read and accepted the Egypt Ladies Club Marketplace Agreement.</label>
                            <a href="" class="see-terms">See our terms & conditions</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center submit-form">
                        <button class="btn btn-success">Submit Form</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>