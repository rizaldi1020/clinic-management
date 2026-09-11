<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::withCount(['doctors', 'appointments']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $departments = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('departemen.index', compact('departments'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Nama poli sudah terdaftar.',
        ]);

        Department::create($request->only('name', 'description'));

        return redirect()->route('departemen.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function show(Department $departemen)
    {
        $departemen->load(['doctors.user', 'doctors.schedules']);
        return view('departemen.show', compact('departemen'));
    }

    public function edit(Department $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Department $departemen)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('departments', 'name')->ignore($departemen->id)],
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Nama poli sudah dipakai departemen lain.',
        ]);

        $departemen->update($request->only('name', 'description'));

        return redirect()->route('departemen.index')
            ->with('success', 'Data poli berhasil diperbarui.');
    }

    public function destroy(Department $departemen)
    {
        // Cegah hapus kalau masih ada dokter terdaftar
        if ($departemen->doctors()->exists()) {
            return back()->withErrors([
                'delete' => "Poli \"{$departemen->name}\" tidak bisa dihapus karena masih memiliki dokter terdaftar."
            ]);
        }

        $departemen->delete();

        return redirect()->route('departemen.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}
