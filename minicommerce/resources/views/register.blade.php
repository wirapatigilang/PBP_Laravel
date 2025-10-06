<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>
<body class="auth-page">
    <div class="reg-wrapper">
        <div class="header">
            <h4>minicom</h4>
            <h2>Create Your Account</h2>
        </div>

        <div class="fill-form">
            <form method="POST" action="{{ route('post.register') }}">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Insert Your Name">
                </div>    
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Insert Your Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Insert Your Password">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Your Password">
                </div>

                @if(session('error'))
                    <div style="color:#ff4656;padding:10px;margin-bottom:15px;">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="form-group">
                    <input type="submit" class="btn" value="Register">
                </div>

            </form>
        </div>
    </div>
</body>
</html>
