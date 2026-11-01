<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkStepController extends Controller
{
    public function index(): View
    {
        return view('admin.steps.index', [
            'steps' => WorkStep::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.steps.form', ['step' => new WorkStep]);
    }

    public function edit(WorkStep $step): View
    {
        return view('admin.steps.form', compact('step'));
    }

    public function store(Request $request): RedirectResponse
    {
        WorkStep::query()->create($this->validated($request));

        return redirect()->route('admin.steps.index')->with('success', 'Step added.');
    }

    public function update(Request $request, WorkStep $step): RedirectResponse
    {
        $step->update($this->validated($request));

        return redirect()->route('admin.steps.index')->with('success', 'Step updated.');
    }

    public function destroy(WorkStep $step): RedirectResponse
    {
        $step->delete();

        return redirect()->route('admin.steps.index')->with('success', 'Step removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'step_number' => ['required', 'integer', 'min:1', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]) + ['sort_order' => (int) $request->input('sort_order', 0)];
    }
}
