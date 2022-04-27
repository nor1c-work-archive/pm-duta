$(document).ready(function() {
    $('.toast').toast('show');
});


    $(document).on("click", "#tombolEditUserLevel", function() {
        var level_id = $(this).data('level_id');
        $(".modal-body #level_id").val(level_id);
        var level_name = $(this).data('level_name');
        $(".modal-body #level_name").val(level_name);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);

    });

    $(document).on("click", "#tombolDeleteUserLevel", function() {
        var level_id = $(this).data('level_id');
        $(".modal-body #level_id").val(level_id);
        var level_name = $(this).data('level_name');
        $(".modal-body #level_name").val(level_name);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var nama_unit_kerja = $(this).data('nama_unit_kerja');
        $(".modal-body #nama_unit_kerja").val(nama_unit_kerja);

    });

    $(document).on("click", "#tombolEditMenu", function() {
        var urutan = $(this).data('urutan');
        $(".modal-body #urutan").val(urutan);
        var menu_name = $(this).data('menu_name');
        $(".modal-body #menu_name").val(menu_name);
        var link = $(this).data('link');
        $(".modal-body #link").val(link);
        var parent = $(this).data('parent');
        $(".modal-body #parent").val(parent);
        var icon = $(this).data('icon');
        $(".modal-body #icon").val(icon);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteMenu", function() {
        var urutan = $(this).data('urutan');
        $(".modal-body #urutan").val(urutan);
        var menu_name = $(this).data('menu_name');
        $(".modal-body #menu_name").val(menu_name);
        var link = $(this).data('link');
        $(".modal-body #link").val(link);
        var parent = $(this).data('parent');
        $(".modal-body #parent").val(parent);
        var icon = $(this).data('icon');
        $(".modal-body #icon").val(icon);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditUser", function() {
        var level_id = $(this).data('level_id');
        $(".modal-body #level_id").val(level_id);
        var level_name = $(this).data('level_name');
        $(".modal-body #level_name").val(level_name);
        var email = $(this).data('email');
        $(".modal-body #email").val(email);
        var nama = $(this).data('nama');
        $(".modal-body #nama").val(nama);
        var is_active = $(this).data('is_active');
        $(".modal-body #is_active").val(is_active);
    });

    $(document).on("click", "#tombolDeleteUser", function() {
        var level_id = $(this).data('level_id');
        $(".modal-body #level_id").val(level_id);
        var level_name = $(this).data('level_name');
        $(".modal-body #level_name").val(level_name);
        var email = $(this).data('email');
        $(".modal-body #email").val(email);
        var nama = $(this).data('nama');
        $(".modal-body #nama").val(nama);
        var is_active = $(this).data('is_active');
        $(".modal-body #is_active").val(is_active);
    });

    $(document).on("click", "#tombolEditJenjang", function() {
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var nama_jenjang = $(this).data('nama_jenjang');
        $(".modal-body #nama_jenjang").val(nama_jenjang);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteJenjang", function() {
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var nama_jenjang = $(this).data('nama_jenjang');
        $(".modal-body #nama_jenjang").val(nama_jenjang);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditMapel", function() {
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var nama_mapel = $(this).data('nama_mapel');
        $(".modal-body #nama_mapel").val(nama_mapel);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteMapel", function() {
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var nama_mapel = $(this).data('nama_mapel');
        $(".modal-body #nama_mapel").val(nama_mapel);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditukuran", function() {
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var nama_kategori = $(this).data('nama_kategori');
        $(".modal-body #nama_kategori").val(nama_kategori);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteKategori", function() {
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var nama_kategori = $(this).data('nama_kategori');
        $(".modal-body #nama_kategori").val(nama_kategori);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditUkuran", function() {
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var nama_ukuran = $(this).data('nama_ukuran');
        $(".modal-body #nama_ukuran").val(nama_ukuran);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteUkuran", function() {
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var nama_ukuran = $(this).data('nama_ukuran');
        $(".modal-body #nama_ukuran").val(nama_ukuran);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });
    $(document).on("click", "#tombolEditHalaman", function() {
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var nama_halaman = $(this).data('nama_halaman');
        $(".modal-body #nama_halaman").val(nama_halaman);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteHalaman", function() {
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var nama_halaman = $(this).data('nama_halaman');
        $(".modal-body #nama_halaman").val(nama_halaman);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });
    $(document).on("click", "#tombolEditJenis_kertas", function() {
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var nama_jenis_kertas = $(this).data('nama_jenis_kertas');
        $(".modal-body #nama_jenis_kertas").val(nama_jenis_kertas);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteJenis_kertas", function() {
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var nama_jenis_kertas = $(this).data('nama_jenis_kertas');
        $(".modal-body #nama_jenis_kertas").val(nama_jenis_kertas);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });
    $(document).on("click", "#tombolEditWarna", function() {
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var nama_warna = $(this).data('nama_warna');
        $(".modal-body #nama_warna").val(nama_warna);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteWarna", function() {
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var nama_warna = $(this).data('nama_warna');
        $(".modal-body #nama_warna").val(nama_warna);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditPeriode", function() {
        var periode_id = $(this).data('periode_id');
        $(".modal-body #periode_id").val(periode_id);
        var nama_periode = $(this).data('nama_periode');
        $(".modal-body #nama_periode").val(nama_periode);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeletePeriode", function() {
        var periode_id = $(this).data('periode_id');
        $(".modal-body #periode_id").val(periode_id);
        var nama_periode = $(this).data('nama_periode');
        $(".modal-body #nama_periode").val(nama_periode);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });
    $(document).on("click", "#tombolEditOplah", function() {
        var oplah_id = $(this).data('oplah_id');
        $(".modal-body #oplah_id").val(oplah_id);
        var nama_oplah = $(this).data('nama_oplah');
        $(".modal-body #nama_oplah").val(nama_oplah);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteOplah", function() {
        var oplah_id = $(this).data('oplah_id');
        $(".modal-body #oplah_id").val(oplah_id);
        var nama_oplah = $(this).data('nama_oplah');
        $(".modal-body #nama_oplah").val(nama_oplah);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolEditStandarTarifPraCetak", function() {
        var setting = $(this).data('setting');
        $(".modal-body #setting").val(setting);
        var editing = $(this).data('editing');
        $(".modal-body #editing").val(editing);
        var ilustrasi = $(this).data('ilustrasi');
        $(".modal-body #ilustrasi").val(ilustrasi);
        var cover = $(this).data('cover');
        $(".modal-body #cover").val(cover);
    });

    $(document).on("click", "#tombolEditStandarPraCetak", function() {
        var koefisien = $(this).data('koefisien');
        $(".modal-body #koefisien").val(koefisien);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteStandarPraCetak", function() {
        var koefisien = $(this).data('koefisien');
        $(".modal-body #koefisien").val(koefisien);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolTambahPraCetakDariFilter", function() {
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
    });

    $(document).on("click", "#tombolInfoStandarPraCetak", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });


    $(document).on("click", "#tombolEditStandarCetak", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var oplah_id = $(this).data('oplah_id');
        $(".modal-body #oplah_id").val(oplah_id);
        var biaya_per_eks = $(this).data('biaya_per_eks');
        $(".modal-body #biaya_per_eks").val(biaya_per_eks);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });

    $(document).on("click", "#tombolDeleteStandarCetak", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var oplah_id = $(this).data('oplah_id');
        $(".modal-body #oplah_id").val(oplah_id);
        var biaya_per_eks = $(this).data('biaya_per_eks');
        $(".modal-body #biaya_per_eks").val(biaya_per_eks);
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
    });
    $(document).on("click", "#tombolTambahCetakDariFilter", function() {
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var oplah_id = $(this).data('oplah_id');
        $(".modal-body #oplah_id").val(oplah_id);
    });

    $(document).on("click", "#tombolInfoStandarCetak", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });


    $(document).on("click", "#tombolEditKoefisienHarga", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var koefisien_harga = $(this).data('koefisien_harga');
        $(".modal-body #koefisien_harga").val(koefisien_harga);

    });

    $(document).on("click", "#tombolDeleteKoefisienHarga", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var koefisien_harga = $(this).data('koefisien_harga');
        $(".modal-body #koefisien_harga").val(koefisien_harga);

    });

    $(document).on("click", "#tombolInfoKoefisienHarga", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolEditBuku", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
    });

    $(document).on("click", "#tombolDetailBuku", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
    });

    $(document).on("click", "#tombolInfoBuku", function() {
        var tgl_update = $(this).data('tgl_update');
        $(".modal-body #tgl_update").val(tgl_update);
        var update_oleh = $(this).data('update_oleh');
        $(".modal-body #update_oleh").val(update_oleh);
    });

    $(document).on("click", "#tombolDeleteBuku", function() {
        var id = $(this).data('id');
        $(".modal-body #id").val(id);
        var ukuran_id = $(this).data('ukuran_id');
        $(".modal-body #ukuran_id").val(ukuran_id);
        var halaman_id = $(this).data('halaman_id');
        $(".modal-body #halaman_id").val(halaman_id);
        var warna_id = $(this).data('warna_id');
        $(".modal-body #warna_id").val(warna_id);
        var jenis_kertas_id = $(this).data('jenis_kertas_id');
        $(".modal-body #jenis_kertas_id").val(jenis_kertas_id);
        var jenjang_id = $(this).data('jenjang_id');
        $(".modal-body #jenjang_id").val(jenjang_id);
        var mapel_id = $(this).data('mapel_id');
        $(".modal-body #mapel_id").val(mapel_id);
        var kategori_id = $(this).data('kategori_id');
        $(".modal-body #kategori_id").val(kategori_id);
        var kode = $(this).data('kode');
        $(".modal-body #kode").val(kode);
        var judul = $(this).data('judul');
        $(".modal-body #judul").val(judul);
        var jilid = $(this).data('jilid');
        $(".modal-body #jilid").val(jilid);
        var penulis = $(this).data('penulis');
        $(".modal-body #penulis").val(penulis);
    });
 


