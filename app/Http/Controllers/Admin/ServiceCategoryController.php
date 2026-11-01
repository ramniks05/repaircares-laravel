<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.service-categories.index', [
            'categories' => ServiceCategory::query()->withCount('services')->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.service-categories.form', ['category' => new ServiceCategory]);
    }

    public function edit(ServiceCategory $service_category): View
    {
        return view('admin.service-categories.form', ['category' => $service_category]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        ServiceCategory::query()->create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Category added.');
    }

    public function update(Request $request, ServiceCategory $service_category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $service_category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ServiceCategory $service_category): RedirectResponse
    {
        if ($service_category->services()->exists()) {
            return back()->withErrors(['category' => 'Remove or reassign services in this category before deleting.']);
        }

        $service_category->delete();

        return redirect()->route('admin.service-categories.index')->with('success', 'Category removed.');
    }
}
