<?php

namespace App\Http\Controllers;

use App\Models\LandCoverType;
use Illuminate\Http\Request;

class LandCoverTypeController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $landCoverTypes = LandCoverType::orderBy('sort_order')->paginate(15);

        return view('admin.land-cover-types', [
            'landCoverTypes' => $landCoverTypes,
            'pageTitle' => 'Tipe Tutupan Lahan',
        ]);
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.land-cover-types-form', ['mode' => 'create']);
    }

    public function edit(LandCoverType $landCoverType)
    {
        $this->authorizeAdmin();

        return view('admin.land-cover-types-form', [
            'landCoverType' => $landCoverType,
            'mode' => 'edit',
        ]);
    }

    public function destroy(LandCoverType $landCoverType)
    {
        $this->authorizeAdmin();
        $landCoverType->delete();

        return redirect()->route('admin.landCoverTypes.index')
            ->with('success', 'Tipe tutupan lahan berhasil dihapus.');
    }

    protected function authorizeAdmin(): void
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }
    }
}
