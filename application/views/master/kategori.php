<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('kategori_id ASC');
    $kategori = $this->db->get('kategori')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahKategoriModal">Tambah kategori</button>
            <?php echo form_error('nama_kategori', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('kategori_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">kategori ID</th>
                            <th scope="col">Nama kategori</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($kategori as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['kategori_id'] . '</td>
                                    <td scope="col">' . $j['nama_kategori'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditKategori" type="button"  data-id="' . $j['id'] . '" data-kategori_id="' . $j['kategori_id'] . '" data-nama_kategori="' . $j['nama_kategori'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editKategoriModal">Edit</button>                      
                                    <button id="tombolDeleteKategori" type="button"  data-id="' . $j['id'] . '" data-kategori_id="' . $j['kategori_id'] . '" data-nama_kategori="' . $j['nama_kategori'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteKategoriModal">Delete</button>
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
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/kategori'); ?>">
                    <div class="form-group row">
                        <label for="kategori_id" class="col-sm-3 col-form-label">kategori ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kategori_id" name="kategori_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-3 col-form-label">Nama kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriModalLabel">Edit kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/kategori'); ?>">
                    <div class="form-group row">
                        <label for="kategori_id" class="col-sm-3 col-form-label">kategori ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kategori_id" name="kategori_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-3 col-form-label">Nama kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="deleteKategoriModal" tabindex="-1" aria-labelledby="deleteKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteKategoriModalLabel">Anda akan menghapus kategori ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/kategori'); ?>">
                    <div class="form-group row">
                        <label for="kategori_id" class="col-sm-3 col-form-label">kategori ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kategori_id" name="kategori_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-3 col-form-label">Nama kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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