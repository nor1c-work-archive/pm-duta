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
            <button id="tombolTambahTipeBukuKeluar" type="button" data-id="" data-nama_tipe_buku_keluar="" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahTipeBukuKeluarModal">Tambah Tipe Buku Masuk</button>
            <?php echo form_error('nama_tipe_buku_keluar', '<small class="text-danger pl-3">', '</small>'); ?>

            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tipe Buku Masuk ID</th>
                            <th scope="col">Nama Tipe Buku Keluar</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $tipe_buku_keluar = $this->db->get('tipe_buku_keluar')->result_array();
                        foreach ($tipe_buku_keluar as $tbk) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $tbk['id'] . '</td>
                                    <td scope="col">' . $tbk['nama_tipe_buku_keluar'] . '</td>
                                                            
                                    <td scope="col">
                                    <button id="tombolEditTipeBukuKeluar" type="button"   data-id="' . $tbk['id'] . '"  data-nama_tipe_buku_keluar="' . $tbk['nama_tipe_buku_keluar'] . '"  class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editTipeBukuKeluarModal">Edit</button>                      
                                    <button id="tombolDeleteTipeBukuKeluar" type="button"   data-id="' . $tbk['id'] . '"  data-nama_tipe_buku_keluar="' . $tbk['nama_tipe_buku_keluar'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTipeBukuKeluarModal">Delete</button>
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
<div class="modal fade" id="tambahTipeBukuKeluarModal" tabindex="-1" aria-labelledby="tambahTipeBukuKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTipeBukuKeluarModalLabel">Tambah Tipe Buku Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_keluar'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_keluar" class="col-sm-5 col-form-label">Nama Tipe Buku Keluar</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama_tipe_buku_keluar" name="nama_tipe_buku_keluar">
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
<div class="modal fade" id="editTipeBukuKeluarModal" tabindex="-1" aria-labelledby="editTipeBukuKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTipeBukuKeluarModalLabel">Edit Tipe Buku Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_keluar'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_keluar" class="col-sm-5 col-form-label">Nama Tipe Buku Keluar</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama_tipe_buku_keluar" name="nama_tipe_buku_keluar">
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
<div class="modal fade" id="deleteTipeBukuKeluarModal" tabindex="-1" aria-labelledby="deleteTipeBukuKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTipeBukuKeluarModalLabel">Anda akan menghapus Tipe Buku Keluar ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/tipe_buku_keluar'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_tipe_buku_keluar" class="col-sm-5 col-form-label">Nama Tipe Buku Keluar</label>
                        <div class="col-sm-7">
                            <input readonly type="text" class="form-control" id="nama_tipe_buku_keluar" name="nama_tipe_buku_keluar">
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