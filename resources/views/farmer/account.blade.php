@extends('layouts.farmer')

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

        <!-- Main form container -->
        <div class="bg-white shadow overflow-hidden rounded-xl mt-6 mb-4 ">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Profile Information</h3>
                <p class="text-gray-500">Update your profile details</p>
            </div>

            <!-- Form with adjusted typography -->
            <form id="profileForm" action="{{ route('farmer.account.update') }}" method="POST" class="p-6 sm:p-6" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Full Name -->
                    <div class="space-y-1">
                        <label for="FullName" class="block text-gray-800 font-bold text-base">Full Name :</label>
                        <input type="text" id="FullName" name="FullName" value="{{ old('FullName', $farmer->FullName) }}" 
                               class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition-all duration-200"
                               required>
                        <div id="fullNameError" class="text-rose-600 text-xs mt-1 font-medium hidden"></div>
                        @error('FullName')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIC -->
                    <div class="space-y-1">
                        <label for="NIC" class="block text-gray-800 font-bold text-base">NIC :</label>
                        <input type="text" id="NIC" name="NIC" value="{{ old('NIC', $farmer->NIC) }}" 
                               class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition-all duration-200"
                               required>
                        <div id="nicError" class="text-rose-600 text-xs mt-1 font-medium hidden"></div>
                        @error('NIC')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="space-y-1">
                        <label for="ContactNo" class="block text-gray-800 font-bold text-base">Contact Number :</label>
                        <input type="text" id="ContactNo" name="ContactNo" value="{{ old('ContactNo', $farmer->ContactNo) }}" 
                               class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition-all duration-200"
                               required>
                        <div id="contactNoError" class="text-rose-600 text-xs mt-1 font-medium hidden"></div>
                        @error('ContactNo')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="Email" class="block text-gray-800 font-bold text-base">Email :</label>
                        <input type="email" id="Email" name="Email" value="{{ old('Email', $farmer->Email) }}" 
                               class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition-all duration-200"
                               required
                               pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                               title="Please enter a complete email address (e.g., example@gmail.com)"
                               maxlength="255">
                        <div id="emailError" class="text-rose-600 text-xs mt-1 font-medium hidden"></div>
                        @error('Email')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="space-y-1 md:col-span-2">
                        <label for="Address" class="block text-gray-800 font-bold text-base">Address :</label>
                        <textarea id="Address" name="Address" rows="4" 
                                  class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-transparent transition-all duration-200"
                                  required>{{ old('Address', $farmer->Address) }}</textarea>
                        <div id="addressError" class="text-rose-600 text-xs mt-1 font-medium hidden"></div>
                        @error('Address')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" id="submitButton" class="px-6 py-2 bg-[#1F4529] text-white text-base font-medium rounded-lg hover:bg-emerald-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow hover:shadow-md">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Add Google Fonts for better typography -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
    body {
        font-family: 'Inter', sans-serif;
    }
    input:invalid, textarea:invalid {
        border-color: #ef4444;
    }
    input:valid, textarea:valid {
        border-color: #d1d5db;
    }
</style>

<script>
    // Validate NIC (Sri Lankan formats)
    function validateNIC(nic) {
        // Old NIC format (9 digits + V or X at the end)
        const oldNicPattern = /^[0-9]{9}[vVxX]$/;
        // New NIC format (12 digits)
        const newNicPattern = /^[0-9]{12}$/;
        return oldNicPattern.test(nic) || newNicPattern.test(nic);
    }

    // Validate Contact Number (Sri Lankan mobile numbers)
    function validateContactNo(contactNo) {
        const cleaned = contactNo.replace(/[+\s-]/g, '');
        const mobilePattern = /^(?:\+94|0|94)?(7[0-9])([0-9]{7})$/;
        return mobilePattern.test(cleaned);
    }

    // Validate Email with stricter regex
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email) && email.length <= 255;
    }

    // Show error message
    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }

    // Hide error message
    function hideError(elementId) {
        const errorElement = document.getElementById(elementId);
        errorElement.classList.add('hidden');
    }

    // Form validation
    function validateForm() {
        let isValid = true;
        
        // Full Name validation
        const fullName = document.getElementById('FullName').value.trim();
        if (fullName === '') {
            showError('fullNameError', 'Full Name is required');
            isValid = false;
        } else if (fullName.length > 255) {
            showError('fullNameError', 'Full Name must be less than 255 characters');
            isValid = false;
        } else {
            hideError('fullNameError');
        }
        
        // NIC validation
        const nic = document.getElementById('NIC').value.trim();
        if (!validateNIC(nic)) {
            showError('nicError', 'Please enter a valid NIC (e.g., 123456789V or 200012345678)');
            isValid = false;
        } else {
            hideError('nicError');
        }
        
        // Contact number validation
        const contactNo = document.getElementById('ContactNo').value.trim();
        if (!validateContactNo(contactNo)) {
            showError('contactNoError', 'Please enter a valid Sri Lankan mobile number (e.g., 0712345678)');
            isValid = false;
        } else {
            hideError('contactNoError');
        }
        
        // Email validation
        const email = document.getElementById('Email').value.trim();
        if (!validateEmail(email)) {
            showError('emailError', 'Please enter a complete email address with a valid domain (e.g., example@gmail.com)');
            isValid = false;
        } else if (email.length > 255) {
            showError('emailError', 'Email must be less than 255 characters');
            isValid = false;
        } else {
            hideError('emailError');
        }
        
        // Address validation
        const address = document.getElementById('Address').value.trim();
        if (address === '') {
            showError('addressError', 'Address is required');
            isValid = false;
        } else if (address.length > 255) {
            showError('addressError', 'Address must be less than 255 characters');
            isValid = false;
        } else {
            hideError('addressError');
        }
        
        return isValid;
    }

    // Add event listeners for real-time validation
    document.getElementById('FullName').addEventListener('blur', function() {
        const fullName = this.value.trim();
        if (fullName === '') {
            showError('fullNameError', 'Full Name is required');
        } else if (fullName.length > 255) {
            showError('fullNameError', 'Full Name must be less than 255 characters');
        } else {
            hideError('fullNameError');
        }
    });

    document.getElementById('NIC').addEventListener('blur', function() {
        const nic = this.value.trim();
        if (!validateNIC(nic)) {
            showError('nicError', 'Please enter a valid NIC (e.g., 123456789V or 200012345678)');
        } else {
            hideError('nicError');
        }
    });

    document.getElementById('ContactNo').addEventListener('blur', function() {
        const contactNo = this.value.trim();
        if (!validateContactNo(contactNo)) {
            showError('contactNoError', 'Please enter a valid Sri Lankan mobile number (e.g., 0712345678)');
        } else {
            hideError('contactNoError');
        }
    });

    document.getElementById('Email').addEventListener('blur', function() {
        const email = this.value.trim();
        if (!validateEmail(email)) {
            showError('emailError', 'Please enter a complete email address with a valid domain (e.g., example@gmail.com)');
        } else if (email.length > 255) {
            showError('emailError', 'Email must be less than 255 characters');
        } else {
            hideError('emailError');
        }
    });

    document.getElementById('Address').addEventListener('blur', function() {
        const address = this.value.trim();
        if (address === '') {
            showError('addressError', 'Address is required');
        } else if (address.length > 255) {
            showError('addressError', 'Address must be less than 255 characters');
        } else {
            hideError('addressError');
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