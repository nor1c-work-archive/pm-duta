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
            <button id="tombolTambahPemasok" type="button" data-id="" data-tipe_pemasok="" data-nama_pemasok="" data-alamat_pemasok="" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahPemasokModal">Tambah Pemasok</button>
            <?php echo form_error('nama_pemasok', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('alamat_pemasok', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('tipe_pemasok', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pemasok ID</th>
                            <th scope="col">Nama Pemasok</th>
                            <th scope="col">Alamat Pemasok</th>
                            <th scope="col">Tipe Pemasok</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $pemasok = $this->db->get('pemasok')->result_array();
                        foreach ($pemasok as $p) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $p['id'] . '</td>
                                    <td scope="col">' . $p['nama_pemasok'] . '</td>
                                    <td scope="col">' . $p['alamat_pemasok'] . '</td>
                                    <td scope="col">' . $p['tipe_pemasok'] . '</td>
                                   
                                    <td scope="col">
                                    <button id="tombolEditPemasok" type="button"   data-id="' . $p['id'] . '" data-tipe_pemasok="' . $p['tipe_pemasok'] . '" data-nama_pemasok="' . $p['nama_pemasok'] . '" data-alamat_pemasok="' . $p['alamat_pemasok'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editPemasokModal">Edit</button>                      
                                    <button id="tombolDeletePemasok" type="button"   data-id="' . $p['id'] . '" data-tipe_pemasok="' . $p['tipe_pemasok'] . '" data-nama_pemasok="' . $p['nama_pemasok'] . '" data-alamat_pemasok="' . $p['alamat_pemasok'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePemasokModal">Delete</button>
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
<div class="modal fade" id="tambahPemasokModal" tabindex="-1" aria-labelledby="tambahPemasokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPemasokModalLabel">Tambah Pemasok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pemasok'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pemasok" class="col-sm-3 col-form-label">Nama Pemasok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok">
                        </div>

                    </div>
                    <div class=" form-group row">
                        <label for="alamat_Pemasok" class="col-sm-3 col-form-label">Alamat Pemasok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_pemasok" name="alamat_pemasok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>

                        <div class="form-group col-md-4">
                            <select id="tipe_pemasok" name="tipe_pemasok" class="form-control">

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
<div class="modal fade" id="editPemasokModal" tabindex="-1" aria-labelledby="editPemasokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPemasokModalLabel">Edit Pemasok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pemasok'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pemasok" class="col-sm-3 col-form-label">Nama Pemasok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_Pemasok" class="col-sm-3 col-form-label">Alamat Pemasok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_pemasok" name="alamat_pemasok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="form-group col-md-4">
                            <select id="tipe_pemasok" name="tipe_pemasok" class="form-control">

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
<div class="modal fade" id="deletePemasokModal" tabindex="-1" aria-labelledby="deletePemasokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePemasokModalLabel">Anda akan menghapus Pemasok ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/pemasok'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_pemasok" class="col-sm-3 col-form-label">Nama Pemasok</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_pemasok" name="nama_pemasok">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_Pemasok" class="col-sm-3 col-form-label">Alamat Pemasok</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="alamat_pemasok" name="alamat_pemasok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="form-group col-md-4">
                            <select readonly id="tipe_pemasok" name="tipe_pemasok" class="form-control">

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