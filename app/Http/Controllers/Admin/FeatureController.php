<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.features.index', [
            'features' => Feature::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.features.form', ['feature' => new Feature]);
    }

    public function edit(Feature $feature): View
    {
        return view('admin.features.form', compact('feature'));
    }

    public function store(Request $request): RedirectResponse
    {
        Feature::query()->create($this->validated($request));

        return redirect()->route('admin.features.index')->with('success', 'Feature added.');
    }

    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $feature->update($this->validated($request));

        return redirect()->route('admin.features.index')->with('success', 'Feature updated.');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        return redirect()->route('admin.features.index')->with('success', 'Feature removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'badge_one' => ['nullable', 'string', 'max:255'],
            'badge_two' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]) + ['sort_order' => (int) $request->input('sort_order', 0)];
    }
}
