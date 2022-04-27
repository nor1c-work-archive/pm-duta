<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $tanggal = date('d-m-Y');

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="<?php echo base_url('proses/order_cetak_baru'); ?>">
                        <div class="form-group row">
                            <label for="kode" class=" col-sm-1 col-form-label">Kode</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $buku['kode']; ?>">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" id="cari" name="cari" value=TRUE class="btn btn-info">Cari</button>
                            </div>
                            <div class="col-sm-5">
                                <?php echo $error1; ?>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row">
                        <label for="judul" class="col-sm-1 col-form-label">Judul</label>
                        <div class="col-sm-5">
                            <input readonly type="text" class="form-control" id="judul" name="judul" value="<?php echo $buku['judul']; ?>">
                        </div>
                        <label for="jilid" class="col-sm-1 col-form-label text-right">Jilid</label>
                        <div class="col-sm-1">
                            <input readonly type="text" class="form-control" id="jilid" name="jilid" value="<?php echo $buku['jilid']; ?>">
                        </div>
                        <label for="penulis" class="col-sm-1 col-form-label text-right">Penulis</label>
                        <div class="col-sm-3">
                            <input readonly type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $buku['penulis']; ?>">
                        </div>
                    </div>
                    <br>

                    <form method="post" action="<?php echo base_url('proses/order_cetak_baru'); ?>">
                        <div class="form-group row">
                            <label for="tgl_po" class="col-sm-1 col-form-label">Tanggal</label>
                            <div class="col-sm-2">
                                <input id="tgl_po" name="tgl_po" value="<?php echo date('d-m-Y'); ?>" />
                                <script>
                                    $('#tgl_po').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>
                            <label for="no_reff" class="col-sm-1 col-form-label text-right">No Reff</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="no_reff" name="no_reff">
                            </div>
                            <label for="no_reff" class="col-sm-1 col-form-label text-right">Pemasok</label>
                            <div class="col-sm-3">
                                <select id="inputState" id="nama_pemasok" name="nama_pemasok" class="form-control">
                                    <option></option>
                                    <?php
                                    $this->db->where('tipe_pemasok', 'Eksternal');
                                    $pemasok = $this->db->get('pemasok')->result_array();
                                    foreach ($pemasok as $p) : {
                                            echo ' <option value="' . $p['nama_pemasok'] . '">' . $p['nama_pemasok'] . '</option>';
                                        }
                                    endforeach;
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tiras" class=" col-sm-1 col-form-label">Tiras (eks)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tiras" name="tiras">
                            </div>
                            <input type="hidden" id="kode" name="kode" value="<?php echo $buku['kode']; ?>">
                            <div class="col-sm-5">
                                <button <?php
                                        if (!$tombol_order) {
                                            echo "disabled";
                                        }
                                        ?> type="submit" id="order" name="order" value=TRUE class="btn btn-primary">Order</button>
                                <?php

                                if ($dari_daftar_buku) {
                                    echo '<a href="' . base_url('master/buku') . '" class="btn btn-secondary">Batal</a>';
                                } else {
                                    echo '<a href="' . base_url('proses/order_cetak') . '" class="btn btn-secondary">Batal</a>';
                                }
                                ?>


                            </div>
                        </div>
                    </form>

                    <?php echo form_error('no_reff', '<small class="text-danger pl-3">', '</small>'); ?>
                    <?php echo form_error('nama_pemasok', '<small class="text-danger pl-3">', '</small>'); ?>
                    <?php echo form_error('tiras', '<small class="text-danger pl-3">', '</small>'); ?>
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