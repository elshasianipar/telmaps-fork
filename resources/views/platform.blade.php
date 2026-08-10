<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TELF · Pemantauan Hilang Hutan</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌳</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous" defer></script>

        <style>
            html, body { height: 100%; }
            body { -webkit-font-smoothing: antialiased; }
            #map { height: 100%; min-height: 360px; background: #0E1A12; }
            .leaflet-container { background: #0E1A12; font-family: 'Inter', sans-serif; outline: none; }
            .leaflet-bar a { background: #0F2109; color: #F2EDE3; border-color: rgba(242,237,227,.14); }
            .leaflet-bar a:hover { background: #14291b; color: #C8D84A; }
            .leaflet-control-attribution { background: rgba(14,26,18,.7) !important; color: rgba(242,237,227,.35) !important; font-family: 'JetBrains Mono', monospace; font-size: 9px; }
            .leaflet-control-attribution a { color: rgba(242,237,227,.5) !important; }
            .leaflet-control-scale-line { background: rgba(14,26,18,.55); color: rgba(242,237,227,.5); border-color: rgba(242,237,227,.22); font-family: 'JetBrains Mono', monospace; font-size: 9px; line-height: 1.4; }

            .leaflet-tooltip.telf-tip {
                font-family: 'JetBrains Mono', monospace; font-size: 11px; letter-spacing: .02em;
                background: #0F2109; color: #F2EDE3; border: 1px solid rgba(200,216,74,.35);
                border-radius: 4px; box-shadow: 0 6px 20px rgba(0,0,0,.4); padding: 7px 10px; white-space: nowrap;
            }
            .leaflet-tooltip.telf-tip::before { display: none; }

            .bnd { cursor: pointer; transition: fill-opacity .14s ease, color .14s ease; }

            .tick {
                position: absolute; font-family: 'JetBrains Mono', monospace; font-size: 9px;
                letter-spacing: .04em; color: rgba(242,237,227,.40); white-space: nowrap;
                text-shadow: 0 1px 2px rgba(0,0,0,.6);
            }
            .tick-lat { left: 5px; transform: translateY(-50%); display: flex; align-items: center; gap: 4px; }
            .tick-lat::after { content: ''; width: 5px; height: 1px; background: rgba(242,237,227,.25); }
            .tick-lng { top: 4px; transform: translateX(-50%); }
            .tl-tick { transition: color .15s ease; }

            .live-dot { animation: livepulse 2.2s ease-in-out infinite; }
            @keyframes livepulse { 0%,100% { opacity: .55; transform: scale(1); } 50% { opacity: 1; transform: scale(1.35); } }

            .rail { scrollbar-width: thin; scrollbar-color: rgba(242,237,227,.16) transparent; }
            .rail::-webkit-scrollbar { width: 7px; height: 7px; }
            .rail::-webkit-scrollbar-track { background: transparent; }
            .rail::-webkit-scrollbar-thumb { background: rgba(242,237,227,.14); border-radius: 4px; }

            .prop-track { background: rgba(242,237,227,.08); }
            :focus-visible { outline: 2px solid #C8D84A; outline-offset: 2px; border-radius: 3px; }
            .leaflet-container :focus-visible { outline: none; }

            @media (prefers-reduced-motion: reduce) {
                * { transition: none !important; animation: none !important; }
                .live-dot { opacity: .9; }
            }
        </style>
    </head>
    <body class="bg-ink text-cream font-inter antialiased">
        <div class="flex flex-col lg:h-screen min-h-screen">

            {{-- Header --}}
            <header class="border-b border-cream/10 bg-ink/95 backdrop-blur-sm z-30 shrink-0">
                <div class="flex items-center justify-between gap-4 px-5 py-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-lime/15 ring-1 ring-lime/40 flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" class="shrink-0">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="leading-tight min-w-0">
                            <div class="font-fraunces text-base font-medium text-cream truncate">TELF</div>
                            <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/45 -mt-0.5 truncate">Pemantauan Kebakaran</div>
                        </div>
                    </div>

                    <div class="hidden sm:flex items-center gap-2.5 font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/55 border border-cream/12 rounded-full px-3 py-1.5">
                        <span class="live-dot w-1.5 h-1.5 rounded-full bg-loss"></span>
                        <span>Siaran Langsung</span>
                        <span class="w-px h-3 bg-cream/15"></span>
                        <span class="text-cream/70">Kebakaran · 2020–2024</span>
                    </div>

                    <a href="{{ route('home') }}" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/65 hover:text-lime transition-colors border border-cream/15 hover:border-lime/40 rounded-full px-3 py-1.5 shrink-0">
                        ← Beranda
                    </a>
                </div>

                {{-- Drill path --}}
                <div id="breadcrumb" class="border-t border-cream/10 px-5 py-2 flex items-center gap-2 font-jetbrains-mono text-[11px] text-cream/55 overflow-x-auto whitespace-nowrap rail"></div>
            </header>

            {{-- Main: filters · map · readouts --}}
            <main class="flex-1 grid grid-cols-1 lg:grid-cols-[264px_1fr_316px] min-h-0">

                {{-- Left rail --}}
                <aside class="rail border-b lg:border-b-0 lg:border-r border-cream/10 bg-forest-dark/60 overflow-y-auto">
                    <div class="p-5 space-y-6">
                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.22em] text-lime/70 mb-3">Telusuri Wilayah</p>
                            <h2 class="font-fraunces text-[22px] font-normal text-cream leading-tight">Titik kebakaran hutan</h2>
                            <p class="text-[13px] text-cream/55 leading-relaxed mt-2">Klik batas pada peta untuk menelusuri: <span class="text-lime">provinsi → kabupaten → kecamatan → desa</span>.</p>
                        </div>

                        <div>
                            <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/45 block mb-3">Saring Keyakinan</span>
                            <div class="space-y-2" id="dn-toggles">
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm group">
                                    <input type="checkbox" value="3" checked class="accent-[#C84A26] w-4 h-4 shrink-0">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-loss shrink-0"></span>
                                    <span class="text-cream/85 group-hover:text-cream">Tinggi</span>
                                    <span class="font-jetbrains-mono text-[10px] text-cream/35 ml-auto">DN ≥25</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm group">
                                    <input type="checkbox" value="2" checked class="accent-[#E8A93A] w-4 h-4 shrink-0">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-amber shrink-0"></span>
                                    <span class="text-cream/85 group-hover:text-cream">Sedang</span>
                                    <span class="font-jetbrains-mono text-[10px] text-cream/35 ml-auto">DN 13–21</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm group">
                                    <input type="checkbox" value="1" checked class="accent-[#E8C547] w-4 h-4 shrink-0">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-[#E8C547] shrink-0"></span>
                                    <span class="text-cream/85 group-hover:text-cream">Rendah</span>
                                    <span class="font-jetbrains-mono text-[10px] text-cream/35 ml-auto">DN ≤9</span>
                                </label>
                            </div>
                        </div>

                        <button id="f-reset" type="button" class="w-full font-jetbrains-mono text-[11px] uppercase tracking-[0.18em] text-cream/80 border border-cream/20 hover:border-lime/50 hover:text-lime rounded-full py-2.5 transition-colors">
                            Atur Ulang
                        </button>

                        <div class="pt-4 border-t border-cream/10 space-y-3">
                            <div>
                                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/40 mb-1.5">Sumber</p>
                                <p class="text-[11px] text-cream/45 leading-relaxed">Titik kebakaran hutan Sumatera 2020–2024 (91.355 titik) · batas administrasi — provinsi, kabupaten, kecamatan, desa (Kemendagri). Sel kebakaran divektorisasi dari raster, diklasifikasi per tingkat intensitas.</p>
                            </div>
                            <div class="font-jetbrains-mono text-[10px] tracking-[0.12em] text-cream/30 flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-cream/30"></span>
                                DATUM WGS84 · EPSG:4326
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Center: map plate --}}
                <section class="relative bg-ink min-h-0">
                    <div id="map" class="absolute inset-0"></div>

                    {{-- Cartographic frame --}}
                    <div class="corner-tick pointer-events-none absolute top-2.5 left-2.5 z-[450] w-4 h-4 border-l border-t border-cream/35"></div>
                    <div class="corner-tick pointer-events-none absolute top-2.5 right-2.5 z-[450] w-4 h-4 border-r border-t border-cream/35"></div>

                    <div class="absolute top-3 right-3 z-[455] pointer-events-none flex flex-col items-center gap-0.5 text-cream/45 mr-9">
                        <span class="font-jetbrains-mono text-[9px] tracking-[0.1em]">N</span>
                        <span class="text-[10px] leading-none">↑</span>
                        <span class="w-px h-4 bg-cream/25"></span>
                    </div>

                    <div id="lat-ticks" class="absolute inset-0 pointer-events-none z-[440]"></div>
                    <div id="lng-ticks" class="absolute inset-0 pointer-events-none z-[440]"></div>

                    <div id="loading" class="absolute inset-0 z-[470] flex items-center justify-center pointer-events-none">
                        <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.22em] text-cream/55 bg-ink/55 px-3 py-1.5 rounded-full border border-cream/12">memuat data…</span>
                    </div>

                    {{-- Timeline (MapBiomas-style year slider) --}}
                    <div id="timeline" class="absolute bottom-0 left-0 right-0 z-[460] h-14 bg-ink/85 backdrop-blur-sm border-t border-cream/12 flex items-center gap-3 px-4">
                        <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/40 shrink-0 hidden sm:block">Lembar 02 · Sumatera</span>
                        <button id="tl-play" type="button" aria-label="Putar animasi tahun" class="shrink-0 w-8 h-8 rounded-full border border-cream/20 text-cream/70 hover:text-lime hover:border-lime/50 transition-colors flex items-center justify-center text-[12px] leading-none">▶</button>
                        <div id="tl-track" class="relative flex-1 h-10 cursor-pointer touch-none select-none">
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-px bg-cream/20"></div>
                            <div id="tl-ticks" class="absolute inset-0"></div>
                            <div id="tl-handle" class="absolute top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 rounded-full bg-lime shadow-[0_0_0_3px_rgba(200,216,74,0.18)]" style="left:10px"></div>
                        </div>
                        <span id="tl-year" class="font-fraunces text-xl text-lime shrink-0 w-16 text-right tabular-nums">2024</span>
                        <span class="font-jetbrains-mono text-[9px] text-cream/35 shrink-0 hidden md:block">© Google</span>
                    </div>
                </section>

                {{-- Right rail: readouts --}}
                <aside class="rail border-t lg:border-t-0 lg:border-l border-cream/10 bg-forest-dark/60 overflow-y-auto">
                    <div class="p-5 space-y-7">
                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.22em] text-lime/70 mb-2">Ringkasan</p>
                            <div class="flex items-baseline gap-2">
                                <span id="kpi-alerts" class="font-fraunces text-[44px] leading-none font-medium text-loss">0</span>
                                <span class="font-jetbrains-mono text-[11px] uppercase tracking-[0.18em] text-cream/45">titik</span>
                            </div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] text-cream/40 mt-2">
                                semua intensitas · <span id="kpi-area" class="text-cream/70 normal-case tracking-normal">Sumatera</span>
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/45">Tingkat Intensitas</p>
                                <span id="dn-total" class="font-jetbrains-mono text-[10px] text-cream/30"></span>
                            </div>
                            <div id="dn-summary"></div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p id="by-title" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/45">Berdasarkan Provinsi</p>
                                <span id="by-count" class="font-jetbrains-mono text-[10px] text-cream/30"></span>
                            </div>
                            <div id="prov-bars" class="space-y-2"></div>
                        </div>
                    </div>
                </aside>
            </main>

            {{-- Legend strip --}}
            <footer class="border-t border-cream/10 bg-ink shrink-0">
                <div class="px-5 py-3 flex flex-wrap items-center gap-x-5 gap-y-2">
                    <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.22em] text-cream/40">Legenda</span>
                    <span class="flex items-center gap-2 text-[13px] text-cream/75"><span class="w-2.5 h-2.5 rounded-[1px] bg-loss"></span>Tinggi</span>
                    <span class="flex items-center gap-2 text-[13px] text-cream/75"><span class="w-2.5 h-2.5 rounded-[1px] bg-amber"></span>Sedang</span>
                    <span class="flex items-center gap-2 text-[13px] text-cream/75"><span class="w-2.5 h-2.5 rounded-[1px] bg-[#E8C547]"></span>Rendah</span>
                    <span class="flex items-center gap-2 text-[13px] text-cream/75"><span class="w-4 h-0.5 bg-lime"></span>Batas (klik)</span>
                    <span class="ml-auto font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/45" id="footer-count">0 titik</span>
                </div>
            </footer>
        </div>

        <script>
            (function () {
                const DN = {
                    3: { color: '#C84A26', label: 'Tinggi', range: 'DN ≥25' },
                    2: { color: '#E8A93A', label: 'Sedang', range: 'DN 13–21' },
                    1: { color: '#E8C547', label: 'Rendah', range: 'DN ≤9' },
                };
                const fmt = (n) => Number(n || 0).toLocaleString('id-ID');
                const fmtLat = (lat) => Math.abs(lat).toFixed(1) + '°' + (lat >= 0 ? 'N' : 'S');
                const fmtLng = (lng) => Math.abs(lng).toFixed(1) + '°' + (lng >= 0 ? 'E' : 'W');

                // Fire intensity → 3 tiers. Raw DN values: 3,5,9 / 13,21 / 25,35,40,76.
                const tierOf = (dn) => dn <= 9 ? 1 : (dn <= 21 ? 2 : 3);

                // ---- Custom canvas layer: crisp square cells per alert, anchored to map ----
                let CellLayerClass = null;
                function buildCellLayer() {
                    return L.Layer.extend({
                        options: { baseCell: 3, minCell: 2, maxCell: 12, alpha: 0.82 },
                        initialize(latlngs, opts) { this._latlngs = latlngs || []; L.setOptions(this, opts); },
                        setLatLngs(latlngs) { this._latlngs = latlngs; return this.redraw(); },
                        redraw() {
                            if (this._canvas && this._map && !this._frame) {
                                this._frame = L.Util.requestAnimFrame(this._redraw, this);
                            }
                            return this;
                        },
                        onAdd(map) {
                            this._map = map;
                            if (!this._canvas) this._initCanvas();
                            map.getPanes().overlayPane.appendChild(this._canvas);
                            map.on('moveend', this._reset, this);
                            map.on('zoomend', this._reset, this);
                            if (map.options.zoomAnimation && L.Browser.any3d) {
                                map.on('zoomanim', this._animateZoom, this);
                            }
                            this._reset();
                        },
                        onRemove(map) {
                            map.getPanes().overlayPane.removeChild(this._canvas);
                            map.off('moveend', this._reset, this);
                            map.off('zoomend', this._reset, this);
                            map.off('zoomanim', this._animateZoom, this);
                        },
                        _initCanvas() {
                            const canvas = this._canvas = L.DomUtil.create('canvas', 'leaflet-cell-layer leaflet-layer');
                            const originProp = L.DomUtil.testProp(['transformOrigin', 'WebkitTransformOrigin', 'msTransformOrigin']);
                            canvas.style[originProp] = '0 0';
                            const size = this._map.getSize();
                            canvas.width = size.x; canvas.height = size.y;
                            const animated = this._map.options.zoomAnimation && L.Browser.any3d;
                            L.DomUtil.addClass(canvas, 'leaflet-zoom-' + (animated ? 'animated' : 'hide'));
                        },
                        _reset() {
                            const canvas = this._canvas, map = this._map;
                            L.DomUtil.setPosition(canvas, map.containerPointToLayerPoint([0, 0]));
                            const size = map.getSize();
                            if (canvas.width !== size.x) canvas.width = size.x;
                            if (canvas.height !== size.y) canvas.height = size.y;
                            this._redraw();
                            updateCoordTicks();
                        },
                        _animateZoom(e) {
                            const map = this._map;
                            const scale = map.getZoomScale(e.zoom);
                            const topLeft = map._latLngToNewLayerPoint(map.getBounds().getNorthWest(), e.zoom, e.center);
                            L.DomUtil.setTransform(this._canvas, topLeft, scale);
                        },
                        _redraw() {
                            const ctx = this._ctx || (this._ctx = this._canvas.getContext('2d'));
                            ctx.clearRect(0, 0, this._canvas.width, this._canvas.height);
                            const map = this._map;
                            const z = map.getZoom();
                            const cell = Math.max(this.options.minCell, Math.min(this.options.maxCell, this.options.baseCell + (z - 6)));
                            const r = cell / 2;
                            const pts = this._latlngs;
                            for (let i = 0; i < pts.length; i++) {
                                const p = pts[i];
                                const pt = map.latLngToContainerPoint([p[0], p[1]]);
                                ctx.globalAlpha = p[3] != null ? p[3] : this.options.alpha;
                                ctx.fillStyle = p[2];
                                ctx.fillRect(pt.x - r, pt.y - r, cell, cell);
                            }
                            ctx.globalAlpha = 1;
                            this._frame = null;
                        },
                    });
                }

                // ---- State ----
                let map, cellLayer, bndLayer = null;
                let FIRES = [], PROVINCES = [], REGS = [], KECS = [];
                const kecLookup = new Map(); // kecCode -> { kecamatan, kabupaten, kabCode, province, provCode }
                const desaCache = {};
                let provBoundsAll = null;
                const sel = { province: null, kabupaten: null, kecCode: null, kabCode: null, kecamatan: null };
                const state = { level: 'prov', dn: new Set([1, 2, 3]), year: null };

                const STYLES = {
                    prov: { color: '#C8D84A', weight: 1.5, opacity: 0.9, fillOpacity: 0.04 },
                    kab:  { color: '#C8D84A', weight: 1.2, opacity: 0.8, fillOpacity: 0.05 },
                    kec:  { color: '#C8D84A', weight: 1.0, opacity: 0.7, fillOpacity: 0.06 },
                    desa: { color: '#F2EDE3', weight: 0.6, opacity: 0.5, fillOpacity: 0.05 },
                };

                function boot() {
                    if (typeof L === 'undefined') { return setTimeout(boot, 50); }
                    map = L.map('map', { zoomControl: true, attributionControl: false, scrollWheelZoom: true })
                        .setView([-0.5, 101.5], 6);
                    L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], maxZoom: 20, attribution: '&copy; Google',
                    }).addTo(map);
                    map.on('moveend', updateCoordTicks);
                    map.on('zoomend', updateCoordTicks);
                    Promise.all([
                        fetch('/data/sumatera_provinces.geojson').then((r) => r.json()),
                        fetch('/data/sumatera_regencies.geojson').then((r) => r.json()),
                        fetch('/data/sumatera_kecamatan.geojson').then((r) => r.json()),
                        fetch('/data/fires.json').then((r) => r.json()),
                    ]).then(([provs, regs, kecs, fires]) => {
                        PROVINCES = provs.features;
                        REGS = regs.features;
                        KECS = kecs.features;
                        KECS.forEach((f) => {
                            const p = f.properties;
                            kecLookup.set(p.code, {
                                kecamatan: p.kecamatan, kabupaten: p.kabupaten,
                                kabCode: p.kabCode, province: p.province, provCode: p.provCode,
                            });
                        });
                        FIRES = fires.pts; // [lat, lng, dn, year, kecCode]
                        provBoundsAll = L.geoJSON(PROVINCES).getBounds();
                        document.getElementById('loading').style.display = 'none';
                        buildTimeline();
                        renderBoundary();
                        updateBreadcrumb();
                        if (provBoundsAll.isValid()) map.fitBounds(provBoundsAll, { padding: [12, 12] });
                        render();
                        updateCoordTicks();
                    }).catch((e) => {
                        document.getElementById('loading').textContent = 'gagal memuat data';
                        console.error(e);
                    });
                }

                // ---- Cartographic coordinate ticks (real lat/lng along edges) ----
                const LAT_Y = [0.18, 0.38, 0.58, 0.78];
                const LNG_X = [0.18, 0.36, 0.54, 0.72, 0.90];
                let latEls = [], lngEls = [];
                function buildTicks() {
                    const latBox = document.getElementById('lat-ticks');
                    const lngBox = document.getElementById('lng-ticks');
                    latBox.innerHTML = ''; lngBox.innerHTML = '';
                    latEls = LAT_Y.map(() => { const s = document.createElement('span'); s.className = 'tick tick-lat'; latBox.appendChild(s); return s; });
                    lngEls = LNG_X.map(() => { const s = document.createElement('span'); s.className = 'tick tick-lng'; lngBox.appendChild(s); return s; });
                }
                function updateCoordTicks() {
                    if (!map || !latEls.length) return;
                    const size = map.getSize();
                    LAT_Y.forEach((y, i) => {
                        const ll = map.containerPointToLatLng([8, y * size.y]);
                        latEls[i].textContent = fmtLat(ll.lat);
                        latEls[i].style.top = (y * 100) + '%';
                    });
                    LNG_X.forEach((x, i) => {
                        const ll = map.containerPointToLatLng([x * size.x, size.y - 10]);
                        lngEls[i].textContent = fmtLng(ll.lng);
                        lngEls[i].style.left = (x * 100) + '%';
                    });
                }

                // ---- Boundaries (clickable drill) ----
                function renderBoundary() {
                    if (bndLayer) { map.removeLayer(bndLayer); bndLayer = null; }
                    let fc, style, onClick, tipKey;
                    if (state.level === 'prov') {
                        fc = PROVINCES; style = STYLES.prov; onClick = drillProv; tipKey = 'province';
                    } else if (state.level === 'kab') {
                        fc = REGS.filter((r) => r.properties.province === sel.province);
                        style = STYLES.kab; onClick = drillKab; tipKey = 'regency';
                    } else if (state.level === 'kec') {
                        fc = KECS.filter((k) => k.properties.kabupaten === sel.kabupaten);
                        style = STYLES.kec; onClick = drillKec; tipKey = 'kecamatan';
                    } else if (state.level === 'desa') {
                        const g = desaCache[sel.kabCode];
                        if (!g) return;
                        fc = g.features.filter((d) => d.properties.kecCode === sel.kecCode);
                        style = STYLES.desa; onClick = null; tipKey = 'desa';
                    }
                    if (!fc || (Array.isArray(fc) ? fc.length === 0 : !fc.length)) return;
                    bndLayer = L.geoJSON(fc, {
                        style: () => Object.assign({}, style),
                        interactive: onClick !== null,
                        onEachFeature: (f, lyr) => {
                            const tip = f.properties[tipKey];
                            if (tip) lyr.bindTooltip(tip, { className: 'telf-tip', direction: 'top', sticky: true });
                            if (onClick) lyr.on('click', () => onClick(f));
                            lyr.on('mouseover', () => lyr.setStyle({ color: '#F2EDE3', weight: (style.weight || 1) + 1, opacity: 1, fillOpacity: 0.14 }));
                            lyr.on('mouseout', () => lyr.setStyle(Object.assign({}, style)));
                        },
                    }).addTo(map);
                }

                function drillProv(f) {
                    sel.province = f.properties.province; sel.kabupaten = null; sel.kecCode = null; sel.kabCode = null; sel.kecamatan = null;
                    state.level = 'kab'; renderBoundary(); updateBreadcrumb(); fitTo(bndLayer); render();
                }
                function drillKab(f) {
                    sel.kabupaten = f.properties.regency; sel.kecCode = null; sel.kabCode = null; sel.kecamatan = null;
                    state.level = 'kec'; renderBoundary(); updateBreadcrumb(); fitTo(bndLayer); render();
                }
                function drillKec(f) {
                    sel.kecCode = f.properties.code; sel.kabCode = f.properties.kabCode; sel.kecamatan = f.properties.kecamatan;
                    state.level = 'desa';
                    render(); updateBreadcrumb();
                    loadDesa(sel.kabCode, () => { renderBoundary(); fitTo(bndLayer); });
                }

                function goToLevel(level) {
                    if (level === 'prov') { sel.province = sel.kabupaten = sel.kecCode = sel.kabCode = sel.kecamatan = null; }
                    else if (level === 'kab') { sel.kabupaten = sel.kecCode = sel.kabCode = sel.kecamatan = null; }
                    else if (level === 'kec') { sel.kecCode = sel.kabCode = sel.kecamatan = null; }
                    state.level = level;
                    if (level === 'desa' && sel.kabCode) {
                        loadDesa(sel.kabCode, () => { renderBoundary(); fitTo(bndLayer); });
                    } else {
                        renderBoundary();
                        fitTo(level === 'prov' ? null : bndLayer);
                    }
                    updateBreadcrumb();
                    render();
                }

                function loadDesa(kabCode, cb) {
                    if (desaCache[kabCode]) { cb(); return; }
                    fetch('/data/desa/' + kabCode + '.geojson').then((r) => r.json()).then((g) => {
                        desaCache[kabCode] = g; cb();
                    }).catch((e) => console.error('desa load fail', kabCode, e));
                }

                function fitTo(layer) {
                    if (layer && layer.getBounds) {
                        const b = layer.getBounds();
                        if (b.isValid()) { map.fitBounds(b, { padding: [14, 14] }); return; }
                    }
                    if (provBoundsAll && provBoundsAll.isValid()) map.fitBounds(provBoundsAll, { padding: [12, 12] });
                }

                function updateBreadcrumb() {
                    const bc = document.getElementById('breadcrumb');
                    const crumbs = [{ l: 'prov', t: 'Sumatera' }];
                    if (sel.province) crumbs.push({ l: 'kab', t: sel.province });
                    if (sel.kabupaten) crumbs.push({ l: 'kec', t: sel.kabupaten });
                    if (sel.kecamatan) crumbs.push({ l: 'desa', t: sel.kecamatan });
                    bc.innerHTML = '';
                    const tag = document.createElement('span');
                    tag.textContent = 'Jalur';
                    tag.className = 'font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/30 shrink-0';
                    bc.appendChild(tag);
                    crumbs.forEach((c, idx) => {
                        if (idx > 0) {
                            const s = document.createElement('span');
                            s.textContent = '›'; s.className = 'text-lime/45 shrink-0';
                            bc.appendChild(s);
                        }
                        const b = document.createElement('button');
                        b.type = 'button'; b.textContent = c.t;
                        b.className = 'hover:text-lime transition-colors truncate max-w-[220px] '
                            + (idx === crumbs.length - 1 ? ' text-cream font-medium' : 'text-cream/55');
                        b.addEventListener('click', () => goToLevel(c.l));
                        bc.appendChild(b);
                    });
                }

                // ---- Fire points (cells) ----
                function filtered() {
                    return FIRES.filter((pt) => {
                        if (state.year !== null && pt[3] !== state.year) return false;
                        const code = pt[4];
                        if (state.level === 'desa') {
                            if (code !== sel.kecCode) return false;
                        } else {
                            const a = kecLookup.get(code);
                            if (!a) return false;
                            if (state.level === 'kab' && a.province !== sel.province) return false;
                            if (state.level === 'kec' && a.kabupaten !== sel.kabupaten) return false;
                        }
                        return state.dn.has(tierOf(pt[2]));
                    });
                }

                function render() {
                    const data = filtered();
                    const pts = data.map((pt) => {
                        const t = tierOf(pt[2]);
                        const alpha = t === 3 ? 0.92 : (t === 2 ? 0.8 : 0.62);
                        return [pt[0], pt[1], (DN[t] || DN[1]).color, alpha];
                    });
                    if (!cellLayer) {
                        const Cls = CellLayerClass || (CellLayerClass = buildCellLayer());
                        cellLayer = new Cls(pts, { baseCell: 3 }).addTo(map);
                    } else {
                        cellLayer.setLatLngs(pts);
                    }
                    renderStats(data);
                }

                function renderStats(data) {
                    document.getElementById('kpi-alerts').textContent = fmt(data.length);
                    const areaName = sel.kecamatan || sel.kabupaten || sel.province || 'Sumatera';
                    document.getElementById('kpi-area').textContent = areaName;
                    document.getElementById('footer-count').textContent = fmt(data.length) + ' titik';

                    // Intensity breakdown — vertical bar chart (diagram batang)
                    const sum = { 3: 0, 2: 0, 1: 0 };
                    data.forEach((pt) => { sum[tierOf(pt[2])]++; });
                    const total = Math.max(1, data.length);
                    const maxDn = Math.max(1, sum[3], sum[2], sum[1]);
                    const cs = document.getElementById('dn-summary');
                    cs.innerHTML = '';
                    document.getElementById('dn-total').textContent = 'Σ ' + fmt(data.length);

                    const grid = document.createElement('div');
                    grid.className = 'relative h-32 border-b border-cream/15';
                    // horizontal gridlines at 25/50/75%
                    [25, 50, 75].forEach((pct) => {
                        const g = document.createElement('span');
                        g.className = 'absolute left-0 right-0 h-px bg-cream/8';
                        g.style.bottom = pct + '%';
                        grid.appendChild(g);
                    });
                    const plot = document.createElement('div');
                    plot.className = 'absolute inset-0 flex items-end gap-3 px-1';
                    [3, 2, 1].forEach((k) => {
                        const col = document.createElement('div');
                        col.className = 'flex-1 flex flex-col items-center justify-end h-full gap-1';
                        const val = document.createElement('span');
                        val.className = 'font-jetbrains-mono text-[10px] text-cream/65';
                        val.textContent = fmt(sum[k]);
                        const bar = document.createElement('div');
                        bar.className = 'w-full rounded-t-[2px] transition-[height] duration-300';
                        bar.style.height = (sum[k] / maxDn * 100) + '%';
                        bar.style.minHeight = '2px';
                        bar.style.background = DN[k].color;
                        col.appendChild(val);
                        col.appendChild(bar);
                        plot.appendChild(col);
                    });
                    grid.appendChild(plot);
                    cs.appendChild(grid);

                    const dleg = document.createElement('div');
                    dleg.className = 'flex gap-3 mt-2';
                    [3, 2, 1].forEach((k) => {
                        const c = document.createElement('div');
                        c.className = 'flex-1 flex flex-col items-center gap-1';
                        c.innerHTML =
                            '<span class="w-2.5 h-2.5 rounded-[1px]" style="background:' + DN[k].color + '"></span>' +
                            '<span class="text-[10px] text-cream/65">' + DN[k].label + '</span>' +
                            '<span class="font-jetbrains-mono text-[9px] text-cream/35">' + DN[k].range + '</span>';
                        dleg.appendChild(c);
                    });
                    cs.appendChild(dleg);

                    // Region distribution — horizontal bar chart (diagram batang)
                    const groupKey = state.level === 'prov' ? 'province' : (state.level === 'kab' ? 'kabupaten' : 'kecamatan');
                    document.getElementById('by-title').textContent =
                        'Berdasarkan ' + (state.level === 'prov' ? 'Provinsi' : state.level === 'kab' ? 'Kabupaten' : 'Kecamatan');
                    const groups = {};
                    data.forEach((pt) => {
                        const a = kecLookup.get(pt[4]);
                        const k = (a && a[groupKey]) || '—';
                        groups[k] = (groups[k] || 0) + 1;
                    });
                    const entries = Object.entries(groups).sort((a, b) => b[1] - a[1]).slice(0, 10);
                    const max = Math.max(1, ...entries.map((e) => e[1]));
                    const bars = document.getElementById('prov-bars');
                    bars.innerHTML = '';
                    document.getElementById('by-count').textContent = entries.length ? (entries.length + ' wilayah') : '';
                    if (entries.length === 0) {
                        const e = document.createElement('p');
                        e.className = 'text-[12px] text-cream/40';
                        e.textContent = 'Tidak ada titik kebakaran pada wilayah ini.';
                        bars.appendChild(e);
                    } else {
                        // scale ticks header
                        const axis = document.createElement('div');
                        axis.className = 'flex items-center gap-2 mb-1.5';
                        axis.innerHTML =
                            '<span class="w-24 shrink-0"></span>' +
                            '<div class="flex-1 flex justify-between font-jetbrains-mono text-[9px] text-cream/30">' +
                            '<span>0</span><span>' + fmt(Math.round(max / 2)) + '</span><span>' + fmt(max) + '</span>' +
                            '</div>' +
                            '<span class="w-9 shrink-0"></span>';
                        bars.appendChild(axis);
                        entries.forEach(([p, v]) => {
                            const row = document.createElement('div');
                            row.className = 'flex items-center gap-2';
                            row.innerHTML =
                                '<span class="text-[11px] text-cream/70 truncate w-24 shrink-0" title="' + p + '">' + p + '</span>' +
                                '<div class="relative flex-1 h-3.5 rounded-[1px] bg-cream/5 overflow-hidden">' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-cream/8" style="left:25%"></span>' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-cream/8" style="left:50%"></span>' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-cream/8" style="left:75%"></span>' +
                                    '<div class="relative h-full rounded-[1px] transition-[width] duration-300" style="width:' + (v / max * 100) + '%;min-width:2px;background:#C84A26"></div>' +
                                '</div>' +
                                '<span class="font-jetbrains-mono text-[10px] text-cream/60 w-9 text-right shrink-0">' + fmt(v) + '</span>';
                            bars.appendChild(row);
                        });
                    }
                }

                // ---- Year timeline (MapBiomas-style slider) ----
                let YEARS = [];
                let tlTimer = null, tlDragging = false;
                const tlTrack = () => document.getElementById('tl-track');
                const PAD = 12;

                function yearToX(y) {
                    const w = tlTrack().clientWidth;
                    const i = YEARS.indexOf(y);
                    if (i < 0 || YEARS.length === 1) return PAD;
                    return PAD + (i / (YEARS.length - 1)) * (w - PAD * 2);
                }
                function xToYear(x) {
                    const w = tlTrack().clientWidth;
                    let frac = (x - PAD) / (w - PAD * 2);
                    frac = Math.max(0, Math.min(1, frac || 0));
                    return YEARS[Math.round(frac * (YEARS.length - 1))];
                }
                function moveHandle() {
                    document.getElementById('tl-handle').style.left = yearToX(state.year) + 'px';
                }
                function highlightTick() {
                    document.querySelectorAll('.tl-tick').forEach((t) => {
                        t.className = 'tl-tick absolute top-0 -translate-x-1/2 font-jetbrains-mono text-[10px] pointer-events-none '
                            + (Number(t.dataset.year) === state.year ? 'text-lime' : 'text-cream/45');
                    });
                }
                function setYear(y, doRender) {
                    state.year = y;
                    moveHandle();
                    highlightTick();
                    document.getElementById('tl-year').textContent = y;
                    if (doRender !== false) render();
                }
                function positionTimeline() {
                    document.querySelectorAll('.tl-tick').forEach((t, i) => {
                        t.style.left = yearToX(Number(t.dataset.year)) + 'px';
                    });
                    moveHandle();
                }
                function stopPlay() {
                    if (tlTimer) { clearInterval(tlTimer); tlTimer = null; }
                    const btn = document.getElementById('tl-play');
                    btn.textContent = '▶'; btn.classList.remove('text-lime'); btn.setAttribute('aria-label', 'Putar animasi tahun');
                }
                function buildTimeline() {
                    YEARS = Array.from(new Set(FIRES.map((p) => p[3]))).sort((a, b) => a - b);
                    const inner = document.getElementById('tl-ticks');
                    inner.innerHTML = '';
                    YEARS.forEach((y) => {
                        const t = document.createElement('span');
                        t.className = 'tl-tick absolute top-0 -translate-x-1/2 font-jetbrains-mono text-[10px] text-cream/45 pointer-events-none';
                        t.dataset.year = y; t.textContent = y;
                        inner.appendChild(t);
                    });
                    if (state.year === null || !YEARS.includes(state.year)) state.year = YEARS[YEARS.length - 1];
                    positionTimeline();
                    setYear(state.year, false);

                    const track = tlTrack();
                    track.addEventListener('pointerdown', (e) => {
                        tlDragging = true; stopPlay(); track.setPointerCapture(e.pointerId);
                        const rect = track.getBoundingClientRect();
                        setYear(xToYear(e.clientX - rect.left));
                    });
                    track.addEventListener('pointermove', (e) => {
                        if (!tlDragging) return;
                        const rect = track.getBoundingClientRect();
                        setYear(xToYear(e.clientX - rect.left));
                    });
                    track.addEventListener('pointerup', () => { tlDragging = false; });
                    track.addEventListener('pointercancel', () => { tlDragging = false; });

                    document.getElementById('tl-play').addEventListener('click', () => {
                        if (tlTimer) { stopPlay(); return; }
                        const btn = document.getElementById('tl-play');
                        btn.textContent = '⏸'; btn.classList.add('text-lime'); btn.setAttribute('aria-label', 'Jeda animasi');
                        tlTimer = setInterval(() => {
                            let i = YEARS.indexOf(state.year);
                            i = (i + 1) % YEARS.length;
                            setYear(YEARS[i]);
                        }, 1400);
                    });

                    window.addEventListener('resize', positionTimeline);
                }

                // ---- Controls ----
                document.querySelectorAll('#dn-toggles input').forEach((cb) => {
                    cb.addEventListener('change', () => {
                        const v = Number(cb.value);
                        if (cb.checked) state.dn.add(v); else state.dn.delete(v);
                        render();
                    });
                });
                document.getElementById('f-reset').addEventListener('click', () => {
                    state.dn = new Set([1, 2, 3]);
                    stopPlay();
                    document.querySelectorAll('#dn-toggles input').forEach((cb) => { cb.checked = true; });
                    if (YEARS.length) setYear(YEARS[YEARS.length - 1], false);
                    goToLevel('prov');
                });

                buildTicks();
                boot();
            })();
        </script>
    </body>
</html>