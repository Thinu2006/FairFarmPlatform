@extends('layouts.admin')

@section('title', 'Account Settings')

@section('content')
<section class="py-5 sm:py-5 px-0 sm:px-6 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between justify-center">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 font-merriweather">Account Settings</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Notification -->
        @if(session('success'))
        <div id="successNotification" class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="hideNotification('successNotification')" class="ml-4 text-green-700 hover:text-green-900">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Notification -->
        @if(session('error'))
        <div id="errorNotification" class="fixed top-4 right-4 z-50">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button onclick="hideNotification('errorNotification')" class="ml-4 text-red-700 hover:text-red-900">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Profile Section -->
        <div class="bg-white shadow overflow-hidden rounded-xl mt-6 mb-4 ">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Profile Information</h3>
                <p class="text-gray-500">Update your profile details</p>
            </div>

            <form id="adminProfileForm" action="{{ route('admin.account.update') }}" method="POST" class="p-6" onsubmit="return validateAdminForm()">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-base font-bold text-gray-700 mb-2 font-merriweather">Username :</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $admin->Username) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                               required
                               minlength="3"
                               maxlength="255">
                        <div id="usernameError" class="text-red-600 text-sm mt-1 hidden"></div>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-base font-bold text-gray-700 font-merriweather mb-2">Email :</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->Email) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                            required
                            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                            title="Please enter a complete email address (e.g., example@gmail.com)"
                            maxlength="255">
                        <div id="emailError" class="text-red-600 text-sm mt-1 hidden"></div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-green-700 text-white font-medium rounded-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Validate Username
    function validateUsername(username) {
        const usernamePattern = /^[a-zA-Z0-9_]+$/;
        return usernamePattern.test(username) && username.length >= 3 && username.length <= 255;
    }

    // Validate Email with stricter regex
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email) && email.length <= 255;
    }

    // Update the email blur event listener
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        const emailError = document.getElementById('emailError');
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a complete email address with a valid domain (e.g., example@gmail.com)';
            emailError.classList.remove('hidden');
            this.classList.add('border-red-500');
        } else {
            emailError.classList.add('hidden');
            this.classList.remove('border-red-500');
        }
    });

    // Form validation
    function validateAdminForm() {
        let isValid = true;
        
        // Username validation
        const username = document.getElementById('username').value.trim();
        const usernameError = document.getElementById('usernameError');
        if (!validateUsername(username)) {
            usernameError.textContent = 'Username must be 3-255 characters and contain only letters, numbers, and underscores';
            usernameError.classList.remove('hidden');
            isValid = false;
        } else {
            usernameError.classList.add('hidden');
        }
        
        // Email validation
        const email = document.getElementById('email').value.trim();
        const emailError = document.getElementById('emailError');
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a complete email address with a valid domain (e.g., example@gmail.com)';
            emailError.classList.remove('hidden');
            document.getElementById('email').classList.add('border-red-500');
            isValid = false;
        } else {
            emailError.classList.add('hidden');
            document.getElementById('email').classList.remove('border-red-500');
        }
        
        return isValid;
    }

    // Real-time validation
    document.getElementById('username').addEventListener('blur', function() {
        const username = this.value.trim();
        const usernameError = document.getElementById('usernameError');
        if (!validateUsername(username)) {
            usernameError.textContent = 'Username must be 3-255 characters and contain only letters, numbers, and underscores';
            usernameError.classList.remove('hidden');
        } else {
            usernameError.classList.add('hidden');
        }
    });

    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        const emailError = document.getElementById('emailError');
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address (max 255 characters)';
            emailError.classList.remove('hidden');
        } else {
            emailError.classList.add('hidden');
        }
    });

    // Notification functions
    function hideNotification(id) {
        const notification = document.getElementById(id);
        if (notification) {
            notification.classList.add('animate__animated', 'animate__fadeOutRight');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Auto-hide notifications after 5 seconds
    const successNotification = document.getElementById('successNotification');
    if (successNotification) {
        setTimeout(() => hideNotification('successNotification'), 5000);
    }

    const errorNotification = document.getElementById('errorNotification');
    if (errorNotification) {
        setTimeout(() => hideNotification('errorNotification'), 5000);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection