@extends('layouts.app')

@section('content')
    <!-- Hero Section with Animation -->
    <!-- <section class="relative w-full min-h-[60vh] md:min-h-screen bg-cover bg-center flex items-center justify-center overflow-hidden" style="background-image: url('{{ asset('images/HomepgBG.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-6 sm:px-8 lg:px-16 text-center">
            <h2 class="text-white text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-bold px-4 leading-tight sm:leading-snug animate-fadeInUp">
                Sri Lanka Has A Long History Of Agriculture
            </h2>
        </div>
    </section> -->

    <!-- Hero Section -->
    <section class="relative w-full min-h-[50vh] md:min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('images/HomepgBG.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40 flex items-center justify-center px-6 sm:px-8 md:px-12 text-center">
            <h2 class="text-white text-2xl sm:text-4xl md:text-6xl font-bold hero-text">Sri Lanka Has A Long History Of Agriculture</h2>
        </div>
    </section>


    <!-- About Section with Animation -->
    <section class="py-16 md:py-20 px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl mx-auto overflow-hidden">
        <div class="flex flex-col lg:flex-row items-center gap-8 xl:gap-12">
            <div class="w-full lg:w-2/5 animate-fadeInUp">
                <img src="{{ asset('images/IMG4.jpg') }}" alt="Paddy" 
                     class="w-full h-auto rounded-xl shadow-lg object-cover hover:scale-105 transition-transform duration-500">
            </div>
            <div class="w-full lg:w-3/5 animate-fadeInUp ">
                <h3 class="text-[#1F4529] text-3xl md:text-4xl font-bold mb-6">Paddy Of Sri Lanka</h3>
                <div class="space-y-4 text-gray-800 text-base md:text-lg leading-relaxed">
                    <p class="animate-fadeInUp ">Sri Lanka has a deep-rooted history in agriculture, particularly in paddy cultivation. The country's fertile lands and traditional farming techniques have resulted in some of the finest rice varieties in the world.</p>
                    <p class="animate-fadeInUp">Farmers across the island dedicate their lives to producing high-quality rice that meets both local and international demands.</p>
                </div>
                <button class="mt-8 bg-[#1F4529] hover:bg-green-800 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 animate-fadeInUp ">
                    Read More
                </button>
            </div>
        </div>
    </section>

    <!-- Products Section with Animation -->
    <section class="py-16 md:py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 xl:px-16">
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
                        <p class="text-lg font-bold text-gray-800 mb-4">Rs{{ $paddy->PriceSelected }} <span class="text-sm font-normal">per 1Kg</span></p>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <h5 class="text-sm font-medium text-gray-600 mb-2">Farmer details:</h5>
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

                        <button class="mt-6 w-full bg-[#1F4529] hover:bg-green-800 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                            View Details
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center animate-fadeInUp delay-500">
                <a href="{{ route('buyer.products') }}" class="inline-block bg-[#1F4529] hover:bg-green-800 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                    Browse All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Quality and Pricing Section - Now Fully Responsive -->
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
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 xl:px-16">
            <h3 class="text-center text-3xl md:text-4xl font-bold text-[#1F4529] mb-4 animate-fadeInUp">What Our Buyers Say</h3>
            <p class="text-center text-gray-600 max-w-3xl mx-auto mb-12 animate-fadeInUp delay-100">Hear from our satisfied customers about their experiences with our products</p>
            
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
        /* Keyframe Animations */
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
        
        .delay-200 {
            animation-delay: 200ms;
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
@endsection