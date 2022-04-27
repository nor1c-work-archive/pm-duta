<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('unit_kerja_id ASC');
    $unit_kerja = $this->db->get('unit_kerja')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahUnitKerjaModal">Tambah Unit Kerja</button>
            <?php echo form_error('nama_unit_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('unit_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('inisial_unit_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Unit Kerja ID</th>
                            <th scope="col">Nama Unit Kerja</th>
                            <th scope="col">Inisial Unit Kerja</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($unit_kerja as $j) : {
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $j['unit_kerja_id'] . '</td>
                                    <td scope="col">' . $j['nama_unit_kerja'] . '</td>
                                    <td scope="col">' . $j['inisial_unit_kerja'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditUnitKerja" type="button"  data-id="' . $j['id'] . '" data-inisial_unit_kerja="' . $j['inisial_unit_kerja'] . '" data-unit_kerja_id="' . $j['unit_kerja_id'] . '" data-nama_unit_kerja="' . $j['nama_unit_kerja'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editUnitKerjaModal">Edit</button>                      
                                    <button id="tombolDeleteUnitKerja" type="button"  data-id="' . $j['id'] . '" data-inisial_unit_kerja="' . $j['inisial_unit_kerja'] . '" data-unit_kerja_id="' . $j['unit_kerja_id'] . '" data-nama_unit_kerja="' . $j['nama_unit_kerja'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUnitKerjaModal">Delete</button>
                                    <button id="tombolInfoUnitKerja" type="button" data-tgl_update="' . date('d-M-Y H:i', $j['last_update']) . ' WIB" data-update_oleh="' . $j['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
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
<div class="modal fade" id="tambahUnitKerjaModal" tabindex="-1" aria-labelledby="tambahUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUnitKerjaModalLabel">Tambah Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/unit_kerja'); ?>">
                    <div class="form-group row">
                        <label for="unit_kerja_id" class="col-sm-3 col-form-label">Unit Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="unit_kerja_id" name="unit_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_unit_kerja" class="col-sm-3 col-form-label">Inisial Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_unit_kerja" name="inisial_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="editUnitKerjaModal" tabindex="-1" aria-labelledby="editUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitKerjaModalLabel">Edit Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/unit_kerja'); ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="unit_kerja_id" class="col-sm-3 col-form-label">Unit Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="unit_kerja_id" name="unit_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_unit_kerja" class="col-sm-3 col-form-label">Inisial Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_unit_kerja" name="inisial_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
<div class="modal fade" id="deleteUnitKerjaModal" tabindex="-1" aria-labelledby="deleteUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUnitKerjaModalLabel">Anda akan menghapus Unit Kerja ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/unit_kerja'); ?>">
                    <div class="form-group row">
                        <label for="unit_kerja_id" class="col-sm-3 col-form-label">Unit Kerja ID</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="unit_kerja_id" name="unit_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_unit_kerja" class="col-sm-3 col-form-label">Nama Unit Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_unit_kerja" class="col-sm-3 col-form-label">Inisial Unit Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="inisial_unit_kerja" name="inisial_unit_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
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
                    <label for="nama" class="col-sm-5 col-form-label">Update Oleh AKun</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh">
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>