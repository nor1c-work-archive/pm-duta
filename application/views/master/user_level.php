<!-- Begin Page Content -->
<div class="container-fluid">
    <?php echo $this->session->flashdata('pesan'); ?>

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('level_id ASC');
    $user_level = $this->db->get('user_level')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahUserLevelModal">Tambah User Level</button>
            <?php echo form_error('level_name', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('level_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Level ID</th>
                            <th scope="col">Nama Level</th>
                            <th scope="col">Unit Kerja Produksi</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($user_level as $ul) : {
                                echo '                    <tr>
                        <th scope="row">' . $i . '</th>
                        <td>' . $ul['level_id'] . '</td>
                        <td>' . $ul['level_name'] . '</td>
                        <td>' . $ul['nama_unit_kerja'] . '</td>
                        <td>     <form method="post" action="' . base_url('pengaturan/hak_akses') . '">
                        <button ';

                                if ($ul['level_id'] == 0) {
                                    //   echo "disabled";
                                }
                                echo ' id="tombolEditUserLevel" type="button" data-nama_unit_kerja = "' . $ul['nama_unit_kerja'] . '" data-id="' . $ul['id'] . '" data-level_id="' . $ul['level_id'] . '" data-level_name="' . $ul['level_name'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editUserLevelModal">Edit</button>
                        
                        <button ';
                                if ($ul['level_id'] == 0) {
                                    //  echo "disabled";
                                }

                                echo  ' id="tombolDeleteUserLevel" type="button" data-nama_unit_kerja = "' . $ul['nama_unit_kerja'] . '" data-id="' . $ul['id'] . '" data-level_id="' . $ul['level_id'] . '" data-level_name="' . $ul['level_name'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUserLevelModal">Delete</button>
                    
                        <button ';
                                if ($ul['level_id'] == 0) {
                                    //  echo "disabled";
                                }


                                echo ' type ="submit" id="lihat" name="lihat" value=TRUE class="btn btn-sm btn-secondary">Hak Akses</button>
                        <input type="hidden" value="' . $ul['level_id'] . '" name="level_idx" id="level_idx">
                        </form></td>

                    </tr> ';
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

<!-- ModalTAMBAH-->
<div class="modal fade" id="tambahUserLevelModal" tabindex="-1" aria-labelledby="tambahUserLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserLevelModalLabel">Tambah User Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/user_level'); ?>">
                    <div class="form-group row">
                        <label for="level_id" class="col-sm-3 col-form-label">Level ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="level_id" name="level_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="level_name" class="col-sm-3 col-form-label">Nama Level</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="level_name" name="level_name" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_unit_kerja ASC');
                                $unit_kerja = $this->db->get('unit_kerja')->result_array();
                                foreach ($unit_kerja as $ak) : {
                                        echo '<option value=' . $ak['nama_unit_kerja'] . '>' . $ak['nama_unit_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>

                    </div>
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
<div class="modal fade" id="editUserLevelModal" tabindex="-1" aria-labelledby="editUserLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLevelModalLabel">Edit User Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/user_level'); ?>">
                    <div class="form-group row">
                        <label for="level_id" class="col-sm-3 col-form-label">Level ID</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="level_id" name="level_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="level_name" class="col-sm-3 col-form-label">Nama Level</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="level_name" name="level_name" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_unit_kerja ASC');
                                $unit_kerja = $this->db->get('unit_kerja')->result_array();
                                foreach ($unit_kerja as $ak) : {
                                        echo '<option value=' . $ak['nama_unit_kerja'] . '>' . $ak['nama_unit_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>

                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Up Date</button>
            </div>
            </form>
        </div>
    </div>
</div>




<!-- ModalDELETE-->
<div class="modal fade" id="deleteUserLevelModal" tabindex="-1" aria-labelledby="deleteUserLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserLevelModalLabel">Anda akan menghapus User Level ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/user_level'); ?>">
                    <div class="form-group row">
                        <label for="level_id" class="col-sm-3 col-form-label">Level ID</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control" id="level_id" name="level_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="level_name" class="col-sm-3 col-form-label">Nama Level</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control" id="level_name" name="level_name" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="nama_unit_kerja" name="nama_unit_kerja">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_unit_kerja ASC');
                                $unit_kerja = $this->db->get('unit_kerja')->result_array();
                                foreach ($unit_kerja as $ak) : {
                                        echo '<option value=' . $ak['nama_unit_kerja'] . '>' . $ak['nama_unit_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>

                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>