<?php

namespace Database\Seeders;

use App\Models\DeforestationRecord;
use App\Models\LandCoverType;
use App\Models\Region;
use Illuminate\Database\Seeder;

class PlatformDataSeeder extends Seeder
{
    /**
     * Curated demo data for the TELF forest-loss monitoring platform:
     * Indonesian provinces (centroid lat/lng), land-cover types with map
     * colours, and deforestation records across 2019–2025 weighted toward
     * known loss hotspots (Riau, Kalimantan, Sumatera Selatan).
     */
    public function run(): void
    {
        if (Region::exists()) {
            return;
        }

        $provinces = [
            // [code, name, lat, lng, area_km2, population, lossWeight]
            ['ID-AC', 'Aceh', 4.6950, 96.7490, 57956, 5400000, 1.0],
            ['ID-SU', 'Sumatera Utara', 2.4840, 99.0180, 72981, 15100000, 1.2],
            ['ID-RI', 'Riau', 0.8970, 101.4460, 87024, 6600000, 2.2],
            ['ID-SB', 'Sumatera Barat', -0.3050, 100.7110, 42013, 5600000, 1.0],
            ['ID-JA', 'Jambi', -1.6860, 103.0740, 50058, 3600000, 1.5],
            ['ID-SS', 'Sumatera Selatan', -3.0420, 104.5580, 91592, 8700000, 2.0],
            ['ID-KB', 'Kalimantan Barat', -0.2790, 111.4730, 147307, 5400000, 1.8],
            ['ID-KT', 'Kalimantan Tengah', -2.2240, 113.9460, 153564, 2700000, 2.1],
            ['ID-KI', 'Kalimantan Timur', 0.5330, 116.4190, 129067, 3900000, 1.9],
            ['ID-JB', 'Jawa Barat', -7.0940, 107.6080, 35377, 49000000, 0.6],
            ['ID-JT', 'Jawa Tengah', -7.0900, 110.0450, 32801, 37000000, 0.5],
            ['ID-ST', 'Sulawesi Selatan', -3.6680, 120.0630, 46717, 9100000, 1.1],
            ['ID-MA', 'Maluku', -3.2380, 129.1430, 46914, 1900000, 1.0],
            ['ID-PA', 'Papua', -4.0660, 138.1140, 319036, 4400000, 1.6],
            ['ID-PB', 'Papua Barat', -1.4750, 133.5260, 99672, 600000, 1.3],
            ['ID-NT', 'Nusa Tenggara Timur', -8.6570, 121.8980, 48718, 5500000, 0.8],
        ];

        $regionIds = [];
        foreach ($provinces as $p) {
            $region = Region::create([
                'code' => $p[0],
                'name' => $p[1],
                'type' => 'province',
                'capital' => null,
                'area_km2' => $p[4],
                'population' => $p[5],
                'latitude' => $p[2],
                'longitude' => $p[3],
                'boundary' => null,
            ]);
            $regionIds[$p[0]] = ['id' => $region->id, 'lossWeight' => $p[6]];
        }

        $coverTypes = [
            // [code, name, color, is_forest, sort_order]
            ['HUT-PRM', 'Hutan Primer', '#1C3A14', true, 1],
            ['HUT-SEC', 'Hutan Sekunder', '#3E6B2A', true, 2],
            ['HUT-MNG', 'Hutan Mangrove', '#4A7C59', true, 3],
            ['KB-SAW', 'Kebun Kelapa Sawit', '#C98A2B', false, 4],
            ['PERT-LK', 'Pertanian Lahan Kering', '#D4B25A', false, 5],
            ['PMK', 'Pemukiman', '#8A8D8C', false, 6],
            ['PDG', 'Padang/Rumput', '#BFAE5E', false, 7],
            ['TBA', 'Tubuh Air', '#3F6B7A', false, 8],
        ];

        $coverIds = [];
        foreach ($coverTypes as $c) {
            $lc = LandCoverType::create([
                'code' => $c[0],
                'name' => $c[1],
                'color' => $c[2],
                'description' => null,
                'is_forest' => $c[3],
                'sort_order' => $c[4],
            ]);
            $coverIds[$c[0]] = $lc->id;
        }

        $forestCoverCodes = ['HUT-PRM', 'HUT-SEC', 'HUT-MNG'];
        $allCoverCodes = array_keys($coverIds);
        $lossCauses = ['Pembalakan ilegal', 'Konversi lahan', 'Perkebunan sawit', 'Kebakaran hutan', 'Tambang', 'Infrastruktur'];
        $gainCauses = ['Reboisasi', 'Restorasi mangrove', 'Rehabilitasi hutan'];
        $sources = ['Landsat 8', 'Sentinel-2', 'MODIS', 'PlanetScope'];

        // Deterministic pseudo-random spread (no Date:: now() needed).
        $years = range(2019, 2025);
        $seed = 20260810;
        $rng = function () use (&$seed) {
            $seed = ($seed * 1103515245 + 12345) & 0x7FFFFFFF;

            return $seed / 0x7FFFFFFF;
        };

        foreach ($regionIds as $code => $meta) {
            $weight = $meta['lossWeight'];
            $count = (int) round(4 + $rng() * 3); // 4–6 records per province
            for ($i = 0; $i < $count; $i++) {
                $year = $years[(int) floor($rng() * count($years))];
                $roll = $rng();
                // loss probability scales with the province's loss weight
                $changeType = $roll < (0.30 + 0.12 * $weight) ? 'loss' : ($roll < 0.78 ? 'stable' : 'gain');

                if ($changeType === 'loss') {
                    $coverCode = $forestCoverCodes[(int) floor($rng() * count($forestCoverCodes))];
                    $area = round(20 + $rng() * 780 * $weight, 2);
                    $cause = $lossCauses[(int) floor($rng() * count($lossCauses))];
                } elseif ($changeType === 'gain') {
                    $coverCode = $forestCoverCodes[(int) floor($rng() * count($forestCoverCodes))];
                    $area = round(2 + $rng() * 90, 2);
                    $cause = $gainCauses[(int) floor($rng() * count($gainCauses))];
                } else {
                    $coverCode = $allCoverCodes[(int) floor($rng() * count($allCoverCodes))];
                    $area = round(1 + $rng() * 120, 2);
                    $cause = null;
                }

                DeforestationRecord::create([
                    'region_id' => $meta['id'],
                    'land_cover_type_id' => $coverIds[$coverCode],
                    'year' => $year,
                    'change_type' => $changeType,
                    'area_km2' => $area,
                    'cause' => $cause,
                    'source' => $sources[(int) floor($rng() * count($sources))],
                    'geometry' => null,
                    'notes' => null,
                ]);
            }
        }
    }
}
