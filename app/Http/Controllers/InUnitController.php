<?php

namespace App\Http\Controllers;

use App\Models\InUnit;
use Illuminate\Http\Request;

class InUnitController extends Controller
{
    public function index()
    {
        $inUnits = InUnit::orderBy('group_model')->orderBy('sales_model')->orderBy('warna')->get();
        return view('admin.stocks.in_unit', compact('inUnits'));
    }

    public function create()
    {
        return view('admin.stocks.in_unit_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_model' => 'required|string|max:255',
            'sales_model' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
        ]);

        InUnit::create($request->all());

        return redirect()->route('admin.in-units.index')->with('success', 'Data In Unit berhasil ditambahkan.');
    }

    public function edit(InUnit $inUnit)
    {
        return view('admin.stocks.in_unit_edit', compact('inUnit'));
    }

    public function update(Request $request, InUnit $inUnit)
    {
        $request->validate([
            'group_model' => 'required|string|max:255',
            'sales_model' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
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
