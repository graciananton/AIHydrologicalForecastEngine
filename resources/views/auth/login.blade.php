<!--<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <form method='POST' id='login_view' action='http://localhost/laravel/public/login_submit'>
            @csrf
            <label>Email:</label>
            <input type="email" id='email' name="email" required><br><br>

            <label>Password:</label>
            <input type="password" id='password' name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </body>
</html>-->

<!doctype html>
<html>
<head>
    @vite([
        'resources/css/app.css',
        'resources/js/app.jsx'
    ])
    <title>AI Forecast Engine - Login</title>
</head>
<body>
    <script>
    window.__REACT_DATA__ = @json([
                    ['error'=>session('error')],
                    ['req'  => 'login']
                    ]);
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="react-root"></div>
<!--

<div id="login_page">
    <div id="login" class="container-fluid">
        <div id="title">Login</div>

        <form method="POST" action="{{ url('/login_submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label><br/>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label><br/>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>


