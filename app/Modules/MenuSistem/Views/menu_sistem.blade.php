@extends('layouts.dashboard')

@section('content')

{{-- ── Header ─────────────────────────────────────────────────── --}}
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Menu Sistem</h3>
        <p class="text-muted mb-0">Kelola hierarki menu & sidebar aplikasi serta atur hak akses berdasarkan jabatan secara dinamis</p>
    </div>
    <div class="col-12 col-md-5 text-md-right mt-3 mt-md-0">
        <button type="button" class="btn btn-primary px-3 py-2 shadow-sm font-weight-bold"
                data-toggle="modal" data-target="#modalTambahMenu">
            <i class="typcn typcn-plus mr-1"></i> Tambah Menu / Modul
        </button>
    </div>
</div>

{{-- ── Alert ───────────────────────────────────────────────────── --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="typcn typcn-tick mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="typcn typcn-warning mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- ── Tab Navigation ──────────────────────────────────────────── --}}
<ul class="nav nav-tabs mb-3" id="menuTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tab-daftar" data-toggle="tab" href="#panel-daftar" role="tab" aria-controls="panel-daftar" aria-selected="true">
            <i class="typcn typcn-th-list mr-1"></i> Daftar Menu & Hierarki Sidebar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab-hakakses" data-toggle="tab" href="#panel-hakakses" role="tab" aria-controls="panel-hakakses" aria-selected="false">
            <i class="typcn typcn-lock-closed mr-1"></i> Hak Akses per Jabatan
        </a>
    </li>
</ul>

<div class="tab-content">

    {{-- ══════════════════════════════════════════════════════════
         TAB 1 — DAFTAR MENU
    ══════════════════════════════════════════════════════════ --}}
    <div class="tab-pane fade show active" id="panel-daftar" role="tabpanel" aria-labelledby="tab-daftar">
        <div class="card mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tabelMenu">
                        <thead>
                            <tr>
                                <th style="width:5px;">No</th>
                                <th>Nama Menu / Kategori</th>
                                <th>Route / Link</th>
                                <th>Icon</th>
                                <th>Tipe</th>
                                <th>Urutan</th>
                                <th style="text-align:center; width:100px;">Status</th>
                                <th style="text-align:center; width:150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @forelse($menus as $menu)
                            <tr class="{{ $menu->is_active ? '' : 'table-secondary text-muted' }}">
                                <td>{{ $i++ }}</td>
                                <td>
                                    @if($menu->parent_id)
                                        <span class="ml-4 text-muted"><i class="typcn typcn-arrow-right-outline mr-1"></i></span>
                                        <i class="{{ $menu->icon }} mr-1"></i> <strong>{{ $menu->nama_menu }}</strong>
                                    @else
                                        <i class="{{ $menu->icon }} mr-1 text-primary"></i> <strong class="text-dark">{{ $menu->nama_menu }}</strong>
                                    @endif

                                    @if(in_array($menu->route_name, ['admin', 'log', 'menu_sistem.index']) || $menu->nama_menu === 'Admin')
                                        <span class="badge badge-warning text-dark ml-1">Khusus Admin</span>
                                    @endif
                                </td>
                                <td>
                                    @if($menu->route_name === '#' || empty($menu->route_name))
                                        <span class="text-muted"><small><em>(Dropdown Group)</em></small></span>
                                    @else
                                        <code>{{ $menu->route_name }}</code>
                                    @endif
                                </td>
                                <td><small><code>{{ $menu->icon }}</code></small></td>
                                <td>
                                    @if(is_null($menu->parent_id))
                                        <span class="badge badge-primary">Menu Utama</span>
                                    @else
                                        <span class="badge badge-light text-dark">Sub-Menu</span>
                                    @endif
                                </td>
                                <td>{{ $menu->urutan }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('menu_sistem.toggle', $menu->id_menu) }}"
                                       class="badge badge-{{ $menu->is_active ? 'success' : 'secondary' }} p-2"
                                       title="Klik untuk aktifkan / nonaktifkan menu">
                                        {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </a>
                                </td>
                                <td style="text-align:center;">
                                    <button type="button"
                                            class="btn btn-sm btn-warning btn-edit-menu"
                                            data-id="{{ $menu->id_menu }}"
                                            data-toggle="modal"
                                            data-target="#modalUbahMenu">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm btn-danger btn-hapus-menu"
                                            data-id="{{ $menu->id_menu }}"
                                            data-nama="{{ $menu->nama_menu }}">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="typcn typcn-info-large"></i> Belum ada menu. Silakan tambah menu terlebih dahulu.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TAB 2 — HAK AKSES PER JABATAN
    ══════════════════════════════════════════════════════════ --}}
    <div class="tab-pane fade" id="panel-hakakses" role="tabpanel" aria-labelledby="tab-hakakses">
        <div class="card mb-4">
            <div class="card-body p-3 p-md-4">

                {{-- Pilih Jabatan --}}
                <div class="form-group row align-items-center">
                    <label class="col-sm-2 col-form-label font-weight-bold">Pilih Jabatan:</label>
                    <div class="col-sm-4">
                        <select id="selectJabatan" class="form-control">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($jabatan as $jab)
                                <option value="{{ $jab->id_jabatan }}">{{ $jab->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">
                            <i class="typcn typcn-info-large"></i>
                            Pilih jabatan untuk melihat & mengatur checklist modul yang diizinkan untuk jabatan tersebut.
                        </small>
                    </div>
                </div>

                <hr>

                {{-- Panel checklist menu --}}
                <div id="panelChecklist" style="display:none;">
                    <form method="POST" action="{{ route('menu_sistem.hak_akses') }}" id="formHakAkses">
                        {{ csrf_field() }}
                        <input type="hidden" name="jabatan_id" id="hiddenJabatanId">

                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                            <h6 class="font-weight-bold text-dark mb-2 mb-md-0">
                                Centang Modul yang Boleh Diakses oleh <span id="namaJabatanTerpilih" class="text-primary font-weight-bold"></span>:
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary mb-1" id="btnCentangSemua">
                                    <i class="fa fa-check-square"></i> Centang Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info ml-1 mb-1" id="btnCentangNonAdmin">
                                    <i class="fa fa-check"></i> Centang Semua Non-Admin
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary ml-1 mb-1" id="btnHapusSemua">
                                    <i class="fa fa-square-o"></i> Hapus Semua Centang
                                </button>
                            </div>
                        </div>

                        <div class="row mb-4" id="checklistContainer">
                            {{-- Diisi oleh JavaScript --}}
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary font-weight-bold px-4 mr-2">
                                <i class="typcn typcn-tick mr-1"></i> Simpan Hak Akses Jabatan
                            </button>
                        </div>
                    </form>
                </div>

                <div id="panelPilihJabatan" class="text-center text-muted py-5">
                    <i class="typcn typcn-arrow-up-outline" style="font-size:2.5rem; color:#0284c7;"></i>
                    <h5 class="mt-2 font-weight-bold text-dark">Pilih Jabatan di Atas</h5>
                    <p class="text-muted">Silakan pilih salah satu jabatan pada dropdown di atas untuk memuat checklist hak akses modul.</p>
                </div>

            </div>
        </div>
    </div>

</div>{{-- end tab-content --}}


{{-- ══════════════════════════════════════════════════════════════
     MODAL TAMBAH MENU
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalTambahMenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Tambah Menu / Modul Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('menu_sistem.tambah') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>Nama Menu / Modul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_menu" required placeholder="Contoh: Presensi Harian">
                    </div>

                    <div class="form-group">
                        <label>Route Name / Link</label>
                        <input type="text" class="form-control" name="route_name" placeholder="Contoh: absensi atau biarkan # jika menu induk (dropdown)">
                        <small class="text-muted">Isi nama route Laravel (misal: <code>karyawan</code>), atau isi <code>#</code> jika menu induk tanpa link</small>
                    </div>

                    <div class="form-group">
                        <label>Icon Class</label>
                        <input type="text" class="form-control" name="icon" placeholder="Contoh: typcn typcn-briefcase">
                        <small class="text-muted">Class icon Typicons (misal: <code>typcn typcn-tags</code>)</small>
                    </div>

                    <div class="form-group">
                        <label>Menu Induk / Parent (opsional)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Tidak ada (Jadikan Menu Induk / Mandiri) --</option>
                            @foreach($parentMenus as $pm)
                                <option value="{{ $pm->id_menu }}">{{ $pm->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="typcn typcn-plus mr-1"></i> Tambah Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     MODAL UBAH MENU
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalUbahMenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Ubah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('menu_sistem.ubah') }}" id="formUbahMenu">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_menu" id="ubah_id_menu">

                    <div class="form-group">
                        <label>Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_menu" id="ubah_nama_menu" required>
                    </div>

                    <div class="form-group">
                        <label>Route Name / Link</label>
                        <input type="text" class="form-control" name="route_name" id="ubah_route_name">
                        <small class="text-muted">Isi nama route Laravel, atau isi <code>#</code> jika menu induk</small>
                    </div>

                    <div class="form-group">
                        <label>Icon Class</label>
                        <input type="text" class="form-control" name="icon" id="ubah_icon">
                    </div>

                    <div class="form-group">
                        <label>Menu Induk / Parent (opsional)</label>
                        <select name="parent_id" id="ubah_parent_id" class="form-control">
                            <option value="">-- Tidak ada (Menu Induk / Mandiri) --</option>
                            @foreach($parentMenus as $pm)
                                <option value="{{ $pm->id_menu }}">{{ $pm->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Urutan Tampil (Angka)</label>
                        <input type="number" class="form-control" name="urutan" id="ubah_urutan" min="1">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control" id="ubah_is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning font-weight-bold">
                            <i class="fa fa-edit mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    // ── Modal Ubah: isi form dari AJAX ───────────────────────────
    $(document).on('click', '.btn-edit-menu', function () {
        var id = $(this).data('id');

        $('#ubah_id_menu').val('');
        $('#ubah_nama_menu').val('Memuat...');
        $('#ubah_route_name').val('');
        $('#ubah_icon').val('');
        $('#ubah_urutan').val('');

        $.ajax({
            url: "{{ url('menu-sistem/get-ubah') }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function (m) {
                if (typeof m === 'string') {
                    m = JSON.parse(m);
                }
                $('#ubah_id_menu').val(m.id_menu);
                $('#ubah_nama_menu').val(m.nama_menu);
                $('#ubah_route_name').val(m.route_name);
                $('#ubah_icon').val(m.icon);
                $('#ubah_urutan').val(m.urutan);
                $('#ubah_is_active').val(m.is_active);
                $('#ubah_parent_id').val(m.parent_id || '');
            },
            error: function () {
                alert('Gagal mengambil data menu. Silakan muat ulang halaman.');
            }
        });
    });

    // ── Hapus Menu dengan Konfirmasi SweetAlert / Native ──────────
    $(document).on('click', '.btn-hapus-menu', function (e) {
        e.preventDefault();
        var id   = $(this).data('id');
        var nama = $(this).data('nama');
        var urlHapus = "{{ url('menu-sistem/hapus') }}/" + id;

        if (typeof swal !== 'undefined') {
            swal({
                title: "Apakah Anda yakin?",
                text: "Menu '" + nama + "' dan seluruh hak aksesnya akan dihapus!",
                icon: "warning",
                buttons: ["Batal", "Ya, Hapus!"],
                dangerMode: true,
            }).then(function (willDelete) {
                if (willDelete) {
                    window.location.href = urlHapus;
                }
            });
        } else {
            if (confirm("Apakah Anda yakin ingin menghapus menu '" + nama + "'?")) {
                window.location.href = urlHapus;
            }
        }
    });

    // ── Tab Hak Akses: pilih jabatan -> load checklist via AJAX ──
    var adminRoutes = ['admin', 'log', 'menu_sistem.index'];

    function loadHakAksesJabatan(jabatanId, namaJabatan) {
        if (!jabatanId) {
            $('#panelChecklist').hide();
            $('#panelPilihJabatan').show();
            return;
        }

        $('#hiddenJabatanId').val(jabatanId);
        $('#namaJabatanTerpilih').text(namaJabatan || $('#selectJabatan option:selected').text());

        $('#checklistContainer').html('<div class="col-12 py-4 text-center text-muted"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Memuat daftar modul...</p></div>');
        $('#panelPilihJabatan').hide();
        $('#panelChecklist').show();

        var allMenus = @json($menus);

        $.ajax({
            url: "{{ url('menu-sistem/jabatan') }}/" + jabatanId,
            type: 'GET',
            dataType: 'json',
            success: function (raw) {
                var assigned = (typeof raw === 'string') ? JSON.parse(raw) : raw;
                if (!Array.isArray(assigned)) assigned = [];
                assigned = assigned.map(Number);

                // Kelompokkan menu menjadi: Parent -> Children
                var parents = [];
                var childrenMap = {};

                allMenus.forEach(function (m) {
                    if (!m.parent_id) {
                        parents.push(m);
                    } else {
                        if (!childrenMap[m.parent_id]) {
                            childrenMap[m.parent_id] = [];
                        }
                        childrenMap[m.parent_id].push(m);
                    }
                });

                var html = '';

                parents.forEach(function (parent) {
                    var subs = childrenMap[parent.id_menu] || [];
                    var isAdminGroup = (adminRoutes.indexOf(parent.route_name) !== -1 || parent.nama_menu === 'Admin');

                    html += `
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="card h-100 shadow-sm border ${isAdminGroup ? 'border-warning' : 'border-light'}">
                            <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                                <span class="font-weight-bold text-dark">
                                    <i class="${parent.icon || 'typcn typcn-folder'} mr-1 text-primary"></i> ${parent.nama_menu}
                                </span>
                                ${isAdminGroup ? '<span class="badge badge-warning text-dark font-weight-normal">Khusus Admin</span>' : ''}
                            </div>
                            <div class="card-body p-3">`;

                    if (subs.length > 0) {
                        subs.forEach(function (child) {
                            var childId = Number(child.id_menu);
                            var isChecked = assigned.indexOf(childId) !== -1 ? 'checked' : '';
                            var isChildAdmin = isAdminGroup || (adminRoutes.indexOf(child.route_name) !== -1);

                            html += `
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input menu-checkbox"
                                           id="menu_${child.id_menu}"
                                           name="menu_ids[]"
                                           value="${child.id_menu}"
                                           data-route="${child.route_name}"
                                           data-admin="${isChildAdmin ? '1' : '0'}"
                                           ${isChecked}>
                                    <label class="custom-control-label font-weight-bold text-secondary" for="menu_${child.id_menu}">
                                        <i class="${child.icon || 'typcn typcn-document'} mr-1"></i> ${child.nama_menu}
                                        <small class="text-muted font-weight-normal ml-1">(<code>${child.route_name}</code>)</small>
                                    </label>
                                </div>`;
                        });
                    } else {
                        // Menu tunggal tanpa anak (seperti Dashboard)
                        var parentId = Number(parent.id_menu);
                        var isChecked = assigned.indexOf(parentId) !== -1 ? 'checked' : '';

                        html += `
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input menu-checkbox"
                                       id="menu_${parent.id_menu}"
                                       name="menu_ids[]"
                                       value="${parent.id_menu}"
                                       data-route="${parent.route_name}"
                                       data-admin="${isAdminGroup ? '1' : '0'}"
                                       ${isChecked}>
                                <label class="custom-control-label font-weight-bold text-secondary" for="menu_${parent.id_menu}">
                                    Akses Menu ${parent.nama_menu}
                                    <small class="text-muted font-weight-normal ml-1">(<code>${parent.route_name}</code>)</small>
                                </label>
                            </div>`;
                    }

                    html += `
                            </div>
                        </div>
                    </div>`;
                });

                $('#checklistContainer').html(html);
            },
            error: function (xhr, status, error) {
                $('#checklistContainer').html('<div class="col-12 py-3 text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Gagal memuat data hak akses (' + error + '). Silakan coba lagi.</div>');
            }
        });
    }

    // Trigger saat dropdown jabatan diganti (mendukung change biasa maupun select2)
    $('#selectJabatan').on('change select2:select', function () {
        var id = $(this).val();
        var nama = $(this).find('option:selected').text();
        loadHakAksesJabatan(id, nama);
    });

    // Cek jika saat pertama kali dibuka dropdown sudah memiliki nilai terpilih
    var currentJab = $('#selectJabatan').val();
    if (currentJab) {
        loadHakAksesJabatan(currentJab, $('#selectJabatan option:selected').text());
    }

    // Cek saat tab "Hak Akses per Jabatan" di-klik
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if ($(e.target).attr('href') === '#panel-hakakses') {
            var jabId = $('#selectJabatan').val();
            if (jabId) {
                loadHakAksesJabatan(jabId, $('#selectJabatan option:selected').text());
            }
        }
    });

    // ── Centang Semua ─────────────────────────────────────────────
    $('#btnCentangSemua').on('click', function () {
        $('.menu-checkbox').prop('checked', true);
    });

    // ── Centang Semua Non-Admin ───────────────────────────────────
    $('#btnCentangNonAdmin').on('click', function () {
        $('.menu-checkbox').each(function () {
            var isAdmin = $(this).data('admin');
            if (isAdmin != '1') {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    });

    // ── Hapus Semua Centang ───────────────────────────────────────
    $('#btnHapusSemua').on('click', function () {
        $('.menu-checkbox').prop('checked', false);
    });

    // ── Aktifkan tab berdasarkan URL hash ─────────────────────────
    if (window.location.hash === '#hakakses') {
        $('#tab-hakakses').tab('show');
    }
});
</script>
@endsection
