<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;


class BuyerController extends Controller
{
    public function index()
    {
        $buyers = Buyer::all();
        return view('admin.buyer.index', ['buyers' => $buyers]);
    }

    public function destroy($id)
    {
        $buyer = Buyer::findOrFail($id);
        $buyer->delete();
        return redirect()->route('admin.buyer.index')->with('success', 'Buyer deleted successfully.');

    }
}
