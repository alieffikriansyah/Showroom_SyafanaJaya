@extends('layouts.dashboard')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: #f4f6fb !important;
    }
    .stat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #ffffff;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }
    .chart-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
        background: #ffffff;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid #eef2f6;
        color: #475569;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
    }
    .table-custom tbody td {
        padding: 13px 14px;
        vertical-align: middle;
        font-size: 0.88rem;
        border-top: 1px solid #f1f5f9;
        color: #334155;
    }
    .badge-soft-success {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-warning {
        background-color: #fef9c3;
        color: #a16207;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-info {
        background-color: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-purple {
        background-color: #f3e8ff;
        color: #7e22ce;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    @media (max-width: 767.98px) {
        .chart-container-responsive {
            position: relative;
            height: 280px !important;
            width: 100%;
        }
        .stat-card .card-body {
            padding: 1.1rem;
        }
    }
</style>
@endsection

@section('content')

@if (!Auth::user()->karyawan)
<!-- Header Title -->
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-8">
        <h3 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.5px;">Dashboard Utama</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">
            Ringkasan performa penjualan mobil, kehadiran karyawan, dan aktivitas terkini.
        </p>
    </div>
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
        <span class="badge badge-light px-3 py-2 border shadow-sm" style="font-size: 0.85rem; font-weight: 600; border-radius: 10px;">
            <i class="typcn typcn-calendar text-primary mr-1"></i> {{ date('l, d F Y') }}
        </span>
    </div>
</div>

<!-- 4 Key Stat Cards -->
<div class="row">
    <!-- Total Karyawan -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Karyawan</span>
                    <h3 class="font-weight-bold text-dark mt-2 mb-0">{{ $total_karyawan }}</h3>
                    <small class="text-success font-weight-bold"><i class="typcn typcn-arrow-up"></i> Aktif</small>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                    <i class="typcn typcn-group"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Departemen -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Departemen</span>
                    <h3 class="font-weight-bold text-dark mt-2 mb-0">{{ $total_departemen }}</h3>
                    <small class="text-muted">Divisi operasional</small>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.12); color: #0284c7;">
                    <i class="typcn typcn-flow-children"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Unit Mobil Terjual -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Unit Terjual (Tahun Ini)</span>
                    <h3 class="font-weight-bold text-dark mt-2 mb-0" id="stat_total_unit">...</h3>
                    <small class="text-success font-weight-bold"><i class="typcn typcn-chart-line"></i> Penjualan Mobil</small>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                    <i class="typcn typcn-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sanksi Bulan Ini -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Sanksi Bulan Ini</span>
                    <h3 class="font-weight-bold text-dark mt-2 mb-0">{{ $total_sanksi }}</h3>
                    <small class="text-danger font-weight-bold">Bulan berjalan</small>
                </div>
                <div class="stat-icon-wrapper" style="background: rgba(239, 68, 68, 0.12); color: #dc2626;">
                    <i class="typcn typcn-warning-outline"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Analytics Charts (The Cool Interactive Sales Dashboard) -->
<div class="row mb-4">
    <!-- Main Line/Area Trend Chart -->
    <div class="col-12 col-lg-8 mb-4 mb-lg-0">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3">
                    <div>
                        <h5 class="font-weight-bold text-dark mb-1">
                            <i class="typcn typcn-chart-area-outline text-primary mr-1"></i> Tren Omzet Penjualan Mobil
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Performa omzet penjualan bulanan tahun {{ date('Y') }}</p>
                    </div>
                    <div class="mt-2 mt-sm-0">
                        <span class="badge badge-soft-purple px-3 py-2" id="badge_total_omzet" style="font-size: 0.85rem;">
                            Total: Rp ...
                        </span>
                    </div>
                </div>

                <div class="chart-container-responsive" style="position: relative; height: 320px; width: 100%;">
                    <canvas id="salesMainChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Doughnut Breakdown by Brand -->
    <div class="col-12 col-lg-4">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">
                        <i class="typcn typcn-pie-chart text-success mr-1"></i> Penjualan per Merk
                    </h5>
                    <p class="text-muted mb-3" style="font-size: 0.85rem;">Pangsa unit mobil terjual</p>
                </div>

                <div style="position: relative; height: 230px; width: 100%;">
                    <canvas id="salesBrandChart"></canvas>
                </div>

                <div id="brandLegendList" class="mt-3">
                    <!-- Dynamic legend loaded via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Operational Overview: Presensi & Sanksi -->
<div class="row mb-4">
    <!-- Presensi Hari Ini -->
    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0">
                        <i class="typcn typcn-time text-primary mr-1"></i> Presensi Hari Ini
                    </h5>
                    <span class="badge badge-soft-info">{{ count($absenPerDay) }} Data</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Karyawan</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absenPerDay as $index => $absen)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $absen->name }}</td>
                                <td>{{ date('H:i', strtotime($absen->tanggaldanwaktu_absensi)) }} WIB</td>
                                <td>
                                    @if(strtolower($absen->tipe_absensi) == 'hadir')
                                        <span class="badge-soft-success"><i class="typcn typcn-tick"></i> Hadir</span>
                                    @elseif(strtolower($absen->tipe_absensi) == 'telat')
                                        <span class="badge-soft-warning"><i class="typcn typcn-warning"></i> Telat</span>
                                    @else
                                        <span class="badge-soft-info">{{ ucfirst($absen->tipe_absensi) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="typcn typcn-info-large d-block mb-1" style="font-size: 1.5rem;"></i>
                                    Belum ada data presensi hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sanksi Bulan Ini -->
    <div class="col-12 col-lg-6">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0">
                        <i class="typcn typcn-warning-outline text-danger mr-1"></i> Sanksi Bulan Ini
                    </h5>
                    <span class="badge badge-soft-danger">{{ count($sanksiPerMonth) }} Pelanggaran</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sanksiPerMonth as $index => $sanksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $sanksi->name }}</td>
                                <td>{{ date('d M Y', strtotime($sanksi->waktu_sanksi)) }}</td>
                                <td><span class="badge-soft-danger">{{ $sanksi->keterangan_sanksi }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="typcn typcn-thumbs-up d-block mb-1 text-success" style="font-size: 1.5rem;"></i>
                                    Tidak ada sanksi tercatat bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Cuti Bulan Ini -->
<div class="row">
    <div class="col-12">
        <div class="card chart-card">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="font-weight-bold text-dark mb-1">
                            <i class="typcn typcn-plane-outline text-info mr-1"></i> Daftar Cuti Karyawan Bulan Ini
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Pengajuan cuti yang sedang berjalan pada periode ini</p>
                    </div>
                    <span class="badge badge-soft-purple">{{ count($cutiPerMonth) }} Pengajuan</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Mulai Cuti</th>
                                <th>Selesai Cuti</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cutiPerMonth as $index => $cuti)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $cuti->name }}</td>
                                <td>{{ date('d M Y', strtotime($cuti->tanggal_mulai_cuti)) }}</td>
                                <td>{{ date('d M Y', strtotime($cuti->tanggal_selesai_cuti)) }}</td>
                                <td>{{ $cuti->keterangan_cuti }}</td>
                                <td>
                                    @if(strtolower($cuti->status_cuti) == 'terima')
                                        <span class="badge-soft-success"><i class="typcn typcn-tick"></i> Disetujui</span>
                                    @elseif(strtolower($cuti->status_cuti) == 'tolak')
                                        <span class="badge-soft-danger"><i class="typcn typcn-times"></i> Ditolak</span>
                                    @else
                                        <span class="badge-soft-warning"><i class="typcn typcn-time"></i> Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="typcn typcn-document-text d-block mb-1" style="font-size: 1.5rem;"></i>
                                    Tidak ada karyawan yang cuti pada bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    // Format Rupiah Helper
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);
    }

    // Fetch and Render Rich Sales Charts
    $.ajax({
        url: "{{ route('getPenjualanPerBulan') }}",
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            // Update Stat Badges
            if (res.summary) {
                $('#stat_total_unit').text(res.summary.total_unit + ' Unit');
                $('#badge_total_omzet').html('<i class="typcn typcn-chart-line mr-1"></i> Total Omzet: ' + res.summary.total_omzet_formatted);
            }

            // 1. Render Main Area & Bar Chart (Omzet & Unit)
            const ctxMain = document.getElementById('salesMainChart').getContext('2d');
            
            // Gradient Fill for Omzet
            const gradientOmzet = ctxMain.createLinearGradient(0, 0, 0, 300);
            gradientOmzet.addColorStop(0, 'rgba(99, 102, 241, 0.45)');
            gradientOmzet.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

            new Chart(ctxMain, {
                type: 'line',
                data: {
                    labels: res.labels,
                    datasets: [
                        {
                            label: 'Omzet Penjualan (Rp)',
                            data: res.data_omzet || res.data,
                            borderColor: '#4f46e5',
                            backgroundColor: gradientOmzet,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#4f46e5',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Unit Mobil Terjual',
                            data: res.data_unit,
                            type: 'bar',
                            backgroundColor: 'rgba(16, 185, 129, 0.65)',
                            borderColor: '#10b981',
                            borderWidth: 1,
                            borderRadius: 6,
                            barThickness: 18,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13, weight: 'bold' },
                            bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (context.dataset.yAxisID === 'y') {
                                        return label + ': ' + formatRupiah(context.parsed.y);
                                    } else {
                                        return label + ': ' + context.parsed.y + ' Unit';
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '500' },
                                color: '#64748b'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                color: '#64748b',
                                callback: function(value) {
                                    if (value >= 1000000000) return (value / 1000000000) + ' M';
                                    if (value >= 1000000) return (value / 1000000) + ' Jt';
                                    return value;
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                stepSize: 1,
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                color: '#10b981'
                            }
                        }
                    }
                }
            });

            // 2. Render Doughnut Chart (Brand Breakdown)
            if (res.brands && res.brands.labels.length > 0) {
                const ctxBrand = document.getElementById('salesBrandChart').getContext('2d');
                const brandColors = ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6'];

                new Chart(ctxBrand, {
                    type: 'doughnut',
                    data: {
                        labels: res.brands.labels,
                        datasets: [{
                            data: res.brands.units,
                            backgroundColor: brandColors,
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.label + ': ' + context.parsed + ' Unit Mobil';
                                    }
                                }
                            }
                        }
                    }
                });

                // Custom Brand Legend
                let legendHtml = '<div class="row">';
                res.brands.labels.forEach((label, idx) => {
                    const color = brandColors[idx % brandColors.length];
                    const unit = res.brands.units[idx];
                    legendHtml += `
                        <div class="col-6 mb-2">
                            <div class="d-flex align-items-center" style="font-size: 0.8rem;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: ${color}; display: inline-block; margin-right: 6px;"></span>
                                <span class="text-truncate font-weight-bold text-dark">${label}:</span>
                                <span class="ml-1 text-muted">${unit} unit</span>
                            </div>
                        </div>
                    `;
                });
                legendHtml += '</div>';
                $('#brandLegendList').html(legendHtml);
            } else {
                $('#brandLegendList').html('<p class="text-center text-muted small my-3">Belum ada data penjualan merk.</p>');
            }
        },
        error: function(err) {
            console.error("Gagal memuat data grafik:", err);
        }
    });
});
</script>
@endsection