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
            <?php echo form_error('gudang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('dari_tgl', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('sampai_tgl', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>

            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('laporan/kartu_stok'); ?>">
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
                        <form method="post" action="<?php echo base_url('laporan/kartu_stok'); ?>">
                            <div class="form-group row">
                                <label for="kode_buku" class="col-sm-2 col-form-label">Gudang</label>
                                <div class="col-sm-3">
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

                            </div>
                            <div class="form-group row">
                                <label for="dari_tgl" class="col-sm-2 col-form-label">Dari tanggal:</label>
                                <div class="col-sm-3">
                                    <input id="dari_tgl" name="dari_tgl" />
                                    <script>
                                        $('#dari_tgl').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            format: 'dd-mm-yyyy'
                                        });
                                    </script>
                                </div>
                                <label for="sampai_tgl" class="col-sm-2 col-form-label text-right">Sampai tanggal:</label>
                                <div class="col-sm-3">
                                    <input id="sampai_tgl" name="sampai_tgl" />
                                    <script>
                                        $('#sampai_tgl').datepicker({
                                            uiLibrary: 'bootstrap4',
                                            format: 'dd-mm-yyyy'
                                        });
                                    </script>
                                </div>
                                <input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>">
                                <div class="col-sm-2">
                                    <button type="submit" id="tampilkan" name="tampilkan" value=TRUE class="btn btn-primary">Tampilkan</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php
            if ($tampilkan) {

            ?>


                <div class="card mb-1">
                    <div class="card-body">
                        <?php
                        echo '<h5>Gudang ' . $nama_gudang . '</h5>';
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Input Data</th>
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Masuk/Keluar</th>
                                    <th scope="col">Dari/Ke</th>
                                    <th scope="col">Jenis Transaksi</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldo_awal = 0;
                                $saldo_akhir = 0;
                                $total_masuk = 0;
                                $total_keluar = 0;
                                $i = 1;

                                foreach ($kartu_stok as $ts) : {
                                        $tanggal_input = date('d-m-Y', $ts['last_update']);
                                        $id = $ts['id'];
                                        $tanggal = $ts['tanggal'];
                                        $masuk_keluar = $ts['masuk_keluar'];
                                        $qty = $ts['qty'];
                                        $stok_akhir = $ts['stok_akhir'];
                                        if ($masuk_keluar == 'MASUK') {
                                            $pemasok_id = $ts['pemasok_pelanggan_id'];
                                            $dari_ke = $this->db->get_where('pemasok', ['id' => $pemasok_id])->row()->nama_pemasok;
                                            $tipe_buku_masuk_id = $ts['tipe_transaksi_id'];
                                            $jenis_transaksi = $this->db->get_where('tipe_buku_masuk', ['id' => $tipe_buku_masuk_id])->row()->nama_tipe_buku_masuk;
                                            if ($i == 1) {
                                                $saldo_awal = $stok_akhir - $qty;
                                            }
                                            $total_masuk = $total_masuk + $qty;
                                        } else {
                                            if ($masuk_keluar == 'KELUAR') {
                                                $pelanggan_id = $ts['pemasok_pelanggan_id'];
                                                $dari_ke = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row()->nama_pelanggan;
                                                $tipe_buku_keluar_id = $ts['tipe_transaksi_id'];
                                                $jenis_transaksi = $this->db->get_where('tipe_buku_keluar', ['id' => $tipe_buku_keluar_id])->row()->nama_tipe_buku_keluar;
                                                if ($i == 1) {
                                                    $saldo_awal = $stok_akhir + $qty;
                                                }
                                                $total_keluar = $total_keluar + $qty;
                                            }
                                        }


                                        echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $tanggal_input . '</td>
                                        <td>' . $tanggal . '</td>
                                        <td>' . $masuk_keluar . '</td>
                                        <td>' . $dari_ke . '</td>
                                        <td>' . $jenis_transaksi . '</td>
                                        <td class="text-right">' . number_format($qty, 0, ",", ".") . '</td>
                                        <td class="text-right">' . number_format($stok_akhir, 0, ",", ".") . '</td>
                                    </tr>';
                                        $saldo_akhir = $stok_akhir;
                                        $i++;
                                    }
                                endforeach;
                                echo '<tr class="text-light">
                                        
                                        <td colspan="6"></td>
                                        <td class="bg-secondary">Stok Awal:</td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($saldo_awal, 0, ",", ".") . '</td>
                                    </tr>';
                                echo '<tr class="text-light">
                                        
                                        <td colspan="6"></td>
                                        <td class="bg-secondary">Total Masuk: </td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($total_masuk, 0, ",", ".") . '</td>
                                    </tr>';
                                echo '<tr class="text-light">
                                        
                                        <td colspan="6"></td>
                                        <td class="bg-secondary">Total Keluar: </td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($total_keluar, 0, ",", ".") . '</td>
                                    </tr>';
                                echo '<tr class="text-light">
                                        
                                        <td colspan="6"></td>
                                        <td class="bg-secondary">Stok Akhir: </td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($saldo_akhir, 0, ",", ".") . '</td>
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