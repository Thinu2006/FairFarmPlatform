<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\PaddyType;
use App\Models\FarmerSellingPaddyType;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::all();
        return view('admin.farmer.index', ['farmers' => $farmers]);
    }

    /**
     * Display the farmer dashboard.
     */
    public function dashboard()
    {
        // Fetch all paddy types for the dropdown
        $paddyTypes = PaddyType::all();

        // Fetch the paddy listings for the authenticated farmer
        $sellingPaddyTypes = FarmerSellingPaddyType::where('FarmerID', auth()->id())
            ->with('paddyType')
            ->get();

        return view('farmer.dashboard', compact('paddyTypes', 'sellingPaddyTypes'));
    }

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

        // Redirect to the dashboard with a success message
        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listed successfully!');
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

        // Redirect with a success message
        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listing updated successfully!');
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

        // Redirect with a success message
        return redirect()->route('farmer.dashboard')->with('success', 'Paddy listing deleted successfully!');
    }
}