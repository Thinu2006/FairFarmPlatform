@extends('layouts.app')

@section('content')
<!-- Hero Banner with Advanced Animations -->
<section class="relative w-full h-screen max-h-[800px] overflow-hidden">
    <!-- Slideshow Container -->
    <div class="slideshow-container w-full h-full relative">
        <!-- Slide 1 -->
        <div class="slide fade w-full h-full flex items-center justify-center" style="opacity: 0;">
            <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 ease-in-out transform scale-100" style="background-image: url('{{ asset('images/farmers-market.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end pb-16 sm:pb-24 md:pb-32 lg:items-center lg:justify-center lg:pb-0 px-6 sm:px-12">
                <div class="text-center max-w-4xl space-y-4 lg:space-y-6">
                    <h2 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.3s;">Direct From Farm</span>
                        </span>
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.6s;">To Your Table</span>
                        </span>
                    </h2>
                    <div class="overflow-hidden">
                        <p class="text-green-100 text-lg sm:text-xl md:text-2xl max-w-2xl mx-auto transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.9s;">
                            Fresh, organic rice straight from Sri Lanka's finest farmers
                        </p>
                    </div>
                    <div class="overflow-hidden pt-2">
                        <a href="{{ route('buyer.products') }}" class="inline-block mt-4 bg-[#1F4529] hover:bg-[#366342] text-white font-medium py-3 px-8 rounded-full transition-all duration-300 transform translate-y-8 opacity-0 animate-slideUp hover:scale-105 shadow-lg" style="animation-delay: 1.2s;">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide fade w-full h-full flex items-center justify-center" style="opacity: 0;">
            <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 ease-in-out transform scale-100" style="background-image: url('{{ asset('images/premium-rice.png') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end pb-16 sm:pb-24 md:pb-32 lg:items-center lg:justify-center lg:pb-0 px-6 sm:px-12">
                <div class="text-center max-w-4xl space-y-4 lg:space-y-6">
                    <h2 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.3s;">Premium Quality</span>
                        </span>
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.6s;">At Fair Prices</span>
                        </span>
                    </h2>
                    <div class="overflow-hidden">
                        <p class="text-amber-100 text-lg sm:text-xl md:text-2xl max-w-2xl mx-auto transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.9s;">
                            Traditional rice varieties grown with care and expertise
                        </p>
                    </div>
                    <div class="overflow-hidden pt-2">
                        <a href="{{ route('buyer.products') }}" class="inline-block mt-4 bg-[#1F4529] hover:bg-[#366342] text-white font-medium py-3 px-8 rounded-full transition-all duration-300 transform translate-y-8 opacity-0 animate-slideUp hover:scale-105 shadow-lg" style="animation-delay: 1.2s;">
                            Explore Varieties
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide fade w-full h-full flex items-center justify-center" style="opacity: 0;">
            <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 ease-in-out transform scale-100" style="background-image: url('{{ asset('images/happy-farmer.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end pb-16 sm:pb-24 md:pb-32 lg:items-center lg:justify-center lg:pb-0 px-6 sm:px-12">
                <div class="text-center max-w-4xl space-y-4 lg:space-y-6">
                    <h2 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.3s;">Supporting</span>
                        </span>
                        <span class="hero-title block overflow-hidden">
                            <span class="inline-block transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.6s;">Local Farmers</span>
                        </span>
                    </h2>
                    <div class="overflow-hidden">
                        <p class="text-teal-100 text-lg sm:text-xl md:text-2xl max-w-2xl mx-auto transform translate-y-full opacity-0 animate-slideUp" style="animation-delay: 0.9s;">
                            Your purchase directly benefits Sri Lankan farming communities
                        </p>
                    </div>
                    <div class="overflow-hidden pt-2">
                        <a href="#" class="inline-block mt-4 bg-[#1F4529] hover:bg-[#366342] text-white font-medium py-3 px-8 rounded-full transition-all duration-300 transform translate-y-8 opacity-0 animate-slideUp hover:scale-105 shadow-lg" style="animation-delay: 1.2s;">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button class="prev absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="sr-only">Previous</span>
    </button>
    <button class="next absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="sr-only">Next</span>
    </button>

    <!-- Pagination Dots -->
    <div class="dots-container absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
        <button class="dot w-3 h-3 rounded-full bg-white/80 hover:bg-white transition-all duration-300 focus:outline-none" aria-label="Slide 1"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300 focus:outline-none" aria-label="Slide 2"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300 focus:outline-none" aria-label="Slide 3"></button>
    </div>
</section>

<style>
    /* Modern Slideshow Styles */
    .slideshow-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .slide > div:first-child {
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 12s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform;
    }

    .slide.fade {
        opacity: 1;
    }

    .slide.fade > div:first-child {
        transform: scale(1.1);
    }

    /* Text Animation Styles */
    @keyframes slideUp {
        0% {
            transform: translateY(100%);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animate-slideUp {
        animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Hero title specific styles */
    .hero-title {
        height: 1.2em;
        line-height: 1.2;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .slide > div:last-child {
            padding-bottom: 8rem;
        }
    }

    @media (max-width: 640px) {
        section {
            height: 85vh;
        }

        .slide h2 {
            font-size: 2.25rem;
            line-height: 1.2;
        }

        .slide p {
            font-size: 1rem;
        }

        .hero-title {
            height: 1.3em;
        }
    }
</style>

<script>
    // Enhanced Slideshow Functionality with Text Animation Control
    document.addEventListener('DOMContentLoaded', function() {
        let slideIndex = 0;
        let slideInterval;
        const slides = document.getElementsByClassName("slide");
        const dots = document.getElementsByClassName("dot");

        // Initialize all slides as invisible on load
        function initializeSlides() {
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
                resetAnimations(slides[i]);
            }

            // Show first slide
            if (slides.length > 0) {
                slides[0].style.opacity = "1";
                dots[0].classList.remove('bg-white/30');
                dots[0].classList.add('bg-white/80');
                triggerAnimations(slides[0]);
            }
        }

        initializeSlides();

        // Auto-advance slides every 5 seconds
        function startSlideShow() {
            slideInterval = setInterval(() => {
                plusSlides(1);
            }, 5000); // Changed to 5000ms (5 seconds)
        }

        startSlideShow();

        // Next/previous controls
        function plusSlides(n) {
            // Reset animations on current slide
            resetAnimations(slides[slideIndex]);

            slideIndex += n;

            if (slideIndex >= slides.length) {
                slideIndex = 0;
            } else if (slideIndex < 0) {
                slideIndex = slides.length - 1;
            }

            showSlides();
            resetSlideInterval();
        }

        function currentSlide(n) {
            // Reset animations on current slide
            resetAnimations(slides[slideIndex]);

            slideIndex = n - 1;
            showSlides();
            resetSlideInterval();
        }

        function showSlides() {
            // Hide all slides
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
                slides[i].querySelector('div:first-child').style.transform = "scale(1)";
                resetAnimations(slides[i]);
            }

            // Update dots
            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove('bg-white/80');
                dots[i].classList.add('bg-white/30');
            }

            // Show current slide
            if (slides.length > 0) {
                slides[slideIndex].style.opacity = "1";
                slides[slideIndex].querySelector('div:first-child').style.transform = "scale(1.1)";

                // Highlight current dot
                dots[slideIndex].classList.remove('bg-white/30');
                dots[slideIndex].classList.add('bg-white/80');

                // Trigger animations for current slide
                triggerAnimations(slides[slideIndex]);
            }
        }

        function resetSlideInterval() {
            clearInterval(slideInterval);
            startSlideShow();
        }

        function resetAnimations(slide) {
            if (!slide) return;

            const animElements = slide.querySelectorAll('.animate-slideUp');
            animElements.forEach(el => {
                el.style.animation = 'none';
                el.style.transform = 'translateY(100%)';
                el.style.opacity = '0';
                void el.offsetWidth; // Trigger reflow
            });
        }

        function triggerAnimations(slide) {
            if (!slide) return;

            const animElements = slide.querySelectorAll('.animate-slideUp');
            animElements.forEach(el => {
                el.style.animation = '';
                void el.offsetWidth; // Trigger reflow
            });
        }

        // Pause on hover
        const slider = document.querySelector('.slideshow-container');
        slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
        slider.addEventListener('mouseleave', resetSlideInterval);

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
            const threshold = 50;
            if (touchEndX < touchStartX - threshold) {
                plusSlides(1);
            } else if (touchEndX > touchStartX + threshold) {
                plusSlides(-1);
            }
        }

        // Event listeners
        document.querySelector('.prev').addEventListener('click', () => plusSlides(-1));
        document.querySelector('.next').addEventListener('click', () => plusSlides(1));

        Array.from(dots).forEach((dot, index) => {
            dot.addEventListener('click', () => currentSlide(index + 1));
        });
    });
</script>


    <!-- Products Section with Animation -->
    <section class="py-16 md:py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-9xl mx-auto px-6 sm:px-40">
            <h3 class="text-center text-3xl md:text-4xl font-bold text-[#1F4529] mb-12 animate-fadeInUp">Our Top Selling Products</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 xl:gap-16">
                @foreach ($topSellingPaddies  as $index => $paddy)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 transform hover:-translate-y-2 hover:shadow-xl animate-fadeInUp delay-{{ $index * 100 }}">
                    <div class="h-56 sm:h-48 md:h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $paddy->paddyType->Image) }}"
                             alt="{{ $paddy->paddyType->PaddyName }}"
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-6">
                        <h4 class="text-xl md:text-2xl font-semibold text-gray-900 mb-2">{{ $paddy->paddyType->PaddyName }}</h4>
                        <p class="text-lg font-bold text-gray-800 mb-4">Rs{{ $paddy->PriceSelected }} <span class="text-base font-normal">per 1 kg</span></p>

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
<!-- Supporting Buyers Section -->
<section class="py-16 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-12">
            <h3 class="text-3xl md:text-4xl font-bold text-[#1F4529] mb-4 animate-fadeInUp"> Your Farming Partner</h3>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto animate-fadeInUp delay-100">
                We're committed to providing you with the best purchasing experience and support throughout your journey with FairFarm.
            </p>
        </div>

         <!-- Feature Cards with Agricultural Icons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 - Quality -->
            <div class="relative group bg-gradient-to-b from-white to-[#f8faf7] rounded-xl p-8 shadow-sm hover:shadow-lg transition-all duration-500 border border-[#1F4529]/10 hover:border-[#1F4529]/30 animate-fadeInUp delay-200">
                <div class="absolute -top-5 right-6 w-12 h-12 bg-[#1F4529] rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-[#1F4529]/10 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1F4529]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h4 class="text-xl font-semibold text-gray-900 mb-3">Verified Quality</h4>
                <p class="text-gray-600 mb-4">
                    Each rice variety undergoes rigorous quality checks from paddy field to packaging, preserving authentic Sri Lankan flavors.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Traditional cultivation methods
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Chemical-free processing
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Heritage grain preservation
                    </li>
                </ul>
            </div>

            <!-- Card 2 - Transparency -->
            <div class="relative group bg-gradient-to-b from-white to-[#f8faf7] rounded-xl p-8 shadow-sm hover:shadow-lg transition-all duration-500 border border-[#1F4529]/10 hover:border-[#1F4529]/30 animate-fadeInUp delay-300">
                <div class="absolute -top-5 right-6 w-12 h-12 bg-[#1F4529] rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-[#1F4529]/10 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1F4529]" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h4 class="text-xl font-semibold text-gray-900 mb-3">Complete Transparency</h4>
                <p class="text-gray-600 mb-4">
                    Know exactly where your rice comes from with farmer profiles, cultivation details, and fair pricing breakdowns.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Farmer stories and practices
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Real-time harvest updates
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Fair trade pricing models
                    </li>
                </ul>
            </div>

            <!-- Card 3 - Support -->
            <div class="relative group bg-gradient-to-b from-white to-[#f8faf7] rounded-xl p-8 shadow-sm hover:shadow-lg transition-all duration-500 border border-[#1F4529]/10 hover:border-[#1F4529]/30 animate-fadeInUp delay-400">
                <div class="absolute -top-5 right-6 w-12 h-12 bg-[#1F4529] rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-[#1F4529]/10 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1F4529]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h4 class="text-xl font-semibold text-gray-900 mb-3">Agricultural Expertise</h4>
                <p class="text-gray-600 mb-4">
                    Our team of rice cultivation experts and farmer representatives are available to guide your purchasing decisions.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Grain selection advice
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Cooking and storage tips
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#1F4529] mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Direct farmer Q&A
                    </li>
                </ul>
            </div>
        </div>

        <!-- Instruction Section -->
        <div class="mt-16 bg-[#1F4529]/5 rounded-2xl p-8 md:p-12 animate-fadeInUp delay-500">
            <div class="text-center mb-8">
                <h3 class="text-2xl md:text-3xl font-bold text-[#1F4529] mb-2">How It Works</h3>
                <p class="text-gray-600 max-w-3xl mx-auto">Simple steps to get the freshest products from our farmers to you</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="relative mx-auto mb-4">
                        <div class="w-16 h-16 bg-[#1F4529] rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto">1</div>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Browse Products</h4>
                    <p class="text-gray-600 text-sm">Explore our selection of premium rice varieties</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="relative mx-auto mb-4">
                        <div class="w-16 h-16 bg-[#1F4529] rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto">2</div>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Select Quantity</h4>
                    <p class="text-gray-600 text-sm">Choose your desired amount and delivery options</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="relative mx-auto mb-4">
                        <div class="w-16 h-16 bg-[#1F4529] rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto">3</div>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Secure Checkout</h4>
                    <p class="text-gray-600 text-sm">Complete your purchase with our protected payment</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="relative mx-auto mb-4">
                        <div class="w-16 h-16 bg-[#1F4529] rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto">4</div>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Receive Delivery</h4>
                    <p class="text-gray-600 text-sm">Get fresh products directly from the farm</p>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('buyer.products') }}" class="inline-block bg-[#1F4529] hover:bg-[#366342] text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                    Start Shopping Now
                </a>
            </div>
        </div>
    </section>
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
