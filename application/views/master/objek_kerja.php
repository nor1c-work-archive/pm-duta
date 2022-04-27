<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('objek_kerja_id ASC');
    $objek_kerja = $this->db->get('objek_kerja')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahObjekKerjaModal">Tambah Objek Kerja</button>
            <?php echo form_error('nama_objek_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('objek_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('inisial_objek_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('satuan', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('perhitungan_durasi', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo $this->session->flashdata('pesan'); ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Objek Kerja ID</th>
                            <th scope="col">Nama Objek Kerja</th>
                            <th scope="col">Inisial Objek Kerja</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Perhitungan durasi</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($objek_kerja as $j) : {
                                if ($j['perhitungan_durasi'] == 'sat_hari') {
                                    $perhitungan_durasi = $j['satuan'] . "/hari";
                                } else {
                                    if ($j['perhitungan_durasi'] == 'hari_sat') {
                                        $perhitungan_durasi = "hari/" . $j['satuan'];
                                    } else {
                                        $perhitungan_durasi = "";
                                    }
                                }
                                echo '
                                <tr>
                                    <th scope="col">' . $j['id'] . '</th>
                                    <td scope="col">' . $j['objek_kerja_id'] . '</td>
                                    <td scope="col">' . $j['nama_objek_kerja'] . '</td>
                                    <td scope="col">' . $j['inisial_objek_kerja'] . '</td>
                                    <td scope="col">' . $j['satuan'] . '</td>
                                    <td scope="col">' .  $perhitungan_durasi . '</td>
                                    <td scope="col">
                                    <button id="tombolEditObjekKerja" type="button"  data-perhitungan_durasi="' . $j['perhitungan_durasi'] . '" data-satuan="' . $j['satuan'] . '" data-id="' . $j['id'] . '" data-inisial_objek_kerja="' . $j['inisial_objek_kerja'] . '" data-objek_kerja_id="' . $j['objek_kerja_id'] . '" data-nama_objek_kerja="' . $j['nama_objek_kerja'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editObjekKerjaModal">Edit</button>                      
                                    <button id="tombolDeleteObjekKerja" type="button"  data-perhitungan_durasi="' . $j['perhitungan_durasi'] . '"  data-satuan="' . $j['satuan'] . '" data-id="' . $j['id'] . '" data-inisial_objek_kerja="' . $j['inisial_objek_kerja'] . '" data-objek_kerja_id="' . $j['objek_kerja_id'] . '" data-nama_objek_kerja="' . $j['nama_objek_kerja'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteObjekKerjaModal">Delete</button>
                                    <button id="tombolInfoObjekKerja" type="button" data-tgl_update="' . date('d-M-Y H:i', $j['last_update']) . ' WIB" data-update_oleh="' . $j['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
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
<div class="modal fade" id="tambahObjekKerjaModal" tabindex="-1" aria-labelledby="tambahObjekKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahObjekKerjaModalLabel">Tambah Objek Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="<?php echo base_url('master/objek_kerja'); ?>">
                    <div class="form-group row">
                        <label for="objek_kerja_id" class="col-sm-3 col-form-label">Objek Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="objek_kerja_id" name="objek_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_objek_kerja" class="col-sm-3 col-form-label">Nama Objek Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_objek_kerja" name="nama_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_objek_kerja" class="col-sm-3 col-form-label">Inisial Objek Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_objek_kerja" name="inisial_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perhitungan_durasi" class="col-sm-3 col-form-label">Perhitungan Durasi</label>
                        <div class="col-sm-9">
                            <select id="perhitungan_durasi" name="perhitungan_durasi" class="form-control">

                                <option value='sat_hari'>satuan/hari</option>
                                <option value='hari_sat'>hari/satuan</option>
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
<div class="modal fade" id="editObjekKerjaModal" tabindex="-1" aria-labelledby="editObjekKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editObjekKerjaModalLabel">Edit Objek Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/objek_kerja'); ?>">
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Hati-hati!! Mengubah master objek kerja akan berpengaruh terhadap keseluruhan data!!
                    </div>
                    <div class="form-group row">
                        <label for="objek_kerja_id" class="col-sm-3 col-form-label">Objek Kerja ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="objek_kerja_id" name="objek_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_objek_kerja" class="col-sm-3 col-form-label">Nama Objek Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_objek_kerja" name="nama_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_objek_kerja" class="col-sm-3 col-form-label">Inisial Objek Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inisial_objek_kerja" name="inisial_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perhitungan_durasi" class="col-sm-3 col-form-label">Perhitungan Durasi</label>
                        <div class="col-sm-9">
                            <select id="perhitungan_durasi" name="perhitungan_durasi" class="form-control">
                                <option value='sat_hari'>satuan/hari</option>
                                <option value='hari_sat'>hari/satuan</option>
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
<div class="modal fade" id="deleteObjekKerjaModal" tabindex="-1" aria-labelledby="deleteObjekKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteObjekKerjaModalLabel">Anda akan menghapus Objek Kerja ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/objek_kerja'); ?>">
                    <div class="alert alert-danger" role="alert">
                        Hati-hati!! Menghapus master objek kerja akan berpengaruh terhadap keseluruhan data!!
                    </div>
                    <div class="form-group row">
                        <label for="objek_kerja_id" class="col-sm-3 col-form-label">Objek Kerja ID</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="objek_kerja_id" name="objek_kerja_id" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="nama_objek_kerja" class="col-sm-3 col-form-label">Nama Objek Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="nama_objek_kerja" name="nama_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inisial_objek_kerja" class="col-sm-3 col-form-label">Inisial Objek Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="inisial_objek_kerja" name="inisial_objek_kerja" placeholder="tidak boleh sama dengan yang sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perhitungan_durasi" class="col-sm-3 col-form-label">Perhitungan Durasi</label>
                        <div class="col-sm-9">
                            <select readonly id="perhitungan_durasi" name="perhitungan_durasi" class="form-control">
                                <option value='sat_hari'>satuan/hari</option>
                                <option value='hari_sat'>hari/satuan</option>
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
                    <label for="nama" class="col-sm-5 col-form-label">Update Oleh Akun</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh">
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>