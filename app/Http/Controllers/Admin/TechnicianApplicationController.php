<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnicianApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianApplicationController extends Controller
{
    public function index(): View
    {
        return view('admin.technician-applications.index', [
            'applications' => TechnicianApplication::query()
                ->with('city')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function show(TechnicianApplication $technicianApplication): View
    {
        $technicianApplication->load('city');

        return view('admin.technician-applications.show', [
            'application' => $technicianApplication,
        ]);
    }

    public function update(Request $request, TechnicianApplication $technicianApplication): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,reviewing,approved,rejected'],
        ]);

        $technicianApplication->update($data);

        return back()->with('success', 'Application status updated.');
    }

    public function destroy(TechnicianApplication $technicianApplication): RedirectResponse
    {
        $technicianApplication->delete();

        return redirect()->route('admin.technician-applications.index')->with('success', 'Application deleted.');
    }
}
