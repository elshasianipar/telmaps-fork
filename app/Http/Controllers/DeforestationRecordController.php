<?php

namespace App\Http\Controllers;

use App\Models\DeforestationRecord;
use App\Models\Region;
use App\Models\LandCoverType;
use Illuminate\Http\Request;

class DeforestationRecordController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $records = DeforestationRecord::with(['region', 'landCoverType'])
            ->when($request->input('year'), fn ($q) => $q->byYear((int) $request->input('year')))
            ->when($request->input('region_id'), fn ($q) => $q->byRegion((int) $request->input('region_id')))
            ->when($request->input('change_type'), fn ($q) => $q->byChangeType($request->input('change_type')))
            ->orderBy('year', 'desc')
            ->paginate(15)
            ->withQueryString();

        $regions = Region::orderBy('name')->get();
        $landCoverTypes = LandCoverType::orderBy('name')->get();

        return view('admin.deforestation-records', [
            'records' => $records,
            'regions' => $regions,
            'landCoverTypes' => $landCoverTypes,
            'pageTitle' => 'Rekod Deforestasi',
        ]);
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.deforestation-records-form', [
            'regions' => Region::orderBy('name')->get(),
            'landCoverTypes' => LandCoverType::orderBy('name')->get(),
            'mode' => 'create',
        ]);
    }

    public function edit(DeforestationRecord $deforestationRecord)
    {
        $this->authorizeAdmin();

        return view('admin.deforestation-records-form', [
            'record' => $deforestationRecord,
            'regions' => Region::orderBy('name')->get(),
            'landCoverTypes' => LandCoverType::orderBy('name')->get(),
            'mode' => 'edit',
        ]);
    }

    public function destroy(DeforestationRecord $deforestationRecord)
    {
        $this->authorizeAdmin();
        $deforestationRecord->delete();

        return redirect()->route('admin.deforestationRecords.index')
            ->with('success', 'Rekod deforestasi berhasil dihapus.');
    }

    protected function authorizeAdmin(): void
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }
    }
}
