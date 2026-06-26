@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Edit Data IN UNIT</h1>
        <p class="page-subtitle">Silakan ubah form di bawah ini untuk memperbarui data in unit.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px;">
    <form action="{{ route('admin.in-units.update', $inUnit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 16px;">
            <label for="group_model" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Group Model</label>
            <input type="text" name="group_model" id="group_model" value="{{ old('group_model', $inUnit->group_model) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            @error('group_model')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="sales_model" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Sales Model</label>
            <input type="text" name="sales_model" id="sales_model" value="{{ old('sales_model', $inUnit->sales_model) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            @error('sales_model')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label for="warna" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Warna</label>
            <input type="text" name="warna" id="warna" value="{{ old('warna', $inUnit->warna) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            @error('warna')
                <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Update</button>
            <a href="{{ route('admin.in-units.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; border: 1px solid #cbd5e1;">Batal</a>
        </div>
    </form>
</div>
@endsection
