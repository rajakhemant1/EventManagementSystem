<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reviewer Dashboard')</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('reviewer.dashboard') }}">Reviewer Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reviewer.dashboard') }}">Home</a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('reviewer.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div id="notifications" class="container mt-4"></div>
    
    <!-- Main Content Area -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Pusher JavaScript library -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<!-- Laravel Echo via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.min.js"></script>
<script>
    // Initialize Laravel Echo with Pusher
    const echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    echo.channel('proposals')
        .listen('.proposal.updated', (event) => {
            let message = event.action === 'added' 
                ? `New proposal added: ${event.talkProposal.title}` 
                : `Proposal updated: ${event.talkProposal.title}`;

            // Create a Bootstrap alert dynamically
            let alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-info alert-dismissible fade show'; // Use 'alert-info' or other classes as needed
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            // Append the alert to a container in your layout (e.g., a div with id="notifications")
            document.getElementById('notifications').appendChild(alertDiv);

            // Optional: Auto-dismiss the alert after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                alertDiv.classList.add('hide');
                setTimeout(() => alertDiv.remove(), 500); // Wait for fade-out to complete
            }, 5000);
        });
</script>

</body>
</html>
