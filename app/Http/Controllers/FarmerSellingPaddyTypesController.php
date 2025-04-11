<?php

namespace App\Http\Controllers;

use App\Models\FarmerSellingPaddyType;
use App\Models\PaddyType;
use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerSellingPaddyTypesController extends Controller
{
    /**
     * Display the form for listing a new paddy type.
     */
    public function create()
    {
        // Fetch all paddy types for the dropdown
        $paddyTypes = PaddyType::all();

        // Render the form view and pass the paddy types
        return view('farmer.FarmerPaddyListingForm', compact('paddyTypes'));
    }

    /**
     * Store a newly listed paddy type.
     */
    public function store(Request $request)
    {
        // Check if farmer already has this paddy type listed
        $existingListing = FarmerSellingPaddyType::where('FarmerID', $request->FarmerID)
            ->where('PaddyID', $request->PaddyID)
            ->first();
    
        if ($existingListing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You already have a listing for this paddy type.');
        }
    
        // Validate the form data
        $request->validate([
            'FarmerID' => 'required|exists:farmers,FarmerID',
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ]);
    
        // Save the data to the database
        FarmerSellingPaddyType::create([
            'FarmerID' => $request->FarmerID,
            'PaddyID' => $request->PaddyID,
            'PriceSelected' => $request->PriceSelected,
            'Quantity' => $request->Quantity,
        ]);
    
        // Redirect to the paddy listing page with a success message
        return redirect()->route('farmer.paddy.listing')->with('success', 'Paddy listed successfully!');
    }

    /**
     * Display the form for editing a paddy listing.
     */
    public function edit($id)
    {
        // Find the paddy listing by ID
        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        // Ensure the farmer can only edit their own listings
        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to edit this listing.');
        }

        // Fetch all paddy types for the dropdown
        $paddyTypes = PaddyType::all();

        // Pass the data to the edit view
        return view('farmer.FarmerPaddyListingEdit', compact('paddyListing', 'paddyTypes'));
    }

    /**
     * Update a paddy listing.
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'PaddyID' => 'required|exists:paddy_types,PaddyID',
            'PriceSelected' => 'required|numeric|min:0',
            'Quantity' => 'required|numeric|min:1',
        ]);

        // Find the paddy listing by ID
        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        // Ensure the farmer can only update their own listings
        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to update this listing.');
        }

        // Update the listing
        $paddyListing->update([
            'PaddyID' => $request->PaddyID,
            'PriceSelected' => $request->PriceSelected,
            'Quantity' => $request->Quantity,
        ]);

        // Redirect to the paddy listing page with a success message
        return redirect()->route('farmer.paddy.listing')->with('success', 'Paddy listing updated successfully!');
    }

    /**
     * Delete a paddy listing.
     */
    public function destroy($id)
    {
        // Find the paddy listing by ID
        $paddyListing = FarmerSellingPaddyType::findOrFail($id);

        // Ensure the farmer can only delete their own listings
        if ($paddyListing->FarmerID !== auth()->id()) {
            return redirect()->route('farmer.dashboard')->with('error', 'You are not authorized to delete this listing.');
        }

        // Delete the listing
        $paddyListing->delete();

        // Redirect to the paddy listing page with a success message
        return redirect()->route('farmer.paddy.listing')->with('success', 'Paddy listing deleted successfully!');
    }

    /**
     * Display the paddy listing page.
     */
    public function index()
    {
        // Fetch all paddy listings for the authenticated farmer
        $sellingPaddyTypes = FarmerSellingPaddyType::where('FarmerID', auth()->id())
            ->with('paddyType')
            ->get();

        // Pass the data to the view
        return view('farmer.FarmerPaddyListing', compact('sellingPaddyTypes'));
    }


    /**
     * Display the products page with farmer's selling paddy types.
     */
    public function products(Request $request)
    {
        $query = $request->input('query');
        
        $sellingPaddyTypes = FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->when($query, function ($q) use ($query) {
                return $q->whereHas('paddyType', function ($q) use ($query) {
                    $q->where('PaddyName', 'like', '%' . $query . '%');
                });
            })
            ->get();

        return view('buyer.products', compact('sellingPaddyTypes'));
    }


    /**
     * Display the farmer selections page.
     */
    public function farmerSelections()
    {
        $selections = FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->latest()
            ->paginate(10);
        
        $paddyTypes = PaddyType::all();
        
        return view('admin.farmer.farmer-paddy-selection', compact('selections', 'paddyTypes'));
    }

    /**
     * Delete a farmer selected paddy type.
     */
    public function destroyFarmerSelectedPaddyType($id)
    {
        try {
            $selection = FarmerSellingPaddyType::findOrFail($id);
            $selection->delete();
            
            return redirect()->back()->with('success', 'Paddy selection deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting paddy selection: ' . $e->getMessage());
        }
    }
}