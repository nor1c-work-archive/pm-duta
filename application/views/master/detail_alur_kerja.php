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

            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="alur_kerja_id" class="col-md-2 col-form-label text-right">Alur Kerja ID</label>
                        <div class="col-md-2">
                            <input readonly type="text" class="form-control" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
                        </div>
                        <label for="model_alur_kerja" class="col-md-2 col-form-label text-right">Model Alur Kerja</label>
                        <div class="col-md-2">
                            <input readonly type="text" class="form-control" id="model_alur_kerja" name="model_alur_kerja" value="<?php echo $model_alur_kerja; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_error('urutan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('inisial_level_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('nama_unit_kerja', '<small class="text-danger pl-3">', '</small>'); ?>


            <?php
            $this->db->order_by('objek_kerja_id');
            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            foreach ($objek_kerja as $ok) : {
                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                    $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                    $ada_urutan = $this->db->get('detail_alur_kerja')->row_array();
                    if (!isset($ada_urutan)) {
                        $max_urutan = 0;
                    } else {
                        $this->db->select_max('urutan');
                        $this->db->where('alur_kerja_id', $alur_kerja_id);
                        $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                        $max_urutan = $this->db->get('detail_alur_kerja')->row()->urutan;
                    }
                    $next_urutan = $max_urutan + 1;
                    echo '
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h5 class="card-title">' . $ok['nama_objek_kerja'] . '</h5>
                                    <button id="tombolTambahLevelKerjaObjek" type="button" data-next_urutan="' . $next_urutan . '" data-alur_kerja_id="' . $alur_kerja_id . '" data-nama_objek_kerja="' . $ok['nama_objek_kerja'] . '" data-objek_kerja_id="' . $ok['objek_kerja_id'] . '" class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#tambahLevelKerjaObjekModal">Tambah Level Kerja</button>';
            ?>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Urutan</th>
                                        <th scope="col">Level Kerja</th>
                                        <th scope="col">Unit Kerja</th>
                                        <th scope="col">Aksi</th>
                                </thead>
                                <tbody>

                                    <?php
                                    $this->db->order_by('urutan ASC');
                                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                                    $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                                    $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();
                                    foreach ($detail_alur_kerja as $dak) : {

                                            echo '<tr>';
                                            echo '<td scope="col">' . $dak['urutan'] . '</td>';
                                            echo '<td scope="col">' . $dak['inisial_level_kerja'] . '</td>';
                                            echo '<td scope="col">' . $dak['nama_unit_kerja'] . '</td>';
                                            echo '<td >
                                                <button id="tombolEditLevelKerjaObjek" type="button" data-nama_unit_kerja="' . $dak['nama_unit_kerja'] . '"  data-inisial_level_kerja="' . $dak['inisial_level_kerja'] . '" data-urutan="' . $dak['urutan'] . '" data-alur_kerja_id="' . $alur_kerja_id . '" data-nama_objek_kerja="' . $ok['nama_objek_kerja'] . '" data-objek_kerja_id="' . $ok['objek_kerja_id'] . '" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editLevelKerjaObjekModal">Edit</button>                   
                                                <button id="tombolDeleteLevelKerjaObjek" ';
                                            if ($dak['urutan'] !=  $max_urutan) {
                                                echo 'disabled';
                                            }

                                            echo ' type="button" data-nama_unit_kerja="' . $dak['nama_unit_kerja'] . '"  data-inisial_level_kerja="' . $dak['inisial_level_kerja'] . '" data-urutan="' . $dak['urutan'] . '" data-alur_kerja_id="' . $alur_kerja_id . '" data-nama_objek_kerja="' . $ok['nama_objek_kerja'] . '" data-objek_kerja_id="' . $ok['objek_kerja_id'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteLevelKerjaObjekModal">Delete</button>                   
                                            ';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    endforeach;
                                    ?>
                                </tbody>
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


<!-- ModalTAMBAH-->
<div class="modal fade" id="tambahLevelKerjaObjekModal" tabindex="-1" aria-labelledby="tambahLevelKerjaObjekModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Level Kerja</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/detail_alur_kerja'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Objek Kerja</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" id="nama_objek_kerja" name="nama_objek_kerja">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Urutan ke-</label>
                        <div class="col-sm-3">
                            <input readonly type="text" class="form-control" id="urutan" name="urutan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_kerja" class="col-sm-3 col-form-label">Level Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('level_kerja_id ASC');
                            $level_kerja = $this->db->get('level_kerja')->result_array();
                            echo '<select class="form-control" id="inisial_level_kerja" name="inisial_level_kerja">
                                            <option></option>';

                            foreach ($level_kerja as $lk) : {
                                    echo '<option value=' . $lk['inisial_level_kerja'] . '>' . $lk['nama_level_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_kerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('unit_kerja_id ASC');
                            $unit_kerja = $this->db->get('unit_kerja')->result_array();
                            echo '<select class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                            <option></option>';

                            foreach ($unit_kerja as $lk) : {
                                    echo '<option value=' . $lk['nama_unit_kerja'] . '>' . $lk['nama_unit_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <input type="hidden" id="alur_kerja_id" name="alur_kerja_id">
                    <input type="hidden" id="objek_kerja_id" name="objek_kerja_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ModalEDIT-->
<div class="modal fade" id="editLevelKerjaObjekModal" tabindex="-1" aria-labelledby="editLevelKerjaObjekModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('master/detail_alur_kerja'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlurKerjaModalLabel">Edit Level Kerja</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Hati-hati!! Mengubah master level kerja akan berpengaruh terhadap keseluruhan data!!
                    </div>
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Objek Kerja</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" id="nama_objek_kerja" name="nama_objek_kerja">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Urutan ke-</label>
                        <div class="col-sm-3">
                            <input readonly type="text" class="form-control" id="urutan" name="urutan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_kerja" class="col-sm-3 col-form-label">Level Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('level_kerja_id ASC');
                            $level_kerja = $this->db->get('level_kerja')->result_array();
                            echo '<select class="form-control" id="inisial_level_kerja" name="inisial_level_kerja">
                                            <option></option>';

                            foreach ($level_kerja as $lk) : {
                                    echo '<option value=' . $lk['inisial_level_kerja'] . '>' . $lk['nama_level_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_kerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('unit_kerja_id ASC');
                            $unit_kerja = $this->db->get('unit_kerja')->result_array();
                            echo '<select class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                            <option></option>';

                            foreach ($unit_kerja as $lk) : {
                                    echo '<option value=' . $lk['nama_unit_kerja'] . '>' . $lk['nama_unit_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <input type="hidden" id="alur_kerja_id" name="alur_kerja_id">
                    <input type="hidden" id="objek_kerja_id" name="objek_kerja_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Up Date</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ModalDelete-->
<div class="modal fade" id="deleteLevelKerjaObjekModal" tabindex="-1" aria-labelledby="deleteLevelKerjaObjekModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('master/detail_alur_kerja'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAlurKerjaModalLabel">Anda akan menghapus Level Kerja ini?</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Hati-hati!! Menghapus master level kerja akan berpengaruh terhadap keseluruhan data!!
                    </div>
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Objek Kerja</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" id="nama_objek_kerja" name="nama_objek_kerja">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Urutan ke-</label>
                        <div class="col-sm-3">
                            <input readonly type="text" class="form-control" id="urutan" name="urutan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_kerja" class="col-sm-3 col-form-label">Level Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('level_kerja_id ASC');
                            $level_kerja = $this->db->get('level_kerja')->result_array();
                            echo '<select readonly class="form-control" id="inisial_level_kerja" name="inisial_level_kerja">
                                            <option></option>';

                            foreach ($level_kerja as $lk) : {
                                    echo '<option value=' . $lk['inisial_level_kerja'] . '>' . $lk['nama_level_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_kerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-8">
                            <?php
                            $this->db->order_by('unit_kerja_id ASC');
                            $unit_kerja = $this->db->get('unit_kerja')->result_array();
                            echo '<select readonly class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                            <option></option>';

                            foreach ($unit_kerja as $lk) : {
                                    echo '<option value=' . $lk['nama_unit_kerja'] . '>' . $lk['nama_unit_kerja'] . '</option>';
                                }
                            endforeach;
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <input type="hidden" id="alur_kerja_id" name="alur_kerja_id">
                    <input type="hidden" id="objek_kerja_id" name="objek_kerja_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>