@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Data IN UNIT</h1>
        <p class="page-subtitle">Referensi Group Model, Sales Model, dan Warna.</p>
    </div>
    <div>
        <a href="{{ route('admin.in-units.create') }}" class="btn btn-primary" style="background: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">+ Tambah Data</a>
    </div>
</div>

@if(session('success'))
<div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bbf7d0;">
    {{ session('success') }}
</div>
@endif

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px; overflow-x: auto;">
    @php
    $inUnitData = [];
    foreach($inUnits as $unit) {
        $inUnitData[$unit->group_model][$unit->sales_model][] = [
            'id' => $unit->id,
            'warna' => $unit->warna
        ];
    }
    @endphp

    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">GROUP MODEL</th>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">SALES MODEL</th>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">Warna</th>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700; width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inUnitData as $groupModel => $salesModels)
                @php
                    $groupRowspan = 0;
                    foreach($salesModels as $colors) {
                        $groupRowspan += count($colors);
                    }
                    $isFirstGroup = true;
                @endphp
                @foreach($salesModels as $salesModel => $colors)
                    @php
                        $salesRowspan = count($colors);
                        $isFirstSales = true;
                    @endphp
                    @foreach($colors as $colorData)
                        <tr>
                            @if($isFirstGroup)
                                <td rowspan="{{ $groupRowspan }}" style="border: 1px solid #cbd5e1; padding: 8px 12px; vertical-align: middle; text-align: center; font-weight: 600;">{{ $groupModel }}</td>
                                @php $isFirstGroup = false; @endphp
                            @endif
                            @if($isFirstSales)
                                <td rowspan="{{ $salesRowspan }}" style="border: 1px solid #cbd5e1; padding: 8px 12px; vertical-align: middle; text-align: center; background: #dcfce7;">{{ $salesModel }}</td>
                                @php $isFirstSales = false; @endphp
                            @endif
                            <td style="border: 1px solid #cbd5e1; padding: 8px 12px; text-align: center;">{{ $colorData['warna'] }}</td>
                            <td style="border: 1px solid #cbd5e1; padding: 8px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="{{ route('admin.in-units.edit', $colorData['id']) }}" style="color: #0284c7; text-decoration: none; font-size: 12px; background: #e0f2fe; padding: 4px 8px; border-radius: 4px;">Edit</a>
                                    <form action="{{ route('admin.in-units.destroy', $colorData['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #e11d48; text-decoration: none; font-size: 12px; background: #ffe4e6; padding: 4px 8px; border-radius: 4px; border: none; cursor: pointer;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 24px; color: #64748b;">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
