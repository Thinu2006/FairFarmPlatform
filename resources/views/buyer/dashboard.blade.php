<!DOCTYPE html>
<html>
<head>
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h1 class="text-success mb-4">Welcome, {{ $buyer->FullName ?? 'Buyer' }}👩‍🌾</h1>
        <p class="mb-4">This is the buyer Dashboard</p>

        <a href="{{ route('buyer.logout') }}" 
           class="btn btn-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logoutt
        </a>

        <form id="logout-form" action="{{ route('buyer.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

</body>
</html>

