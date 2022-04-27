<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];


    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button id="tombolTambahPelanggan" type="button" data-id="" data-tipe_pelanggan="" data-nama_pelanggan="" data-alamat_pelanggan="" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahPelangganModal">Tambah Pelanggan</button>
            <?php echo form_error('nama_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('alamat_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('tipe_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pelanggan ID</th>
                            <th scope="col">Nama Pelanggan</th>
                            <th scope="col">Alamat Pelanggan</th>
                            <th scope="col">Tipe Pelanggan</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $pelanggan = $this->db->get('pelanggan')->result_array();
                        foreach ($pelanggan as $p) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $p['id'] . '</td>
                                    <td scope="col">' . $p['nama_pelanggan'] . '</td>
                                    <td scope="col">' . $p['alamat_pelanggan'] . '</td>
                                    <td scope="col">' . $p['tipe_pelanggan'] . '</td>
                                   
                                    <td scope="col">
                                    <button id="tombolEditPelanggan" type="button"   data-id="' . $p['id'] . '" data-tipe_pelanggan="' . $p['tipe_pelanggan'] . '" data-nama_pelanggan="' . $p['nama_pelanggan'] . '" data-alamat_pelanggan="' . $p['alamat_pelanggan'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editPelangganModal">Edit</button>                      
                                    <button id="tombolDeletePelanggan" type="button"   data-id="' . $p['id'] . '" data-tipe_pelanggan="' . $p['tipe_pelanggan'] . '" data-nama_pelanggan="' . $p['nama_pelanggan'] . '" data-alamat_pelanggan="' . $p['alamat_pelanggan'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePelangganModal">Delete</button>
                                    </td>

                                </tr>';
                                $i++;
                            }
                        endforeach
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
<div class="modal fade" id="tambahPelangganModal" tabindex="-1" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pelanggan'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pelanggan" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan">
                        </div>

                    </div>
                    <div class=" form-group row">
                        <label for="alamat_pelanggan" class="col-sm-3 col-form-label">Alamat Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>

                        <div class="form-group col-md-4">
                            <select id="tipe_pelanggan" name="tipe_pelanggan" class="form-control">

                                <option selected>Pilih ...</option>
                                <option value="Eksternal">Eksternal</option>
                                <option value="Internal">Internal</option>
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
<div class="modal fade" id="editPelangganModal" tabindex="-1" aria-labelledby="editPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPelangganModalLabel">Edit Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pelanggan'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pelanggan" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_pelanggan" class="col-sm-3 col-form-label">Alamat Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="form-group col-md-4">
                            <select id="tipe_pelanggan" name="tipe_pelanggan" class="form-control">

                                <option value="Eksternal">Eksternal</option>
                                <option value="Internal">Internal</option>
                            </select>

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
<div class="modal fade" id="deletePelangganModal" tabindex="-1" aria-labelledby="deletePelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePelangganModalLabel">Anda akan menghapus Pelanggan ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pelanggan'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pelanggan" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_pelanggan" class="col-sm-3 col-form-label">Alamat Pelanggan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="form-group col-md-4">
                            <select readonly id="tipe_pelanggan" name="tipe_pelanggan" class="form-control">

                                <option value="Eksternal">Eksternal</option>
                                <option value="Internal">Internal</option>
                            </select>

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