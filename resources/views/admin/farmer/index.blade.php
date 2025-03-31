@extends('layouts.admin')

@section('title', 'Farmer List')

@section('content')
<div class="rounded-2xl bg-gray-50 md:p-4 p-1">
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Confirm Deletion</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this farmer? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white shadow overflow-hidden rounded-xl md:text-left text-center">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between justify-center">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900">Farmer Management</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-8 md:mt-12">
        <!-- Farmers Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="responsive-table">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                ID
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                Full Name
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                NIC
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                Contact
                            </th>
                            <th scope="col" class="hidden md:table-cell px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase ">
                                Address
                            </th>
                            <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-sm font-bold text-gray-800 uppercase">
                                Email
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-sm font-bold text-gray-800 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($farmers as $farmer)
                        <tr class="hover:bg-gray-50">
                            <td data-label="ID" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $farmer->FarmerID }}
                            </td>
                            <td data-label="Full Name" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $farmer->FullName }}
                            </td>
                            <td data-label="NIC" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $farmer->NIC }}
                            </td>
                            <td data-label="Contact" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $farmer->ContactNo }}
                            </td>
                            <td data-label="Address" class="hidden md:table-cell px-4 py-4 text-sm text-gray-900">
                                {{ $farmer->Address }}
                            </td>
                            <td data-label="Email" class="hidden sm:table-cell px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $farmer->Email }}
                            </td>
                            <td data-label="Actions" class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="showDeleteModal('{{ route('admin.farmer.destroy', $farmer->FarmerID) }}')"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1"
                                        title="Delete Farmer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-state-row">
                            <td colspan="7" class="px-6 py-8 text-center w-full">
                                <div class="flex flex-col items-center justify-center w-full">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-base font-bold text-gray-900 font-merriweather">No Farmers Found</h3>
                                    <p class="mt-2 text-sm text-gray-500 font-open-sans">There are currently no registered farmers.</p>
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
            position: relative;
        }
        
        .responsive-table tr.empty-state-row {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
            border: none;
            box-shadow: none;
            padding: 0;
        }
        
        .responsive-table td {
            display: flex;
            padding: 0.5rem 0;
            border: none;
            align-items: flex-start;
        }
        
        .responsive-table tr.empty-state-row td {
            display: block;
            width: 100%;
            padding: 0;
            text-align: center;
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
        
        .responsive-table tr.empty-state-row td:before {
            display: none;
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

<script>
    function showDeleteModal(url) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection