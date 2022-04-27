<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('jenjang_id ASC');
    $jenjang = $this->db->get('jenjang')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahJenjangModal">Tambah Jenjang</button>
            <?php echo form_error('nama_jenjang', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jenjang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jenjang ID</th>
                            <th scope="col">Nama Jenjang</th>
                            <th scope="col">Koefisien Harga</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($jenjang as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['jenjang_id'] . '</td>
                                    <td scope="col">' . $j['nama_jenjang'] . '</td>
                                    <td scope="col">' . $j['koefisien_harga'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditJenjang" type="button"  data-id="' . $j['id'] . '" data-koefisien_harga="' . $j['koefisien_harga'] . '" data-jenjang_id="' . $j['jenjang_id'] . '" data-nama_jenjang="' . $j['nama_jenjang'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editJenjangModal">Edit</button>                      
                                    <button id="tombolDeleteJenjang" type="button"  data-id="' . $j['id'] . '" data-koefisien_harga="' . $j['koefisien_harga'] . '" data-jenjang_id="' . $j['jenjang_id'] . '" data-nama_jenjang="' . $j['nama_jenjang'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteJenjangModal">Delete</button>
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
<div class="modal fade" id="tambahJenjangModal" tabindex="-1" aria-labelledby="tambahJenjangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahJenjangModalLabel">Tambah Jenjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/jenjang'); ?>">
                    <div class="form-group row">
                        <label for="jenjang_id" class="col-sm-3 col-form-label">Jenjang ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jenjang_id" name="jenjang_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_jenjang" class="col-sm-3 col-form-label">Nama Jenjang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_jenjang" name="nama_jenjang" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="koefisien_harga" class="col-sm-3 col-form-label">Koefisien Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="koefisien_harga" name="koefisien_harga" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editJenjangModal" tabindex="-1" aria-labelledby="editJenjangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJenjangModalLabel">Edit Jenjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/jenjang'); ?>">
                    <div class="form-group row">
                        <label for="jenjang_id" class="col-sm-3 col-form-label">Jenjang ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jenjang_id" name="jenjang_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_jenjang" class="col-sm-3 col-form-label">Nama Jenjang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_jenjang" name="nama_jenjang" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="koefisien_harga" class="col-sm-3 col-form-label">Koefisien Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="koefisien_harga" name="koefisien_harga" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="deleteJenjangModal" tabindex="-1" aria-labelledby="deleteJenjangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteJenjangModalLabel">Anda akan menghapus Jenjang ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/jenjang'); ?>">
                    <div class="form-group row">
                        <label for="jenjang_id" class="col-sm-3 col-form-label">Jenjang ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jenjang_id" name="jenjang_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_jenjang" class="col-sm-3 col-form-label">Nama Jenjang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_jenjang" name="nama_jenjang" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="koefisien_harga" class="col-sm-3 col-form-label">Koefisien Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="koefisien_harga" name="koefisien_harga" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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