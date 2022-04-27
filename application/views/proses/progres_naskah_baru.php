<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];

    $this->db->where('user_email', $email);
    $this->db->where('is_active', 1);

    $status = "(status='TUNDA-LANJUT' OR status='MULAI' OR status='LANJUT')";
    $this->db->where($status);

    $banyak_proses = $this->db->get('progres_naskah')->num_rows();
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo form_error('nama_objek_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('nama_level_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>

            <div class="card mb-2">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">No Job</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Jilid</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Objek</th>
                                <th scope="col">Level</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $this->db->where('user_email', $email);
                            $this->db->where('is_active', 1);
                            $this->db->where('status', 'BARU');
                            $this->db->where('nojob', $nojob);
                            $job = $this->db->get('progres_naskah')->result_array();
                            $i = 1;
                            foreach ($job as $job) : {
                                    $nama_objek_kerja = $job['nama_objek_kerja'];
                                    $nama_level_kerja = $job['nama_level_kerja'];
                                    $naskah_rencana_produksi_id = $job['naskah_rencana_produksi_id'];
                                    $nojob = $job['nojob'];
                                    $naskah = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                                    $judul = $naskah['judul'];
                                    $jilid = $naskah['jilid'];
                                    $penulis = $naskah['penulis'];
                                    echo '
                            <tr>
                                <th scope="row">' . $i . '</th>
                                <td>' . $nojob . '</td>
                                <td>' . $judul . '</td>
                                <td>' . $jilid . '</td>
                                <td>' . $penulis . '</td>
                                <td>' . $nama_objek_kerja . '</td>
                                <td>' . $nama_level_kerja . '</td>
                                <td>';
                                    echo '<div class="row">';
                                    echo ' <button ';
                                    if ($banyak_proses != 0) {
                                        echo 'disabled';
                                    }
                                    echo ' id="tombolMulai" data-status="MULAI" data-naskah_rencana_produksi_id="' . $naskah_rencana_produksi_id . '" data-nojob="' . $nojob . '" data-nama_objek_kerja="' . $nama_objek_kerja . '" data-nama_level_kerja="' . $nama_level_kerja . '" data-toggle="modal" data-target="#mulaiModal" type="button" class="btn btn-primary btn-sm mx-1">Mulai</button>
                                <button id="tombolSelesai" data-status="TUNDA" data-naskah_rencana_produksi_id="' . $naskah_rencana_produksi_id . '" data-nojob="' . $nojob . '" data-nama_objek_kerja="' . $nama_objek_kerja . '" data-nama_level_kerja="' . $nama_level_kerja . '" data-toggle="modal" data-target="#selesaiModal" type="button" class="btn btn-danger btn-sm mx-1">Tunda</button>';
                                    echo '<form method="post" action="' . base_url('laporan/job') . '">
                                    <input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">
<button type="submit" id="cari" name="cari" value=TRUE class="btn btn-success btn-sm mx-1">Detail</button>
                                </form>';


                                    echo '
                                    </div>
                                    </td>
                            </tr>';
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

<!-- ModalMULAI-->
<div class="modal fade" id="mulaiModal" tabindex="-1" aria-labelledby="mulaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" readonly class="form-control-plaintext" id="header" name="header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/progres_naskah'); ?>">
                    <div class="form-group row">
                        <label for="objek_kerja" class="col-sm-3 col-form-label">Objek Kerja</label>
                        <div class="col-sm-9">
                            <select readonly id="nama_objek_kerja" name="nama_objek_kerja" class="form-control">
                                <option></option>
                                <?php
                                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                                foreach ($objek_kerja as $ok) : {
                                        echo '<option value="' . $ok['nama_objek_kerja'] . '" >' . $ok['nama_objek_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_kerja" class="col-sm-3 col-form-label">Level Kerja</label>
                        <div class="col-sm-9">
                            <select readonly id="nama_level_kerja" name="nama_level_kerja" class="form-control">
                                <option></option>
                                <?php
                                $level_kerja = $this->db->get('level_kerja')->result_array();
                                foreach ($level_kerja as $ok) : {
                                        echo '<option value="' . $ok['nama_level_kerja'] . '" >' . $ok['nama_level_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="nojob" id="nojob">
                    <input type="hidden" name="naskah_rencana_produksi_id" id="naskah_rencana_produksi_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="tombol_mulai" name="tombol_mulai" value=TRUE class="btn btn-success">OK</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- ModalSELESAI-->
<div class="modal fade" id="selesaiModal" tabindex="-1" aria-labelledby="selesaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" readonly class="form-control-plaintext" id="header" name="header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/progres_naskah'); ?>">
                    <div class="form-group row">
                        <label for="objek_kerja" class="col-sm-3 col-form-label">Objek Kerja</label>
                        <div class="col-sm-9">
                            <select readonly id="nama_objek_kerja" name="nama_objek_kerja" class="form-control">
                                <option></option>
                                <?php
                                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                                foreach ($objek_kerja as $ok) : {
                                        echo '<option value="' . $ok['nama_objek_kerja'] . '" >' . $ok['nama_objek_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_kerja" class="col-sm-3 col-form-label">Level Kerja</label>
                        <div class="col-sm-9">
                            <select readonly id="nama_level_kerja" name="nama_level_kerja" class="form-control">
                                <option></option>
                                <?php
                                $level_kerja = $this->db->get('level_kerja')->result_array();
                                foreach ($level_kerja as $ok) : {
                                        echo '<option value="' . $ok['nama_level_kerja'] . '" >' . $ok['nama_level_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="nojob" id="nojob">
                    <input type="hidden" name="naskah_rencana_produksi_id" id="naskah_rencana_produksi_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="tombol_selesai" name="tombol_selesai" value=TRUE class="btn btn-danger">OK</button>
            </div>
            </form>
        </div>
    </div>
</div>