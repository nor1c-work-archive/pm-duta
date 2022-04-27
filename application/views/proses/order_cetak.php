<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    if ($dari_daftar_buku) {
        $this->db->where('kode', $kode);
    }

    $this->db->order_by('order_tgl DESC');
    $order_cetak = $this->db->get('order_cetak')->result_array();
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <a class="btn btn-primary mb-1" href="<?php echo base_url('proses/order_cetak_baru'); ?>">Order Baru</a>


            <div class="table-responsive table-sm">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tgl Order</th>
                            <th scope="col">No Reff</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Jilid</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Pemasok</th>
                            <th scope="col">Order (eks)</th>
                            <th scope="col">Masuk (eks)</th>
                            <th scope="col">Aksi</th>




                        </tr>
                    </thead>
                    <tbody style="font-size: small;">
                        <?php
                        $i = 1;
                        foreach ($order_cetak as $oc) : {
                                $order_tgl = date('d-m-Y', $oc['order_tgl']);
                                $id = $oc['id'];
                                $no_po = $oc['no_po'];
                                $kode = $oc['kode'];
                                $nama_pemasok = $oc['nama_pemasok'];
                                $tiras = $oc['qty'];
                                $is_active = $oc['is_active'];

                                $this->db->where('masuk_keluar', 'MASUK');
                                $this->db->where('id_reff', $id);
                                $this->db->select_sum('qty');
                                $query = $this->db->get('transaksi_stok')->row_array();
                                $masuk = $query['qty'];

                                $this->db->where('kode', $kode);
                                $buku = $this->db->get('buku')->row_array();

                                echo '
                                    <tr>
                                        <td scope="col">' . $i . '</td>
                                        <td scope="col">' . $order_tgl . '</td>
                                        <td scope="col">' . $no_po . '</td>
                                        <td scope="col">' . $kode . '</td>
                                        <td scope="col">' . $buku['judul'] . '</td>
                                        <td scope="col">' . $buku['jilid'] . '</td>
                                        <td scope="col">' . $buku['penulis'] . '</td>
                                        <td scope="col">' . $nama_pemasok . '</td>

                                        <td scope="col" class="text-right">' . number_format($tiras, 0, ',', '. ')  . '</td>
                                        <td scope="col" class="text-right">' . number_format($masuk, 0, ',', '. ')  . '</td>
                                        <td scope="col">
                                            <button style="width: 120px;" id="tombolUbahAktivasiOrder" type="button" data-tiras="' . number_format($tiras, 0, ',', '. ') . '"data-nama_pemasok="' . $nama_pemasok . '" data-penulis="' . $buku['penulis'] . '" data-jilid="' . $buku['jilid'] . '" data-judul="' . $buku['judul'] . '" data-id="' . $id . '" data-no_po="' . $no_po . '" data-kode="' . $kode . '"  data-toggle="modal" ';
                                if ($is_active == 1) {
                                    echo 'class="btn btn-sm btn-info mr-2" data-target="#nonAktifkanOrderModal">Non Aktifkan';
                                } else {
                                    echo 'class="btn btn-sm btn-danger mr-2" data-target="#AktifkanOrderModal">Aktifkan';
                                }
                                echo '   
                                            </button>
                                        </td>
                                    </tr>
                                ';
                                $i++;
                            }
                        endforeach;
                        ?>
                    </tbody>
                </table>
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


<!-- ModalNONAKTIFKAN-->
<div class="modal fade" id="nonAktifkanOrderModal" tabindex="-1" aria-labelledby="nonAktifkanOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nonAktifkanOrderModalLabel">Non Aktifkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/order_cetak'); ?>">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="kode">Kode</label>
                            <input readonly type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group col-md-9">
                            <label for="judul">Judul</label>
                            <input readonly type="text" class="form-control" id="judul" name="judul">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="jilid">Jilid</label>
                            <input readonly type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-9">
                            <label for="penulis">Penulis</label>
                            <input readonly type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="no_po">No Reff</label>
                            <input readonly type="text" class="form-control" id="no_po" name="no_po">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input readonly type="text" class="form-control" id="nama_pemasok" name="nama_pemasok">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tiras">Tiras</label>
                            <input readonly type="text" class="form-control text-right" id="tiras" name="tiras">
                        </div>
                    </div>
                    <input readonly type="hidden" class="form-control text-right" id="id" name="id">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="nonaktifkan" name="nonaktifkan" value=TRUE class="btn btn-info">Nonaktifkan</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- ModalAKTIFKAN-->
<div class="modal fade" id="AktifkanOrderModal" tabindex="-1" aria-labelledby="AktifkanOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AktifkanOrderModalLabel">Aktifkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/order_cetak'); ?>">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="kode">Kode</label>
                            <input readonly type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group col-md-9">
                            <label for="judul">Judul</label>
                            <input readonly type="text" class="form-control" id="judul" name="judul">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="jilid">Jilid</label>
                            <input readonly type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-9">
                            <label for="penulis">Penulis</label>
                            <input readonly type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="no_po">No Reff</label>
                            <input readonly type="text" class="form-control" id="no_po" name="no_po">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input readonly type="text" class="form-control" id="nama_pemasok" name="nama_pemasok">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tiras">Tiras</label>
                            <input readonly type="text" class="form-control text-right" id="tiras" name="tiras">
                        </div>
                    </div>
                    <input readonly type="hidden" class="form-control text-right" id="id" name="id">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" id="aktifkan" name="aktifkan" value=TRUE class="btn btn-danger">Aktifkan</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>