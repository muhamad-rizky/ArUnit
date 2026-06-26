@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Tambah Data IN UNIT</h1>
        <p class="page-subtitle">Silakan isi form di bawah ini untuk menambahkan data in unit baru.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px;">
    <form action="{{ route('admin.in-units.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 16px;">
            <label for="group_model" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Group Model</label>
            <input type="text" name="group_model" id="group_model" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;" placeholder="Contoh: PU">
            @error('group_model')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="sales_model" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Sales Model</label>
            <input type="text" name="sales_model" id="sales_model" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;" placeholder="Contoh: NEW CARRY PU FD">
            @error('sales_model')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label for="warna" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Warna</label>
            <input type="text" name="warna" id="warna" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;" placeholder="Contoh: WHITE">
            @error('warna')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Simpan</button>
            <a href="{{ route('admin.in-units.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; border: 1px solid #cbd5e1;">Batal</a>
        </div>
    </form>
</div>
@endsection
