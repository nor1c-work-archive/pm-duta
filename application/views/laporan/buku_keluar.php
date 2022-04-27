<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php


    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo form_error('gudang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('dari_tgl', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('sampai_tgl', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('laporan/buku_keluar'); ?>">
                        <div class="form-group row">
                            <label for="gudang_id" class="col-sm-2 col-form-label">Gudang</label>
                            <div class="col-sm-3">
                                <select class="custom-select" id="gudang_id" name="gudang_id">
                                    <option selected value="">Pilih...</option>
                                    <?php
                                    $gudang = $this->db->get('gudang')->result_array();
                                    foreach ($gudang as $g) : {
                                            echo '
                                            <option ';
                                            if ($buku_keluar['gudang_id'] == $g['id']) {
                                                echo 'selected';
                                            }

                                            echo ' value="' . $g['id'] . '">' . $g['nama_gudang'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="dari_tgl" class="col-sm-2 col-form-label">Dari tanggal:</label>
                            <div class="col-sm-3">
                                <input id="dari_tgl" name="dari_tgl" value="<?php echo $buku_keluar['dari_tgl']; ?>" />
                                <script>
                                    $('#dari_tgl').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>
                            <label for="sampai_tgl" class="col-sm-2 col-form-label text-right">Sampai tanggal:</label>
                            <div class="col-sm-3">
                                <input id="sampai_tgl" name="sampai_tgl" value="<?php echo $buku_keluar['sampai_tgl']; ?>" />
                                <script>
                                    $('#sampai_tgl').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>

                            <div class="col-sm-2">
                                <button type="submit" id="tampilkan" name="tampilkan" value=TRUE class="btn btn-primary">Tampilkan</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <?php
            if ($tampilkan) {

            ?>


                <div class="card mb-1">
                    <div class="card-body">
                        <?php
                        echo '<h5>Gudang ' . $nama_gudang . '</h5>';
                        ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Input Data</th>
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Jilid</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Jenis Transaksi</th>
                                    <th scope="col">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $total_keluar = 0;
                                foreach ($kartu_stok as $ts) : {
                                        $tanggal_input = date('d-m-Y', $ts['last_update']);
                                        $id = $ts['id'];
                                        $kode = $ts['kode'];
                                        $tanggal = $ts['tanggal'];
                                        $masuk_keluar = $ts['masuk_keluar'];
                                        $qty = $ts['qty'];
                                        $stok_akhir = $ts['stok_akhir'];

                                        $pelanggan_id = $ts['pemasok_pelanggan_id'];
                                        $dari_ke = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row()->nama_pelanggan;
                                        $tipe_buku_keluar_id = $ts['tipe_transaksi_id'];
                                        $jenis_transaksi = $this->db->get_where('tipe_buku_keluar', ['id' => $tipe_buku_keluar_id])->row()->nama_tipe_buku_keluar;
                                        $buku = $this->db->get_where('buku', ['kode' => $kode])->row_array();


                                        echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $tanggal_input . '</td>
                                        <td>' . $tanggal . '</td>
                                        <td>' . $buku['kode'] . '</td>
                                        <td>' . $buku['judul'] . '</td>
                                        <td>' . $buku['jilid'] . '</td>
                                        <td>' . $buku['penulis'] . '</td>
                                        <td>' . $dari_ke . '</td>
                                        <td>' . $jenis_transaksi . '</td>
                                        <td class="text-right">' . number_format($qty, 0, ",", ".") . '</td>
                                    </tr>';
                                        $total_keluar = $total_keluar + $qty;
                                    }
                                endforeach;
                                echo '<tr class="text-light">
                                        
                                        <td colspan="8"></td>
                                        <td class="bg-secondary">Total Keluar</td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($total_keluar, 0, ",", ".") . '</td>
                                    </tr>';
                                ?>

                            </tbody>
                        </table>

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