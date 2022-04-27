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
            <button id="tombolTambahTipeBukuMasuk" type="button" data-id="" data-nama_tipe_buku_masuk="" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahTipeBukuMasukModal">Tambah Tipe Buku Masuk</button>
            <?php echo form_error('nama_tipe_buku_masuk', '<small class="text-danger pl-3">', '</small>'); ?>

            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tipe Buku Masuk ID</th>
                            <th scope="col">Nama Tipe Buku Masuk</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $tipe_buku_masuk = $this->db->get('tipe_buku_masuk')->result_array();
                        foreach ($tipe_buku_masuk as $tbm) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $tbm['id'] . '</td>
                                    <td scope="col">' . $tbm['nama_tipe_buku_masuk'] . '</td>
                                                            
                                    <td scope="col">
                                    <button id="tombolEditTipeBukuMasuk" type="button"   data-id="' . $tbm['id'] . '"  data-nama_tipe_buku_masuk="' . $tbm['nama_tipe_buku_masuk'] . '"  class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editTipeBukuMasukModal">Edit</button>                      
                                    <button id="tombolDeleteTipeBukuMasuk" type="button"   data-id="' . $tbm['id'] . '"  data-nama_tipe_buku_masuk="' . $tbm['nama_tipe_buku_masuk'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTipeBukuMasukModal">Delete</button>
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
<div class="modal fade" id="tambahTipeBukuMasukModal" tabindex="-1" aria-labelledby="tambahTipeBukuMasukModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTipeBukuMasukModalLabel">Tambah Tipe Buku Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_masuk'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_masuk" class="col-sm-5 col-form-label">Nama Tipe Buku Masuk</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama_tipe_buku_masuk" name="nama_tipe_buku_masuk">
                        </div>

                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ModalEDIT-->
<div class="modal fade" id="editTipeBukuMasukModal" tabindex="-1" aria-labelledby="editTipeBukuMasukModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTipeBukuMasukModalLabel">Edit Tipe Buku Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_masuk'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_masuk" class="col-sm-5 col-form-label">Nama Tipe Buku Masuk</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama_tipe_buku_masuk" name="nama_tipe_buku_masuk">
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
<div class="modal fade" id="deleteTipeBukuMasukModal" tabindex="-1" aria-labelledby="deleteTipeBukuMasukModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTipeBukuMasukModalLabel">Anda akan menghapus Tipe Buku Masuk ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_masuk'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_masuk" class="col-sm-5 col-form-label">Nama Tipe Buku Masuk</label>
                        <div class="col-sm-7">
                            <input readonly type="text" class="form-control" id="nama_tipe_buku_masuk" name="nama_tipe_buku_masuk">
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