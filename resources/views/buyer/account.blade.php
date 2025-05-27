@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="max-w-7xl mx-auto px-0 sm:px-6 py-4 sm:py-12 mb-20">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('buyer.dashboard') }}" class="inline-flex items-center text-lg font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Success Notification -->
    @if(session('success'))
    <div id="successNotification" class="fixed top-4 right-4 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="hideNotification()" class="ml-4 text-green-700 hover:text-green-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full">
            <!-- Profile Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Profile Information</h3>
                    <p class="mt-1 text-gray-500">Update your profile details</p>
                </div>

                <form id="profileForm" action="{{ route('buyer.account.update') }}" method="POST" class="p-6" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="FullName" class="block text-base font-bold text-gray-700 mb-2">Full Name :</label>
                            <input type="text" name="FullName" id="FullName" value="{{ old('FullName', $buyer->FullName) }}"
                                   class="block w-full p-2 border rounded-lg focus:outline-green-600"
                                   required />
                            <div id="fullNameError" class="error-message"></div>
                            @error('FullName')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIC -->
                        <div>
                            <label for="NIC" class="block text-base font-bold text-gray-700 mb-2">NIC :</label>
                            <input type="text" name="NIC" id="NIC" value="{{ old('NIC', $buyer->NIC) }}"
                                   class="block w-full p-2 border rounded-lg focus:outline-green-600"
                                   required />
                            <div id="nicError" class="error-message"></div>
                            @error('NIC')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="ContactNo" class="block text-base font-bold text-gray-700 mb-2">Contact Number :</label>
                            <input type="text" name="ContactNo" id="ContactNo" value="{{ old('ContactNo', $buyer->ContactNo) }}"
                                   class="block w-full p-2 border rounded-lg focus:outline-green-600"
                                   required />
                            <div id="contactNoError" class="error-message"></div>
                            @error('ContactNo')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="Email" class="block text-base font-bold text-gray-700 mb-2">Email :</label>
                            <input type="email" name="Email" id="Email" value="{{ old('Email', $buyer->Email) }}"
                                   class="block w-full p-2 border rounded-lg focus:outline-green-600"
                                   required />
                            <div id="emailError" class="error-message"></div>
                            @error('Email')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="Address" class="block text-base font-bold text-gray-700 mb-2">Address :</label>
                            <textarea name="Address" id="Address" rows="4"
                                      class="block w-full p-2 border rounded-lg focus:outline-green-600"
                                      required>{{ old('Address', $buyer->Address) }}</textarea>
                            <div id="addressError" class="error-message"></div>
                            @error('Address')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-[#1F4529] text-white font-medium rounded-lg hover:bg-[#2f613c] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1F4529] transform hover:scale-105 active:scale-95 transition duration-300">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Validate NIC 
    function validateNIC(nic) {
        // Old NIC format (9 digits + V or X at the end)
        const oldNicPattern = /^[0-9]{9}[vVxX]$/;
        
        // New NIC format (12 digits)
        const newNicPattern = /^[0-9]{12}$/;
        
        return oldNicPattern.test(nic) || newNicPattern.test(nic);
    }

    // Validate Contact Number (Sri Lanka)
    function validateContactNo(contactNo) {
        const cleaned = contactNo.replace(/[+\s-]/g, '');
        const mobilePattern = /^(?:\+94|0|94)?(7[0-9])([0-9]{7})$/;
        return mobilePattern.test(cleaned);
    }

    // Validate Email
    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    // Form validation
    function validateForm() {
        let isValid = true;
        
        // NIC validation
        const nic = document.getElementById('NIC').value.trim();
        const nicError = document.getElementById('nicError');
        if (!validateNIC(nic)) {
            nicError.textContent = 'Please enter a valid NIC (e.g., 123456789V or 200012345678)';
            isValid = false;
        } else {
            nicError.textContent = '';
        }
        
        // Contact number validation
        const contactNo = document.getElementById('ContactNo').value.trim();
        const contactNoError = document.getElementById('contactNoError');
        if (!validateContactNo(contactNo)) {
            contactNoError.textContent = 'Please enter a valid contact number (e.g., 0712345678)';
            isValid = false;
        } else {
            contactNoError.textContent = '';
        }
        
        // Email validation
        const email = document.getElementById('Email').value.trim();
        const emailError = document.getElementById('emailError');
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address';
            isValid = false;
        } else if (email.length > 255) {
            emailError.textContent = 'Email must be less than 255 characters';
            isValid = false;
        } else {
            emailError.textContent = '';
        }
        
        // Address validation
        const address = document.getElementById('Address').value.trim();
        const addressError = document.getElementById('addressError');
        if (address === '') {
            addressError.textContent = 'Address is required';
            isValid = false;
        } else if (address.length > 255) {
            addressError.textContent = 'Address must be less than 255 characters';
            isValid = false;
        } else {
            addressError.textContent = '';
        }
        
        return isValid;
    }

    document.getElementById('NIC').addEventListener('blur', function() {
        const nic = this.value.trim();
        const nicError = document.getElementById('nicError');
        if (!validateNIC(nic)) {
            nicError.textContent = 'Please enter a valid NIC (e.g., 123456789V or 200012345678)';
        } else {
            nicError.textContent = '';
        }
    });

    document.getElementById('ContactNo').addEventListener('blur', function() {
        const contactNo = this.value.trim();
        const contactNoError = document.getElementById('contactNoError');
        if (!validateContactNo(contactNo)) {
            contactNoError.textContent = 'Please enter a valid contact number (e.g., 0712345678)';
        } else {
            contactNoError.textContent = '';
        }
    });

    document.getElementById('Email').addEventListener('blur', function() {
        const email = this.value.trim();
        const emailError = document.getElementById('emailError');
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address';
        } else if (email.length > 255) {
            emailError.textContent = 'Email must be less than 255 characters';
        } else {
            emailError.textContent = '';
        }
    });

    document.getElementById('Address').addEventListener('blur', function() {
        const address = this.value.trim();
        const addressError = document.getElementById('addressError');
        if (address === '') {
            addressError.textContent = 'Address is required';
        } else if (address.length > 255) {
            addressError.textContent = 'Address must be less than 255 characters';
        } else {
            addressError.textContent = '';
        }
    });

    // Success notification functions
    function hideNotification() {
        const notification = document.getElementById('successNotification');
        if (notification) {
            notification.classList.add('animate__animated', 'animate__fadeOutRight');
            
            // Wait for animation to complete before hiding
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Auto-hide notification after 5 seconds if it exists
    const notification = document.getElementById('successNotification');
    if (notification) {
        setTimeout(hideNotification, 5000);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    input:invalid, textarea:invalid {
        border-color: #ef4444;
    }
    
    input:valid, textarea:valid {
        border-color: #d1d5db;
    }
</style>
@endsection