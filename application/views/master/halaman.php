<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('halaman_id ASC');
    $halaman = $this->db->get('halaman')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahHalamanModal">Tambah halaman</button>
            <?php echo form_error('nama_halaman', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('halaman_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">halaman ID</th>
                            <th scope="col">Nama halaman</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($halaman as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['halaman_id'] . '</td>
                                    <td scope="col">' . $j['nama_halaman'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditHalaman" type="button"  data-id="' . $j['id'] . '" data-halaman_id="' . $j['halaman_id'] . '" data-nama_halaman="' . $j['nama_halaman'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editHalamanModal">Edit</button>                      
                                    <button id="tombolDeleteHalaman" type="button"  data-id="' . $j['id'] . '" data-halaman_id="' . $j['halaman_id'] . '" data-nama_halaman="' . $j['nama_halaman'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteHalamanModal">Delete</button>
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
<div class="modal fade" id="tambahHalamanModal" tabindex="-1" aria-labelledby="tambahHalamanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahHalamanModalLabel">Tambah halaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/halaman'); ?>">
                    <div class="form-group row">
                        <label for="halaman_id" class="col-sm-3 col-form-label">halaman ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="halaman_id" name="halaman_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_halaman" class="col-sm-3 col-form-label">Nama halaman</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_halaman" name="nama_halaman" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editHalamanModal" tabindex="-1" aria-labelledby="editHalamanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHalamanModalLabel">Edit halaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/halaman'); ?>">
                    <div class="form-group row">
                        <label for="halaman_id" class="col-sm-3 col-form-label">halaman ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="halaman_id" name="halaman_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_halaman" class="col-sm-3 col-form-label">Nama halaman</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_halaman" name="nama_halaman" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="deleteHalamanModal" tabindex="-1" aria-labelledby="deleteHalamanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteHalamanModalLabel">Anda akan menghapus halaman ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/halaman'); ?>">
                    <div class="form-group row">
                        <label for="halaman_id" class="col-sm-3 col-form-label">halaman ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="halaman_id" name="halaman_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_halaman" class="col-sm-3 col-form-label">Nama halaman</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_halaman" name="nama_halaman" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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