@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Perhitungan Penghargaan & Bonus Karyawan</h3>
        <p class="text-muted mb-0">Periode: <strong>Bulan {{ date('F', mktime(0,0,0,$months, 1)) }} {{ $years }}</strong></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <!-- Filter Form -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
            <h5 class="font-weight-bold text-dark mb-3 mb-md-0">
                <i class="typcn typcn-filter text-primary mr-1"></i> Filter Periode
            </h5>
            <div class="d-flex flex-wrap align-items-center">
                <div class="mr-2 mb-2 mb-sm-0">
                    <select id="month" name="month" class="custom-select form-control-sm" style="min-width: 140px;">
                        <?php
                            $selected_month = $months;
                            for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                $selected = $selected_month == $i_month ? ' selected' : '';
                                echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month, 1)).'</option>'."\n";
                            }
                        ?>
                    </select>
                </div>
                <div class="mr-2 mb-2 mb-sm-0">
                    <select id="year" name="year" class="custom-select form-control-sm" style="min-width: 100px;">
                        <?php 
                            $year_start  = 2020;
                            $year_end = date('Y') + 2;
                            $selected_year = $years;

                            for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                $selected = $selected_year == $i_year ? ' selected' : '';
                                echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                            }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn btn-dark btn-sm px-3" onclick="changePage()">
                    <i class="typcn typcn-arrow-sync mr-1"></i> Terapkan
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="default-datatable" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Bonus kehadiran, uang makan, dan transport</th>
                            <th>Jumlah Kehadiran</th>
                            <th>Nilai Sanksi</th>
                            <th>Jumlah Sanksi</th>
                            <th>Bonus Penilaian</th>
                            <th>Skor Penilaian</th>
                            <th>Bonus Penjualan</th>
                            <th>Jumlah Penjualan</th>
                            <th>Gaji Pokok</th>
                            <th>Bonus Gaji</th>
                            <th>Gaji Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($result as $hasil)
                        <tr>
                            <td>{{$i}}</td>
                       
                            <td>{{$hasil->karyawan->name}}</td>
                            {{-- <td>{{$hasil->us}}</td> --}}
                           
                            <td>{{$hasil->karyawan->nama_departemen}}</td>
                            <td>{{$hasil->karyawan->nama_jabatan}}</td>
                            <td >
                                {{number_format($hasil->nilaiAbsen[0])}}
                            </td>
                            <td >
                                {{number_format($hasil->nilaiAbsen[1])}}
                            </td>
                            <td>{{$hasil->nilaiSanksi[0]}}%</td>
                            <td>{{$hasil->nilaiSanksi[1]}}</td>
                            <td>{{number_format($hasil->nilaiPenilaian[0])}}</td>
                            <td>{{number_format($hasil->nilaiPenilaian[1])}}</td>
                            <td>{{ $hasil->karyawan->nama_departemen == "penjualan" ? number_format($hasil->nilaiBonusPenjualan[0]) : "-"}}</td>
                            <td>{{ $hasil->karyawan->nama_departemen == "penjualan" ? number_format($hasil->nilaiBonusPenjualan[1]) : "-"}}</td>
                            <td>{{number_format($hasil->karyawan->gaji_pokok)}}</td>
                            <td>{{number_format(round($hasil->bonusGaji,0))}}</td>
                            <td>{{number_format($hasil->gajiTotal)}}</td>
                         
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
<!-- End Modal -->

@endsection
@section('script')
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
    // $('#default-datatable').DataTable();
    // $('#default-datatable-absen').DataTable();

    function validateForm($formx, $inpux) {

        $inputs = $inpux.split(';');
        $valid = true;

        for (let i = 0; i < $inputs.length; i++) {

            $isi = document.forms[$formx][$inputs[i]].value;
            if ($isi == "") {
                alert($inputs[i].toUpperCase() + " tidak boleh kosong!");
                $loader = false;
                return false;
            }
        }

        if ($valid) {
            pageloader();
        }

    }


    function changePage() {
        var $year = $('#year').find(":selected").val();
        var $month = $('#month').find(":selected").val();
        // alert($year + $month);
    
    
        console.log('DEBUGGG >>', $year, $month);
        var url = "{{ route('penghargaan') }}";

        $.ajax({
            url,
            data: {
                date: `${$year}-${$month}`,
            },
            type: 'get',
            success: function (res) {
                // console.log('sucess = ', this.url);
                window.location.href = this.url;
                pageloader();
            }
        });
    }
   
    // $(".clickable-row").each(function (index) {
    //     $(this).on("click", function () {
    //         // ubah($(this).data("{{route('detailNilaiBonusKehadiran')}}"));
    //         var url = "{{route('detailNilaiBonusKehadiran')}}";
    //         window.location.href = this.url;
    //             pageloader();
    //     });
    // });


</script>
@endsection
