function myFunction() {

    var setting = document.getElementById("setting").value;
    var jumlah_halaman = document.getElementById("jumlah_halaman").value;
    document.getElementById("jumlah_halaman2").value = jumlah_halaman;

    var total_setting = parseFloat(setting) * parseFloat(jumlah_halaman);
    var print_total_setting = thousands_separators(total_setting);

    document.getElementById("total_setting").value = print_total_setting;

    var editing = document.getElementById("editing").value;
    var jumlah_halaman = document.getElementById("jumlah_halaman2").value;
    document.getElementById("jumlah_halaman").value = jumlah_halaman;
    var total_editing = parseFloat(editing) * parseFloat(jumlah_halaman);
    var print_total_editing = thousands_separators(total_editing);
    document.getElementById("total_editing").value = print_total_editing;

    var ilustrasi = document.getElementById("ilustrasi").value;
    var banyak_ilustrasi = document.getElementById("banyak_ilustrasi").value;
    var total_ilustrasi = parseFloat(ilustrasi) * parseFloat(banyak_ilustrasi);
    var print_total_ilustrasi = thousands_separators(total_ilustrasi);
    document.getElementById("total_ilustrasi").value = print_total_ilustrasi;

    var cover = document.getElementById("cover").value;

    var total_cover = parseInt(cover);
    var print_total_cover = thousands_separators(total_cover);
    document.getElementById("total_cover").value = print_total_cover;

    var biaya_lain = parseInt(document.getElementById("biaya_lain").value);
    var print_total_biaya_lain = thousands_separators(biaya_lain);
    document.getElementById("total_biaya_lain").value = print_total_biaya_lain;

    var sub_total_i = total_setting + total_editing + total_ilustrasi + total_cover + biaya_lain;
    var print_sub_total_i = thousands_separators(sub_total_i);
    document.getElementById("sub_total_i").value = print_sub_total_i;

    var overhead = parseInt(sub_total_i * 0.2);
    var print_overhead = thousands_separators(overhead);
    document.getElementById("overhead").value = print_overhead;

    var sub_total_ii = sub_total_i + overhead;
    var print_sub_total_ii = thousands_separators(sub_total_ii);
    document.getElementById("sub_total_ii").value = print_sub_total_ii;

    var oplah = parseInt(document.getElementById("total_oplah").value);
    var biaya_per_buku = sub_total_ii / oplah;
    var print_biaya_per_buku = thousands_separators(biaya_per_buku);
    document.getElementById("biaya_per_buku").value = print_biaya_per_buku;

    var biaya_cetak_per_buku = parseInt(document.getElementById("biaya_cetak_per_buku").value);

    var ppn = biaya_cetak_per_buku * 0.1;

    var print_ppn = thousands_separators(ppn);
    document.getElementById("ppn").value = print_ppn;

    var hpp = parseInt(biaya_per_buku + biaya_cetak_per_buku + ppn);
    var print_hpp = thousands_separators(hpp);
    document.getElementById("hpp").value = print_hpp;

    var koefisien_harga = parseFloat(document.getElementById("koefisien_harga").value);
    var harga = parseInt(hpp / koefisien_harga);
    var print_harga = thousands_separators(harga);

    document.getElementById("harga").value = print_harga;

    var pct_terjual = parseFloat(document.getElementById("pct_terjual").value);
    var total_jual = parseInt(harga * oplah);
    var print_total_jual = thousands_separators(total_jual);
    document.getElementById("total_jual").value = print_total_jual;
    var penjualan_kotor = parseInt((pct_terjual / 100) * total_jual);
    var print_penjualan_kotor = thousands_separators(penjualan_kotor);
    document.getElementById("penjualan_kotor").value = print_penjualan_kotor;

    var diskon = parseFloat(document.getElementById("diskon").value);
    document.getElementById("penjualan_kotor1").value = print_penjualan_kotor;
    var total_diskon = parseInt((diskon / 100) * penjualan_kotor);
    var print_total_diskon = thousands_separators(total_diskon);
    document.getElementById("total_diskon").value = print_total_diskon;

    var penjualan_bersih = parseInt(penjualan_kotor - total_diskon);
    var print_penjualan_bersih = thousands_separators(penjualan_bersih);
    document.getElementById("penjualan_bersih").value = print_penjualan_bersih;

    var biaya_hpp = parseInt(hpp * oplah);
    var print_biaya_hpp = thousands_separators(biaya_hpp);
    document.getElementById("biaya_hpp").value = print_biaya_hpp;

    var royalti = parseFloat(document.getElementById("royalti").value);
    document.getElementById("penjualan_kotor2").value = print_penjualan_kotor;
    var total_royalti = parseInt((royalti / 100) * penjualan_kotor);
    var print_total_royalti = thousands_separators(total_royalti);
    document.getElementById("total_royalti").value = print_total_royalti;

    var pct_biaya = parseFloat(document.getElementById("pct_biaya").value);
    document.getElementById("penjualan_kotor3").value = print_penjualan_kotor;
    var biaya_opr = parseInt((pct_biaya / 100) * penjualan_kotor);
    var print_biaya_opr = thousands_separators(biaya_opr);
    document.getElementById("biaya_opr").value = print_biaya_opr;

    var total_biaya = parseInt(biaya_hpp + total_royalti + biaya_opr);
    var print_total_biaya = thousands_separators(total_biaya);
    document.getElementById("total_biaya").value = print_total_biaya;

    var laba_kotor = parseInt(penjualan_bersih - total_biaya);
    var print_laba_kotor = thousands_separators(laba_kotor);
    document.getElementById("laba_kotor").value = print_laba_kotor;

    var pct_laba_bersih = parseFloat(document.getElementById("pct_laba_bersih").value);
    document.getElementById("laba_kotor1").value = print_laba_kotor;
    var laba_bersih = parseInt((pct_laba_bersih / 100) * laba_kotor);
    var print_laba_bersih = thousands_separators(laba_bersih);
    document.getElementById("laba_bersih").value = print_laba_bersih;

    var pct_laba_hpp = ((laba_bersih / biaya_hpp) * 100).toFixed(2);
    var print_pct_laba_hpp = pct_laba_hpp.toString();
    document.getElementById("pct_laba_hpp").value = print_pct_laba_hpp + " %";

    if (oplah == 0) {
        document.getElementById("error1").innerHTML = "Error: Oplah belum dipilih";
    } else {
        document.getElementById("error1").innerHTML = "";
    }

    if (setting != 0) {
        document.getElementById("pesan2").value = "";

    }
    if (editing != 0) {
        document.getElementById("pesan3").value = "";
    }

    if (ilustrasi != 0) {
        document.getElementById("pesan4").value = "";
    }
    if (cover != 0) {
        document.getElementById("pesan5").value = "";
    }

    if (biaya_cetak_per_buku != 0) {
        document.getElementById("pesan1").value = "";
    }



    if (koefisien_harga == 999999) {
        document.getElementById("error2").innerHTML = "Error: Jenjang belum dipilih";
    } else {
        if (koefisien_harga == 0) {
            document.getElementById("error2").innerHTML = "Error: Koefisien harga blm ditentukan di database";
        } else {
            document.getElementById("error2").innerHTML = "";
        }
    }

}

function myFunction1() {

    document.getElementById("setting").value = 0;
    document.getElementById("jumlah_halaman").value = 0;
    document.getElementById("total_setting").value = 0;

    document.getElementById("jumlah_halaman2").value = 0;
    document.getElementById("editing").value = 0;
    document.getElementById("total_editing").value = 0;

    document.getElementById("ilustrasi").value = 0;
    document.getElementById("total_ilustrasi").value = 0;

    document.getElementById("cover").value = 0;
    document.getElementById("total_cover").value = 0;

    document.getElementById("biaya_lain").value = 0;
    document.getElementById("total_biaya_lain").value = 0;


    document.getElementById("sub_total_i").value = 0;

    document.getElementById("overhead").value = 0;


    document.getElementById("sub_total_ii").value = 0;


    document.getElementById("biaya_per_buku").value = 0;

    document.getElementById("biaya_cetak_per_buku").value = 0;

    document.getElementById("ppn").value = 0;

    document.getElementById("hpp").value = 0;

    document.getElementById("harga").value = 0;

    document.getElementById("total_jual").value = 0;
    document.getElementById("penjualan_kotor").value = 0;
    document.getElementById("penjualan_kotor1").value = 0;
    document.getElementById("total_diskon").value = 0;
    document.getElementById("penjualan_bersih").value = 0;
    document.getElementById("biaya_hpp").value = 0;
    document.getElementById("penjualan_kotor2").value = 0;
    document.getElementById("total_royalti").value = 0;
    document.getElementById("penjualan_kotor3").value = 0;
    document.getElementById("biaya_opr").value = 0;
    document.getElementById("total_biaya").value = 0;
    document.getElementById("laba_kotor").value = 0;
    document.getElementById("laba_kotor1").value = 0;
    document.getElementById("laba_bersih").value = 0;


}



function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}