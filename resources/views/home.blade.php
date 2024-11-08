<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Event Management System</h1>
        <p>This is the home page of the application.</p>
        
        <!-- Link to login or dashboard based on authentication status -->
        @auth
            <a href="{{ route('speakers.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        @endauth
    </div>
</body>
</html>
