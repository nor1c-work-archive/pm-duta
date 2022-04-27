<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('alur_kerja_id ASC');

    $alur_kerja = $this->db->get_where('alur_kerja', ['alur_kerja_id' => $alur_kerja_id])->row_array();
    $model_alur_kerja = $alur_kerja['model_alur_kerja'];

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <form method="post" action="<?php echo base_url('master/detail_alur_kerja'); ?>">
                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="alur_kerja_id" class="col-md-3 col-form-label text-right">Alur Kerja ID</label>
                                <div class="col-md-2">
                                    <input readonly type="text" class="form-control" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
                                </div>
                                <label for="model_alur_kerja" class="col-md-3 col-form-label text-right">Model Alur Kerja</label>
                                <div class="col-md-4">
                                    <input readonly type="text" class="form-control" id="model_alur_kerja" name="model_alur_kerja" value="<?php echo $model_alur_kerja; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="urutan" class="col-sm-2 col-form-label">Urutan</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="urutan" name="urutan">
                                </div>
                            </div>
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Objek Kerja</th>
                                        <th scope="col">Level Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->order_by('objek_kerja_id ASC');
                                    $objek_kerja = $this->db->get('objek_kerja')->result_array();
                                    $this->db->order_by('level_kerja_id ASC');
                                    $level_kerja = $this->db->get('level_kerja')->result_array();
                                    foreach ($objek_kerja as $ok) : {
                                            echo '<tr>
                                        <td>' . $ok['nama_objek_kerja'] . '</td>';
                                            echo '<input type="hidden" id="' . $ok['objek_kerja_id'] . '" name="' . $ok['objek_kerja_id'] . '" value="' . $ok['nama_objek_kerja'] . '">';
                                            echo '<td>';
                                            echo '<select class="form-control" id="level_kerja' . $ok['objek_kerja_id'] . '" name="level_kerja' . $ok['objek_kerja_id'] . '">
                                            <option></option>';

                                            foreach ($level_kerja as $lk) : {
                                                    echo '<option value=' . $lk['inisial_level_kerja'] . '>' . $lk['nama_level_kerja'] . '</option>';
                                                }
                                            endforeach;
                                            echo '</select></td>
                                     </tr>';
                                        }
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
            </form>
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