<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Website</title>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    
    <!-- Fonts FIRST - Load before anything else -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Then other assets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Base styles with !important declarations -->
    <style>
        body, h1, h2, h3, h4, h5, h6, .font-slab {
            font-family: 'Roboto Slab', serif !important;
        }
        .font-display {
            font-family: 'Playfair Display', serif !important;
        }
        .hero-text {
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        #nav-links {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    @include('layouts.header')

    <!-- Content Section -->
    <main class="flex-grow bg-gray-50">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')
</body>
</html>