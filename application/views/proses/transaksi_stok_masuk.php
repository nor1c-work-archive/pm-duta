<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $kode = $buku['kode'];
    $judul = $buku['judul'];
    $jilid = $buku['jilid'];
    $penulis = $buku['penulis'];

    $gudang_id = $pencarian['gudang_id'];
    $pemasok_id = $pencarian['pemasok_id'];
    $tipe_buku_masuk_id = $pencarian['tipe_buku_masuk_id'];
    $tanggal_transaksi = $pencarian['tanggal_transaksi'];

    $this->db->where('id', $pemasok_id);
    $pemasok = $this->db->get('pemasok')->row_array();
    if (isset($pemasok)) {
        $tipe_pemasok = $pemasok['tipe_pemasok'];
    } else {
        $tipe_pemasok = '';
    }
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>

            <form method="post" action="<?php echo base_url('proses/transaksi_stok_masuk'); ?>">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="gudang">Transaksi di Gudang</label>
                                <select class="custom-select" id="gudang_id" name="gudang_id">
                                    <option selected value="">Pilih...</option>
                                    <?php
                                    $gudang = $this->db->get('gudang')->result_array();
                                    foreach ($gudang as $g) : {
                                            echo '
                                            <option ';

                                            if ($gudang_id == $g['id']) {
                                                echo 'selected';
                                            }

                                            echo ' value="' . $g['id'] . '">' . $g['nama_gudang'] . '</option>
                                            
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pemasok">Nama Pemasok</label>
                                <select class="custom-select" id="pemasok_id" name="pemasok_id">
                                    <option selected value="">Pilih...</option>
                                    <?php
                                    $pemasok = $this->db->get('pemasok')->result_array();
                                    foreach ($pemasok as $p) : {
                                            echo '
                                            <option ';

                                            if ($pemasok_id == $p['id']) {
                                                echo 'selected';
                                            }

                                            echo ' value="' . $p['id'] . '">' . $p['nama_pemasok'] . '</option>
                                            
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pelanggan">Tipe Buku Masuk</label>
                                <select class="custom-select" id="tipe_buku_masuk_id" name="tipe_buku_masuk_id">
                                    <option selected value="">Pilih...</option>
                                    <?php
                                    $tipe_buku_masuk = $this->db->get('tipe_buku_masuk')->result_array();
                                    foreach ($tipe_buku_masuk as $tbk) : {
                                            echo '
                                            <option ';

                                            if ($tipe_buku_masuk_id == $tbk['id']) {
                                                echo 'selected';
                                            }

                                            echo ' value="' . $tbk['id'] . '">' . $tbk['nama_tipe_buku_masuk'] . '</option>
                                            
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pelanggan">Tanggal Transaksi</label>
                                <input id="tanggal_transaksi" name="tanggal_transaksi" value="<?php echo $tanggal_transaksi; ?>" />
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
                                <label for="kode_buku">Kode Buku</label>
                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>">
                            </div>
                        </div>
                        <button type="submit" id="cari" name="cari" value=TRUE class="btn btn-primary">Cari</button>
                        <?php echo form_error('kode', '<small class="text-danger pl-3">', '</small>'); ?>
                        <?php echo form_error('gudang_id', '<small class="text-danger pl-3">', '</small>'); ?>
                        <?php echo form_error('pemasok_id', '<small class="text-danger pl-3">', '</small>'); ?>
                        <?php echo form_error('tipe_buku_masuk_id', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
            </form>
            <div class="card mb-1">
                <div class="card-body">
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
            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('proses/transaksi_stok_masuk'); ?>">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputAddress">No Reff</label>
                                <?php
                                if ($tipe_pemasok == 'Eksternal') {
                                    $this->db->where('id', $pemasok_id);
                                    $nama_pemasok = $this->db->get('pemasok')->row()->nama_pemasok;
                                    $this->db->where('nama_pemasok', $nama_pemasok);
                                    $this->db->where('kode', $kode);
                                    $this->db->where('is_active', 1);
                                    $this->db->order_by('order_tgl DESC');
                                    $order = $this->db->get('order_cetak')->result_array();
                                    $i = 0;
                                    echo ' <select class="custom-select" id="id_reff" name="id_reff">';
                                    foreach ($order as $order) : {
                                            echo '<option value="' . $order['id'] . '">' . $i = $order['no_po'] . '</option>';
                                            $i++;
                                        }
                                    endforeach;
                                    echo '</select>';
                                    if ($i == 0) {
                                        $cari = FALSE;
                                        echo '<p class="text-danger"><small>Tidak ada Order tersebut.</small></p>';
                                    }
                                    echo '<input type="hidden" class="form-control" id="no_reff" name="no_reff" value="-">';
                                } else {
                                    echo '
                                <input type="hidden" class="form-control" id="id_reff" name="id_reff" value="-">
                                <input type="text" class="form-control" id="no_reff" name="no_reff">';
                                }
                                ?>


                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputAddress">Qty (eksemplar)</label>
                                <input type="number" min="0" class="form-control" id="qty" name="qty">

                            </div>

                        </div>
                        <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                        <input type="hidden" id="gudang_id" name="gudang_id" value="<?php echo $gudang_id; ?>">
                        <input type="hidden" id="pemasok_id" name="pemasok_id" value="<?php echo $pemasok_id; ?>">
                        <input type="hidden" id="tipe_buku_masuk_id" name="tipe_buku_masuk_id" value="<?php echo $tipe_buku_masuk_id; ?>">
                        <input type="hidden" id="tanggal_transaksi" name="tanggal_transaksi" value="<?php echo $tanggal_transaksi; ?>">
                        <button <?php
                                if (!$cari)
                                    echo 'disabled';

                                ?> type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-primary">Proses</button>
                        <?php echo form_error('qty', '<small class="text-danger pl-3">', '</small>'); ?>
                    </form>

                </div>
            </div>



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