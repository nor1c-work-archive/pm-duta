<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('level_kerja_id ASC');
    $level_kerja = $this->db->get('level_kerja')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahLevelKerjaModal">Tambah Level Kerja</button>
            <?php echo form_error('nama_level_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('level_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('inisial_level_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Level Kerja ID</th>
                            <th scope="col">Nama Level Kerja</th>
                            <th scope="col">Inisial Level Kerja</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($level_kerja as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['level_kerja_id'] . '</td>
                                    <td scope="col">' . $j['nama_level_kerja'] . '</td>
                                    <td scope="col">' . $j['inisial_level_kerja'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditLevelKerja" type="button"  data-id="' . $j['id'] . '" data-inisial_level_kerja="' . $j['inisial_level_kerja'] . '" data-level_kerja_id="' . $j['level_kerja_id'] . '" data-nama_level_kerja="' . $j['nama_level_kerja'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editLevelKerjaModal">Edit</button>                      
                                    <button id="tombolDeleteLevelKerja" type="button"  data-id="' . $j['id'] . '" data-inisial_level_kerja="' . $j['inisial_level_kerja'] . '" data-level_kerja_id="' . $j['level_kerja_id'] . '" data-nama_level_kerja="' . $j['nama_level_kerja'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteLevelKerjaModal">Delete</button>
                                    <button id="tombolInfoLevelKerja" type="button" data-tgl_update="' . date('d-M-Y H:i', $j['last_update']) . ' WIB" data-update_oleh="' . $j['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
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

<!-- ModalTAMBAH-->
<div class="modal fade" id="tambahLevelKerjaModal" tabindex="-1" aria-labelledby="tambahLevelKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLevelKerjaModalLabel">Tambah Level Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/level_kerja'); ?>">
                    <div class="form-group row">
                        <label for="level_kerja_id" class="col-sm-3 col-form-label">Level Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="level_kerja_id" name="level_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_level_kerja" class="col-sm-3 col-form-label">Nama Level Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_level_kerja" name="nama_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_level_kerja" class="col-sm-3 col-form-label">Inisial Level Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_level_kerja" name="inisial_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editLevelKerjaModal" tabindex="-1" aria-labelledby="editLevelKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLevelKerjaModalLabel">Edit Level Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/level_kerja'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="level_kerja_id" class="col-sm-3 col-form-label">Level Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="level_kerja_id" name="level_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_level_kerja" class="col-sm-3 col-form-label">Nama Level Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_level_kerja" name="nama_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_level_kerja" class="col-sm-3 col-form-label">Inisial Level Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_level_kerja" name="inisial_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <input type="hidden" id="id" name="id">
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
<div class="modal fade" id="deleteLevelKerjaModal" tabindex="-1" aria-labelledby="deleteLevelKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLevelKerjaModalLabel">Anda akan menghapus Level Kerja ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/level_kerja'); ?>">
                    <div class="form-group row">
                        <label for="level_kerja_id" class="col-sm-3 col-form-label">Level Kerja ID</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="level_kerja_id" name="level_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_level_kerja" class="col-sm-3 col-form-label">Nama Level Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_level_kerja" name="nama_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_level_kerja" class="col-sm-3 col-form-label">Inisial Level Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="inisial_level_kerja" name="inisial_level_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <input type="hidden" id="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- ModaINFO-->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Info Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="nama" class="col-sm-5 col-form-label">Tanggal Update Terakhir</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="tgl_update" name="tgl_update">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-5 col-form-label">Update Oleh Akun</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh">
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>