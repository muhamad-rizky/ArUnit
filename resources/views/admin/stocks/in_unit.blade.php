@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Data IN UNIT</h1>
        <p class="page-subtitle">Referensi Group Model, Sales Model, dan Warna.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px; overflow-x: auto;">
    @php
    $inUnitData = [
        'PU' => [
            'NEW CARRY PU FD' => ['WHITE', 'REAL BLACK', 'SILKY SILVER METALIC'],
            'NEW CARRY PU FD AC PS' => ['WHITE', 'REAL BLACK', 'SILKY SILVER METALIC', 'GRAPHITE GREY METALLIC'],
            'NEW CARRY PU WD' => ['WHITE', 'REAL BLACK', 'SILKY SILVER METALIC'],
            'NEW CARRY PU WD PS' => ['WHITE', 'REAL BLACK', 'SILKY SILVER METALIC', 'GRAPHITE GREY METALLIC'],
        ],
        'APV' => [
            'APV FE GL AB MT' => ['WHITE', 'SILKY SILVER METALLIC', 'COOL BLACK MET'],
            'APV FE GE PS AB MT' => ['WHITE', 'SILKY SILVER METALLIC', 'COOL BLACK MET'],
            'APV FE GX AB MT' => ['WHITE', 'SILKY SILVER METALLIC', 'COOL BLACK MET'],
            'APV FE GE PS DEL.VAN MT (BLINDVAN)' => ['WHITE', 'SILKY SILVER METALLIC', 'COOL BLACK MET'],
        ],
        'XL7' => [
            'NEW XL-7 ZETA AT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2'],
            'NEW XL-7 BETA AT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2'],
            'NEW XL-7 ALPHA AT HYBRID 2TONE' => ['WHITE + BLACK TOP', 'DUMMY.SAVANA IVORY 2', 'RISING ORANGE PEARL METALLIC'],
            'NEW XL-7 ALPHA AT HYBRID' => ['COOL BLACK MET'],
            'NEW XL-7 ALPHA MT HYBRID 2TONE' => ['WHITE + BLACK TOP', 'DUMMY.SAVANA IVORY 2', 'RISING ORANGE PEARL METALLIC'],
            'NEW XL-7 ALPHA MT HYBRID' => ['COOL BLACK MET'],
            'NEW XL-7 KURO EDITION AT HYBRID' => ['WHITE + BLACK TOP', 'DUMMY.SAVANA IVORY 2', 'COOL BLACK MET'],
        ],
        'FRONX' => [
            'FRONX SGX AT' => ['COOL BLACK MET', 'SNOW WHITE', 'SAVANA IVORY'],
            'FRONX SGX AT 2TONE' => ['WHITE + BLACK TOP', 'DUMMY.SAVANA IVORY 2', 'ICE GRAYISH BLUE'],
            'FRONX GL MT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2'],
            'FRONX GL AT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2'],
            'FRONX GX MT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2', 'SAVANA IVORY'],
            'FRONX GX AT' => ['COOL BLACK MET', 'SNOW WHITE', 'MET.MAGMA GRAY 2', 'SAVANA IVORY'],
        ],
        'GRAND VITARA' => [
            'GRAND VITARA MC GX AT' => ['PRL.MIDNIGHT BLACK', 'PEARL CAVE BLACK'],
            'GRAND VITARA MC GX AT 2TONE' => ['PRL.ARCTIC WHITE/PRL.MIDNIGHT BLACK', 'PRME SPLENDID SILVER/PRL.MIDNIGHT BLACK'],
        ],
        'S-PRESSO' => [
            'S-PRESSO AT' => ['WHITE', 'SILKY SILVER METALLIC', 'SOLID FIRE RED', 'GRANITE GRAY METALLIC'],
            'S-PRESSO MT' => ['WHITE', 'SILKY SILVER METALLIC', 'SOLID FIRE RED', 'GRANITE GRAY METALLIC'],
        ],
        'JIMNY' => [
            'JIMNY 3D AT' => ['BLUEISH BLACK PEARL 3', 'SLD.MEDIUM GRAY', 'SLD.JUNGLE GREEN', 'WHITE', 'SILKY SILVER METALLIC'],
            'JIMNY 3D AT 2TONE' => ['MET.CHIFFON IVORY/PRL.BLUISH BLACK 3', 'MET.BRISK BLUE/PRL.BLUISH BLACK 3', 'SLD. KINETIC YELLOW/PRL.BLUISH BLACK 3'],
            'JIMNY 5D AT' => ['SLD JUNGLE GREEN 2', 'PRL.BLUISH BLACK 4', 'GRANITE GRAY METALLIC'],
            'JIMNY 5D AT 2TONE' => ['SLD.KINETIC YELLOW 2/PRL.BLUISH BLACK 4', 'MET.CHIFFON IVORY 2/PRL.BLUISH 4', 'MET.SIZZLING RED/PRL BLUISH BLACK 4'],
        ],
    ];
    @endphp

    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">GROUP MODEL</th>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">SALES MODEL</th>
                <th style="border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #e2e8f0; font-weight: 700;">Warna</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inUnitData as $groupModel => $salesModels)
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
                    @foreach($colors as $color)
                        <tr>
                            @if($isFirstGroup)
                                <td rowspan="{{ $groupRowspan }}" style="border: 1px solid #cbd5e1; padding: 8px 12px; vertical-align: middle; text-align: center; font-weight: 600;">{{ $groupModel }}</td>
                                @php $isFirstGroup = false; @endphp
                            @endif
                            @if($isFirstSales)
                                <td rowspan="{{ $salesRowspan }}" style="border: 1px solid #cbd5e1; padding: 8px 12px; vertical-align: middle; text-align: center; background: #dcfce7;">{{ $salesModel }}</td>
                                @php $isFirstSales = false; @endphp
                            @endif
                            <td style="border: 1px solid #cbd5e1; padding: 8px 12px; text-align: center;">{{ $color }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
