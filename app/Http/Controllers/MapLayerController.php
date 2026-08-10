<?php

namespace App\Http\Controllers;

use App\Models\MapLayer;
use Illuminate\Http\Request;

class MapLayerController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $layers = MapLayer::orderBy('is_default', 'desc')->orderBy('name')->paginate(15);

        return view('admin.map-layers', [
            'layers' => $layers,
            'pageTitle' => 'Lapisan Peta',
        ]);
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.map-layers-form', ['mode' => 'create']);
    }

    public function edit(MapLayer $mapLayer)
    {
        $this->authorizeAdmin();

        return view('admin.map-layers-form', [
            'layer' => $mapLayer,
            'mode' => 'edit',
        ]);
    }

    public function destroy(MapLayer $mapLayer)
    {
        $this->authorizeAdmin();
        $mapLayer->delete();

        return redirect()->route('admin.mapLayers.index')
            ->with('success', 'Lapisan peta berhasil dihapus.');
    }

    protected function authorizeAdmin(): void
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }
    }
}
