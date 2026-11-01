<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatCounter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatController extends Controller
{
    public function index(): View
    {
        return view('admin.stats.index', [
            'stats' => StatCounter::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.stats.form', ['stat' => new StatCounter]);
    }

    public function edit(StatCounter $stat): View
    {
        return view('admin.stats.form', compact('stat'));
    }

    public function store(Request $request): RedirectResponse
    {
        StatCounter::query()->create($this->validated($request));

        return redirect()->route('admin.stats.index')->with('success', 'Stat added.');
    }

    public function update(Request $request, StatCounter $stat): RedirectResponse
    {
        $stat->update($this->validated($request));

        return redirect()->route('admin.stats.index')->with('success', 'Stat updated.');
    }

    public function destroy(StatCounter $stat): RedirectResponse
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')->with('success', 'Stat removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:50'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]) + ['sort_order' => (int) $request->input('sort_order', 0)];
    }
}
