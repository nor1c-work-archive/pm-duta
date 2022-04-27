<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <form method="post" action="<?php echo base_url('laporan/antrian'); ?>">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nojob" class="col-sm-1 col-form-label">No Job</label>
                            <div class="col-sm-2">
                                <input readonly type="text" class="form-control" id="nojob" name="nojob" value="<?php echo $rencana['nojob']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="judul" class="col-sm-1 col-form-label">Judul</label>
                            <div class="col-sm-5">
                                <input readonly type="text" class="form-control" id="judul" name="judul" value="<?php echo $rencana['judul']; ?>">
                            </div>
                            <label for="jilid" class="col-sm-1 col-form-label text-right">Jilid</label>
                            <div class="col-sm-1">
                                <input readonly type="text" class="form-control" id="jilid" name="jilid" value="<?php echo $rencana['jilid']; ?>">
                            </div>
                            <label for="penulis" class="col-sm-1 col-form-label text-right">Penulis</label>
                            <div class="col-sm-3">
                                <input readonly type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $rencana['penulis']; ?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="nama_objek_kerja" class="col-sm-1 col-form-label">Objek</label>
                            <div class="col-sm-3">
                                <input readonly type="text" class="form-control" id="nama_objek_kerja" name="nama_objek_kerja" value="<?php echo $rencana['nama_objek_kerja']; ?>">
                            </div>
                            <label for="nama_level_kerja" class="text-right col-sm-1 col-form-label">Level</label>
                            <div class="col-sm-3">
                                <input readonly type="text" class="form-control" id="nama_level_kerja" name="nama_level_kerja" value="<?php echo $rencana['nama_level_kerja']; ?>">
                            </div>
                            <label for="pic" class="text-right col-sm-1 col-form-label"><?php echo $teks; ?> Ke:</label>
                            <div class="col-sm-3">
                                <select id="pic_email" name="pic_email" class="form-control">
                                    <?php

                                    $level_id = $this->db->get_where('user_level', ['nama_unit_kerja' => $rencana['nama_unit_kerja']])->row()->level_id;
                                    $user_unit_kerja = $this->db->get_where('user', ['level_id' => $level_id])->result_array();
                                    foreach ($user_unit_kerja as $uuk) : {

                                            $this->db->where('pic', $uuk['email']);
                                            $this->db->where('mulai_real !=', '');
                                            $this->db->where('selesai_real', '');
                                            $tersedia = $this->db->get('detail_rencana_produksi')->num_rows();
                                            if ($tersedia == 0) {
                                                $tersedia_teks = " (Tersedia)";
                                            } else {
                                                $tersedia_teks = " (Tidak tersedia)";
                                            }

                                            echo '<option ';

                                            if ($bagi) {

                                                $this->db->where('user_email', $uuk['email']);
                                                $this->db->where('selesai_real', '');
                                                $this->db->where('nojob', $rencana['nojob']);
                                                $this->db->where('nama_objek_kerja', $rencana['nama_objek_kerja']);
                                                $this->db->where('nama_level_kerja', $rencana['nama_level_kerja']);
                                                $ada = $this->db->get('progres_naskah')->row_array();

                                                if (isset($ada)) {
                                                    echo ' disabled ';
                                                    $tersedia_teks = " (Sedang proses job ini)";
                                                }
                                            } else {
                                                if ($rencana['pic_email'] == $uuk['email']) {
                                                    echo 'selected';
                                                }
                                            }

                                            echo ' value="' . $uuk['email'] . '" >' . $uuk['nama'] . $tersedia_teks . '</option> ';
                                        }
                                    endforeach;
                                    echo '        </select>';

                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($kirim2 or $bagi) {
                    echo '<input type="hidden" id="ke_antri" name="ke_antri" value=FALSE>';
                } else {
                    echo '<input type="hidden" id="ke_antri" name="ke_antri" value=TRUE>';
                }
                ?>

                <input type="hidden" id="id" name="id" value="<?php echo $rencana['id']; ?>">

                <button type="submit" id="kirim" name="kirim" value=TRUE class="btn btn-primary"><?php echo $teks; ?></button>
                <a class="btn btn-secondary" href="<?php
                                                    if ($kirim2 or $bagi) {

                                                        echo base_url('laporan/detail_proses_job');
                                                    } else {

                                                        echo base_url('laporan/antrian');
                                                    }



                                                    ?>">Batal</a>
            </form>
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