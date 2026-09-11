<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'habis')  $query->where('stock', 0);
            if ($request->stock === 'rendah') $query->whereBetween('stock', [1, 10]);
            if ($request->stock === 'aman')   $query->where('stock', '>', 10);
        }

        $medicines = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('obat.index', compact('medicines'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|max:30|unique:medicines,code',
            'name'        => 'required|string|max:150',
            'unit'        => 'required|string|max:30',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'code.unique' => 'Kode obat sudah terdaftar.',
        ]);

        Medicine::create($request->only('code', 'name', 'unit', 'stock', 'price', 'description'));

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function show(Medicine $obat)
    {
        return view('obat.show', compact('obat'));
    }

    public function edit(Medicine $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, Medicine $obat)
    {
        $request->validate([
            'code'        => ['required', 'string', 'max:30', Rule::unique('medicines', 'code')->ignore($obat->id)],
            'name'        => 'required|string|max:150',
            'unit'        => 'required|string|max:30',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $obat->update($request->only('code', 'name', 'unit', 'stock', 'price', 'description'));

        return redirect()->route('obat.show', $obat)
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Medicine $obat)
    {
        if ($obat->prescriptionDetails()->exists()) {
            return back()->withErrors(['delete' => "Obat \"{$obat->name}\" tidak bisa dihapus karena sudah dipakai di resep."]);
        }

        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }

    // Tambah/kurangi stok manual
    public function updateStock(Request $request, Medicine $obat)
    {
        $request->validate([
            'action' => 'required|in:tambah,kurangi',
            'jumlah' => 'required|integer|min:1',
        ]);

        $jumlah = (int) $request->jumlah;

        if ($request->action === 'tambah') {
            $obat->increment('stock', $jumlah);
            $msg = "Stok {$obat->name} berhasil ditambah {$jumlah} {$obat->unit}.";
        } else {
            if ($obat->stock < $jumlah) {
                return back()->withErrors(['stock' => 'Stok tidak mencukupi untuk dikurangi sejumlah itu.']);
            }
            $obat->decrement('stock', $jumlah);
            $msg = "Stok {$obat->name} berhasil dikurangi {$jumlah} {$obat->unit}.";
        }

        return back()->with('success', $msg);
    }
}
