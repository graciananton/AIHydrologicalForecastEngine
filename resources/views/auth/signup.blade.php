<!DOCTYPE html>
<html>
    <head>
        <title>AI Forecast Engine - Signup</title>
    </head>
    <body>
        <form method='POST' action='http://localhost/laravel/public/signup_submit'>
                @csrf
                <label>Name</label><br>
                <input type="text" name="name" value="{{ old('name') }}"><br><br>

                <label>Email</label><br>
                <input type="email" name="email" value="{{ old('email') }}"><br><br>

                <label>Password</label><br>
                <input type="password" name="password"><br><br>

                <label>Confirm Password</label><br>
                <input type="password" name="password_confirmation"><br><br>

                <button type="submit">Register</button>
        </form>
    </body>
</html>