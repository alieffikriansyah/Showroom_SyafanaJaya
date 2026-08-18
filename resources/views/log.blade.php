@extends('layouts.dashboard')

@section('content')
<div class="row pt-2 pb-3">
    <div class="col-sm-9 pt-2">
        <h4 class="page-title">Log Admin</h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="background: #f7f7f8 !important;">
        <div class="card-body">
            <div class="table-responsive">
               <form action="{{route('log')}}" method="GET">
                <select id="fitur" name="fitur">
                    <option value=""selected>Semua Fitur</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="jabatan">Jabatan</option>
                    <option value="departemen">Departemen</option>
                    <option value="presensi">Presensi</option>
                    <option value="pengajuanCuti">Pengajuan Cuti</option>
                    <option value="sanksi">Sanksi</option>
                    <option value="kriteria">Kriteria</option>
                    <option value="indikator">Indikator</option>
                    <option value="fromPenilaian"> Form Penilaian</option>
                    <option value="detilFormPenilaian"> Detil Form Penilaian</option>
                    <option value="penilaian">Penilaian</option>
                    <option value="penjualan">Penjualan</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" >Pilih</button>
               </form>

                <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:5px;">No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                        <th>Fitur</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($log as $l)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$l->user->name}}</td>
                        <td>{{$l->aksi}}</td>
                        <td>{{$l->fitur}}</td>
                        <td>{{$l->created_at ? date('d-m-Y H:i:s', strtotime($l->created_at)) : ($l->waktu ?? '-')}}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!--Data Tables js-->
<script src="assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

<script>
    $('#default-datatable').DataTable();
</script>
@endsection