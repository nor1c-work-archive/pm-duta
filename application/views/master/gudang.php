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
            <button id="tombolTambahGudang" type="button" data-id="" data-nama_gudang="" data-alamat_gudang="" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahGudangModal">Tambah Gudang</button>
            <?php echo form_error('nama_gudang', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('alamat_gudang', '<small class="text-danger pl-3">', '</small>'); ?>

            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Gudang ID</th>
                            <th scope="col">Nama Gudang</th>
                            <th scope="col">Alamat Gudang</th>

                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $gudang = $this->db->get('gudang')->result_array();
                        foreach ($gudang as $g) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $g['id'] . '</td>
                                    <td scope="col">' . $g['nama_gudang'] . '</td>
                                    <td scope="col">' . $g['alamat_gudang'] . '</td>

                                   
                                    <td scope="col">
                                    <button id="tombolEditGudang" type="button"   data-id="' . $g['id'] . '"  data-nama_gudang="' . $g['nama_gudang'] . '" data-alamat_gudang="' . $g['alamat_gudang'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editGudangModal">Edit</button>                      
                                    <button id="tombolDeleteGudang" type="button"   data-id="' . $g['id'] . '"  data-nama_gudang="' . $g['nama_gudang'] . '" data-alamat_gudang="' . $g['alamat_gudang'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteGudangModal">Delete</button>
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
<div class="modal fade" id="tambahGudangModal" tabindex="-1" aria-labelledby="tambahGudangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahGudangModalLabel">Tambah Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/gudang'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_gudang" class="col-sm-3 col-form-label">Nama Gudang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang">
                        </div>

                    </div>
                    <div class=" form-group row">
                        <label for="alamat_gudang" class="col-sm-3 col-form-label">Alamat Gudang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_gudang" name="alamat_gudang">
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
<div class="modal fade" id="editGudangModal" tabindex="-1" aria-labelledby="editGudangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGudangModalLabel">Edit Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/gudang'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_gudang" class="col-sm-3 col-form-label">Nama Gudang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_gudang" class="col-sm-3 col-form-label">Alamat Gudang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat_gudang" name="alamat_gudang">
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
<div class="modal fade" id="deleteGudangModal" tabindex="-1" aria-labelledby="deleteGudangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGudangModalLabel">Anda akan menghapus Gudang ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/gudang'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_gudang" class="col-sm-3 col-form-label">Nama Gudang</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_gudang" name="nama_gudang">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="alamat_gudang" class="col-sm-3 col-form-label">Alamat Gudang</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="alamat_gudang" name="alamat_gudang">
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