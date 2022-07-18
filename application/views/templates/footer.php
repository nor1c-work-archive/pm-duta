<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url('assets/js/'); ?>print.js"></script>


<script src="<?php echo base_url('assets/js/'); ?>myscript.js"></script>
<script src="<?php echo base_url('assets/js/'); ?>myscript1.js"></script>
<script src="<?php echo base_url('assets/js/'); ?>myscript2.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/moment-develop/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-datetimepicker.js"></script>

<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">
    $(document).on("click", "#tombolEditUnitKerja", function() {
        var unit_kerja_id = $(this).data('unit_kerja_id');
        $(".modal-body #unit_kerja_id").val(unit_kerja_id);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);
        var inisial_unit_kerja = $(this).data('inisial_unit_kerja');
        $(".modal-body #inisial_unit_kerja").val(inisial_unit_kerja);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);

    });


    $(document).on("click", "#tombolDeleteUnitKerja", function() {
        var unit_kerja_id = $(this).data('unit_kerja_id');
        $(".modal-body #unit_kerja_id").val(unit_kerja_id);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);
        var inisial_unit_kerja = $(this).data('inisial_unit_kerja');
        $(".modal-body #inisial_unit_kerja").val(inisial_unit_kerja);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);

    })


    $(document).on("click", "#tombolInfoUnitKerja", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolEditLevelKerja", function() {
        var level_kerja_id = $(this).data('level_kerja_id');
        $(".modal-body #level_kerja_id").val(level_kerja_id);
        var nama_level_kerja = $(this).data('nama_level_kerja');
        $(".modal-body #nama_level_kerja").val(nama_level_kerja);
        var inisial_level_kerja = $(this).data('inisial_level_kerja');
        $(".modal-body #inisial_level_kerja").val(inisial_level_kerja);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });


    $(document).on("click", "#tombolDeleteLevelKerja", function() {
        var level_kerja_id = $(this).data('level_kerja_id');
        $(".modal-body #level_kerja_id").val(level_kerja_id);
        var nama_level_kerja = $(this).data('nama_level_kerja');
        $(".modal-body #nama_level_kerja").val(nama_level_kerja);
        var inisial_level_kerja = $(this).data('inisial_level_kerja');
        $(".modal-body #inisial_level_kerja").val(inisial_level_kerja);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    })


    $(document).on("click", "#tombolInfoLevelKerja", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolEditObjekKerja", function() {
        var objek_kerja_id = $(this).data('objek_kerja_id');
        $(".modal-body #objek_kerja_id").val(objek_kerja_id);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var inisial_objek_kerja = $(this).data('inisial_objek_kerja');
        $(".modal-body #inisial_objek_kerja").val(inisial_objek_kerja);
        var perhitungan_durasi = $(this).data('perhitungan_durasi');
        $(".modal-body #perhitungan_durasi").val(perhitungan_durasi);
        var satuan = $(this).data('satuan');
        $(".modal-body #satuan").val(satuan);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });


    $(document).on("click", "#tombolDeleteObjekKerja", function() {
        var objek_kerja_id = $(this).data('objek_kerja_id');
        $(".modal-body #objek_kerja_id").val(objek_kerja_id);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var inisial_objek_kerja = $(this).data('inisial_objek_kerja');
        $(".modal-body #inisial_objek_kerja").val(inisial_objek_kerja);
        var perhitungan_durasi = $(this).data('perhitungan_durasi');
        $(".modal-body #perhitungan_durasi").val(perhitungan_durasi);
        var satuan = $(this).data('satuan');
        $(".modal-body #satuan").val(satuan);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    })


    $(document).on("click", "#tombolInfoObjekKerja", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolEditNaskah", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
        var jumlah_halaman = $(this).data('jumlah_halaman');
        $(".modal-body #jumlah_halaman").val(jumlah_halaman);
    });

    $(document).on("click", "#tombolSpekNaskah", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
        var jumlah_halaman = $(this).data('jumlah_halaman');
        $(".modal-body #jumlah_halaman").val(jumlah_halaman);
    });
    $(document).on("click", "#tombolDeleteNaskah", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
        var jumlah_halaman = $(this).data('jumlah_halaman');
        $(".modal-body #jumlah_halaman").val(jumlah_halaman);
    });

    $(document).on("click", "#tombolInfoNaskah", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolEditAlurKerja", function() {
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var model_alur_kerja = $(this).data('model_alur_kerja');
        $(".modal-body #model_alur_kerja").val(model_alur_kerja);

    });
    $(document).on("click", "#tombolDeleteAlurKerja", function() {
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var model_alur_kerja = $(this).data('model_alur_kerja');
        $(".modal-body #model_alur_kerja").val(model_alur_kerja);

    });

    $(document).on("click", "#tombolInfoAlurKerja", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolTambahLevelKerjaObjek", function() {
        var objek_kerja_id = $(this).data('objek_kerja_id');
        $(".modal-body #objek_kerja_id").val(objek_kerja_id);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var urutan = $(this).data('next_urutan');;
        $(".modal-body #urutan").val(urutan);
        var inisial_level_kerja = '';
        $(".modal-body #inisial_level_kerja").val(inisial_level_kerja);
    });
    $(document).on("click", "#tombolEditLevelKerjaObjek", function() {
        var objek_kerja_id = $(this).data('objek_kerja_id');
        $(".modal-body #objek_kerja_id").val(objek_kerja_id);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var urutan = $(this).data('urutan');
        $(".modal-body #urutan").val(urutan);
        var inisial_level_kerja = $(this).data('inisial_level_kerja');
        $(".modal-body #inisial_level_kerja").val(inisial_level_kerja);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);
    });
    $(document).on("click", "#tombolDeleteLevelKerjaObjek", function() {
        var objek_kerja_id = $(this).data('objek_kerja_id');
        $(".modal-body #objek_kerja_id").val(objek_kerja_id);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var urutan = $(this).data('urutan');
        $(".modal-body #urutan").val(urutan);
        var inisial_level_kerja = $(this).data('inisial_level_kerja');
        $(".modal-body #inisial_level_kerja").val(inisial_level_kerja);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);
    });
    $(document).on("click", "#tombolDeleteStandarWaktu", function() {
        var alur_kerja_id = $(this).data('alur_kerja_id');
        $(".modal-body #alur_kerja_id").val(alur_kerja_id);
        var standar_pc_id = $(this).data('standar_pc_id');
        $(".modal-body #standar_pc_id").val(standar_pc_id);
        var model_alur_kerja = $(this).data('model_alur_kerja');
        $(".modal-body #model_alur_kerja").val(model_alur_kerja);

    });
    $(document).on("click", "#tombolDeleteHariLiburNasional", function() {
        var date = $(this).data('date');
        $(".modal-body #date").val(date);
        var keterangan = $(this).data('keterangan');
        $(".modal-body #keterangan").val(keterangan);
        var tanggal = $(this).data('tanggal');
        $(".modal-body #tanggal").val(tanggal);

    });

    $(document).on("click", "#tombolMulai0", function() {
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var naskah_rencana_produksi_id = $(this).data('naskah_rencana_produksi_id');
        $(".modal-body #naskah_rencana_produksi_id").val(naskah_rencana_produksi_id);
        var status = $(this).data('status');
        $(".modal-body #status").val(status);
        var header = status + " naskah ini?";
        $(".modal-header #header").val(header);
    });

    $(document).on("keyup", "#naskah_selesai_jumlah_halaman", function () {
        let submitButton = $("#tombol_selesai")

        if ($(this).val() !== "") {
            submitButton[0].classList.remove("disabled")
            submitButton.attr("onclick", "").off("click")
        } else {
            submitButton[0].classList.add("disabled")
            submitButton.attr("onclick", "return false").off("click")
        }
    })

    $(document).on("click", "#tombolMulai", function() {
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var nama_level_kerja = $(this).data('nama_level_kerja');
        $(".modal-body #nama_level_kerja").val(nama_level_kerja);
        var naskah_rencana_produksi_id = $(this).data('naskah_rencana_produksi_id');
        $(".modal-body #naskah_rencana_produksi_id").val(naskah_rencana_produksi_id);
        var status = $(this).data('status');
        $(".modal-body #status").val(status);
        var header = status + " naskah ini?";
        $(".modal-header #header").val(header);
    });
    $(document).on("click", "#tombolSelesai", function() {
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var nama_level_kerja = $(this).data('nama_level_kerja');
        $(".modal-body #nama_level_kerja").val(nama_level_kerja);
        var naskah_rencana_produksi_id = $(this).data('naskah_rencana_produksi_id');
        $(".modal-body #naskah_rencana_produksi_id").val(naskah_rencana_produksi_id);
        var status = $(this).data('status');
        $(".modal-body #status").val(status);
        var header = status + " naskah ini?";
        $(".modal-header #header").val(header);
    });
    $(document).on("click", "#tombolTambahPemasok", function() {

        var nama_pemasok = $(this).data('nama_pemasok');
        $(".modal-body #nama_pemasok").val(nama_pemasok);
        var alamat_pemasok = $(this).data('alamat_pemasok');
        $(".modal-body #alamat_pemasok").val(alamat_pemasok);
        var tipe_pemasok = $(this).data('tipe_pemasok');
        $(".modal-body #tipe_pemasok").val(tipe_pemasok);

    });
    $(document).on("click", "#tombolEditPemasok", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_pemasok = $(this).data('nama_pemasok');
        $(".modal-body #nama_pemasok").val(nama_pemasok);
        var alamat_pemasok = $(this).data('alamat_pemasok');
        $(".modal-body #alamat_pemasok").val(alamat_pemasok);
        var tipe_pemasok = $(this).data('tipe_pemasok');
        $(".modal-body #tipe_pemasok").val(tipe_pemasok);

    });
    $(document).on("click", "#tombolDeletePemasok", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_pemasok = $(this).data('nama_pemasok');
        $(".modal-body #nama_pemasok").val(nama_pemasok);
        var alamat_pemasok = $(this).data('alamat_pemasok');
        $(".modal-body #alamat_pemasok").val(alamat_pemasok);
        var tipe_pemasok = $(this).data('tipe_pemasok');
        $(".modal-body #tipe_pemasok").val(tipe_pemasok);

    });

    $(document).on("click", "#tombolTambahPelanggan", function() {

        var nama_pelanggan = $(this).data('nama_pelanggan');
        $(".modal-body #nama_pelanggan").val(nama_pelanggan);
        var alamat_pelanggan = $(this).data('alamat_pelanggan');
        $(".modal-body #alamat_pelanggan").val(alamat_pelanggan);
        var tipe_pelanggan = $(this).data('tipe_pelanggan');
        $(".modal-body #tipe_pelanggan").val(tipe_pelanggan);

    });
    $(document).on("click", "#tombolEditPelanggan", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_pelanggan = $(this).data('nama_pelanggan');
        $(".modal-body #nama_pelanggan").val(nama_pelanggan);
        var alamat_pelanggan = $(this).data('alamat_pelanggan');
        $(".modal-body #alamat_pelanggan").val(alamat_pelanggan);
        var tipe_pelanggan = $(this).data('tipe_pelanggan');
        $(".modal-body #tipe_pelanggan").val(tipe_pelanggan);

    });
    $(document).on("click", "#tombolDeletePelanggan", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_pelanggan = $(this).data('nama_pelanggan');
        $(".modal-body #nama_pelanggan").val(nama_pelanggan);
        var alamat_pelanggan = $(this).data('alamat_pelanggan');
        $(".modal-body #alamat_pelanggan").val(alamat_pelanggan);
        var tipe_pelanggan = $(this).data('tipe_pelanggan');
        $(".modal-body #tipe_pelanggan").val(tipe_pelanggan);

    });
    $(document).on("click", "#tombolTambahTipeBukuMasuk", function() {

        var nama_tipe_buku_masuk = $(this).data('nama_tipe_buku_masuk');
        $(".modal-body #nama_tipe_buku_masuk").val(nama_tipe_buku_masuk);


    });
    $(document).on("click", "#tombolEditTipeBukuMasuk", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_tipe_buku_masuk = $(this).data('nama_tipe_buku_masuk');
        $(".modal-body #nama_tipe_buku_masuk").val(nama_tipe_buku_masuk);


    });
    $(document).on("click", "#tombolDeleteTipeBukuMasuk", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_tipe_buku_masuk = $(this).data('nama_tipe_buku_masuk');
        $(".modal-body #nama_tipe_buku_masuk").val(nama_tipe_buku_masuk);


    });

    $(document).on("click", "#tombolTambahTipeBukuKeluar", function() {

        var nama_tipe_buku_keluar = $(this).data('nama_tipe_buku_keluar');
        $(".modal-body #nama_tipe_buku_keluar").val(nama_tipe_buku_keluar);


    });
    $(document).on("click", "#tombolEditTipeBukuKeluar", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_tipe_buku_keluar = $(this).data('nama_tipe_buku_keluar');
        $(".modal-body #nama_tipe_buku_keluar").val(nama_tipe_buku_keluar);


    });
    $(document).on("click", "#tombolDeleteTipeBukuKeluar", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_tipe_buku_keluar = $(this).data('nama_tipe_buku_keluar');
        $(".modal-body #nama_tipe_buku_keluar").val(nama_tipe_buku_keluar);


    });

    $(document).on("click", "#tombolTambahGudang", function() {

        var nama_gudang = $(this).data('nama_gudang');
        $(".modal-body #nama_gudang").val(nama_gudang);
        var alamat_gudang = $(this).data('alamat_gudang');
        $(".modal-body #alamat_gudang").val(alamat_gudang);


    });
    $(document).on("click", "#tombolEditGudang", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_gudang = $(this).data('nama_gudang');
        $(".modal-body #nama_gudang").val(nama_gudang);
        var alamat_gudang = $(this).data('alamat_gudang');
        $(".modal-body #alamat_gudang").val(alamat_gudang);


    });
    $(document).on("click", "#tombolDeleteGudang", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_gudang = $(this).data('nama_gudang');
        $(".modal-body #nama_gudang").val(nama_gudang);
        var alamat_gudang = $(this).data('alamat_gudang');
        $(".modal-body #alamat_gudang").val(alamat_gudang);


    });
    $(document).on("click", "#tombolKirimKePic", function() {
        var nojob = $(this).data('nojob');
        $(".modal-body #nojob").val(nojob);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
        var nama_objek_kerja = $(this).data('nama_objek_kerja');
        $(".modal-body #nama_objek_kerja").val(nama_objek_kerja);
        var nama_level_kerja = $(this).data('nama_level_kerja');
        $(".modal-body #nama_level_kerja").val(nama_level_kerja);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);
        var pic_email = $(this).data('pic_email');
        $(".modal-body #pic_email").val(pic_email);


    })
    $(document).on("click", "#tombolUbahAktivasiOrder", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
        var no_po = $(this).data('no_po');
        $(".modal-body #no_po").val(no_po);
        var nama_pemasok = $(this).data('nama_pemasok');
        $(".modal-body #nama_pemasok").val(nama_pemasok);
        var tiras = $(this).data('tiras');
        $(".modal-body #tiras").val(tiras);

    });
</script>


</body>

</html>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda akan menyelesaikan sesi ini?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Klik "Logout" untuk keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>