<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.form', ['slide' => new HeroSlide]);
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.form', ['slide' => $heroSlide]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $image = $data['image_path'] ?? null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('hero-slides', 'public');
        }

        if (! $image) {
            return back()->withErrors(['image' => 'Upload an image or enter an assets path.'])->withInput();
        }

        HeroSlide::query()->create([
            'image' => $image,
            'alt_text' => $data['alt_text'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide added.');
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $payload = [
            'alt_text' => $data['alt_text'] ?? null,
            'sort_order' => $data['sort_order'] ?? $heroSlide->sort_order,
            'is_active' => $request->boolean('is_active', $heroSlide->is_active),
        ];

        if ($request->hasFile('image')) {
            $payload['image'] = $request->file('image')->store('hero-slides', 'public');
        } elseif (! empty($data['image_path'])) {
            $payload['image'] = $data['image_path'];
        }

        $heroSlide->update($payload);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide removed.');
    }
}
