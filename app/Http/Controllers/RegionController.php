<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $regions = Region::with('parent')->orderBy('code')->paginate(15);

        return view('admin.regions', [
            'regions' => $regions,
            'pageTitle' => 'Wilayah',
        ]);
    }

    public function create()
    {
        $this->authorizeAdmin();
        $regions = Region::orderBy('name')->get();

        return view('admin.regions-form', [
            'regions' => $regions,
            'mode' => 'create',
        ]);
    }

    public function edit(Region $region)
    {
        $this->authorizeAdmin();
        $regions = Region::where('id', '!=', $region->id)->orderBy('name')->get();

        return view('admin.regions-form', [
            'region' => $region,
            'regions' => $regions,
            'mode' => 'edit',
        ]);
    }

    public function destroy(Region $region)
    {
        $this->authorizeAdmin();
        $region->delete();

        return redirect()->route('admin.regions.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }

    protected function authorizeAdmin(): void
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }
    }
}
