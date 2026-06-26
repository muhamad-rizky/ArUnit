<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($inUnitData as $groupModel => $salesModels) {
            foreach ($salesModels as $salesModel => $colors) {
                foreach ($colors as $color) {
                    \App\Models\InUnit::create([
                        'group_model' => $groupModel,
                        'sales_model' => $salesModel,
                        'warna' => $color,
                    ]);
                }
            }
        }
    }
}
