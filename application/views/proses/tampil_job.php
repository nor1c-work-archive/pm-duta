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
    $ada_standar = TRUE;
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
                            <input readonly type="text" class="form-control" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                        </div>

                        <div class="col-sm-3">
                            <p class="text-danger">
                                <small><?php echo $error1; ?></small>
                            </p>
                            <?php echo form_error('nojob', '<small class="text-danger pl-3">', '</small>'); ?>
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

                    <br>
                </div>
            </div>
            <?php
            if ($tampil) {
            ?>

                <?php

                $naskah_rencana_produksi = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row_array();
                $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];

                $this->db->order_by('objek_kerja_id');
                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                foreach ($objek_kerja as $ok) : {
                        $id = $ok['id'];
                        $nama_objek_kerja = $ok['nama_objek_kerja'];
                        $inisial_objek_kerja = $ok['inisial_objek_kerja'];
                        if ($nojob == '') {
                            $jumlah_halaman = 0;
                        } else {
                            $jumlah_halaman = $this->db->get_where('spek_naskah', ['nama_objek_kerja' => $nama_objek_kerja, 'nojob' => $nojob])->row()->jumlah_halaman;
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
                                            <th scope="col">Rencana Mulai</th>
                                            <th scope="col">Real Mulai</th>
                                            <th scope="col">Rencana Selesai</th>
                                            <th scope="col">Real Selesai</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Rencana Oleh</th>
                                            <th scope="col">Proses Oleh</th>
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
                                                    $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                                    $rencana_oleh = $this->db->get('naskah_rencana_produksi')->row()->update_oleh;
                                                    $nama_perencana = $this->db->get_where('user', ['email' => $rencana_oleh])->row()->nama;
                                                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                    $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                                    $detail_rencana_produksi = $this->db->get('detail_rencana_produksi')->row_array();
                                                    $mulai = $detail_rencana_produksi['mulai'];
                                                    $selesai = $detail_rencana_produksi['selesai'];
                                                    $mulai_real = $detail_rencana_produksi['mulai_real'];
                                                    $selesai_real = $detail_rencana_produksi['selesai_real'];
                                                    $status = $detail_rencana_produksi['status'];
                                                    $update_oleh = $detail_rencana_produksi['update_oleh'];
                                                    $pic = $this->db->get_where('user', ['email' => $update_oleh])->row()->nama;
                                                    echo '<tr ';
                                                    if ($baru['nama_objek_kerja'] == $ok['nama_objek_kerja'] and $baru['inisial_level_kerja'] == $dak['inisial_level_kerja']) {
                                                        echo 'class="table-warning"';
                                                    }



                                                    echo ' >';
                                                    echo '<td scope="col">' . $dak['urutan'] . '</td>';
                                                    echo '<td scope="col">' . $dak['inisial_level_kerja'] . '</td>';
                                                    echo '<td >' . $mulai . '</td>';
                                                    echo '<td >' . $mulai_real . '</td>';
                                                    echo '<td >' . $selesai . '</td>';
                                                    echo '<td >' . $selesai_real . '</td>';
                                                    echo '<td >' . $status . '</td>';
                                                    echo '<td >' . $nama_perencana . '</td>';
                                                    echo '<td >' . $pic . '</td>';
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
<?php
            }


?>
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