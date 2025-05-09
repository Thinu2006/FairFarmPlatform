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

    <!-- Success Notification (Hidden by default) -->
    <div id="successNotification" class="hidden fixed top-4 right-4 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-y-0 opacity-100">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">Profile updated successfully!</span>
                <button onclick="hideNotification()" class="ml-4 text-green-700 hover:text-green-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full">
            <!-- Profile Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Profile Information</h3>
                    <p class="mt-1 text-gray-500">Update your account's profile details</p>
                </div>

                <form id="profileForm" action="{{ route('buyer.account.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div class="transition-all duration-300 transform hover:scale-[1.005]">
                            <label for="FullName" class="block text-base font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="FullName" id="FullName" value="{{ old('FullName', $buyer->FullName) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#1F4529] focus:border-[#1F4529] text-gray-700 transition duration-300 hover:border-gray-400">
                        </div>

                        <!-- NIC -->
                        <div class="transition-all duration-300 transform hover:scale-[1.005]">
                            <label for="NIC" class="block text-base font-medium text-gray-700 mb-2">NIC</label>
                            <input type="text" name="NIC" id="NIC" value="{{ old('NIC', $buyer->NIC) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#1F4529] focus:border-[#1F4529] text-gray-700 transition duration-300 hover:border-gray-400">
                        </div>

                        <!-- Contact Number -->
                        <div class="transition-all duration-300 transform hover:scale-[1.005]">
                            <label for="ContactNo" class="block text-base font-medium text-gray-700 mb-2">Contact Number</label>
                            <input type="text" name="ContactNo" id="ContactNo" value="{{ old('ContactNo', $buyer->ContactNo) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#1F4529] focus:border-[#1F4529] text-gray-700 transition duration-300 hover:border-gray-400">
                        </div>

                        <!-- Email -->
                        <div class="transition-all duration-300 transform hover:scale-[1.005]">
                            <label for="Email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="Email" id="Email" value="{{ old('Email', $buyer->Email) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#1F4529] focus:border-[#1F4529] text-gray-700 transition duration-300 hover:border-gray-400">
                        </div>

                        <!-- Address -->
                        <div class="transition-all duration-300 transform hover:scale-[1.005]">
                            <label for="Address" class="block text-base font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="Address" id="Address" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#1F4529] focus:border-[#1F4529] text-gray-700 transition duration-300 hover:border-gray-400">{{ old('Address', $buyer->Address) }}</textarea>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" id="saveButton" class="px-6 py-3 bg-[#1F4529] text-white font-medium rounded-lg hover:bg-[#2f613c] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1F4529] transform hover:scale-105 active:scale-95 transition duration-300">
                                <span id="buttonText">Save Changes</span>
                                <span id="buttonSpinner" class="hidden"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Delete Account Section -->
            <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Delete Account</h3>
                    <p class="mt-1 text-gray-500">Permanently remove your account and all associated data</p>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h4 class="text-base font-medium text-gray-800">Are you sure you want to delete your account?</h4>
                            <p class="mt-1 text-gray-600">Once deleted, all your information will be permanently erased.</p>
                        </div>
                        <button onclick="showDeleteConfirmation()" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 active:scale-95 transition duration-300">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
    
    <div class="modal-content bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative z-10">
        <div class="text-center">
            <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Confirm Account Deletion</h3>
            <p class="text-gray-600 mb-6">This action cannot be undone. All your data will be permanently removed.</p>
            
            <div class="flex justify-center space-x-4">
                <button onclick="hideDeleteConfirmation()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition-colors">
                    Cancel
                </button>
                <form action="{{ route('buyer.account.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Delete confirmation functions
    function showDeleteConfirmation() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideDeleteConfirmation() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteConfirmation();
        }
    });

    // Form submission with loading spinner
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const button = document.getElementById('saveButton');
        const buttonText = document.getElementById('buttonText');
        const spinner = document.getElementById('buttonSpinner');
        
        // Show loading state
        button.disabled = true;
        buttonText.textContent = 'Saving...';
        spinner.classList.remove('hidden');
        
        // Simulate form submission (remove this in production)
        setTimeout(() => {
            // In a real application, this would be handled by the form submission response
            showSuccessNotification();
            
            // Reset button state
            button.disabled = false;
            buttonText.textContent = 'Save Changes';
            spinner.classList.add('hidden');
        }, 1500);
    });

    // Success notification functions
    function showSuccessNotification() {
        const notification = document.getElementById('successNotification');
        notification.classList.remove('hidden');
        notification.classList.add('animate__animated', 'animate__fadeInRight');
        
        // Auto-hide after 5 seconds
        setTimeout(hideNotification, 5000);
    }

    function hideNotification() {
        const notification = document.getElementById('successNotification');
        notification.classList.add('animate__animated', 'animate__fadeOutRight');
        
        // Wait for animation to complete before hiding
        setTimeout(() => {
            notification.classList.add('hidden');
            notification.classList.remove('animate__animated', 'animate__fadeOutRight');
        }, 500);
    }
</script>

<!-- Animate.css for notification animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection