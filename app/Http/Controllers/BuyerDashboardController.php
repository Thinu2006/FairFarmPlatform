<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\FarmerSellingPaddyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BuyerDashboardController extends Controller
{
    /**
     * Display buyer dashboard with top selling paddy types
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('buyer.dashboard', [
            'topSellingPaddies' => $this->getTopSellingPaddyTypes()
        ]);
    }

    /**
     * Show buyer account details
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        return view('buyer.account', [
            'buyer' => $this->getAuthenticatedBuyer()
        ]);
    }

    /**
     * Update buyer account information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request)
    {
        $buyer = $this->getAuthenticatedBuyer();
        $validated = $this->validateAccountUpdateRequest($request, $buyer);
        
        $this->updateBuyerAccount($buyer, $validated);
        
        return back()->with('success', 'Account updated successfully!');
    }

    // ==================== Protected Helper Methods ====================

    /**
     * Get top selling paddy types
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getTopSellingPaddyTypes()
    {
        return FarmerSellingPaddyType::with(['farmer', 'paddyType'])
            ->where('Quantity', '>', 0)
            ->withCount(['orders as total_orders'])
            ->withSum('orders as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();
    }

    /**
     * Get authenticated buyer instance
     *
     * @return \App\Models\Buyer
     */
    protected function getAuthenticatedBuyer()
    {
        return auth('buyer')->user();
    }

    /**
     * Validate account update request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyer  $buyer
     * @return array
     */
    protected function validateAccountUpdateRequest(Request $request, Buyer $buyer)
    {
        return $request->validate([
            'FullName' => 'required',
            'NIC' => [
                'required',
                'string',
                'max:12',
                'regex:/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/',
                Rule::unique('buyers', 'NIC')->ignore($buyer->BuyerID, 'BuyerID')
            ],
            'ContactNo' => 'required|string|max:15|regex:/^[0-9]{10}$/',
            'Address' => 'required|string|max:255',
            'Email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('buyers', 'Email')->ignore($buyer->BuyerID, 'BuyerID')
            ],
        ], $this->validationMessages());
    }

    /**
     * Get validation error messages
     *
     * @return array
     */
    protected function validationMessages()
    {
        return [
            'NIC.regex' => 'Please enter a valid NIC number (old 10-digit or new 12-digit format)',
            'ContactNo.regex' => 'Please enter a valid 10-digit phone number',
        ];
    }

    /**
     * Update buyer account information
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  array  $validatedData
     * @return void
     */
    protected function updateBuyerAccount(Buyer $buyer, array $validatedData)
    {
        $buyer->update($validatedData);
    }
}