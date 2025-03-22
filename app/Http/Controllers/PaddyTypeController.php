<?php

// PaddyTypeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaddyType;

class PaddyTypeController extends Controller
{
    public function index()
    {
        $paddytypes = PaddyType::all();
        return view('admin.paddy.index', ['paddytypes' => $paddytypes]);

    }

    public function create()
    {
        return view('admin.paddy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'PaddyName' => 'required|string|max:255',
            'MaxPricePerKg' => 'required|numeric|min:0',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $paddy = new PaddyType($request->only(['PaddyName', 'MaxPricePerKg']));

        if ($request->hasFile('Image')) {
            $paddy->Image = $request->file('Image')->store('paddy_images', 'public');
        }

        $paddy->save();
        return redirect()->route('admin.paddy.index')->with('success', 'Paddy type added successfully!');
    }

    public function edit($id)
    {
        $paddy = PaddyType::findOrFail($id);
        return view('admin.paddy.edit', compact('paddy'));
    }

    public function update(Request $request, $id)
    {
        $paddy = PaddyType::findOrFail($id);

        $request->validate([
            'PaddyName' => 'required|string|max:255',
            'MaxPricePerKg' => 'required|numeric|min:0',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $paddy->update($request->only(['PaddyName', 'MaxPricePerKg']));

        if ($request->hasFile('Image')) {
            $paddy->Image = $request->file('Image')->store('paddy_images', 'public');
        }

        $paddy->save();
        return redirect()->route('admin.paddy.index')->with('success', 'Paddy type updated successfully!');
    }

    public function destroy($id)
    {
        $paddy = PaddyType::findOrFail($id);
        $paddy->delete();

        return redirect()->route('admin.paddy.index')->with('success', 'Paddy type deleted successfully!');
    }
}