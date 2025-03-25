@extends('layouts.admin')

@section('title', 'Farmer Paddy Selections')

@section('content')
<div class="rounded-2xl bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl mb-4">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg md:text-2xl font-bold text-gray-900">Farmer Paddy Listings</h1>
                    <p class="mt-1 text-xs md:text-sm text-gray-500">Manage all paddy selections from farmers</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-10">
        <!-- Farmer Selections Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="responsive-table">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Farmer
                            </th>
                            <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paddy Type
                            </th>
                            <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty (kg)
                            </th>
                            <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price (Rs/1kg)
                            </th>
                            <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($selections as $selection)
                        <tr class="hover:bg-gray-50">
                            <td data-label="Farmer" class="px-3 py-3 md:px-6 md:py-4 whitespace-normal">
                                <div class="flex items-center">
                                    <div class="hidden md:flex flex-shrink-0 h-8 w-8 md:h-9 md:w-9 rounded-full bg-green-100 items-center justify-center">
                                        <span class="text-green-600 font-medium text-sm md:text-base">{{ substr($selection->farmer->FullName, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-0 md:ml-3">
                                        <div class="text-[15px] md:text-sm font-medium text-gray-900">{{ $selection->farmer->FullName }}</div>
                                        <div class="text-sm md:text-xs text-gray-500">ID: {{ $selection->FarmerID }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Paddy Type" class="px-3 py-3 md:px-6 md:py-4 whitespace-normal">
                                <div class="flex items-center">
                                    @if($selection->paddyType->Image)
                                        <img class="hidden md:block h-6 w-6 md:h-8 md:w-8 rounded-md object-cover mr-1 md:mr-2" 
                                            src="{{ asset('storage/' . $selection->paddyType->Image) }}" 
                                            alt="{{ $selection->paddyType->PaddyName }}">
                                    @endif
                                    <div>
                                        <div class="text-[15px] md:text-sm font-medium text-gray-900">{{ $selection->paddyType->PaddyName }}</div>
                                        <div class="text-sm md:text-xs text-gray-500">ID: {{ $selection->paddyType->PaddyID }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Qty (kg)" class="px-3 py-3 md:px-6 md:py-4 whitespace-normal">
                                <div class="text-[15px] md:text-sm text-gray-900">{{ number_format($selection->Quantity) }}</div>
                                <div class="text-xs text-gray-400 hidden md:block">{{ $selection->created_at->format('M d, Y') }}</div>
                            </td>
                            <td data-label="Price (Rs/kg)" class="px-3 py-3 md:px-6 md:py-4 whitespace-normal">
                                <div class="text-[15px] md:text-sm font-medium text-green-600">Rs. {{ number_format($selection->PriceSelected, 2) }}</div>
                                <div class="text-sm md:text-xs font-meduim text-gray-400">Max: Rs. {{ number_format($selection->paddyType->MaxPricePerKg, 2) }}</div>
                            </td>
                            <td data-label="Actions" class="px-3 py-3 md:px-6 md:py-4 whitespace-normal">
                                <div class="flex justify-end md:justify-center">
                                    <form action="{{ route('admin.farmer.paddy.delete', $selection->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this listing? This action cannot be undone.')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1 md:p-2"
                                            title="Delete Listing">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-3 text-sm font-medium text-gray-900">No paddy listings</h3>
                                    <p class="mt-1 text-sm text-gray-500">Farmers haven't submitted any paddy selections yet.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($selections instanceof \Illuminate\Pagination\AbstractPaginator && $selections->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $selections->links() }}
            </div>
            @endif
        </div>
    </main>
</div>

<style>
    /* Responsive table styles */
    @media (max-width: 767px) {
        .responsive-table {
            width: 100%;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .responsive-table thead {
            display: none;
        }
        
        .responsive-table tbody {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .responsive-table tr {
            display: flex;
            flex-direction: column;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .responsive-table td {
            display: flex;
            padding: 0.7rem 0;
            align-items: flex-start;
        }
        
        .responsive-table td:before {
            content: attr(data-label);
            font-weight: 500;
            width: 110px;
            flex-shrink: 0;
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .responsive-table td > div {
            flex-grow: 1;
        }
        
        /* Action buttons */
        .responsive-table td[data-label="Actions"] {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            padding: 0;
            margin: 0;
            border: none;
            justify-content: flex-end;
        }
        
        .responsive-table td[data-label="Actions"]:before {
            display: none;
        }
        
        /* Adjust padding for first cell to account for delete button */
        .responsive-table td:first-child {
            padding-right: 2.5rem;
        }
    }
</style>
@endsection