<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $nojob = $naskah['nojob'];
    $judul = $naskah['judul'];
    $jilid = $naskah['jilid'];
    $penulis = $naskah['penulis'];
    $standar_pc_id = $naskah['standar_pc_id'];
    $ada_model = TRUE;
    if ($standar_pc_id != '') {
        $this->db->where('standar_pc_id', $standar_pc_id);
        $standar_pracetak = $this->db->get('standar_pracetak')->row_array();
        $mapel_id = $standar_pracetak['mapel_id'];
        $mapel = $this->db->get_where('mapel', ['mapel_id' => $mapel_id])->row()->nama_mapel;
        $jenjang_id = $standar_pracetak['jenjang_id'];
        $jenjang = $this->db->get_where('jenjang', ['jenjang_id' => $jenjang_id])->row()->nama_jenjang;
        $kategori_id = $standar_pracetak['kategori_id'];
        $kategori = $this->db->get_where('kategori', ['kategori_id' => $kategori_id])->row()->nama_kategori;
        $banyak_standar_model_alur_kerja = $this->db->get_where('standar_model_alur_kerja', ['standar_pc_id' => $standar_pc_id])->num_rows();
        if ($banyak_standar_model_alur_kerja == 0) {
            $ada_model = FALSE;
        } else {
            $ada_model = TRUE;
        }
    } else {
        $mapel = '';
        $jenjang = '';
        $kategori = '';
    }


    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>


            <div class="card  mb-1">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="nojob" class="col-sm-1 col-form-label">No Job</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                        </div>

                    </div>

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
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="mapel">Mapel</label>
                            <input readonly type="text" class="form-control" id="mapel" name="mapel" value="<?php echo $mapel; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="jenjang">Jenjang</label>
                            <input readonly type="text" class="form-control" id="jenjang" name="jenjang" value="<?php echo $jenjang; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="kategori">Kategori</label>
                            <input readonly type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <?php
                        $this->db->order_by('objek_kerja_id');
                        $objek_kerja = $this->db->get('objek_kerja')->result_array();
                        foreach ($objek_kerja as $ok) : {
                                $nama_objek_kerja = $ok['nama_objek_kerja'];
                                $inisial_objek_kerja = $ok['inisial_objek_kerja'];
                                if ($nojob == '') {
                                    $jumlah_halaman = 0;
                                } else {
                                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                                    $this->db->where('nojob', $nojob);
                                    $spek_naskah = $this->db->get('spek_naskah')->row_array();
                                    if (isset($spek_naskah)) {
                                        $jumlah_halaman = $spek_naskah['jumlah_halaman'];
                                    } else {
                                        $jumlah_halaman = 'Tdk Terdaftar/terhapus';
                                    }
                                }
                                echo '<div class="form-group col-md-2">';
                                echo '<label for="kategori">Banyak (satuan) ' . $inisial_objek_kerja . '</label>';
                                echo ' <input readonly type="text" class="form-control" value="' . $jumlah_halaman . '">';
                                echo '</div>';
                            }
                        endforeach;
                        ?>
                    </div>

                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('pengaturan/perencanaan_produksi'); ?>">
                        <div class="form-row">
                            <div class="form-group col-sm-2">
                                <label for="model">Model Alur Kerja</label>
                                <select readonly class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                                    <?php
                                    $this->db->where('standar_pc_id', $standar_pc_id);
                                    $this->db->order_by('alur_kerja_id ASC');
                                    $standar_model_alur_kerja = $this->db->get('standar_model_alur_kerja')->result_array();
                                    foreach ($standar_model_alur_kerja as $smak) : {
                                            $this->db->where('alur_kerja_id', $smak['alur_kerja_id']);
                                            $model_alur_kerja = $this->db->get('alur_kerja')->row()->model_alur_kerja;
                                            echo '<option ';
                                            if ($alur_kerja_id == $smak['alur_kerja_id']) {
                                                echo "selected";
                                            }
                                            echo 'value=' . $smak['alur_kerja_id'] . '>' . $model_alur_kerja . '</option>';
                                        }
                                    endforeach;
                                    ?>

                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="jilid">Versi</label>
                                <input readonly type="text" class="form-control" id="versi" name="versi" value="<?php echo $versi; ?>">
                            </div>

                            <?php
                            $this->db->where('nojob', $nojob);
                            $this->db->where('alur_kerja_id', $alur_kerja_id);
                            $this->db->where('versi', $versi);
                            $naskah_rencana_produksi = $this->db->get('naskah_rencana_produksi')->row_array();
                            $last_update = $naskah_rencana_produksi['last_update'];
                            $update_oleh = $naskah_rencana_produksi['update_oleh'];

                            ?>
                            <div class="form-group col-sm-2">
                                <label for="jilid">Last Update</label>
                                <input readonly type="text" class="form-control" id="last_update" name="last_update" value="<?php echo date('d-m-Y', $last_update); ?>">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="jilid">Update Oleh</label>
                                <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh" value="<?php echo $update_oleh; ?>">
                            </div>
                        </div>

                </div>
            </div>

            <?php
            $naskah_rencana_produksi_id = $nojob . $alur_kerja_id . $versi;
            $this->db->order_by('objek_kerja_id');
            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            foreach ($objek_kerja as $ok) : {
                    $id = $ok['id'];
                    $nama_objek_kerja = $ok['nama_objek_kerja'];
                    $inisial_objek_kerja = $ok['inisial_objek_kerja'];
                    if ($nojob == '') {
                        $jumlah_halaman = 0;
                    } else {
                        $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->where('nojob', $nojob);
                        $spek_naskah = $this->db->get('spek_naskah')->row_array();
                        if (isset($spek_naskah)) {
                            $jumlah_halaman = $spek_naskah['jumlah_halaman'];
                        } else {
                            $jumlah_halaman = 'Tdk Terdaftar/terhapus';
                        }
                    }
                    echo '
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h5 class="card-title">' . $ok['nama_objek_kerja'] . '</h5>';
            ?>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Urutan</th>
                                        <th scope="col">Level Kerja</th>
                                        <th scope="col">Mulai</th>
                                        <th scope="col">Selesai</th>
                                        <th scope="col">PIC</th>
                                    <tr>
                                </thead>
                                <?php
                                if ($jumlah_halaman != 0) {
                                ?>
                                    <tbody>
                                        <?php

                                        $this->db->order_by('urutan ASC');
                                        $this->db->where('alur_kerja_id', $alur_kerja_id);
                                        $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                                        $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();

                                        foreach ($detail_alur_kerja as $dak) : {
                                                $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                                $detail_rencana_produksi = $this->db->get('detail_rencana_produksi')->row_array();
                                                $mulai = $detail_rencana_produksi['mulai'];
                                                $selesai = $detail_rencana_produksi['selesai'];
                                                $email_pic = $detail_rencana_produksi['pic'];
                                                if ($email_pic == 'tentatif') {
                                                    $nama_pic = "Tentatif";
                                                } else {
                                                    $nama_pic = $this->db->get_where('user', ['email' => $email_pic])->row()->nama;
                                                }


                                                echo '<tr>';
                                                echo '<td scope="col">' . $dak['urutan'] . '</td>';
                                                echo '<td scope="col">' . $dak['inisial_level_kerja'] . '</td>';
                                                echo '<td >' . $mulai . '</td>';

                                                echo '<td >' . $selesai . '</td>';
                                                echo '<td >' . $nama_pic . '</td>';
                                                echo '</tr>';
                                            }
                                        endforeach;


                                        ?>
                                    </tbody>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div>

        </div>

    </div>
<?php
                }
            endforeach;
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