@extends('layouts.admin')

@section('title', 'Farmer List')

@section('content')
<div class="rounded-2xl bg-gray-50">
    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden sm:rounded-2xl">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Farmer Management</h1>
                    <p class="mt-1 text-sm text-gray-500">View and manage all registered farmers</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-10">
        <!-- Farmers Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="responsive-table">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Full Name
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                NIC
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Contact
                            </th>
                            <th scope="col" class="hidden md:table-cell px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Address
                            </th>
                            <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($farmers as $farmer)
                        <tr class="hover:bg-gray-50">
                            <td data-label="ID" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $farmer->FarmerID }}
                            </td>
                            <td data-label="Full Name" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $farmer->FullName }}
                            </td>
                            <td data-label="NIC" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $farmer->NIC }}
                            </td>
                            <td data-label="Contact" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $farmer->ContactNo }}
                            </td>
                            <td data-label="Address" class="hidden md:table-cell px-4 py-4 text-sm text-gray-500">
                                {{ $farmer->Address }}
                            </td>
                            <td data-label="Email" class="hidden sm:table-cell px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $farmer->Email }}
                            </td>
                            <td data-label="Actions" class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex justify-center space-x-2">
                                    <form action="{{ route('admin.farmer.destroy', $farmer->FarmerID) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this farmer?')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1"
                                            title="Delete Farmer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-3 text-sm font-medium text-gray-900">No farmers found</h3>
                                    <p class="mt-1 text-sm text-gray-500">There are currently no registered farmers.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($farmers instanceof \Illuminate\Pagination\AbstractPaginator && $farmers->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $farmers->links() }}
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
            position: relative; /* Added for absolute positioning */
        }
        
        .responsive-table td {
            display: flex;
            padding: 0.5rem 0;
            border: none;
            align-items: flex-start;
        }
        
        .responsive-table td:before {
            content: attr(data-label) ": ";
            font-weight: 700;
            width: 120px;
            flex-shrink: 0;
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .responsive-table td > div {
            flex-grow: 1;
            word-break: break-word;
        }

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
        .responsive-table td:first-child {
            padding-right: 2.5rem;
        }
    }
</style>
@endsection