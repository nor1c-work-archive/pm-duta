<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $kode = $buku['kode'];
    $judul = $buku['judul'];
    $jilid = $buku['jilid'];
    $penulis = $buku['penulis'];

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>

            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('proses/transaksi_stok_keluar'); ?>">
                        <div class="form-group row">
                            <label for="kode_buku" class="col-sm-2 col-form-label">Kode Buku</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" id="cari" name="cari" value=TRUE class="btn btn-primary">Cari</button>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-danger">
                                    <small><?php echo $error1; ?></small>
                                </p>
                            </div>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="judul">Judul</label>
                            <input readonly type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="jilid">Jilid</label>
                            <input readonly type="text" class="form-control" id="jilid" name="jilid" value="<?php echo $jilid; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="penulis">Penulis</label>
                            <input readonly type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>">
                        </div>
                    </div>
                </div>
            </div>


            <?php
            if ($cari) {

            ?>

                <div class="card mb-1">
                    <div class="card-body">
                        <form method="post" action="<?php echo base_url('proses/transaksi_stok_keluar'); ?>">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="gudang">Transaksi di Gudang</label>
                                    <select class="custom-select" id="gudang_id" name="gudang_id">
                                        <option selected value="">Pilih...</option>
                                        <?php
                                        $gudang = $this->db->get('gudang')->result_array();
                                        foreach ($gudang as $g) : {
                                                echo '
                                            <option value="' . $g['id'] . '">' . $g['nama_gudang'] . '</option>
                                            
                                            
                                             ';
                                            }
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pelanggan">Nama pelanggan</label>
                                    <select class="custom-select" id="pelanggan_id" name="pelanggan_id">
                                        <option selected value="">Pilih...</option>
                                        <?php
                                        $pelanggan = $this->db->get('pelanggan')->result_array();
                                        foreach ($pelanggan as $p) : {
                                                echo '
                                            <option value="' . $p['id'] . '">' . $p['nama_pelanggan'] . '</option>
                                            
                                            
                                             ';
                                            }
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pelanggan">Tipe Buku Keluar</label>
                                    <select class="custom-select" id="tipe_buku_keluar_id" name="tipe_buku_keluar_id">
                                        <option selected value="">Pilih...</option>
                                        <?php
                                        $tipe_buku_keluar = $this->db->get('tipe_buku_keluar')->result_array();
                                        foreach ($tipe_buku_keluar as $tbk) : {
                                                echo '
                                            <option value="' . $tbk['id'] . '">' . $tbk['nama_tipe_buku_keluar'] . '</option>
                                            
                                            
                                             ';
                                            }
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pelanggan">Tanggal Transaksi</label>
                                    <input id="tanggal_transaksi" name="tanggal_transaksi" value="<?php echo date('d-m-Y'); ?>" />
                                    <script>
                                        $('#tanggal_transaksi').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            format: 'dd-mm-yyyy'

                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputAddress">Qty (eksemplar)</label>
                                    <input type="number" min="0" class="form-control" id="qty" name="qty">
                                </div>
                                <?php echo form_error('gudang_id', '<small class="text-danger pl-3">', '</small>'); ?>
                                <?php echo form_error('pelanggan_id', '<small class="text-danger pl-3">', '</small>'); ?>
                                <?php echo form_error('tipe_buku_keluar_id', '<small class="text-danger pl-3">', '</small>'); ?>
                                <?php echo form_error('qty', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                            <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-primary">Proses</button>
                        </form>

                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if ($tambah) {

            ?>
                <div class="card mb-1">
                    <div class="card-body">
                        <h5 class="card-title">Stok Keluar Gudang <?php echo $rekap['nama_gudang']; ?></h5>
                        <form>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $rekap['tanggal']; ?>">
                                </div>
                                <label for="nomor" class="col-sm-2 col-form-label text-right">Nomor</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" class="form-control" id="nomor" name="nomor" value="<?php echo $rekap['id']; ?>">
                                </div>
                                <label for="keterangan" class="col-sm-2 col-form-label text-right">Keterangan</label>
                                <div class="col-sm-3">
                                    <input readonly type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $rekap['nama_tipe_buku_keluar']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pelanggan" class="col-sm-1 col-form-label text-right">pelanggan</label>
                                <div class="col-sm-11">
                                    <input readonly type="text" class="form-control" id="pelanggan" name="pelanggan" value="<?php echo $rekap['nama_pelanggan']; ?>">
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="qty" class="col-sm-1 col-form-label text-right">Qty Keluar</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" class="form-control text-right" id="qty" name="qty" value="<?php echo number_format($rekap['qty'], 0, ",", "."); ?>">
                                </div>
                                <label for="qty" class="col-sm-1 col-form-label text-left">eks</label>
                                <label for="saldo" class="col-sm-1 col-form-label text-right">Saldo</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" class="form-control text-right" id="saldo" name="saldo" value="<?php echo number_format($rekap['stok_akhir'], 0, ",", "."); ?>">
                                </div>
                                <label for="qty" class="col-sm-1 col-form-label text-left">eks</label>
                            </div>

                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>