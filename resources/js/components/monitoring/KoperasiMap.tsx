import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import {
    AlertTriangle,
    Camera,
    Loader2,
    Maximize2,
    Minimize2,
} from 'lucide-react';
import { useEffect, useMemo, useRef, useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { mapPoints as mapPointsRoute } from '@/routes/monitoring';
import type {
    MapPointsResponse,
    MapPointTuple,
    MarkerColor,
    MarkerTier,
} from '@/types/monitoring';

const COLOR_HEX: Record<MarkerColor, string> = {
    red: '#dc2626',
    orange: '#f97316',
    yellow: '#eab308',
    green: '#16a34a',
    blue: '#2563eb',
    gray: '#9ca3af',
};

const SPRITE_SIZE = 22;
const SPRITE_RADIUS = SPRITE_SIZE / 2;

function drawShape(
    ctx: CanvasRenderingContext2D,
    tier: MarkerTier,
    color: string,
) {
    ctx.fillStyle = color;
    ctx.strokeStyle = '#ffffff';
    ctx.lineWidth = 1.5;

    switch (tier) {
        case 'sarpras': {
            ctx.beginPath();
            ctx.moveTo(11, 2);
            ctx.lineTo(20, 19);
            ctx.lineTo(2, 19);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();
            break;
        }
        case 'sdm': {
            ctx.beginPath();
            ctx.arc(11, 7, 4, 0, Math.PI * 2);
            ctx.fill();
            ctx.stroke();

            ctx.beginPath();
            ctx.moveTo(3, 20);
            ctx.bezierCurveTo(3, 15.6, 6.6, 13, 11, 13);
            ctx.bezierCurveTo(15.4, 13, 19, 15.6, 19, 20);
            ctx.fill();
            ctx.stroke();
            break;
        }
        case 'odoo': {
            ctx.strokeStyle = color;
            ctx.lineWidth = 2;
            ctx.lineJoin = 'round';
            ctx.beginPath();
            ctx.moveTo(2, 3);
            ctx.lineTo(4, 3);
            ctx.lineTo(6, 15);
            ctx.lineTo(17, 15);
            ctx.lineTo(19, 7);
            ctx.lineTo(6, 7);
            ctx.stroke();

            ctx.fillStyle = color;
            ctx.beginPath();
            ctx.arc(8, 19, 1.6, 0, Math.PI * 2);
            ctx.fill();
            ctx.beginPath();
            ctx.arc(16, 19, 1.6, 0, Math.PI * 2);
            ctx.fill();
            break;
        }
        default: {
            ctx.beginPath();
            ctx.arc(SPRITE_RADIUS, SPRITE_RADIUS, 7, 0, Math.PI * 2);
            ctx.fill();
            ctx.stroke();
            break;
        }
    }
}

// Setiap kombinasi tier dan warna dirender sekali menjadi bitmap, kemudian
// digunakan berulang melalui drawImage() saat menggambar titik pada canvas.
// Pendekatan ini jauh lebih efisien dibandingkan membuat elemen DOM per titik.
function buildSpriteAtlas(): Map<string, HTMLCanvasElement> {
    const atlas = new Map<string, HTMLCanvasElement>();

    const tiers: MarkerTier[] = ['status', 'sarpras', 'sdm', 'odoo'];
    const colors = Object.keys(COLOR_HEX) as MarkerColor[];

    for (const tier of tiers) {
        for (const color of colors) {
            const sprite = document.createElement('canvas');
            sprite.width = SPRITE_SIZE;
            sprite.height = SPRITE_SIZE;

            const ctx = sprite.getContext('2d');

            if (ctx) {
                drawShape(ctx, tier, COLOR_HEX[color]);
            }

            atlas.set(`${tier}_${color}`, sprite);
        }
    }

    return atlas;
}

function shapeSvg(tier: MarkerTier, color: string): string {
    switch (tier) {
        case 'sarpras':
            return `<svg width="22" height="22" viewBox="0 0 22 22"><polygon points="11,2 20,19 2,19" fill="${color}" stroke="white" stroke-width="1.5"/></svg>`;
        case 'sdm':
            return `<svg width="22" height="22" viewBox="0 0 22 22"><circle cx="11" cy="7" r="4" fill="${color}" stroke="white" stroke-width="1.5"/><path d="M3 20c0-4.4 3.6-7 8-7s8 2.6 8 7" fill="${color}" stroke="white" stroke-width="1.5"/></svg>`;
        case 'odoo':
            return `<svg width="22" height="22" viewBox="0 0 22 22"><path d="M2 3h2l2 12h11l2-8H6" fill="none" stroke="${color}" stroke-width="2" stroke-linejoin="round"/><circle cx="8" cy="19" r="1.6" fill="${color}"/><circle cx="16" cy="19" r="1.6" fill="${color}"/></svg>`;
        default:
            return `<svg width="18" height="18" viewBox="0 0 18 18"><circle cx="9" cy="9" r="7" fill="${color}" stroke="white" stroke-width="1.5"/></svg>`;
    }
}

const FIELD = {
    nik: 0,
    nama: 1,
    provinsi: 2,
    kotaKabupaten: 3,
    kecamatan: 4,
    kodim: 5,
    lat: 6,
    lng: 7,
    validationStatus: 8,
    progress: 9,
    completedSarprasCount: 10,
    sarprasPrimary: 11,
    sarprasSecondary: 12,
    sarprasLengkap: 13,
    jumlahKaryawan: 14,
    hasPo: 15,
    hasReceipt: 16,
    hasSales: 17,
    tier: 18,
    color: 19,
} as const;

function popupHtml(point: MapPointTuple): string {
    const yesNo = (value: boolean) => (value ? 'Ya' : 'Belum');

    return `
        <div style="font-size:13px;line-height:1.5;min-width:220px">
            <p style="font-weight:600;margin-bottom:2px">${point[FIELD.nama] ?? '-'}</p>
            <p style="color:#6b7280;margin-bottom:6px">${[point[FIELD.kecamatan], point[FIELD.kotaKabupaten], point[FIELD.provinsi]].filter(Boolean).join(', ')}</p>
            <table style="width:100%;border-collapse:collapse">
                <tr><td style="color:#6b7280;padding:1px 0">Status verifikasi</td><td style="text-align:right;font-weight:500">${point[FIELD.validationStatus] ?? '-'}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Progres pembangunan</td><td style="text-align:right;font-weight:500">${point[FIELD.progress]}%</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sarpras lengkap</td><td style="text-align:right;font-weight:500">${point[FIELD.completedSarprasCount]} jenis</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sarpras esensial 1</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.sarprasPrimary])}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sarpras esensial 2</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.sarprasSecondary])}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sarpras lengkap semua</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.sarprasLengkap])}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Jumlah karyawan</td><td style="text-align:right;font-weight:500">${point[FIELD.jumlahKaryawan]}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sudah PO</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.hasPo])}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sudah penerimaan barang</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.hasReceipt])}</td></tr>
                <tr><td style="color:#6b7280;padding:1px 0">Sudah penjualan</td><td style="text-align:right;font-weight:500">${yesNo(point[FIELD.hasSales])}</td></tr>
            </table>
        </div>
    `;
}

function LegendGroup({
    tier,
    title,
    items,
}: {
    tier: MarkerTier;
    title: string;
    items: Array<{ color: MarkerColor; label: string }>;
}) {
    return (
        <div>
            <p className="mb-1.5 text-xs font-semibold text-foreground">
                {title}
            </p>
            <div className="space-y-1">
                {items.map((item) => (
                    <div
                        key={item.label}
                        className="flex items-center gap-2 text-xs text-muted-foreground"
                    >
                        <span
                            className="inline-block h-[18px] w-[18px] shrink-0"
                            dangerouslySetInnerHTML={{
                                __html: shapeSvg(tier, COLOR_HEX[item.color]),
                            }}
                        />
                        {item.label}
                    </div>
                ))}
            </div>
        </div>
    );
}

const HIT_TEST_RADIUS_PX = 9;
const ALL = 'all';

type DrawnPoint = { x: number; y: number; index: number };

type Filters = {
    provinsi: string;
    kotaKabupaten: string;
    kecamatan: string;
    tier: string;
};

const DEFAULT_FILTERS: Filters = {
    provinsi: ALL,
    kotaKabupaten: ALL,
    kecamatan: ALL,
    tier: ALL,
};

function matchesFilters(point: MapPointTuple, filters: Filters): boolean {
    if (
        filters.provinsi !== ALL &&
        point[FIELD.provinsi] !== filters.provinsi
    ) {
        return false;
    }

    if (
        filters.kotaKabupaten !== ALL &&
        point[FIELD.kotaKabupaten] !== filters.kotaKabupaten
    ) {
        return false;
    }

    if (
        filters.kecamatan !== ALL &&
        point[FIELD.kecamatan] !== filters.kecamatan
    ) {
        return false;
    }

    if (filters.tier !== ALL && point[FIELD.tier] !== filters.tier) {
        return false;
    }

    return true;
}

function uniqueSorted(values: Array<string | null>): string[] {
    return Array.from(
        new Set(values.filter((v): v is string => Boolean(v))),
    ).sort((a, b) => a.localeCompare(b));
}

export default function KoperasiMap() {
    const containerRef = useRef<HTMLDivElement>(null);
    const cardRef = useRef<HTMLDivElement>(null);
    const mapRef = useRef<L.Map | null>(null);
    const allPointsRef = useRef<MapPointTuple[]>([]);
    const filtersRef = useRef<Filters>(DEFAULT_FILTERS);
    const drawRef = useRef<() => void>(() => {});
    const fitToFilterRef = useRef<() => void>(() => {});

    const [status, setStatus] = useState<'loading' | 'ok' | 'error'>('loading');
    const [pointCount, setPointCount] = useState(0);
    const [visibleCount, setVisibleCount] = useState(0);
    const [fetchedAt, setFetchedAt] = useState<string | null>(null);
    const [filters, setFilters] = useState<Filters>(DEFAULT_FILTERS);
    const [isFullscreen, setIsFullscreen] = useState(false);
    const [isCapturing, setIsCapturing] = useState(false);
    const [captureError, setCaptureError] = useState(false);
    const [allPoints, setAllPoints] = useState<MapPointTuple[]>([]);

    const provinsiOptions = useMemo(
        () => uniqueSorted(allPoints.map((p) => p[FIELD.provinsi])),
        [allPoints],
    );

    const kotaKabupatenOptions = useMemo(
        () =>
            uniqueSorted(
                allPoints
                    .filter(
                        (p) =>
                            filters.provinsi === ALL ||
                            p[FIELD.provinsi] === filters.provinsi,
                    )
                    .map((p) => p[FIELD.kotaKabupaten]),
            ),
        [allPoints, filters.provinsi],
    );

    const kecamatanOptions = useMemo(
        () =>
            uniqueSorted(
                allPoints
                    .filter(
                        (p) =>
                            (filters.provinsi === ALL ||
                                p[FIELD.provinsi] === filters.provinsi) &&
                            (filters.kotaKabupaten === ALL ||
                                p[FIELD.kotaKabupaten] ===
                                    filters.kotaKabupaten),
                    )
                    .map((p) => p[FIELD.kecamatan]),
            ),
        [allPoints, filters.provinsi, filters.kotaKabupaten],
    );

    useEffect(() => {
        const container = containerRef.current;

        if (!container || mapRef.current) {
            return;
        }

        const map = L.map(container, {
            center: [-2.5, 118],
            zoom: 5,
            scrollWheelZoom: true,
            preferCanvas: true,
        });
        mapRef.current = map;

        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            { attribution: 'Tiles &copy; Esri', maxZoom: 19 },
        ).addTo(map);

        // Pane khusus agar canvas titik berada di atas tile namun tetap di
        // bawah popup (markerPane=600, tooltipPane=650, popupPane=700).
        const pane = map.createPane('koperasiPointsPane');
        pane.style.zIndex = '610';
        pane.style.pointerEvents = 'none';

        const canvas = L.DomUtil.create(
            'canvas',
            'koperasi-map-canvas',
            pane,
        ) as HTMLCanvasElement;
        canvas.style.position = 'absolute';
        canvas.style.top = '0';
        canvas.style.left = '0';
        const ctx = canvas.getContext('2d');
        const spriteAtlas = buildSpriteAtlas();

        let drawnPoints: DrawnPoint[] = [];
        let lastTopLeft = L.point(0, 0);
        let popup: L.Popup | null = null;

        // Canvas berada di dalam pane khusus yang otomatis ikut ditransformasi
        // oleh Leaflet saat drag, sama seperti tilePane dan markerPane. Oleh
        // karena itu titik digambar menggunakan koordinat layerPoint (bukan
        // containerPoint), relatif terhadap sudut kiri-atas canvas. Posisi
        // dan ukuran canvas direset setiap kali draw() dipanggil, mengikuti
        // origin viewport saat itu.
        const draw = () => {
            const points = allPointsRef.current;

            if (!ctx || points.length === 0) {
                return;
            }

            const size = map.getSize();
            canvas.width = size.x;
            canvas.height = size.y;

            const topLeft = map.containerPointToLayerPoint([0, 0]);
            lastTopLeft = topLeft;
            L.DomUtil.setPosition(canvas, topLeft);

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const bounds = map.getBounds().pad(0.15);
            const nextDrawn: DrawnPoint[] = [];
            const activeFilters = filtersRef.current;

            for (let i = 0; i < points.length; i++) {
                const point = points[i];
                const lat = point[FIELD.lat];
                const lng = point[FIELD.lng];

                if (!bounds.contains([lat, lng])) {
                    continue;
                }

                if (!matchesFilters(point, activeFilters)) {
                    continue;
                }

                const layerPoint = map.latLngToLayerPoint([lat, lng]);
                const x = layerPoint.x - topLeft.x;
                const y = layerPoint.y - topLeft.y;

                const sprite = spriteAtlas.get(
                    `${point[FIELD.tier]}_${point[FIELD.color]}`,
                );

                if (sprite) {
                    ctx.drawImage(sprite, x - SPRITE_RADIUS, y - SPRITE_RADIUS);
                }

                nextDrawn.push({ x, y, index: i });
            }

            drawnPoints = nextDrawn;
            setVisibleCount(nextDrawn.length);
        };
        drawRef.current = draw;

        const fitToFilter = () => {
            const points = allPointsRef.current;
            const activeFilters = filtersRef.current;
            const matched = points.filter((p) =>
                matchesFilters(p, activeFilters),
            );

            if (matched.length === 0) {
                map.setView([-2.5, 118], 5);

                return;
            }

            const bounds = L.latLngBounds(
                matched.map(
                    (p) => [p[FIELD.lat], p[FIELD.lng]] as [number, number],
                ),
            );
            map.fitBounds(bounds, { padding: [24, 24], maxZoom: 12 });
        };
        fitToFilterRef.current = fitToFilter;

        const onClick = (event: L.LeafletMouseEvent) => {
            const clickLayerPoint = map.latLngToLayerPoint(event.latlng);
            const clickPoint = clickLayerPoint.subtract(lastTopLeft);

            let closest: DrawnPoint | null = null;
            let closestDistSq = HIT_TEST_RADIUS_PX * HIT_TEST_RADIUS_PX;

            for (const drawn of drawnPoints) {
                const dx = drawn.x - clickPoint.x;
                const dy = drawn.y - clickPoint.y;
                const distSq = dx * dx + dy * dy;

                if (distSq <= closestDistSq) {
                    closest = drawn;
                    closestDistSq = distSq;
                }
            }

            if (!closest) {
                return;
            }

            const point = allPointsRef.current[closest.index];

            if (popup) {
                map.closePopup(popup);
            }

            popup = L.popup()
                .setLatLng([point[FIELD.lat], point[FIELD.lng]])
                .setContent(popupHtml(point))
                .openOn(map);
        };

        map.on('moveend zoomend resize', draw);
        map.on('click', onClick);

        // ResizeObserver mendeteksi perubahan ukuran container secara akurat
        // (misal saat masuk/keluar mode fullscreen), lalu memanggil
        // invalidateSize() supaya Leaflet memuat ulang tile untuk area yang
        // baru terlihat. Pendekatan ini lebih andal dibandingkan menebak
        // durasi transisi CSS dengan setTimeout.
        let resizeFrame: number | null = null;
        const resizeObserver = new ResizeObserver(() => {
            if (resizeFrame !== null) {
                cancelAnimationFrame(resizeFrame);
            }

            resizeFrame = requestAnimationFrame(() => {
                map.invalidateSize();
            });
        });
        resizeObserver.observe(container);

        fetch(mapPointsRoute.url())
            .then((response) => response.json() as Promise<MapPointsResponse>)
            .then((body) => {
                if (body.status !== 'ok') {
                    setStatus('error');

                    return;
                }

                allPointsRef.current = body.points;
                setAllPoints(body.points);
                setPointCount(body.points.length);
                setFetchedAt(body.fetched_at);
                setStatus('ok');
                draw();
            })
            .catch(() => setStatus('error'));

        return () => {
            map.off('moveend zoomend resize', draw);
            map.off('click', onClick);
            resizeObserver.disconnect();

            if (resizeFrame !== null) {
                cancelAnimationFrame(resizeFrame);
            }

            map.remove();
            mapRef.current = null;
        };
    }, []);

    // Canvas digambar ulang setiap filter berubah. Peta otomatis pan/zoom ke
    // bounding box titik yang cocok apabila filter wilayah yang berubah,
    // bukan filter status saja.
    const updateFilter = (patch: Partial<Filters>) => {
        setFilters((prev) => {
            const next = { ...prev, ...patch };
            filtersRef.current = next;

            requestAnimationFrame(() => {
                if ('tier' in patch && Object.keys(patch).length === 1) {
                    drawRef.current();
                } else {
                    fitToFilterRef.current();
                }
            });

            return next;
        });
    };

    const resetFilters = () => {
        setFilters(DEFAULT_FILTERS);
        filtersRef.current = DEFAULT_FILTERS;
        requestAnimationFrame(() => {
            mapRef.current?.setView([-2.5, 118], 5);
        });
    };

    const handleCapture = () => {
        const map = mapRef.current;
        const container = containerRef.current;

        if (!map || !container || isCapturing) {
            return;
        }

        setIsCapturing(true);
        setCaptureError(false);

        try {
            const rect = container.getBoundingClientRect();
            const scale = Math.min(window.devicePixelRatio || 1, 2);

            const exportCanvas = document.createElement('canvas');
            exportCanvas.width = Math.round(rect.width * scale);
            exportCanvas.height = Math.round(rect.height * scale);
            const ctx = exportCanvas.getContext('2d');

            if (!ctx) {
                return;
            }

            ctx.scale(scale, scale);

            const tiles =
                container.querySelectorAll<HTMLImageElement>(
                    'img.leaflet-tile',
                );
            tiles.forEach((tile) => {
                if (!tile.complete || tile.naturalWidth === 0) {
                    return;
                }

                const b = tile.getBoundingClientRect();
                ctx.drawImage(
                    tile,
                    b.left - rect.left,
                    b.top - rect.top,
                    b.width,
                    b.height,
                );
            });

            const pointsCanvas = container.querySelector<HTMLCanvasElement>(
                '.koperasi-map-canvas',
            );

            if (pointsCanvas) {
                const b = pointsCanvas.getBoundingClientRect();
                ctx.drawImage(
                    pointsCanvas,
                    b.left - rect.left,
                    b.top - rect.top,
                    b.width,
                    b.height,
                );
            }

            let dataUrl: string;

            try {
                dataUrl = exportCanvas.toDataURL('image/png');
            } catch {
                // Tile citra satelit dimuat tanpa header CORS permisif,
                // sehingga canvas hasil composite dianggap "tainted" oleh
                // browser dan tidak bisa diekspor. Kegagalan ditangani di
                // sini agar tidak muncul sebagai uncaught error.
                setCaptureError(true);

                return;
            }

            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = `peta-sebaran-kdkmp-${new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-')}.png`;
            link.click();
        } finally {
            setIsCapturing(false);
        }
    };

    useEffect(() => {
        const previousOverflow = document.body.style.overflow;

        if (isFullscreen) {
            document.body.style.overflow = 'hidden';
        }

        return () => {
            document.body.style.overflow = previousOverflow;
        };
    }, [isFullscreen]);

    return (
        <Card
            ref={cardRef}
            className={
                isFullscreen
                    ? 'fixed inset-0 z-[1000] overflow-y-auto rounded-none border-0'
                    : 'shadow-sm'
            }
        >
            <CardContent className="space-y-4 p-5">
                <div className="flex flex-wrap items-center justify-between gap-2">
                    <p className="text-sm font-medium text-muted-foreground">
                        Peta Sebaran KDKMP
                        {status === 'ok' && (
                            <span className="ml-2 text-xs text-muted-foreground">
                                (menampilkan{' '}
                                {visibleCount.toLocaleString('id-ID')} dari{' '}
                                {pointCount.toLocaleString('id-ID')} titik
                                {fetchedAt &&
                                    `, update ${new Date(fetchedAt).toLocaleString('id-ID')}`}
                                )
                            </span>
                        )}
                    </p>
                    <div className="flex items-center gap-2">
                        {status === 'loading' && (
                            <span className="flex items-center gap-1.5 text-xs text-muted-foreground">
                                <Loader2 className="h-3.5 w-3.5 animate-spin" />
                                Memuat titik peta...
                            </span>
                        )}
                        {status === 'error' && (
                            <span className="flex items-center gap-1.5 text-xs text-destructive">
                                <AlertTriangle className="h-3.5 w-3.5" />
                                Gagal memuat data peta
                            </span>
                        )}
                        {captureError && (
                            <span className="flex items-center gap-1.5 text-xs text-destructive">
                                <AlertTriangle className="h-3.5 w-3.5" />
                                Screenshot gagal, coba screenshot manual
                            </span>
                        )}
                        {status === 'ok' && (
                            <>
                                <Button
                                    type="button"
                                    size="icon"
                                    variant="outline"
                                    disabled={isCapturing}
                                    onClick={handleCapture}
                                    title="Screenshot peta"
                                >
                                    <Camera className="h-4 w-4" />
                                </Button>
                                <Button
                                    type="button"
                                    size="icon"
                                    variant="outline"
                                    onClick={() =>
                                        setIsFullscreen((prev) => !prev)
                                    }
                                    title={
                                        isFullscreen
                                            ? 'Keluar fullscreen'
                                            : 'Fullscreen'
                                    }
                                >
                                    {isFullscreen ? (
                                        <Minimize2 className="h-4 w-4" />
                                    ) : (
                                        <Maximize2 className="h-4 w-4" />
                                    )}
                                </Button>
                            </>
                        )}
                    </div>
                </div>

                {status === 'ok' && (
                    <div className="flex flex-wrap items-center gap-2">
                        <Select
                            value={filters.provinsi}
                            onValueChange={(value) =>
                                updateFilter({
                                    provinsi: value,
                                    kotaKabupaten: ALL,
                                    kecamatan: ALL,
                                })
                            }
                        >
                            <SelectTrigger size="sm" className="w-[160px]">
                                <SelectValue placeholder="Semua Provinsi" />
                            </SelectTrigger>
                            <SelectContent className="z-[1200]">
                                <SelectItem value={ALL}>
                                    Semua Provinsi
                                </SelectItem>
                                {provinsiOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {option}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>

                        <Select
                            value={filters.kotaKabupaten}
                            onValueChange={(value) =>
                                updateFilter({
                                    kotaKabupaten: value,
                                    kecamatan: ALL,
                                })
                            }
                        >
                            <SelectTrigger size="sm" className="w-[170px]">
                                <SelectValue placeholder="Semua Kab/Kota" />
                            </SelectTrigger>
                            <SelectContent className="z-[1200]">
                                <SelectItem value={ALL}>
                                    Semua Kab/Kota
                                </SelectItem>
                                {kotaKabupatenOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {option}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>

                        <Select
                            value={filters.kecamatan}
                            onValueChange={(value) =>
                                updateFilter({ kecamatan: value })
                            }
                        >
                            <SelectTrigger size="sm" className="w-[160px]">
                                <SelectValue placeholder="Semua Kecamatan" />
                            </SelectTrigger>
                            <SelectContent className="z-[1200]">
                                <SelectItem value={ALL}>
                                    Semua Kecamatan
                                </SelectItem>
                                {kecamatanOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {option}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>

                        <Select
                            value={filters.tier}
                            onValueChange={(value) =>
                                updateFilter({ tier: value })
                            }
                        >
                            <SelectTrigger size="sm" className="w-[160px]">
                                <SelectValue placeholder="Semua Status" />
                            </SelectTrigger>
                            <SelectContent className="z-[1200]">
                                <SelectItem value={ALL}>
                                    Semua Status
                                </SelectItem>
                                <SelectItem value="status">
                                    Verifikasi & Pembangunan
                                </SelectItem>
                                <SelectItem value="sarpras">
                                    Fokus Sarpras
                                </SelectItem>
                                <SelectItem value="sdm">Fokus SDM</SelectItem>
                                <SelectItem value="odoo">
                                    Operasional (Odoo)
                                </SelectItem>
                            </SelectContent>
                        </Select>

                        <Button
                            type="button"
                            size="sm"
                            variant="ghost"
                            onClick={resetFilters}
                        >
                            Reset
                        </Button>
                    </div>
                )}

                <div
                    ref={containerRef}
                    className={
                        isFullscreen
                            ? 'relative h-[calc(100vh-220px)] w-full overflow-hidden rounded-lg border'
                            : 'relative h-[480px] w-full overflow-hidden rounded-lg border'
                    }
                />

                <div className="grid gap-4 border-t pt-4 sm:grid-cols-2 lg:grid-cols-4">
                    <LegendGroup
                        tier="status"
                        title="Status verifikasi & pembangunan"
                        items={[
                            { color: 'yellow', label: 'Sedang diverifikasi' },
                            { color: 'orange', label: 'Dipertimbangkan' },
                            {
                                color: 'red',
                                label: 'Terverifikasi, belum bangun',
                            },
                            { color: 'green', label: 'Mulai pembangunan' },
                        ]}
                    />
                    <LegendGroup
                        tier="sarpras"
                        title="Pembangunan 100%, fokus sarpras"
                        items={[
                            { color: 'red', label: 'Sarpras < 6 jenis' },
                            { color: 'yellow', label: 'Sarpras esensial 1' },
                            { color: 'green', label: 'Sarpras esensial 2' },
                        ]}
                    />
                    <LegendGroup
                        tier="sdm"
                        title="Sarpras lengkap, fokus SDM"
                        items={[
                            { color: 'red', label: 'SDM belum ada' },
                            { color: 'yellow', label: 'SDM sebagian' },
                            { color: 'green', label: 'SDM 6 orang (lengkap)' },
                        ]}
                    />
                    <LegendGroup
                        tier="odoo"
                        title="Operasional (Odoo)"
                        items={[
                            { color: 'yellow', label: 'Sudah PO' },
                            {
                                color: 'green',
                                label: 'Sudah penerimaan barang',
                            },
                            { color: 'blue', label: 'Sudah penjualan' },
                        ]}
                    />
                </div>
                <p className="text-xs text-muted-foreground">
                    Tiap titik menampilkan tahap paling lanjut yang sudah
                    dicapai: operasional (Odoo) lebih prioritas dari SDM, SDM
                    lebih prioritas dari sarpras, sarpras lebih prioritas dari
                    status verifikasi. Klik titik untuk lihat detail lengkap.
                </p>
            </CardContent>
        </Card>
    );
}
