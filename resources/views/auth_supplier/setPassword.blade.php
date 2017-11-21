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
            <h2 class="form-header">Set Password*</h2>
            <form method="post" action="{{route('supplier.setPassword',['id'=>$id])}}">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" required>
                            <span>Password</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <span>Password Confirmation</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center submit-form">
                        <button class="btn btn-success">Set Password</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>