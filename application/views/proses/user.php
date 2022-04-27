<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php

    $this->db->order_by('level_id ASC');
    $user = $this->db->get('user')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">
        <?php echo $this->session->flashdata('pesan'); ?>

        <!-- Content Column -->
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">email</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Level</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Update Terakhir</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($user as $u) : {
                            $level_name = $this->db->get_where('user_level', ['level_id' => $u['level_id']])->row()->level_name;
                            if ($u['is_active'] == 1) {
                                $status = "Aktif";
                            } else {
                                $status = "Nonaktif";
                            }
                            echo '<tr>
                                <th scope="row">' . $i . '</th>
                                <td>' . $u['email'] . '</td>
                                <td>' . $u['nama'] . '</td>
                                <td>' . $level_name . '</td>
                                <td ';
                            if ($u['is_active'] == 0) {
                                echo 'class="text-danger"';
                            }

                            echo  '>' . $status . '</td>
                                <td>' . date('d-M-Y H:i', $u['last_update']) . ' WIB</td>
                                <td>';
                            echo '
                                <button id="tombolEditUser" type="button" data-email="' . $u['email'] . '" data-nama="' . $u['nama'] . '" data-level_name="' . $level_name . '" data-level_id="' . $u['level_id'] . '" data-is_active="' . $u['is_active'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editUserModal">Edit</button>
                                <button id="tombolDeleteUser" type="button" data-email="' . $u['email'] . '" data-nama="' . $u['nama'] . '" data-level_name="' . $level_name . '" data-level_id="' . $u['level_id'] . '" data-is_active="' . $u['is_active'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUserModal">Delete</button>
 
                                </td>';


                            echo '</td>

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


<!-- ModalEDIT-->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/user'); ?>">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">email</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="email" name="email">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama" name="nama" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Level User</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="level_id" name="level_id">
                                <?php
                                $this->db->order_by('level_id ASC');
                                $user_level = $this->db->get('user_level')->result_array();
                                foreach ($user_level as $ul) : {
                                        echo '<option value=' . $ul['level_id'] . '>' . $ul['level_name'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="is_active" name="is_active">
                                <option value=0>Nonaktif</option>
                                <option value=1>Aktif</option>

                            </select>
                        </div>
                    </div>

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
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">delete User Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('proses/user'); ?>">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">email</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="email" name="email">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama" name="nama" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Level User</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="level_id" name="level_id">
                                <?php
                                $this->db->order_by('level_id ASC');
                                $user_level = $this->db->get('user_level')->result_array();
                                foreach ($user_level as $ul) : {
                                        echo '<option value=' . $ul['level_id'] . '>' . $ul['level_name'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="is_active" name="is_active">
                                <option value=0>Nonaktif</option>
                                <option value=1>Aktif</option>

                            </select>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>