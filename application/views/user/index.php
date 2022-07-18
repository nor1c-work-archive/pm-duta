<link rel="stylesheet" href="<?=base_url('');?>assets/css/attendance.css">

<div class="container-fluid" style="margin-bottom:100px;">
    <h3 style="margin-top:50px;">
        <center>
            <p><span id="tanggalwaktu"></span></p>
        </center>
    </h3>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <br>
            <center>
                <h3>
                    <div style="height:50px;" id="txtDatang"></div>
                    <button id="buttonDatang" class="btn" onclick="absence()">Datang</button>
                </h3>
            </center>
        </div>

        <div class="col-lg-6 mb-4">
            <br>
            <center>
                <h3>
                    <div style="height:50px;" id="txtPulang"></div>
                    <button id="buttonPulang" class="btn" onclick="absencePulang()">Pulang</button>
                </h3>
            </center>
        </div>
    </div>

    <hr>
    <br>

    <center>
        <div class="card border-dark " style="max-width: 70rem; ">
            <div class="card-body text-dark">
                <table style="font-family: arial; font-size: 12px;">
                    <tr>
                        <th>No.Job</th>
                        <th>Judul</th>
                        <th>Rencana Mulai</th>
                        <th>Rencana Selesai</th>
                        <th>Level</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
        </div>
    <center>

    <!-- Pie -->
    <div class="margin-section" style="margin-bottom:50px">
        <div class="pie animate" style="--p:80;--c:red;--b:15px">60</div>
        <div class="pie animate" style="--p:80;--c:blue">80</div>

        <br>
        <br>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="button">Button</button>
            <button class="btn btn-primary" type="button">Button</button>
        </div>
    </div>

    <hr>

    <!-- Riwayat Kehadiran -->
    <div class="margin-section">
        <center>
            <h5><b>Riwayat Kehadiran</b></h5>
        </center>

        <div class="col-lg-12" style="margin-top:10px;background-color:#f0e9dd;border-radius:10px;padding:20px;">
            <div class="col-lg-12 d-flex justify-content-between">
                <div class="row">
                    <div class="form-group col">
                        <label><b>Tanggal Mulai</b></label>
                        <input type="text" id="filter-tanggal-mulai" class="form-control date" data-date-format="DD/MM/YYYY" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group col">
                        <label><b>Tanggal Akhir</b></label>
                        <input type="text" id="filter-tanggal-sampai" class="form-control date" data-date-format="DD/MM/YYYY" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group col">
                        <label><b>Karyawan</b></label>
                        <select class="form-control" id="filter-karyawan">
                            <option width="50px" />
                            <?php
                                $this->db->order_by('nama', 'ASC');
                                foreach($this->db->get('t_karyawan')->result() as $kar){
                                    if($kar->id_karyawan == $this->session->userdata('user_id')){
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }

                                    echo "<option value='".$kar->id_karyawan."' ".$selected.">".$kar->nama."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col">
                        <label><b>&nbsp;</b></label>
                        <button id="report-pdf" class="form-control date btn-info">Report PDF</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="attendance-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Waktu Datang</th>
                            <th>Datang Melalui</th>
                            <th>Waktu Pulang</th>
                            <th>Pulang Melalui</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var tw = new Date();
    
    if (tw.getTimezoneOffset() == 0) {
        (a=tw.getTime() + ( 7 *60*60*1000))
    } else {
        (a=tw.getTime());
    }

    tw.setTime(a);

    var tahun= tw.getFullYear ();
    var hari= tw.getDay ();
    var bulan= tw.getMonth ();
    var tanggal= tw.getDate ();
    var hariarray=new Array("Minggu,","Senin,","Selasa,","Rabu,","Kamis,","Jum'at,","Sabtu,");
    var bulanarray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
    
    document.getElementById("tanggalwaktu").innerHTML = hariarray[hari]+" "+tanggal+" "+bulanarray[bulan]+" "+tahun+("");
	
    let timerTimeout
    let timerTimeoutPulang

    let absence
    let absencePulang

    let refreshAttendanceTable

  	$(document).ready(function () {
        // on load
        checkAttendance()
        
        $("#filter-tanggal-mulai").datetimepicker({
            pickTime: false
        });
        $("#filter-tanggal-sampai").datetimepicker({
            pickTime: false
        });

        // on page load check atttendance status
		function checkAttendance () {
            $('#filter-tanggal-mulai').val('<?=date('d/m/Y', time())?>')
            $('#filter-tanggal-sampai').val('<?=date('d/m/Y', time())?>')

            const attendanceStatus = $.ajax({
                url: '<?=base_url('user/check_attendance');?>',
                type: 'POST',
                success: function (data) {
                    if (data == 'null') {
                        startTime()
                    } else {
                        getAbsenceTime()
                        checkAttendancePulang()
                    }
                }
            })
		}

        function checkAttendancePulang () {
            $.ajax({
                url: '<?=base_url('user/check_attendance_pulang');?>',
                type: 'POST',
                success: function (data) {
                    if (data == 'null') {
                        $('#buttonDatang').attr('disabled', true)
                        $('#buttonDatang').css('cursor', 'not-allowed')
                        
                        startTimerPulang()
                    } else {
                        getAbsenceTime()
                        $('#buttonDatang').attr('disabled', true)
                        $('#buttonDatang').css('cursor', 'not-allowed')
                        
                        $('#buttonPulang').attr('disabled', true)
                        $('#buttonPulang').css('cursor', 'not-allowed')

                        data = JSON.parse(data)
                        const jamPulang = data.jam_pulang.split(' ')[1]

                        document.getElementById('txtPulang').innerHTML = jamPulang
                    }
                }
            })
        }

        function getAbsenceTime () {
            $.ajax({
                url: '<?=base_url('user/get_absence_time')?>',
                type: 'GET',
                success: function (data) {
                    data = JSON.parse(data)
                    const jamDatang = data.jam_datang.split(' ')[1]

                    document.getElementById('txtDatang').innerHTML = jamDatang
                }
            })
        }

		function startTime() {
            $('#buttonPulang').attr('disabled', true)
            $('#buttonPulang').css('cursor', 'not-allowed')

			const today = new Date();
			let h = today.getHours();
			let m = today.getMinutes();
			let s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('txtDatang').innerHTML =  h + ":" + m + ":" + s;
			timerTimeout = setTimeout(startTime, 1000);
		}

        function startTimerPulang () {
			const today = new Date();
			let h = today.getHours();
			let m = today.getMinutes();
			let s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('txtPulang').innerHTML =  h + ":" + m + ":" + s;
			timerTimeoutPulang = setTimeout(startTimerPulang, 1000);
        }

		function checkTime(i) {
			if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}

		absence = function () {
            $.ajax({
                url: '<?=base_url('user/absence');?>',
                type: 'POST',
                success: function (success) {
                    if (success == 'true') {
                        clearTimeout(timerTimeout)
                        
                        $('#buttonDatang').attr('disabled', true)
                        $('#buttonDatang').css('cursor', 'not-allowed')
                        startTimerPulang()
                        
                        $('#buttonPulang').attr('disabled', false)
                        $('#buttonPulang').css('cursor', 'pointer')
                    } else {
                        alert('Gagal absen masuk, harap refresh halaman lalu coba lagi.')
                    }
                }
            })
		}

        absencePulang = function () {
            $.ajax({
                url: '<?=base_url('user/absence_pulang')?>',
                success: function (success) {
                    if (success == 'true') {
                        clearTimeout(timerTimeoutPulang)

                        $('#buttonPulang').attr('disabled', true)
                        $('#buttonPulang').css('cursor', 'not-allowed')
                    } else {
                        alert('Gagal absen pulang, harap refresh halaman lalu coba lagi.')
                    }
                }
            })
        }

        let filterKaryawanInputVal = $('#filter-karyawan').val()
        let filterTglMulaiInputVal = $('#filter-tanggal-mulai').val()
        let filterTglSampaiInputVal = $('#filter-tanggal-sampai').val()
        const attendanceTable = $('#attendance-table').DataTable({
            dom: "Bfrtip",
            pageLength: 10,
            ajax: {
                url: '<?=site_url('user/get_attendance_history')?>',
                type: 'POST',
                data: function (d) {
                    d.mulai=filterTglMulaiInputVal
                    d.sampai=filterTglSampaiInputVal
                    d.karyawan=filterKaryawanInputVal
                }
            },
            columns: [
                // {
                //     data: null,
                //     render: function (data, type, row, meta) {
                //         return meta.row+1
                //     }
                // },
                { data: 'nik' },
                { data: 'nama' },
                { data: 'hari' },
                { data: 'tanggal' },
                { data: 'jam_datang' },
                { data: 'ip_datang' },
                { data: 'jam_pulang' },
                { data: 'ip_pulang' },
                { data: 'keterangan' }
            ],
            order: [
                [1, 'asc']
            ]
        })

        refreshAttendanceTable = () => {
            attendanceTable.ajax.reload()
        }
        
        // filters
        const filterKaryawanInput = $('#filter-karyawan')
        const filterTglMulaiInput = $('#filter-tanggal-mulai')
        const filterTglSampaiInput = $('#filter-tanggal-sampai')
        filterKaryawanInput.change(function () {
            filterKaryawanInputVal = $(this).val()
            refreshAttendanceTable()
        })
        filterTglMulaiInput.change(function () {
            filterTglMulaiInputVal = $(this).val()
            refreshAttendanceTable()
        })
        filterTglSampaiInput.change(function () {
            filterTglSampaiInputVal = $(this).val()
            refreshAttendanceTable()
        })

        $('#report-pdf').click(function () {
            const url = '<?=site_url('user/report_attendance_pdf')?>?mulai='+filterTglMulaiInputVal+'&sampai='+filterTglSampaiInputVal+'&karyawan='+filterKaryawanInputVal

            window.location.href = url
        })
	})
</script>
