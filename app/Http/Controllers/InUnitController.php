<?php

namespace App\Http\Controllers;

use App\Models\InUnit;
use App\Models\Cabang;
use Illuminate\Http\Request;

class InUnitController extends Controller
{
    public function index()
    {
        $inUnits = InUnit::with('cabang')->orderBy('tanggal', 'desc')->orderBy('nama_driver')->get();
        return view('admin.stocks.in_unit', compact('inUnits'));
    }

    public function create()
    {
        $cabangs = Cabang::orderBy('nama')->get();
        return view('admin.stocks.in_unit_create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver'        => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'type'               => 'required|string|max:255',
            'warna'              => 'required|string|max:255',
            'no_rangka'          => 'nullable|string|max:255',
            'no_mesin'           => 'nullable|string|max:255',
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'cabang_id'          => 'nullable|exists:cabangs,id',
            'cekits'             => 'nullable|string|max:255',
            'jam_kedatangan'     => 'nullable|date_format:H:i',
        ]);

        InUnit::create($request->all());

        return redirect()->route('admin.in-units.index')->with('success', 'Data In Unit berhasil ditambahkan.');
    }

    public function edit(InUnit $inUnit)
    {
        $cabangs = Cabang::orderBy('nama')->get();
        return view('admin.stocks.in_unit_edit', compact('inUnit', 'cabangs'));
    }

    public function update(Request $request, InUnit $inUnit)
    {
        $request->validate([
            'nama_driver'        => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'type'               => 'required|string|max:255',
            'warna'              => 'required|string|max:255',
            'no_rangka'          => 'nullable|string|max:255',
            'no_mesin'           => 'nullable|string|max:255',
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'cabang_id'          => 'nullable|exists:cabangs,id',
            'cekits'             => 'nullable|string|max:255',
            'jam_kedatangan'     => 'nullable|date_format:H:i',
        ]);

        $inUnit->update($request->all());

        return redirect()->route('admin.in-units.index')->with('success', 'Data In Unit berhasil diperbarui.');
    }

    public function destroy(InUnit $inUnit)
    {
        $inUnit->delete();

        return redirect()->route('admin.in-units.index')->with('success', 'Data In Unit berhasil dihapus.');
    }
}
