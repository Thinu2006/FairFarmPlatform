<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaddyType;
use Illuminate\Support\Facades\Storage;

class PaddyTypeController extends Controller
{
    /**
     * Display a listing of paddy types
     */
    public function index()
    {
        return view('admin.paddy.index', [
            'paddytypes' => $this->getAllPaddyTypes()
        ]);
    }

    /**
     * Show the form for creating a new paddy type
     */
    public function create()
    {
        return view('admin.paddy.create');
    }

    /**
     * Store a newly created paddy type
     */
    public function store(Request $request)
    {
        $validated = $this->validatePaddyTypeRequest($request);
        $paddy = $this->createPaddyType($validated);

        if ($request->hasFile('Image')) {
            $this->storePaddyImage($paddy, $request->file('Image'));
        }

        return redirect()->route('admin.paddy.index')
            ->with('success', 'Paddy type added successfully!');
    }

    /**
     * Show the form for editing the specified paddy type
     */
    public function edit($id)
    {
        return view('admin.paddy.edit', [
            'paddy' => $this->getPaddyType($id)
        ]);
    }

    /**
     * Update the specified paddy type
     */
    public function update(Request $request, $id)
    {
        $paddy = $this->getPaddyType($id);
        $validated = $this->validatePaddyTypeRequest($request);

        $paddy->update($validated);

        if ($request->hasFile('Image')) {
            $this->updatePaddyImage($paddy, $request->file('Image'));
        }

        return redirect()->route('admin.paddy.index')
            ->with('success', 'Paddy type updated successfully!');
    }

    /**
     * Remove the specified paddy type
     */
    public function destroy($id)
    {
        $paddy = $this->getPaddyType($id);
        $this->deletePaddyType($paddy);

        return redirect()->route('admin.paddy.index')
            ->with('success', 'Paddy type deleted successfully!');
    }

    // ==================== Protected Helper Methods ====================

    protected function getAllPaddyTypes()
    {
        return PaddyType::all();
    }

    protected function validatePaddyTypeRequest(Request $request)
    {
        return $request->validate([
            'PaddyName' => 'required|string|max:255',
            'MinPricePerKg' => 'required|numeric|min:0',
            'MaxPricePerKg' => 'required|numeric|min:0|gt:MinPricePerKg',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }

    protected function createPaddyType(array $validatedData)
    {
        return PaddyType::create($validatedData);
    }

    protected function storePaddyImage(PaddyType $paddy, $imageFile)
    {
        $paddy->Image = $imageFile->store('paddy_images', 'public');
        $paddy->save();
    }

    protected function getPaddyType($id)
    {
        return PaddyType::findOrFail($id);
    }

    protected function updatePaddyImage(PaddyType $paddy, $imageFile)
    {
        // Delete old image if exists
        if ($paddy->Image) {
            Storage::disk('public')->delete($paddy->Image);
        }

        $paddy->Image = $imageFile->store('paddy_images', 'public');
        $paddy->save();
    }

    protected function deletePaddyType(PaddyType $paddy)
    {
        // Delete associated image if exists
        if ($paddy->Image) {
            Storage::disk('public')->delete($paddy->Image);
        }

        $paddy->delete();
    }
}