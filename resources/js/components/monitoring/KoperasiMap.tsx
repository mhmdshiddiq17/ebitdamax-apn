import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { AlertTriangle, Loader2 } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { Card, CardContent } from '@/components/ui/card';
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

// Pre-render 24 kombinasi tier x warna jadi bitmap sekali di awal, dipakai
// berulang via drawImage() saat render titik di canvas (jauh lebih murah
// daripada bikin elemen DOM per titik).
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

// TEST SEMENTARA (jangan di-commit): render semua titik ke satu <canvas>
// (drawImage sprite per titik), bukan DOM marker sama sekali. Jauh lebih
// murah daripada divIcon/clustering buat puluhan ribu titik.
const HIT_TEST_RADIUS_PX = 9;

type DrawnPoint = { x: number; y: number; index: number };

export default function KoperasiMap() {
    const containerRef = useRef<HTMLDivElement>(null);
    const canvasRef = useRef<HTMLCanvasElement>(null);
    const mapRef = useRef<L.Map | null>(null);
    const [status, setStatus] = useState<'loading' | 'ok' | 'error'>('loading');
    const [pointCount, setPointCount] = useState(0);
    const [fetchedAt, setFetchedAt] = useState<string | null>(null);

    useEffect(() => {
        if (!containerRef.current || mapRef.current) {
            return;
        }

        const map = L.map(containerRef.current, {
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

        // Pane custom biar canvas titik ada di atas tile tapi di bawah popup
        // (markerPane=600, tooltipPane=650, popupPane=700 di Leaflet).
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
        canvasRef.current = canvas;
        const ctx = canvas.getContext('2d');
        const spriteAtlas = buildSpriteAtlas();

        let allPoints: MapPointTuple[] = [];
        let drawnPoints: DrawnPoint[] = [];
        let lastTopLeft = L.point(0, 0);
        let popup: L.Popup | null = null;

        // Canvas ada di dalam pane custom yang ikut di-transform (digeser)
        // otomatis sama Leaflet pas drag, kayak tilePane/markerPane. Jadi
        // titik digambar pakai koordinat layerPoint (bukan containerPoint),
        // relatif ke top-left canvas, dan posisi+ukuran canvas di-reset tiap
        // draw() ngikutin origin viewport saat itu.
        const draw = () => {
            if (!ctx || allPoints.length === 0) {
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

            for (let i = 0; i < allPoints.length; i++) {
                const point = allPoints[i];
                const lat = point[FIELD.lat];
                const lng = point[FIELD.lng];

                if (!bounds.contains([lat, lng])) {
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
        };

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

            const point = allPoints[closest.index];

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

        fetch(mapPointsRoute.url())
            .then((response) => response.json() as Promise<MapPointsResponse>)
            .then((body) => {
                if (body.status !== 'ok') {
                    setStatus('error');

                    return;
                }

                allPoints = body.points;
                setPointCount(body.points.length);
                setFetchedAt(body.fetched_at);
                setStatus('ok');
                draw();
            })
            .catch(() => setStatus('error'));

        return () => {
            map.off('moveend zoomend resize', draw);
            map.off('click', onClick);
            map.remove();
            mapRef.current = null;
        };
    }, []);

    return (
        <Card className="shadow-sm">
            <CardContent className="space-y-4 p-5">
                <div className="flex flex-wrap items-center justify-between gap-2">
                    <p className="text-sm font-medium text-muted-foreground">
                        Peta Sebaran KDKMP
                        {status === 'ok' && (
                            <span className="ml-2 text-xs text-muted-foreground">
                                ({pointCount.toLocaleString('id-ID')} titik
                                {fetchedAt &&
                                    `, update ${new Date(fetchedAt).toLocaleString('id-ID')}`}
                                )
                            </span>
                        )}
                    </p>
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
                </div>

                <div
                    ref={containerRef}
                    className="relative h-[480px] w-full overflow-hidden rounded-lg border"
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
                            { color: 'blue', label: 'Sarpras lengkap semua' },
                        ]}
                    />
                    <LegendGroup
                        tier="sdm"
                        title="SDM sudah ditambahkan"
                        items={[
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
