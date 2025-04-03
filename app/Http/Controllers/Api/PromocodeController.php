<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromocodeController extends Controller
{
    public function index()
    {
        return response()->json(Promocode::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promocodes,code',
            'type' => ['required', Rule::in(['percentage', 'fixed'])],
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $promocode = Promocode::create($validated);
        return response()->json($promocode, 201);
    }

    public function show(Promocode $promocode)
    {
        return response()->json($promocode);
    }

    public function update(Request $request, Promocode $promocode)
    {
        $validated = $request->validate([
            'code' => ['string', Rule::unique('promocodes')->ignore($promocode->id)],
            'type' => [Rule::in(['percentage', 'fixed'])],
            'value' => 'numeric|min:0',
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $promocode->update($validated);
        return response()->json($promocode);
    }

    public function destroy(Promocode $promocode)
    {
        $promocode->delete();
        return response()->json(null, 204);
    }
} 