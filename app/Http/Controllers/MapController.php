<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * The forest-loss monitoring platform map page. Real vector layers
     * (Sumatera province outlines + GLAD 2026 alerts) are served as
     * pre-processed GeoJSON from /public/data and filtered in-browser,
     * so no database data is needed to render the map.
     */
    public function show(Request $request)
    {
        return view('platform');
    }
}
