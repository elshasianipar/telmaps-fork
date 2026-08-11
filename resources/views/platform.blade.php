<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $lang === 'en' ? 'TELF · Fire Monitoring' : 'TELF · Pemantauan Kebakaran' }}</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔥</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous" defer></script>
        <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js" crossorigin="anonymous" defer></script>

        <style>
            html, body { height: 100%; }
            body { -webkit-font-smoothing: antialiased; }
            #map { height: 100%; min-height: 360px; background: #0A0F0B; }
            .leaflet-container { background: #0A0F0B; font-family: 'JetBrains Mono', monospace; outline: none; }
            .leaflet-bar a { background: #0F1A12; color: #F2EDE3; border-color: rgba(242,237,227,.12); }
            .leaflet-bar a:hover { background: #1F1611; color: #E6652A; }

            .leaflet-tooltip.telf-tip {
                font-family: 'JetBrains Mono', monospace; font-size: 11px; letter-spacing: .02em;
                background: #0F1A12; color: #F2EDE3; border: 1px solid rgba(216,80,30,.45);
                border-radius: 4px; box-shadow: 0 6px 20px rgba(0,0,0,.5); padding: 7px 10px; white-space: nowrap;
            }
            .leaflet-tooltip.telf-tip::before { display: none; }

            .bnd { cursor: pointer; transition: fill-opacity .14s ease, color .14s ease; }

            .rail { scrollbar-width: thin; scrollbar-color: rgba(242,237,227,.14) transparent; }
            .rail::-webkit-scrollbar { width: 7px; height: 7px; }
            .rail::-webkit-scrollbar-track { background: transparent; }
            .rail::-webkit-scrollbar-thumb { background: rgba(242,237,227,.12); border-radius: 4px; }

            /* Ember readout: the fire count glows like coals. */
            .ember { text-shadow: 0 0 16px rgba(200,74,38,.55), 0 0 46px rgba(200,74,38,.24); }

            /* Scan-line used during the year play animation. */
            #scan { background: rgba(216,80,30,.7); box-shadow: 0 0 12px rgba(216,80,30,.5); }

            .tl-tick { transition: color .15s ease; }

            :focus-visible { outline: 2px solid #D8501E; outline-offset: 2px; border-radius: 3px; }
            .leaflet-container :focus-visible { outline: none; }

            @media (prefers-reduced-motion: reduce) {
                * { transition: none !important; animation: none !important; }
            }
        </style>
    </head>
    <body class="bg-[#0A0F0B] text-cream font-jetbrains-mono antialiased">
        <div class="flex flex-col lg:h-screen min-h-screen">

            {{-- Top bar — instrument strip --}}
            <header class="shrink-0 border-b border-white/8 bg-[#0C120E]">
                <div class="flex items-center justify-between gap-4 px-5 py-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-lime/12 ring-1 ring-lime/35 flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" class="shrink-0">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5" stroke="#D8501E" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5" stroke="#D8501E" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#D8501E" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="leading-tight min-w-0">
                            <div class="font-fraunces text-[15px] font-medium text-cream truncate">TELF</div>
                            <div class="font-jetbrains-mono text-[9px] uppercase tracking-[0.2em] text-[#7A8B7F] -mt-0.5 truncate">{{ $lang === 'en' ? 'Forest Fire · Sumatra' : 'Kebakaran Hutan · Sumatera' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <div class="grid grid-cols-2 gap-1 border border-white/10 rounded-full p-1 bg-white/5" id="mode-toggle">
                            <button type="button" data-mode="cell" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] rounded-full py-1 px-3 transition-colors text-ink bg-lime">{{ $lang === 'en' ? 'Points' : 'Titik' }}</button>
                            <button type="button" data-mode="heat" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] rounded-full py-1 px-3 transition-colors text-cream/50 hover:text-cream">{{ $lang === 'en' ? 'Heat' : 'Panas' }}</button>
                        </div>
                        <div class="grid grid-cols-2 gap-0.5 border border-white/10 rounded-full p-0.5 bg-white/5 shrink-0">
                            <a href="{{ url()->current() }}?lang=id" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] rounded-full px-2.5 py-1 transition-colors {{ $lang === 'id' ? 'text-ink bg-lime' : 'text-cream/50 hover:text-cream' }}">ID</a>
                            <a href="{{ url()->current() }}?lang=en" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] rounded-full px-2.5 py-1 transition-colors {{ $lang === 'en' ? 'text-ink bg-lime' : 'text-cream/50 hover:text-cream' }}">EN</a>
                        </div>
                        <a href="{{ route('home') }}" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-cream/50 hover:text-lime transition-colors border border-white/10 hover:border-lime/40 rounded-full px-3 py-1.5 shrink-0">{{ $lang === 'en' ? 'Home' : 'Beranda' }}</a>
                    </div>
                </div>
            </header>

            {{-- Filter strip: breadcrumb · intensity chips · count · reset --}}
            <div class="shrink-0 border-b border-white/8 bg-[#0C120E] px-5 py-2 flex items-center justify-between gap-4 flex-wrap">
                <div id="breadcrumb" class="flex items-center gap-2 font-jetbrains-mono text-[11px] overflow-x-auto whitespace-nowrap rail min-w-0"></div>

                <div class="flex items-center gap-3 shrink-0 flex-wrap">
                    <div id="dn-toggles" class="flex items-center gap-1.5">
                        <label class="flex items-center gap-1.5 cursor-pointer pl-2 pr-2.5 py-1 rounded-full border border-white/10 text-[#7A8B7F] has-[:checked]:border-loss has-[:checked]:bg-loss/15 has-[:checked]:text-cream transition-colors text-[11px]">
                            <input type="checkbox" value="3" checked class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-loss"></span>
                            <span>{{ $lang === 'en' ? 'High' : 'Tinggi' }}</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer pl-2 pr-2.5 py-1 rounded-full border border-white/10 text-[#7A8B7F] has-[:checked]:border-amber has-[:checked]:bg-amber/15 has-[:checked]:text-cream transition-colors text-[11px]">
                            <input type="checkbox" value="2" checked class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-amber"></span>
                            <span>{{ $lang === 'en' ? 'Moderate' : 'Sedang' }}</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer pl-2 pr-2.5 py-1 rounded-full border border-white/10 text-[#7A8B7F] has-[:checked]:border-[#E8C547] has-[:checked]:bg-[#E8C547]/15 has-[:checked]:text-cream transition-colors text-[11px]">
                            <input type="checkbox" value="1" checked class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-[#E8C547]"></span>
                            <span>{{ $lang === 'en' ? 'Low' : 'Rendah' }}</span>
                        </label>
                    </div>
                    <span class="w-px h-5 bg-white/10"></span>
                    <span id="footer-count" class="font-jetbrains-mono text-[11px] text-[#8FA392] tabular-nums">0 {{ $lang === 'en' ? 'points' : 'titik' }}</span>
                    <button id="f-reset" type="button" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.16em] text-[#8FA392] hover:text-lime border border-white/10 hover:border-lime/40 rounded-full px-3 py-1 transition-colors">{{ $lang === 'en' ? 'Reset' : 'Atur ulang' }}</button>
                </div>
            </div>

            {{-- Main: dark map plate + dark readout rail --}}
            <main class="flex-1 grid grid-cols-1 lg:grid-cols-[1fr_320px] min-h-0">

                {{-- Map plate — the field at night --}}
                <section class="relative bg-[#0A0F0B] min-h-[60vh] lg:min-h-0">
                    <div id="map" class="absolute inset-0"></div>

                    {{-- Instrument rulers (quiet) --}}
                    <div class="absolute top-0 bottom-14 left-0 w-2.5 pointer-events-none z-[450]" style="background:repeating-linear-gradient(to bottom, rgba(242,237,227,.13) 0 1px, transparent 1px 9px)"></div>
                    <div class="absolute left-0 right-0 bottom-14 h-2.5 pointer-events-none z-[450]" style="background:repeating-linear-gradient(to right, rgba(242,237,227,.13) 0 1px, transparent 1px 9px)"></div>

                    {{-- Scan-line for the year play animation --}}
                    <div id="scan" class="absolute top-0 bottom-14 w-px hidden pointer-events-none z-[465]" style="left:0px"></div>

                    {{-- DN spectrum legend (instrument) --}}
                    <div class="absolute top-3 right-3 z-[455] pointer-events-none select-none">
                        <div class="rounded-lg border border-white/10 bg-ink/70 backdrop-blur-sm px-3 py-2">
                            <div class="font-jetbrains-mono text-[9px] uppercase tracking-[0.22em] text-cream/50 mb-1.5">{{ $lang === 'en' ? 'Intensity spectrum' : 'Spektrum intensitas' }}</div>
                            <div class="h-2 w-40 rounded-full" style="background:linear-gradient(to right,#2F7A3C,#E8C547,#E8A93A,#C84A26)"></div>
                            <div class="flex justify-between font-jetbrains-mono text-[9px] text-cream/40 mt-1">
                                <span>DN ≤9</span><span>13–21</span><span>≥25</span>
                            </div>
                        </div>
                    </div>

                    <div id="loading" class="absolute inset-0 z-[470] flex items-center justify-center pointer-events-none">
                        <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.22em] text-[#8FA392] bg-black/55 px-3 py-1.5 rounded-full border border-white/10">{{ $lang === 'en' ? 'loading data…' : 'memuat data…' }}</span>
                    </div>

                    {{-- Timeline — year slider --}}
                    <div id="timeline" class="absolute bottom-0 left-0 right-0 z-[460] h-14 bg-black/70 backdrop-blur-sm border-t border-white/10 flex items-center gap-3 px-4">
                        <button id="tl-play" type="button" aria-label="{{ $lang === 'en' ? 'Play year animation' : 'Putar animasi tahun' }}" class="shrink-0 w-8 h-8 rounded-full border border-white/20 text-cream/70 hover:text-lime hover:border-lime/50 transition-colors flex items-center justify-center text-[12px] leading-none">▶</button>
                        <div id="tl-track" class="relative flex-1 h-10 cursor-pointer touch-none select-none">
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-px bg-white/20"></div>
                            <div id="tl-ticks" class="absolute inset-0"></div>
                            <div id="tl-handle" class="absolute top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 rounded-full bg-lime shadow-[0_0_0_3px_rgba(216,80,30,0.22)]" style="left:10px"></div>
                        </div>
                        <span id="tl-year" class="font-fraunces text-xl text-lime shrink-0 w-16 text-right tabular-nums">2024</span>
                        <span class="font-jetbrains-mono text-[9px] text-white/25 shrink-0 hidden md:block">© Google</span>
                    </div>
                </section>

                {{-- Readout rail — telemetry --}}
                <aside class="rail border-t lg:border-t-0 lg:border-l border-white/8 bg-[#0D1410] overflow-y-auto">
                    <div class="p-5 space-y-7">
                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5F7466] mb-2">{{ $lang === 'en' ? 'Summary' : 'Ringkasan' }}</p>
                            <div class="flex items-baseline gap-2">
                                <span id="kpi-alerts" class="font-fraunces text-[44px] leading-none font-medium text-loss">0</span>
                                <span class="font-jetbrains-mono text-[11px] uppercase tracking-[0.18em] text-[#7A8B7F]">{{ $lang === 'en' ? 'points' : 'titik' }}</span>
                            </div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] text-[#5F7466] mt-2">
                                <span id="kpi-area" class="normal-case tracking-normal text-[#8FA392]">Sumatera</span>
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5F7466]">{{ $lang === 'en' ? 'Yearly Trend' : 'Tren Tahunan' }}</p>
                                <span id="trend-peak" class="font-jetbrains-mono text-[10px] text-[#5F7466]"></span>
                            </div>
                            <div id="trend-chart"></div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5F7466]">{{ $lang === 'en' ? 'Intensity Levels' : 'Tingkat Intensitas' }}</p>
                                <span id="dn-total" class="font-jetbrains-mono text-[10px] text-[#5F7466]"></span>
                            </div>
                            <div id="dn-summary"></div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p id="by-title" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5F7466]">{{ $lang === 'en' ? 'By Province' : 'Berdasarkan Provinsi' }}</p>
                                <span id="by-count" class="font-jetbrains-mono text-[10px] text-[#5F7466]"></span>
                            </div>
                            <div id="prov-bars" class="space-y-2"></div>
                        </div>
                    </div>
                </aside>
            </main>
        </div>

        <script>
            (function () {
                const LANG = @json($lang);
                const I18N = {
                    loadFail: LANG === 'en' ? 'failed to load data' : 'gagal memuat data',
                    subd: LANG === 'en' ? 'Subd.' : 'Kec.',
                    points: LANG === 'en' ? 'points' : 'titik',
                    regions: LANG === 'en' ? 'regions' : 'wilayah',
                    region: LANG === 'en' ? 'Region' : 'Wilayah',
                    peak: LANG === 'en' ? 'peak ' : 'puncak ',
                    byPrefix: LANG === 'en' ? 'By ' : 'Berdasarkan ',
                    byProvince: LANG === 'en' ? 'Province' : 'Provinsi',
                    byRegency: LANG === 'en' ? 'Regency' : 'Kabupaten',
                    bySubdistrict: LANG === 'en' ? 'Subdistrict' : 'Kecamatan',
                    noFire: LANG === 'en' ? 'No fire points in this area.' : 'Tidak ada titik kebakaran pada wilayah ini.',
                    play: LANG === 'en' ? 'Play year animation' : 'Putar animasi tahun',
                    pause: LANG === 'en' ? 'Pause animation' : 'Jeda animasi',
                };
                const DN = {
                    3: { color: '#C84A26', label: LANG === 'en' ? 'High' : 'Tinggi', range: 'DN ≥25' },
                    2: { color: '#E8A93A', label: LANG === 'en' ? 'Moderate' : 'Sedang', range: 'DN 13–21' },
                    1: { color: '#E8C547', label: LANG === 'en' ? 'Low' : 'Rendah', range: 'DN ≤9' },
                };
                const fmt = (n) => Number(n || 0).toLocaleString('id-ID');
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                // Fire intensity → 3 tiers. Raw DN values: 3,5,9 / 13,21 / 25,35,40,76.
                const tierOf = (dn) => dn <= 9 ? 1 : (dn <= 21 ? 2 : 3);

                const cellSize = () => { const z = map.getZoom(); return Math.max(2, Math.min(12, 3 + (z - 6))); };

                // ---- Spatial grid for hover-tooltipping the nearest fire point ----
                const GRID = 40; let pointGrid = new Map(), gridPts = null;
                function buildGrid(pts) {
                    pointGrid = new Map();
                    pts.forEach((pt, i) => {
                        const key = Math.floor(pt[0] * GRID) + ',' + Math.floor(pt[1] * GRID);
                        let arr = pointGrid.get(key);
                        if (!arr) { arr = []; pointGrid.set(key, arr); }
                        arr.push(i);
                    });
                    gridPts = pts;
                }
                function nearestPoint(latlng) {
                    if (!gridPts || !gridPts.length) return null;
                    const blat = Math.floor(latlng.lat * GRID), blng = Math.floor(latlng.lng * GRID);
                    let best = null, bestD = Infinity;
                    for (let dy = -1; dy <= 1; dy++) for (let dx = -1; dx <= 1; dx++) {
                        const arr = pointGrid.get((blat + dy) + ',' + (blng + dx));
                        if (!arr) continue;
                        for (const i of arr) {
                            const pt = gridPts[i];
                            const dlat = pt[0] - latlng.lat, dlng = pt[1] - latlng.lng;
                            const d = dlat * dlat + dlng * dlng;
                            if (d < bestD) { bestD = d; best = pt; }
                        }
                    }
                    return best;
                }

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
                const state = { level: 'prov', dn: new Set([1, 2, 3]), year: null, mode: 'cell' };
                let lastFiltered = [];
                let tipMarker = null, heatLayer = null;

                const STYLES = {
                    prov: { color: '#6B7B4E', weight: 1.5, opacity: 0.9, fillOpacity: 0.04 },
                    kab:  { color: '#6B7B4E', weight: 1.2, opacity: 0.8, fillOpacity: 0.05 },
                    kec:  { color: '#6B7B4E', weight: 1.0, opacity: 0.7, fillOpacity: 0.06 },
                    desa: { color: '#F2EDE3', weight: 0.6, opacity: 0.5, fillOpacity: 0.05 },
                };

                function boot() {
                    if (typeof L === 'undefined') { return setTimeout(boot, 50); }
                    map = L.map('map', { zoomControl: true, attributionControl: false, scrollWheelZoom: true })
                        .setView([-0.5, 101.5], 6);
                    L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], maxZoom: 20, attribution: '&copy; Google',
                    }).addTo(map);

                    tipMarker = L.circleMarker([0, 0], { radius: 0, opacity: 0, fillOpacity: 0, stroke: false, interactive: false })
                        .bindTooltip('', { className: 'telf-tip', direction: 'top', offset: [0, -6] })
                        .addTo(map);
                    let lastTipKey = null;
                    const closeTip = () => { if (lastTipKey) { tipMarker.closeTooltip(); lastTipKey = null; } };
                    map.on('movestart', closeTip);
                    map.on('zoomstart', closeTip);
                    map.getContainer().addEventListener('mousemove', (e) => {
                        const rect = map.getContainer().getBoundingClientRect();
                        const cp = [e.clientX - rect.left, e.clientY - rect.top];
                        const ll = map.containerPointToLatLng(cp);
                        const pt = nearestPoint(ll);
                        if (!pt) { closeTip(); return; }
                        const pp = map.latLngToContainerPoint([pt[0], pt[1]]);
                        const thr = cellSize() / 2 + 6;
                        if ((pp.x - cp[0]) * (pp.x - cp[0]) + (pp.y - cp[1]) * (pp.y - cp[1]) > thr * thr) { closeTip(); return; }
                        const key = pt[0] + ',' + pt[1] + ',' + pt[2] + ',' + pt[3];
                        if (key !== lastTipKey) {
                            const a = kecLookup.get(pt[4]);
                            tipMarker.setLatLng([pt[0], pt[1]]);
                            tipMarker.setTooltipContent('DN ' + pt[2] + ' · ' + pt[3] + ' · ' + I18N.subd + ' ' + (a ? a.kecamatan : '—'));
                            tipMarker.openTooltip();
                            lastTipKey = key;
                        }
                    });
                    map.getContainer().addEventListener('mouseout', closeTip);

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
                    }).catch((e) => {
                        document.getElementById('loading').textContent = I18N.loadFail;
                        console.error(e);
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
                    tag.textContent = I18N.region;
                    tag.className = 'font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-[#5F7466] shrink-0';
                    bc.appendChild(tag);
                    crumbs.forEach((c, idx) => {
                        if (idx > 0) {
                            const s = document.createElement('span');
                            s.textContent = '›'; s.className = 'text-lime/40 shrink-0';
                            bc.appendChild(s);
                        }
                        const b = document.createElement('button');
                        b.type = 'button'; b.textContent = c.t;
                        b.className = 'hover:text-lime transition-colors truncate max-w-[220px] '
                            + (idx === crumbs.length - 1 ? ' text-cream font-medium' : 'text-[#8FA392]');
                        b.addEventListener('click', () => goToLevel(c.l));
                        bc.appendChild(b);
                    });
                }

                // ---- Fire points (cells / heatmap) ----
                function filtered(applyYear) {
                    if (applyYear === undefined) applyYear = true;
                    return FIRES.filter((pt) => {
                        if (applyYear && state.year !== null && pt[3] !== state.year) return false;
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
                    const baseData = filtered(false);
                    const data = (state.year !== null) ? baseData.filter((pt) => pt[3] === state.year) : baseData;
                    lastFiltered = data;
                    buildGrid(data);

                    const heatOk = (typeof L !== 'undefined' && typeof L.heatLayer === 'function');
                    if (state.mode === 'heat' && heatOk) {
                        if (cellLayer && map.hasLayer(cellLayer)) map.removeLayer(cellLayer);
                        const hpts = data.map((pt) => {
                            const t = tierOf(pt[2]);
                            return [pt[0], pt[1], t === 3 ? 1.0 : (t === 2 ? 0.6 : 0.3)];
                        });
                        if (!heatLayer) {
                            heatLayer = L.heatLayer(hpts, {
                                radius: 18, blur: 22, max: 1.0, minOpacity: 0.2,
                                gradient: { 0.0: '#2F7A3C', 0.3: '#E8C547', 0.6: '#E8A93A', 1.0: '#C84A26' },
                            }).addTo(map);
                        } else {
                            heatLayer.setLatLngs(hpts);
                            if (!map.hasLayer(heatLayer)) heatLayer.addTo(map);
                        }
                    } else {
                        if (heatLayer && map.hasLayer(heatLayer)) map.removeLayer(heatLayer);
                        const pts = data.map((pt) => {
                            const t = tierOf(pt[2]);
                            const alpha = t === 3 ? 0.92 : (t === 2 ? 0.8 : 0.62);
                            return [pt[0], pt[1], (DN[t] || DN[1]).color, alpha];
                        });
                        if (!cellLayer) {
                            const Cls = CellLayerClass || (CellLayerClass = buildCellLayer());
                            cellLayer = new Cls(pts, { baseCell: 3 }).addTo(map);
                        } else {
                            if (!map.hasLayer(cellLayer)) cellLayer.addTo(map);
                            cellLayer.setLatLngs(pts);
                        }
                    }
                    renderStats(data, baseData);
                }

                function renderStats(data, baseData) {
                    document.getElementById('kpi-alerts').textContent = fmt(data.length);
                    document.getElementById('kpi-alerts').classList.toggle('ember', data.length > 0);
                    const areaName = sel.kecamatan || sel.kabupaten || sel.province || 'Sumatera';
                    document.getElementById('kpi-area').textContent = areaName;
                    document.getElementById('footer-count').textContent = fmt(data.length) + ' ' + I18N.points;

                    // Intensity breakdown — vertical bar chart
                    const sum = { 3: 0, 2: 0, 1: 0 };
                    data.forEach((pt) => { sum[tierOf(pt[2])]++; });
                    const total = Math.max(1, data.length);
                    const maxDn = Math.max(1, sum[3], sum[2], sum[1]);
                    const cs = document.getElementById('dn-summary');
                    cs.innerHTML = '';
                    document.getElementById('dn-total').textContent = 'Σ ' + fmt(data.length);

                    const grid = document.createElement('div');
                    grid.className = 'relative h-32 border-b border-white/10';
                    [25, 50, 75].forEach((pct) => {
                        const g = document.createElement('span');
                        g.className = 'absolute left-0 right-0 h-px bg-white/6';
                        g.style.bottom = pct + '%';
                        grid.appendChild(g);
                    });
                    const plot = document.createElement('div');
                    plot.className = 'absolute inset-0 flex items-end gap-3 px-1';
                    [3, 2, 1].forEach((k) => {
                        const col = document.createElement('div');
                        col.className = 'flex-1 flex flex-col items-center justify-end h-full gap-1';
                        const val = document.createElement('span');
                        val.className = 'font-jetbrains-mono text-[10px] text-[#8FA392]';
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
                            '<span class="text-[10px] text-[#A9B4AD]">' + DN[k].label + '</span>' +
                            '<span class="font-jetbrains-mono text-[9px] text-[#5F7466]">' + DN[k].range + '</span>';
                        dleg.appendChild(c);
                    });
                    cs.appendChild(dleg);

                    // Region distribution — horizontal bar chart
                    const groupKey = state.level === 'prov' ? 'province' : (state.level === 'kab' ? 'kabupaten' : 'kecamatan');
                    document.getElementById('by-title').textContent =
                        I18N.byPrefix + (state.level === 'prov' ? I18N.byProvince : state.level === 'kab' ? I18N.byRegency : I18N.bySubdistrict);
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
                    document.getElementById('by-count').textContent = entries.length ? (entries.length + ' ' + I18N.regions) : '';
                    if (entries.length === 0) {
                        const e = document.createElement('p');
                        e.className = 'text-[12px] text-[#7A8B7F]';
                        e.textContent = I18N.noFire;
                        bars.appendChild(e);
                    } else {
                        const axis = document.createElement('div');
                        axis.className = 'flex items-center gap-2 mb-1.5';
                        axis.innerHTML =
                            '<span class="w-24 shrink-0"></span>' +
                            '<div class="flex-1 flex justify-between font-jetbrains-mono text-[9px] text-[#5F7466]">' +
                            '<span>0</span><span>' + fmt(Math.round(max / 2)) + '</span><span>' + fmt(max) + '</span>' +
                            '</div>' +
                            '<span class="w-9 shrink-0"></span>';
                        bars.appendChild(axis);
                        entries.forEach(([p, v]) => {
                            const row = document.createElement('div');
                            row.className = 'flex items-center gap-2';
                            row.innerHTML =
                                '<span class="text-[11px] text-[#B7C1BA] truncate w-24 shrink-0" title="' + p + '">' + p + '</span>' +
                                '<div class="relative flex-1 h-3.5 rounded-[1px] bg-white/6 overflow-hidden">' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-white/10" style="left:25%"></span>' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-white/10" style="left:50%"></span>' +
                                    '<span class="absolute top-0 bottom-0 w-px bg-white/10" style="left:75%"></span>' +
                                    '<div class="relative h-full rounded-[1px] transition-[width] duration-300" style="width:' + (v / max * 100) + '%;min-width:2px;background:#C84A26"></div>' +
                                '</div>' +
                                '<span class="font-jetbrains-mono text-[10px] text-[#8FA392] w-9 text-right shrink-0">' + fmt(v) + '</span>';
                            bars.appendChild(row);
                        });
                    }

                    // ---- Tren tahunan (region + DN, semua tahun) ----
                    const years = YEARS.length ? YEARS : Array.from(new Set(FIRES.map((p) => p[3]))).sort((a, b) => a - b);
                    const yc = {}; years.forEach((y) => { yc[y] = 0; });
                    baseData.forEach((pt) => { yc[pt[3]] = (yc[pt[3]] || 0) + 1; });
                    const maxY = Math.max(1, ...years.map((y) => yc[y]));
                    const peak = years.reduce((a, b) => (yc[a] >= yc[b] ? a : b), years[0]);
                    document.getElementById('trend-peak').textContent = I18N.peak + peak;
                    const tc = document.getElementById('trend-chart');
                    tc.innerHTML = '';
                    const tplot = document.createElement('div');
                    tplot.className = 'flex items-end gap-1.5 h-20';
                    const tlabels = document.createElement('div');
                    tlabels.className = 'flex gap-1.5 mt-1.5';
                    years.forEach((y) => {
                        const v = yc[y] || 0;
                        const sel = (y === state.year);
                        const col = document.createElement('button');
                        col.type = 'button';
                        col.className = 'flex-1 flex flex-col items-center justify-end gap-1 h-full';
                        const cnt = document.createElement('span');
                        cnt.className = 'font-jetbrains-mono text-[9px] ' + (sel ? 'text-lime' : 'text-[#5F7466]');
                        cnt.textContent = fmt(v);
                        const bar = document.createElement('div');
                        bar.className = 'w-full rounded-t-[2px] transition-[height] duration-300 ' + (sel ? 'bg-lime' : 'bg-[#C84A26]/40 hover:bg-[#C84A26]/60');
                        bar.style.height = (v / maxY * 100) + '%';
                        bar.style.minHeight = '2px';
                        col.appendChild(cnt);
                        col.appendChild(bar);
                        col.addEventListener('click', () => setYear(y));
                        tplot.appendChild(col);
                        const lab = document.createElement('span');
                        lab.className = 'flex-1 text-center font-jetbrains-mono text-[9px] ' + (sel ? 'text-lime' : 'text-[#7A8B7F]');
                        lab.textContent = String(y);
                        tlabels.appendChild(lab);
                    });
                    tc.appendChild(tplot);
                    tc.appendChild(tlabels);
                }

                // ---- Year timeline (MapBiomas-style slider) ----
                let YEARS = [];
                let tlTimer = null, tlDragging = false, scanTimer = null;
                const tlTrack = () => document.getElementById('tl-track');
                const PAD = 12;

                // Scan-line sweeps the map when the year animation plays.
                function sweepScan() {
                    const s = document.getElementById('scan');
                    const el = document.getElementById('map');
                    if (!s || !el || reduceMotion) return;
                    const w = el.clientWidth;
                    s.classList.remove('hidden');
                    s.style.transition = 'none';
                    s.style.left = '0px';
                    void s.offsetWidth;
                    s.style.transition = 'left 1.1s cubic-bezier(.6,.05,.3,1)';
                    s.style.left = w + 'px';
                    clearTimeout(scanTimer);
                    scanTimer = setTimeout(() => s.classList.add('hidden'), 1250);
                }

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
                            + (Number(t.dataset.year) === state.year ? 'text-lime' : 'text-cream/40');
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
                    document.querySelectorAll('.tl-tick').forEach((t) => {
                        t.style.left = yearToX(Number(t.dataset.year)) + 'px';
                    });
                    moveHandle();
                }
                function stopPlay() {
                    if (tlTimer) { clearInterval(tlTimer); tlTimer = null; }
                    clearTimeout(scanTimer);
                    const s = document.getElementById('scan');
                    if (s) s.classList.add('hidden');
                    const btn = document.getElementById('tl-play');
                        btn.textContent = '▶'; btn.classList.remove('text-lime'); btn.setAttribute('aria-label', I18N.play);
                }
                function buildTimeline() {
                    YEARS = Array.from(new Set(FIRES.map((p) => p[3]))).sort((a, b) => a - b);
                    const inner = document.getElementById('tl-ticks');
                    inner.innerHTML = '';
                    YEARS.forEach((y) => {
                        const t = document.createElement('span');
                        t.className = 'tl-tick absolute top-0 -translate-x-1/2 font-jetbrains-mono text-[10px] text-cream/40 pointer-events-none';
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
                        btn.textContent = '⏸'; btn.classList.add('text-lime'); btn.setAttribute('aria-label', I18N.pause);
                        tlTimer = setInterval(() => {
                            let i = YEARS.indexOf(state.year);
                            i = (i + 1) % YEARS.length;
                            sweepScan();
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

                document.querySelectorAll('#mode-toggle button').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        state.mode = btn.dataset.mode;
                        document.querySelectorAll('#mode-toggle button').forEach((b) => {
                            const active = b.dataset.mode === state.mode;
                            b.className = 'font-jetbrains-mono text-[10px] uppercase tracking-[0.14em] rounded-full py-1 px-3 transition-colors ' + (active ? 'text-ink bg-lime' : 'text-cream/50 hover:text-cream');
                        });
                        render();
                    });
                });

                boot();
            })();
        </script>
    </body>
</html>
