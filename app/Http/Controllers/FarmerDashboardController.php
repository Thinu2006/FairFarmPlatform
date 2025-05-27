<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FarmerDashboardController extends Controller
{
    /**
     * Show farmer account details
     * 
     * @return \Illuminate\View\View
     */
    public function account()
    {
        return view('farmer.account', [
            'farmer' => $this->getAuthenticatedFarmer()
        ]);
    }

    /**
     * Update farmer account information
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request)
    {
        $farmer = $this->getAuthenticatedFarmer();
        $validatedData = $this->validateAccountUpdateRequest($request, $farmer);
        
        $this->updateFarmerAccount($farmer, $validatedData);
        
        return back()->with('success', 'Account updated successfully!');
    }

    // ==================== Protected Helper Methods ====================

    /**
     * Get authenticated farmer instance
     * 
     * @return \App\Models\Farmer
     */
    protected function getAuthenticatedFarmer()
    {
        return auth('farmer')->user();
    }

    /**
     * Validate account update request
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Farmer $farmer
     * @return array
     */
    protected function validateAccountUpdateRequest(Request $request, Farmer $farmer)
    {
        return $request->validate([
            'FullName' => 'required|string|max:255',
            'NIC' => $this->getNicValidationRules($farmer),
            'ContactNo' => $this->getContactNoValidationRules(),
            'Address' => 'required|string|max:255',
            'Email' => $this->getEmailValidationRules($farmer),
        ], $this->getValidationMessages());
    }

    /**
     * Get NIC validation rules
     * 
     * @param \App\Models\Farmer $farmer
     * @return array
     */
    protected function getNicValidationRules(Farmer $farmer)
    {
        return [
            'required',
            'string',
            'max:12',
            'regex:/^([0-9]{9}[xXvV]|[0-9]{12})$/',
            Rule::unique('farmers', 'NIC')->ignore($farmer->FarmerID, 'FarmerID')
        ];
    }

    /**
     * Get contact number validation rules
     * 
     * @return array
     */
    protected function getContactNoValidationRules()
    {
        return [
            'required',
            'string',
            'max:15',
            'regex:/^[0-9]{10}$/'
        ];
    }

    /**
     * Get email validation rules
     * 
     * @param \App\Models\Farmer $farmer
     * @return array
     */
    protected function getEmailValidationRules(Farmer $farmer)
    {
        return [
            'required',
            'email',
            'max:255',
            Rule::unique('farmers', 'Email')->ignore($farmer->FarmerID, 'FarmerID')
        ];
    }

    /**
     * Get validation error messages
     * 
     * @return array
     */
    protected function getValidationMessages()
    {
        return [
            'NIC.regex' => 'Please enter a valid NIC number (old 10-digit or new 12-digit format)',
            'ContactNo.regex' => 'Please enter a valid 10-digit phone number',
        ];
    }

    /**
     * Update farmer account details
     * 
     * @param \App\Models\Farmer $farmer
     * @param array $validatedData
     * @return void
     */
    protected function updateFarmerAccount(Farmer $farmer, array $validatedData)
    {
        $farmer->update($validatedData);
        Log::info('Farmer account updated', ['farmer_id' => $farmer->FarmerID]);
    }
}