<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('mapel_id ASC');
    $mapel = $this->db->get('mapel')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahMapelModal">Tambah mapel</button>
            <?php echo form_error('nama_mapel', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('mapel_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">mapel ID</th>
                            <th scope="col">Nama mapel</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($mapel as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['mapel_id'] . '</td>
                                    <td scope="col">' . $j['nama_mapel'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditMapel" type="button"  data-id="' . $j['id'] . '" data-mapel_id="' . $j['mapel_id'] . '" data-nama_mapel="' . $j['nama_mapel'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editMapelModal">Edit</button>                      
                                    <button id="tombolDeleteMapel" type="button"  data-id="' . $j['id'] . '" data-mapel_id="' . $j['mapel_id'] . '" data-nama_mapel="' . $j['nama_mapel'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMapelModal">Delete</button>
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
<div class="modal fade" id="tambahMapelModal" tabindex="-1" aria-labelledby="tambahMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMapelModalLabel">Tambah mapel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/mapel'); ?>">
                    <div class="form-group row">
                        <label for="mapel_id" class="col-sm-3 col-form-label">mapel ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mapel_id" name="mapel_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_mapel" class="col-sm-3 col-form-label">Nama mapel</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editMapelModal" tabindex="-1" aria-labelledby="editMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMapelModalLabel">Edit mapel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/mapel'); ?>">
                    <div class="form-group row">
                        <label for="mapel_id" class="col-sm-3 col-form-label">mapel ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mapel_id" name="mapel_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_mapel" class="col-sm-3 col-form-label">Nama mapel</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="deleteMapelModal" tabindex="-1" aria-labelledby="deleteMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMapelModalLabel">Anda akan menghapus mapel ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/mapel'); ?>">
                    <div class="form-group row">
                        <label for="mapel_id" class="col-sm-3 col-form-label">mapel ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mapel_id" name="mapel_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_mapel" class="col-sm-3 col-form-label">Nama mapel</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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