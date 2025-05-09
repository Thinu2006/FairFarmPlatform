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

        <div class="bg-white shadow overflow-hidden rounded-xl mt-6 sm:mt-12 mb-4 p-6 sm:p-6 text-sm">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 text-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm" role="alert">
                    <p>{!! nl2br(e(session('error'))) !!}</p>
                </div>
            @endif

            <form action="{{ route('farmer.account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="FullName" class="block text-gray-700 font-medium mb-1 text-sm">Full Name</label>
                        <input type="text" id="FullName" name="FullName" value="{{ old('FullName', $farmer->FullName) }}" 
                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-green-700">
                        @error('FullName')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="NIC" class="block text-gray-700 font-medium mb-1 text-sm">NIC</label>
                        <input type="text" id="NIC" name="NIC" value="{{ old('NIC', $farmer->NIC) }}" 
                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-green-700">
                        @error('NIC')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ContactNo" class="block text-gray-700 font-medium mb-1 text-sm">Contact Number</label>
                        <input type="text" id="ContactNo" name="ContactNo" value="{{ old('ContactNo', $farmer->ContactNo) }}" 
                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-green-700">
                        @error('ContactNo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Email" class="block text-gray-700 font-medium mb-1 text-sm">Email</label>
                        <input type="email" id="Email" name="Email" value="{{ old('Email', $farmer->Email) }}" 
                               class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-green-700">
                        @error('Email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="Address" class="block text-gray-700 font-medium mb-1 text-sm">Address</label>
                        <textarea id="Address" name="Address" rows="3" 
                                  class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-green-700">{{ old('Address', $farmer->Address) }}</textarea>
                        @error('Address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6 gap-4">
                    <button type="submit" class="px-4 py-1.5 bg-green-800 text-white rounded-md hover:bg-green-900 transition-colors text-sm">
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection