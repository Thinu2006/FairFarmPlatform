<?php

namespace App\Http\Controllers;

use App\Models\FarmerSellingPaddyType;
use App\Models\PaddyType;
use App\Models\Order;
use Illuminate\Http\Request;

class FarmerSellingPaddyTypesController extends Controller
{
    /**
     * Display form for creating new paddy listing
     */
    public function create()
    {
        return view('farmer.FarmerPaddyListingForm', [
            'paddyTypes' => $this->getAllPaddyTypes()
        ]);
    }

    /**
     * Store new paddy listing
     */
    public function store(Request $request)
    {
        $validated = $this->validatePaddyListingRequest($request);
    
        if ($this->hasExistingListing($request->FarmerID, $request->PaddyID)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You already have a listing for this paddy type.');
        }

        $this->createPaddyListing($validated); // Use the returned validated data

        return redirect()->route('farmer.paddy.listing')
            ->with('success', 'Paddy listed successfully!');
    }

    /**
     * Show form for editing paddy listing
     */
    public function edit($id)
    {
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        return view('farmer.FarmerPaddyListingEdit', [
            'paddyListing' => $paddyListing,
            'paddyTypes' => $this->getAllPaddyTypes()
        ]);
    }

    /**
     * Update paddy listing
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validatePaddyListingRequest($request, false);
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        $paddyListing->update($validated);

        return redirect()->route('farmer.paddy.listing')
            ->with('success', 'Paddy listing updated successfully!');
    }

    /**
     * Delete paddy listing
     */
    public function destroy($id)
    {
        $paddyListing = $this->getPaddyListing($id);
        $this->authorizeListingAccess($paddyListing);

        $paddyListing->delete();

        return redirect()->route('farmer.paddy.listing')
            ->with('success', 'Paddy listing deleted successfully!');
    }

    /**
     * Display paddy listings for farmer
     */
    public function index()
    {
        $listings = $this->getFarmerListingsWithPendingOrders();
        return view('farmer.FarmerPaddyListing', compact('listings'));
    }

    /**
     * Display products page with available paddy types
     */
    public function products(Request $request)
    {
        return view('buyer.products', [
            'sellingPaddyTypes' => $this->getAvailablePaddyListings($request->input('query'))
        ]);
    }

    /**
     * Display farmer selections for admin
     */
    public function farmerSelections()
    {
        return view('admin.farmer.farmer-paddy-selection', [
            'selections' => $this->getPaginatedFarmerSelections(),
            'paddyTypes' => $this->getAllPaddyTypes()
        ]);
    }

    /**
     * Delete farmer selected paddy type (admin)
     */
    public function destroyFarmerSelectedPaddyType($id)
    {
        try {
            $selection = $this->getPaddyListing($id);
            $selection->delete();
            
            return redirect()->back()
                ->with('success', 'Paddy selection deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting paddy selection: ' . $e->getMessage());
        }
    }

    // ==================== Protected Helper Methods ====================

    protected function getAllPaddyTypes()
    {
        return PaddyType::all();
    }

    protected function validatePaddyListingRequest(Request $request, $includeFarmerId = true)
    {
        $rules = [
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ];

        if ($includeFarmerId) {
            $rules['FarmerID'] = 'required|exists:farmers,FarmerID';
        }

        return $request->validate($rules); // Returns validated data
    }

    protected function hasExistingListing($farmerId, $paddyId)
    {
        return FarmerSellingPaddyType::where('FarmerID', $farmerId)
            ->where('PaddyID', $paddyId)
            ->exists();
    }

    protected function createPaddyListing(array $data)
    {
        return FarmerSellingPaddyType::create($data);
    }

    protected function getPaddyListing($id)
    {
        return FarmerSellingPaddyType::findOrFail($id);
    }

    protected function authorizeListingAccess(FarmerSellingPaddyType $listing)
    {
        if ($listing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')
                ->with('error', 'You are not authorized to access this listing.');
        }
    }

    protected function getFarmerListingsWithPendingOrders()
    {
        $listings = FarmerSellingPaddyType::where('FarmerID', auth()->id())
            ->with(['paddyType'])
            ->get();

        return $listings->map(function ($listing) {
            $listing->has_pending_orders = $this->hasPendingOrders($listing->PaddyID);
            $listing->pending_orders_count = $this->countPendingOrders($listing->PaddyID);
            return $listing;
        });
    }

    protected function hasPendingOrders($paddyId)
    {
        return $this->countPendingOrders($paddyId) > 0;
    }

    protected function countPendingOrders($paddyId)
    {
        return Order::where('farmer_id', auth()->id())
            ->where('paddy_type_id', $paddyId)
            ->where('status', 'pending')
            ->count();
    }

    protected function getAvailablePaddyListings($searchQuery = null)
    {
        return FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->where('Quantity', '>', 0)
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->whereHas('paddyType', function ($q) use ($searchQuery) {
                    $q->where('PaddyName', 'like', '%' . $searchQuery . '%');
                });
            })
            ->get();
    }

    protected function getPaginatedFarmerSelections()
    {
        return FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->latest()
            ->paginate(10);
    }
}