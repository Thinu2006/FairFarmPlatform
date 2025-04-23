@extends('layouts.app')

@section('content')
    <section class="relative w-full min-h-[50vh] md:min-h-[90vh] overflow-hidden">
        <!-- Slideshow Container -->
        <div class="slideshow-container w-full h-full relative">
            <!-- Slide 1 - Marketplace Focus -->
            <div class="slide fade w-full h-full flex items-center justify-center" style="opacity: 1;">
                <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('{{ asset('images/farmers-market.jpg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-4 sm:px-8 md:px-12 text-center">
                    <h2 class="text-white text-xl sm:text-3xl md:text-5xl lg:text-6xl font-bold hero-text">Direct From Farm To Your Table</h2>
                </div>
            </div>
            
            <!-- Slide 2 - Quality Focus -->
            <div class="slide fade w-full h-full flex items-center justify-center">
                <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('{{ asset('images/premium-rice.png') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-4 sm:px-8 md:px-12 text-center">
                    <h2 class="text-white text-xl sm:text-3xl md:text-5xl lg:text-6xl font-bold hero-text">Premium Quality Rice At Fair Prices</h2>
                </div>
            </div>
            
            <!-- Slide 3 - Farmer Focus -->
            <div class="slide fade w-full h-full flex items-center justify-center">
                <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('{{ asset('images/happy-farmer.jpg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-4 sm:px-8 md:px-12 text-center">
                    <h2 class="text-white text-xl sm:text-3xl md:text-5xl lg:text-6xl font-bold hero-text">Supporting Local Farmers Directly</h2>
                </div>
            </div>
            
            <!-- Slide 4 - Variety Focus -->
            <div class="slide fade w-full h-full flex items-center justify-center">
                <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('{{ asset('images/rice-varieties.png') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-4 sm:px-8 md:px-12 text-center">
                    <h2 class="text-white text-xl sm:text-3xl md:text-5xl lg:text-6xl font-bold hero-text">Discover Sri Lanka's Finest Rice Varieties</h2>
                </div>
            </div>
        </div>
        
        <!-- Slideshow Controls -->
        <a class="prev absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl md:text-4xl cursor-pointer z-10 hover:text-green-300 transition">❮</a>
        <a class="next absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl md:text-4xl cursor-pointer z-10 hover:text-green-300 transition">❯</a>
        
        <!-- Slideshow Dots -->
        <div class="dots-container absolute bottom-2 md:bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
            <span class="dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-green-300 cursor-pointer hover:bg-green-400 transition" onclick="currentSlide(1)"></span>
            <span class="dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white cursor-pointer hover:bg-green-300 transition" onclick="currentSlide(2)"></span>
            <span class="dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white cursor-pointer hover:bg-green-300 transition" onclick="currentSlide(3)"></span>
            <span class="dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white cursor-pointer hover:bg-green-300 transition" onclick="currentSlide(4)"></span>
        </div>
    </section>

    <style>
        .slideshow-container {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: inherit;
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            overflow: hidden;
        }
        .slide > div:first-child {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(1px);
            transform: scale(1.05);
            transition: filter 0.3s ease; /* Smooth blur transition */
        }
        
        .slide.fade {
            opacity: 1;
        }
        
        /* Responsive Controls */
        .prev, .next {
            user-select: none;
            z-index: 10;
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
            padding: 8px;
            background-color: rgba(0,0,0,0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Mobile-specific styles */
        @media (max-width: 640px) {
            .slide > div:first-child {
                filter: blur(2px);
                transform: scale(1.02);
            }
            .prev, .next {
                width: 30px;
                height: 30px;
                font-size: 1.5rem;
            }
            
            .hero-text {
                font-size: 1.5rem;
                padding: 0 1rem;
            }
            
            .slide {
                background-position: center center;
            }
        }
        
        /* Hero Text Animation */
        .hero-text {
            animation: fadeIn 1s ease-in-out;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Ensure dots are visible on all devices */
        .dots-container {
            z-index: 10;
            padding: 4px 8px;
            background-color: rgba(0,0,0,0.3);
            border-radius: 20px;
        }
    </style>

    <script>
        // Improved Responsive Slideshow Functionality
        document.addEventListener('DOMContentLoaded', function() {
            let slideIndex = 1;
            let slideInterval;
            const slides = document.getElementsByClassName("slide");
            const dots = document.getElementsByClassName("dot");
            
            // Initialize the slider
            showSlides(slideIndex);
            
            // Start auto-advance
            startSlideInterval();
            
            // Next/previous controls
            function plusSlides(n) {
                showSlides(slideIndex += n);
                resetSlideInterval();
            }
            
            // Thumbnail image controls
            function currentSlide(n) {
                showSlides(slideIndex = n);
                resetSlideInterval();
            }
            
            function showSlides(n) {
                if (n > slides.length) {slideIndex = 1}
                if (n < 1) {slideIndex = slides.length}
                
                for (let i = 0; i < slides.length; i++) {
                    slides[i].style.opacity = "0";
                }
                
                for (let i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" bg-green-300", " bg-white");
                }
                
                if (slides.length > 0) {
                    slides[slideIndex-1].style.opacity = "1";
                    dots[slideIndex-1].className = dots[slideIndex-1].className.replace(" bg-white", "");
                    dots[slideIndex-1].className += " bg-green-300";
                }
            }
            
            function startSlideInterval() {
                slideInterval = setInterval(() => {
                    plusSlides(1);
                }, 5000);
            }
            
            function resetSlideInterval() {
                clearInterval(slideInterval);
                startSlideInterval();
            }
            
            // Pause on hover (desktop only)
            const slider = document.querySelector('.slideshow-container');
            if (window.matchMedia("(min-width: 640px)").matches) {
                slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
                slider.addEventListener('mouseleave', resetSlideInterval);
            }
            
            // Touch events for mobile
            let touchStartX = 0;
            let touchEndX = 0;
            
            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                clearInterval(slideInterval);
            }, {passive: true});
            
            slider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                resetSlideInterval();
            }, {passive: true});
            
            function handleSwipe() {
                const threshold = 50; // Minimum swipe distance
                if (touchEndX < touchStartX - threshold) {
                    plusSlides(1); // Swipe left - next slide
                } else if (touchEndX > touchStartX + threshold) {
                    plusSlides(-1); // Swipe right - previous slide
                }
            }
            
            // Event listeners for controls
            document.querySelector('.prev').addEventListener('click', () => plusSlides(-1));
            document.querySelector('.next').addEventListener('click', () => plusSlides(1));
            
            // Dot controls
            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.addEventListener('click', () => currentSlide(index + 1));
            });
            
            // Window resize handler
            window.addEventListener('resize', function() {
                // Adjust any responsive elements if needed
            });
        });
    </script>

    <!-- Products Section with Animation -->
    <section class="py-16 md:py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-9xl mx-auto px-6 sm:px-40">
            <h3 class="text-center text-3xl md:text-4xl font-bold text-[#1F4529] mb-12 animate-fadeInUp">Our Products</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 xl:gap-16">
                @foreach ($sellingPaddyTypes as $index => $paddy)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 transform hover:-translate-y-2 hover:shadow-xl animate-fadeInUp delay-{{ $index * 100 }}">
                    <div class="h-56 sm:h-48 md:h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}" 
                             alt="{{ $paddy->paddyType->PaddyName }}" 
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-6">
                        <h4 class="text-xl md:text-2xl font-semibold text-gray-900 mb-2">{{ $paddy->paddyType->PaddyName }}</h4>
                        <p class="text-lg font-bold text-gray-800 mb-4">Rs{{ $paddy->PriceSelected }} <span class="text-base font-normal">per 1Kg</span></p>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <h5 class="text-lg font-medium text-gray-600 mb-2">Farmer details:</h5>
                            <ul class="text-gray-600 space-y-1">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $paddy->farmer->FullName }}
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $paddy->farmer->Address }}
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('buyer.product.details', $paddy->id) }}" class="mt-4 w-full bg-[#1F4529] text-white text-lg px-4 py-2 rounded-md hover:bg-green-800 transition duration-300 block text-center">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center animate-fadeInUp delay-500">
                <a href="{{ route('buyer.products') }}" class="inline-block bg-[#1F4529] hover:bg-green-800 text-white text-lg font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                    Browse All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Quality and Pricing Section -->
    <section class="relative w-full h-auto min-h-[400px] md:min-h-[500px] lg:min-h-[100px] bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('{{ asset('images/paddy4.jpg') }}');">
        <div class="bg-black/50 h-full flex items-center py-12 md:py-16">
            <div class="max-w-7xl mx-auto w-full px-6 sm:px-8 lg:px-12 xl:px-16">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 md:gap-8 text-center text-white">
                    <!-- Stat 1 with Animation -->
                    <div class="p-6 backdrop-blur-sm bg-white/5 rounded-xl animate-fadeIn delay-100 hover:bg-white/10 transition-all duration-500">
                        <h4 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-2 animate-countUp" data-target="100">0</h4>
                        <p class="text-lg md:text-xl lg:text-2xl">High Quality</p>
                    </div>
                    
                    <!-- Stat 2 with Animation -->
                    <div class="p-6 backdrop-blur-sm bg-white/5 rounded-xl animate-fadeIn delay-300 hover:bg-white/10 transition-all duration-500">
                        <h4 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-2 animate-countUp" data-target="100">0</h4>
                        <p class="text-lg md:text-xl lg:text-2xl">Fair Prices</p>
                    </div>
                    
                    <!-- Stat 3 with Animation -->
                    <div class="p-6 backdrop-blur-sm bg-white/5 rounded-xl animate-fadeIn delay-500 hover:bg-white/10 transition-all duration-500">
                        <h4 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-2 animate-countUp" data-target="40">0</h4>
                        <p class="text-lg md:text-xl lg:text-2xl">Island Farmers</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section with Animation -->
    <section class="py-16 md:py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-9xl mx-auto px-6 sm:px-40">
            <h3 class="text-center text-3xl md:text-4xl font-bold text-[#1F4529] mb-4 animate-fadeInUp">What Our Buyers Say</h3>
            <p class="text-center text-gray-600 text-xl max-w-3xl mx-auto mb-12 animate-fadeInUp delay-100">Hear from our satisfied customers about their experiences with our products</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
                <!-- Testimonial 1 with Animation -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 animate-fadeInLeft">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/buyer1.jpg') }}" alt="Nimal Perera" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="text-xl font-semibold">Nimal Perera</h4>
                            <div class="flex text-yellow-400 mt-1">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The rice was of excellent quality, delivered in good quantity, and priced fairly. Truly worth it."</p>
                </div>
                
                <!-- Testimonial 2 with Animation -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 animate-fadeInUp">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/buyer2.jpg') }}" alt="Ranoweera" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="text-xl font-semibold">Ranoweera</h4>
                            <div class="flex text-yellow-400 mt-1">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Great value for money with high-quality rice, ample quantity, and a very reasonable price."</p>
                </div>
                
                <!-- Testimonial 3 with Animation -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-1 animate-fadeInRight">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/buyer3.jpg') }}" alt="Nelum Perera" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="text-xl font-semibold">Nelum Perera</h4>
                            <div class="flex text-yellow-400 mt-1">
                                ★★★★★
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The rice met all expectations with superb quality, a fair price, and sufficient quantity."</p>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Animation Styles -->
    <style>
        /* Animation Styles */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInLeft {
            from { 
                opacity: 0;
                transform: translateX(-20px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from { 
                opacity: 0;
                transform: translateX(20px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Animation Classes */
        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-fadeInLeft {
            animation: fadeInLeft 0.8s ease-out forwards;
        }
        
        .animate-fadeInRight {
            animation: fadeInRight 0.8s ease-out forwards;
        }
        
        /* Delayed Animations */
        .delay-100 {
            animation-delay: 100ms;
        }
        
        .delay-300 {
            animation-delay: 300ms;
        }
        
        .delay-500 {
            animation-delay: 500ms;
        }
        
        /* Count Up Animation */
        .animate-countUp {
            display: inline-block;
        }
    </style>

    <!-- Animation Script -->
    <script>
        // Count Up Animation
        function animateCountUp() {
            const counters = document.querySelectorAll('.animate-countUp');
            const speed = 200;
            
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCountUp, 1);
                } else {
                    counter.innerText = target;
                }
            });
        }
        
        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('animate-countUp')) {
                        animateCountUp();
                    }
                    entry.target.classList.add('animate');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('[class*="animate-"]').forEach(el => {
            observer.observe(el);
        });
    </script>
<!-- BotMan Chat Widget -->
<div id="botman-isolation-container" style="all:initial">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
    <style>
        /* Reset all styles within the container */
        #botman-isolation-container * {
            all: revert;
        }
        /* Specific BotMan styles */
        #botman-isolation-container .botmanWidgetBtn {
            background-color: #1F4529 !important;
            font-family: 'Roboto Slab', serif !important;
        }
        #botman-isolation-container .botmanWidgetContainer {
            z-index: 10000;
            font-family: 'Roboto Slab', serif !important;
        }
    </style>
    <script>
        var botmanWidget = {
            aboutText: 'Need help? Start with "Hi"',
            introMessage: "WELCOME TO FAIRFARM!",
            bubbleAvatarUrl: '',
            mainColor: '#1F4529',
            bubbleBackground: '#1F4529',
            desktopHeight: 500,
            desktopWidth: 400,
            chatServer: '/botman',
            title: 'Paddy Assistant',
            widgetHeight: '500px',
            widgetWidth: '350px',
            headerTextColor: 'white',
            headerBackgroundColor: '#1F4529',
            bodyBackgroundColor: 'white',
            bodyTextColor: '#333333',
            messageFontFamily: "'Roboto Slab', serif",
            inputFontFamily: "'Roboto Slab', serif"
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</div>
@endsection