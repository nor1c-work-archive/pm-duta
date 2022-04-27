<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('urutan ASC');
    $menu = $this->db->get('menu')->result_array();

    ?>
    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahMenuModal">Tambah Menu</button>
            <?php echo form_error('urutan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('menu_name', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Urutan</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Induk</th>
                            <th scope="col">Link</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Notif</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($menu as $m) : {
                                if ($m['parent'] == 0) {
                                    $parent = "-";
                                } else {
                                    $parent = $this->db->get_where('menu', ['id' => $m['parent']])->row()->menu_name;
                                }
                                echo '
                        <tr>
                        <th scope="col">' . $i . '</th>
                        <td scope="col">' . $m['urutan'] . '</td>
                        <td scope="col">' . $m['menu_name'] . '</td>
                        <td scope="col">' . $parent . '</td>
                        <td scope="col">' . $m['link'] . '</td>
                        <td scope="col">' . $m['icon'] . '</td>
                        <td scope="col">' . $m['notif'] . '</td>
                        <td scope="col">
                            <button id="tombolEditMenu" type="button" data-id="' . $m['id'] . '" data-urutan="' . $m['urutan'] . '" data-menu_name="' . $m['menu_name'] . '" data-link="' . $m['link'] . '" data-parent="' . $m['parent'] . '" data-icon="' . $m['icon'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editMenuModal">Edit</button>
                            <button id="tombolDeleteMenu" type="button" data-id="' . $m['id'] . '" data-urutan="' . $m['urutan'] . '" data-menu_name="' . $m['menu_name'] . '" data-link="' . $m['link'] . '" data-parent="' . $m['parent'] . '" data-icon="' . $m['icon'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMenuModal">Delete</button>
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

<!-- Modal TAMBAH MENU -->
<div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-labelledby="tambahMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMenuModalLabel">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/menu'); ?>">
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Urutan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="urutan" name="urutan" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Nama Menu</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Induk</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="parent" name="parent">
                                <option value="0">Tidak ada</option>
                                <?php
                                $this->db->order_by('urutan ASC');
                                $menu = $this->db->get('menu')->result_array();
                                foreach ($menu as $m) : {
                                        echo ' <option value="' . $m['id'] . '">' . $m['menu_name'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-sm-3 col-form-label">Link</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="link" name="link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="ambil dari https://fontawesome.com/icons?d=gallery&p=2&m=free">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notif" class="col-sm-3 col-form-label">Notif</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="notif" name="notif">

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
</div>

<!-- Modal EDIT MENU -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/menu'); ?>">
                    <div class="form-group row">
                        <label for="urutan" class="col-sm-3 col-form-label">Urutan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="urutan" name="urutan" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Nama Menu</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Induk</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="parent" name="parent">
                                <option value="0">Tidak ada</option>
                                <?php
                                $this->db->order_by('urutan ASC');
                                $menu = $this->db->get('menu')->result_array();
                                foreach ($menu as $m) : {
                                        echo ' <option value="' . $m['id'] . '">' . $m['menu_name'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="link" class="col-sm-3 col-form-label">Link</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="link" name="link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="ambil dari https://fontawesome.com/icons?d=gallery&p=2&m=free">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notif" class="col-sm-3 col-form-label">Notif</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="notif" name="notif">

                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal DELETE MENU -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Anda akan menghapus Menu ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Menghapus menu ini akan menghapus pula submenu di bawahnya (jika ada)</p>
                <form method="post" action="<?php echo base_url('master/menu'); ?>">
                    <div class="form-group row">
                        <label for="menu_id" class="col-sm-3 col-form-label">Urutan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="urutan" name="urutan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Nama Menu</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="menu_name" name="menu_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_name" class="col-sm-3 col-form-label">Induk</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="induk" name="induk">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-sm-3 col-form-label">Link</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="link" name="link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="icon" name="icon">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notif" class="col-sm-3 col-form-label">Notif</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="notif" name="notif">
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>