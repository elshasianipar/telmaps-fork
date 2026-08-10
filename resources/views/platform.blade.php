<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'TELF') }} · Pemantauan Hilang Hutan</title>

        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌳</text></svg>">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous" defer></script>

        <style>
            html, body { height: 100%; }
            body { -webkit-font-smoothing: antialiased; }
            #map { height: 100%; min-height: 320px; background: #0E1A12; }
            .leaflet-container { background: #0E1A12; font-family: 'Inter', sans-serif; }
            .leaflet-tooltip.telf-tip {
                font-family: 'JetBrains Mono', monospace; font-size: 11px;
                background: #0E1A12; color: #F2EDE3; border: 1px solid rgba(242,237,227,.18);
                border-radius: 6px; box-shadow: none; padding: 8px 10px; white-space: nowrap;
            }
            .leaflet-tooltip.telf-tip::before { display: none; }
            .graticule {
                background-image:
                    linear-gradient(to right, rgba(200,216,74,.05) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(200,216,74,.05) 1px, transparent 1px);
                background-size: 48px 48px;
            }
            .corner-tick { width: 18px; height: 18px; }
            .bnd { cursor: pointer; transition: fill-opacity .12s; }
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(28,58,20,.2); border-radius: 4px; }
            @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
        </style>
    </head>
    <body class="bg-cream text-ink font-inter antialiased">
        <div class="flex flex-col lg:h-screen min-h-screen">
            {{-- Header --}}
            <header class="border-b border-forest/15 bg-cream/95 backdrop-blur-sm z-30">
                <div class="flex items-center justify-between gap-4 px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-forest flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M9 2C5.5 2 3 5 3 9c0 2 .8 3.8 2 5" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2c3.5 0 6 3 6 7 0 2-.8 3.8-2 5" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M9 2v14M6 7s1.5 1 3 1 3-1 3-1M5 12s1.5 1 4 1 4-1 4-1" stroke="#C8D84A" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <div class="font-fraunces text-base font-medium text-forest">TELF</div>
                            <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/70 -mt-0.5">Pemantauan Hilang Hutan</div>
                        </div>
                    </div>

                    <div class="hidden sm:flex items-center gap-2 font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/60">
                        <span class="h-1 w-1 rounded-full bg-loss"></span>
                        <span>GLAD 2026 · Sumatera</span>
                    </div>

                    <a href="{{ route('home') }}" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/70 hover:text-forest transition-colors border border-forest/20 rounded-full px-3 py-1.5">
                        ← Beranda
                    </a>
                </div>
                {{-- Breadcrumb drill --}}
                <div id="breadcrumb" class="border-t border-forest/15 px-5 py-2 flex items-center gap-1.5 font-jetbrains-mono text-[11px] text-bark/70 overflow-x-auto whitespace-nowrap"></div>
            </header>

            {{-- Main: filters · map · stats --}}
            <main class="flex-1 grid grid-cols-1 lg:grid-cols-[256px_1fr_300px] min-h-0">
                {{-- Left rail --}}
                <aside class="border-b lg:border-b-0 lg:border-r border-forest/15 bg-cream overflow-y-auto">
                    <div class="p-5 space-y-6">
                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50 mb-3">Telusuri Wilayah</p>
                            <h2 class="font-fraunces text-xl font-normal text-forest leading-tight">Alert kehilangan hutan</h2>
                            <p class="text-xs text-bark/70 leading-relaxed mt-2">Klik batas pada peta untuk menelusuri: <span class="text-forest">provinsi → kabupaten → kecamatan → desa</span>.</p>
                        </div>

                        <div>
                            <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/60 block mb-2">Tingkat Keyakinan</span>
                            <div class="space-y-1.5" id="dn-toggles">
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm">
                                    <input type="checkbox" value="3" checked class="accent-[#C84A26] w-4 h-4">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-loss"></span>
                                    <span>Tinggi (DN 3)</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm">
                                    <input type="checkbox" value="2" checked class="accent-[#E8A93A] w-4 h-4">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-amber"></span>
                                    <span>Sedang (DN 2)</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer text-sm">
                                    <input type="checkbox" value="1" checked class="accent-[#E8C547] w-4 h-4">
                                    <span class="w-2.5 h-2.5 rounded-[1px] bg-[#E8C547]"></span>
                                    <span>Rendah (DN 1)</span>
                                </label>
                            </div>
                        </div>

                        <button id="f-reset" type="button" class="w-full font-jetbrains-mono text-[11px] uppercase tracking-[0.18em] text-forest border border-forest/25 rounded-full py-2 hover:bg-forest hover:text-cream transition-colors">
                            Atur Ulang
                        </button>

                        <div class="pt-4 border-t border-forest/15">
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50 mb-2">Sumber</p>
                            <p class="text-xs text-bark/70 leading-relaxed">GLAD Alert (UMD/Landsat) 2026 · Batas administrasi Sumatera — provinsi, kabupaten, kecamatan, desa (Kemendagri). 5.684 sel alert Sumatera dari 2,18 juta (sampel), diklasifikasi per tingkat keyakinan.</p>
                        </div>
                    </div>
                </aside>

                {{-- Center: map --}}
                <section class="relative bg-ink min-h-0">
                    <div id="map" class="absolute inset-0"></div>

                    <div class="graticule pointer-events-none absolute inset-0 z-[400]"></div>

                    <div class="corner-tick pointer-events-none absolute top-3 left-3 z-[450] border-l-2 border-t-2 border-cream/40"></div>
                    <div class="corner-tick pointer-events-none absolute top-3 right-3 z-[450] border-r-2 border-t-2 border-cream/40"></div>
                    <div class="corner-tick pointer-events-none absolute bottom-3 left-3 z-[450] border-l-2 border-b-2 border-cream/40"></div>
                    <div class="corner-tick pointer-events-none absolute bottom-3 right-3 z-[450] border-r-2 border-b-2 border-cream/40"></div>

                    <div class="absolute top-3 left-1/2 -translate-x-1/2 z-[460] pointer-events-none">
                        <div class="font-jetbrains-mono text-[10px] uppercase tracking-[0.25em] text-cream/55 bg-ink/40 px-3 py-1 rounded-full border border-cream/15">
                            Lembar 02 · Sumatera
                        </div>
                    </div>

                    <div id="loading" class="absolute inset-0 z-[470] flex items-center justify-center pointer-events-none">
                        <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-cream/50 bg-ink/50 px-3 py-1.5 rounded-full border border-cream/15">memuat data…</span>
                    </div>

                    <div class="absolute bottom-4 right-4 z-[460] pointer-events-none font-jetbrains-mono text-[10px] text-cream/45 flex flex-col items-center gap-0.5">
                        <span>↑</span><span class="uppercase tracking-widest">U</span>
                    </div>
                </section>

                {{-- Right rail: stats --}}
                <aside class="border-t lg:border-t-0 lg:border-l border-forest/15 bg-cream overflow-y-auto">
                    <div class="p-5 space-y-7">
                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50 mb-1">Ringkasan</p>
                            <div class="flex items-end gap-2">
                                <span id="kpi-alerts" class="font-jetbrains-mono text-4xl font-medium text-loss leading-none">0</span>
                                <span class="font-jetbrains-mono text-xs text-bark/60 mb-1">alert</span>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-3">
                                <div class="border border-forest/15 rounded-lg px-3 py-2">
                                    <div id="kpi-high" class="font-jetbrains-mono text-lg text-loss">0</div>
                                    <div class="font-jetbrains-mono text-[10px] uppercase tracking-widest text-bark/55">Keyakinan Tinggi</div>
                                </div>
                                <div class="border border-forest/15 rounded-lg px-3 py-2 min-w-0">
                                    <div id="kpi-area" class="font-jetbrains-mono text-sm text-forest truncate">Sumatera</div>
                                    <div class="font-jetbrains-mono text-[10px] uppercase tracking-widest text-bark/55">Wilayah</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p id="by-title" class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50 mb-3">Berdasarkan Provinsi</p>
                            <div id="prov-bars" class="space-y-2.5"></div>
                        </div>

                        <div>
                            <p class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50 mb-3">Tingkat Keyakinan</p>
                            <div id="dn-summary" class="space-y-2 text-sm"></div>
                        </div>
                    </div>
                </aside>
            </main>

            {{-- Legend strip --}}
            <footer class="border-t border-forest/15 bg-cream">
                <div class="px-5 py-3 flex flex-wrap items-center gap-x-5 gap-y-2">
                    <span class="font-jetbrains-mono text-[10px] uppercase tracking-[0.2em] text-bark/50">Legenda</span>
                    <span class="flex items-center gap-2 text-sm"><span class="w-2.5 h-2.5 rounded-[1px] bg-loss"></span>Keyakinan Tinggi</span>
                    <span class="flex items-center gap-2 text-sm"><span class="w-2.5 h-2.5 rounded-[1px] bg-amber"></span>Keyakinan Sedang</span>
                    <span class="flex items-center gap-2 text-sm"><span class="w-2.5 h-2.5 rounded-[1px] bg-[#E8C547]"></span>Keyakinan Rendah</span>
                    <span class="flex items-center gap-2 text-sm"><span class="w-4 h-0.5 bg-lime"></span>Batas Wilayah (klik)</span>
                    <span class="ml-auto font-jetbrains-mono text-[10px] uppercase tracking-[0.18em] text-bark/50" id="footer-count">0 alert</span>
                </div>
            </footer>
        </div>

        <script>
            (function () {
                const DN = {
                    3: { color: '#C84A26', label: 'Tinggi' },
                    2: { color: '#E8A93A', label: 'Sedang' },
                    1: { color: '#E8C547', label: 'Rendah' },
                };
                const fmt = (n) => Number(n || 0).toLocaleString('id-ID');

                // ---- Custom canvas layer: crisp solid square cells per alert ----
                let CellLayerClass = null;
                function buildCellLayer() {
                    return L.Layer.extend({
                        options: { baseCell: 3, minCell: 2, maxCell: 12, alpha: 0.8 },
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
                            if (map.options.zoomAnimation && L.Browser.any3d) {
                                map.on('zoomanim', this._animateZoom, this);
                            }
                            this._reset();
                        },
                        onRemove(map) {
                            map.getPanes().overlayPane.removeChild(this._canvas);
                            map.off('moveend', this._reset, this);
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
                            ctx.globalAlpha = this.options.alpha;
                            const pts = this._latlngs;
                            for (let i = 0; i < pts.length; i++) {
                                const p = pts[i];
                                const pt = map.latLngToContainerPoint([p[0], p[1]]);
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
                let ALERTS = [], PROVINCES = [], REGS = [], KECS = [];
                const desaCache = {};
                let provBoundsAll = null;
                const sel = { province: null, kabupaten: null, kecCode: null, kabCode: null, kecamatan: null };
                const state = { level: 'prov', dn: new Set([1, 2, 3]) };

                const STYLES = {
                    prov: { color: '#C8D84A', weight: 1.5, opacity: 0.9, fillOpacity: 0.04 },
                    kab:  { color: '#C8D84A', weight: 1.2, opacity: 0.8, fillOpacity: 0.05 },
                    kec:  { color: '#C8D84A', weight: 1.0, opacity: 0.7, fillOpacity: 0.06 },
                    desa: { color: '#F2EDE3', weight: 0.6, opacity: 0.5, fillOpacity: 0.05 },
                };

                function boot() {
                    if (typeof L === 'undefined') { return setTimeout(boot, 50); }
                    map = L.map('map', { zoomControl: true, attributionControl: true, scrollWheelZoom: true })
                        .setView([-0.5, 101.5], 6);
                    L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], maxZoom: 20, attribution: '&copy; Google',
                    }).addTo(map);
                    Promise.all([
                        fetch('/data/sumatera_provinces.geojson').then((r) => r.json()),
                        fetch('/data/sumatera_regencies.geojson').then((r) => r.json()),
                        fetch('/data/sumatera_kecamatan.geojson').then((r) => r.json()),
                        fetch('/data/glad_alerts_2026.geojson').then((r) => r.json()),
                    ]).then(([provs, regs, kecs, alerts]) => {
                        PROVINCES = provs.features;
                        REGS = regs.features;
                        KECS = kecs.features;
                        ALERTS = alerts.features;
                        provBoundsAll = L.geoJSON(PROVINCES).getBounds();
                        document.getElementById('loading').style.display = 'none';
                        renderBoundary();
                        updateBreadcrumb();
                        if (provBoundsAll.isValid()) map.fitBounds(provBoundsAll, { padding: [10, 10] });
                        render();
                    }).catch((e) => {
                        document.getElementById('loading').textContent = 'gagal memuat data';
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
                            lyr.addClass && lyr.addClass('bnd');
                            const tip = f.properties[tipKey];
                            if (tip) lyr.bindTooltip(tip, { className: 'telf-tip', direction: 'top', sticky: true });
                            if (onClick) lyr.on('click', () => onClick(f));
                            lyr.on('mouseover', () => lyr.setStyle({ color: '#F2EDE3', weight: (style.weight || 1) + 1, opacity: 1, fillOpacity: 0.12 }));
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
                        if (b.isValid()) { map.fitBounds(b, { padding: [12, 12] }); return; }
                    }
                    if (provBoundsAll && provBoundsAll.isValid()) map.fitBounds(provBoundsAll, { padding: [10, 10] });
                }

                function updateBreadcrumb() {
                    const bc = document.getElementById('breadcrumb');
                    const crumbs = [{ l: 'prov', t: 'Sumatera' }];
                    if (sel.province) crumbs.push({ l: 'kab', t: sel.province });
                    if (sel.kabupaten) crumbs.push({ l: 'kec', t: sel.kabupaten });
                    if (sel.kecamatan) crumbs.push({ l: 'desa', t: sel.kecamatan });
                    bc.innerHTML = '';
                    crumbs.forEach((c, idx) => {
                        if (idx > 0) {
                            const s = document.createElement('span');
                            s.textContent = '›'; s.className = 'text-forest/30';
                            bc.appendChild(s);
                        }
                        const b = document.createElement('button');
                        b.type = 'button'; b.textContent = c.t;
                        b.className = 'hover:text-forest transition-colors truncate max-w-[200px] '
                            + (idx === crumbs.length - 1 ? ' text-forest font-medium' : '');
                        b.addEventListener('click', () => goToLevel(c.l));
                        bc.appendChild(b);
                    });
                }

                // ---- Alerts (cells) ----
                function filtered() {
                    return ALERTS.filter((a) => {
                        const p = a.properties;
                        if (state.level === 'kab' && p.province !== sel.province) return false;
                        if (state.level === 'kec' && p.kabupaten !== sel.kabupaten) return false;
                        if (state.level === 'desa' && p.kecCode !== sel.kecCode) return false;
                        return state.dn.has(p.dn);
                    });
                }

                function render() {
                    const data = filtered();
                    const pts = data.map((a) => {
                        const [lng, lat] = a.geometry.coordinates;
                        return [lat, lng, (DN[a.properties.dn] || DN[1]).color];
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
                    const high = data.filter((a) => a.properties.dn === 3).length;
                    document.getElementById('kpi-high').textContent = fmt(high);
                    const areaName = sel.kecamatan || sel.kabupaten || sel.province || 'Sumatera';
                    document.getElementById('kpi-area').textContent = areaName;
                    document.getElementById('footer-count').textContent = fmt(data.length) + ' alert';

                    const groupKey = state.level === 'prov' ? 'province' : (state.level === 'kab' ? 'kabupaten' : 'kecamatan');
                    document.getElementById('by-title').textContent =
                        'Berdasarkan ' + (state.level === 'prov' ? 'Provinsi' : state.level === 'kab' ? 'Kabupaten' : 'Kecamatan');
                    const groups = {};
                    data.forEach((a) => { const k = a.properties[groupKey] || '—'; groups[k] = (groups[k] || 0) + 1; });
                    const entries = Object.entries(groups).sort((a, b) => b[1] - a[1]).slice(0, 12);
                    const max = Math.max(1, ...entries.map((e) => e[1]));
                    const bars = document.getElementById('prov-bars');
                    bars.innerHTML = '';
                    entries.forEach(([p, v]) => {
                        const row = document.createElement('div');
                        row.innerHTML =
                            '<div class="flex items-center justify-between text-xs mb-1">' +
                            '<span class="truncate">' + p + '</span>' +
                            '<span class="font-jetbrains-mono text-bark/70 ml-2">' + fmt(v) + '</span>' +
                            '</div>' +
                            '<div class="h-1.5 rounded-full bg-forest/10 overflow-hidden">' +
                            '<div class="h-full rounded-full bg-loss" style="width:' + (v / max * 100) + '%"></div>' +
                            '</div>';
                        bars.appendChild(row);
                    });

                    const sum = { 3: 0, 2: 0, 1: 0 };
                    data.forEach((a) => { sum[a.properties.dn] = (sum[a.properties.dn] || 0) + 1; });
                    const cs = document.getElementById('dn-summary');
                    cs.innerHTML = '';
                    [3, 2, 1].forEach((k) => {
                        const row = document.createElement('div');
                        row.className = 'flex items-center justify-between';
                        row.innerHTML =
                            '<span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-[1px]" style="background:' + DN[k].color + '"></span>' + DN[k].label + '</span>' +
                            '<span class="font-jetbrains-mono text-bark/75">' + fmt(sum[k]) + '</span>';
                        cs.appendChild(row);
                    });
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
                    document.querySelectorAll('#dn-toggles input').forEach((cb) => { cb.checked = true; });
                    goToLevel('prov');
                });

                boot();
            })();
        </script>
    </body>
</html>