<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FairFarm | Paddy Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../../Images/Logo.png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Poppins"', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#e6f5ea',
                            100: '#c2e6cd',
                            200: '#99d6ae',
                            300: '#68c68c',
                            400: '#3ab771',
                            500: '#0fa858',
                            600: '#0d974d',
                            700: '#0b8540',
                            800: '#097335',
                            900: '#055325',
                        },
                        earth: {
                            50: '#fafaf5',
                            100: '#f3f2e9',
                            200: '#e8e6d9',
                            300: '#d6d3b8',
                            400: '#b8b48d',
                            500: '#9c9465',
                            600: '#7a744d',
                            700: '#5e5a3b',
                            800: '#48452e',
                            900: '#3a3826',
                        },
                        gold: {
                            100: '#fff9e6',
                            200: '#ffedb3',
                            300: '#ffe180',
                            400: '#ffd54d',
                            500: '#ffc926',
                            600: '#ffb300',
                            700: '#cc8f00',
                            800: '#996b00',
                            900: '#664800',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-in-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' }, <!-- Reduced from -10px to -5px -->
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .grain-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%239C9465' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        .scroll-container {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        .scroll-container::-webkit-scrollbar {
            width: 6px;
        }
        .scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .scroll-container::-webkit-scrollbar-thumb {
            background: #9c9465;
            border-radius: 10px;
        }
        .scroll-container::-webkit-scrollbar-thumb:hover {
            background: #7a744d;
        }
        
        /* Floating icon adjustments */
        .floating-icon-container {
            position: absolute;
            top: 20px; /* Adjusted from -top-10 to ensure visibility */
            right: 2rem;
            z-index: 10;
        }
        .floating-icon {
            width: 4rem;
            height: 4rem;
            background-color: #f3f2e9;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center p-4 font-sans">
    <!-- Video Background with Enhanced Overlay -->
    <div class="fixed inset-0 z-0">
        <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('videos/BGVideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- <div class="absolute inset-0 bg-gradient-to-br from-primary-900/80 to-earth-900/90"></div> -->
    </div>

    <!-- Main Content Card -->
    <div class="relative z-10 w-full max-w-2xl bg-white/95 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden border border-earth-200 transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 animate-fade-in">
        <!-- Decorative Elements -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-gold-200 rounded-full opacity-20"></div>
        <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-primary-200 rounded-full opacity-20"></div>
        
        <!-- Header Section with Dark Forest Green Gradient -->
        <div class="h-56 bg-gradient-to-r from-primary-800 to-primary-900 relative">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center p-6 transform transition-all duration-300 hover:scale-105">
                    <h1 class="text-5xl font-serif font-bold text-white mb-2 tracking-tight">FairFarm</h1>
                    <p class="text-primary-100/90 font-sans tracking-widest text-sm max-w-md mx-auto">Connecting farmers directly with buyers for fair trade of premium quality paddy</p>
                    <div class="mt-4 w-16 h-1 bg-gold-500 mx-auto"></div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-8 bg-white transform skew-y-2 origin-bottom"></div>
        </div>

        <!-- Floating Rice Icon -->
        <!-- <div class="floating-icon-container animate-float">
            <div class="floating-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-earth-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div> -->

        <!-- Scrollable Content Area -->
        <div class="scroll-container">
            <div class="p-8 relative">
                <div class="grid md:grid-cols-2 gap-6 ">
                    <!-- Farmer Card -->
                    <a href="{{ route('farmer.login') }}" class="group relative overflow-hidden rounded-xl border border-earth-200 bg-white p-8 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary-700 hover:bg-earth-50">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-50/30 to-earth-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="mb-5 p-4 bg-gradient-to-br from-primary-100 to-primary-50 rounded-full text-primary-800 shadow-inner group-hover:shadow-md transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-serif font-semibold text-earth-800 mb-3 group-hover:text-primary-800 transition-colors">Farmer Portal</h3>
                            <p class="text-sm text-earth-500 text-center group-hover:text-earth-600 transition-colors">Sell your premium paddy directly to verified buyers</p>
                            <div class="mt-4 w-8 h-0.5 bg-gold-400 group-hover:bg-primary-700 transition-colors"></div>
                        </div>
                    </a>

                    <!-- Buyer Card -->
                    <a href="{{ route('buyer.login') }}" class="group relative overflow-hidden rounded-xl border border-earth-200 bg-white p-8 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary-700 hover:bg-earth-50">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-50/30 to-earth-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="mb-5 p-4 bg-gradient-to-br from-primary-100 to-primary-50 rounded-full text-primary-800 shadow-inner group-hover:shadow-md transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-serif font-semibold text-earth-800 mb-3 group-hover:text-primary-800 transition-colors">Buyer Portal</h3>
                            <p class="text-sm text-earth-500 text-center group-hover:text-earth-600 transition-colors">Source quality paddy directly from trusted farmers</p>
                            <div class="mt-4 w-8 h-0.5 bg-gold-400 group-hover:bg-primary-700 transition-colors"></div>
                        </div>
                    </a>
                </div>

                <!-- Admin Section -->
                <div class="text-center border-t border-earth-100 pt-6">
                    <p class="text-sm text-earth-500 mb-4">Platform administration</p>
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center px-5 py-2.5 border border-earth-200 shadow-sm text-sm font-medium rounded-lg text-earth-700 bg-white hover:bg-earth-50 hover:border-primary-700 hover:text-primary-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-earth-500 group-hover:text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>