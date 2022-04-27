<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $daynames = array("MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU");



    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>

            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahLiburNasionalModal">Tambah Libur Nasional </button>
            <?php echo form_error('alur_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('nama_alur_kerja', '<small class="text-danger pl-3">', '</small>'); ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->db->order_by('tanggal ASC');
                        $this->db->where('tahun', $tahun);
                        $this->db->where('keterangan !=', 'Rutin');
                        $hari_libur = $this->db->get('hari_libur')->result_array();
                        $i = 1;
                        foreach ($hari_libur as $hl) : {
                                $date = $hl['tanggal'];
                                $keterangan = $hl['keterangan'];
                                $tanggal = date('d-m-Y', $date);
                                $dayW = date('w', $date);


                                $hari = $daynames[$dayW]; // output "PETAK" (Friday)
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $hari . '</td>
                                    <td scope="col">' . $tanggal . '</td>
                 
                                   <td scope="col">' . $keterangan . '</td>
                                   <td scope="col">
                                        <button id="tombolDeleteHariLiburNasional" data-date="' . $date . '" data-keterangan="' . $keterangan . '" data-tanggal="' . $tanggal . '" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteLiburNasionalModal">Delete</button>
                                    </td>
                                 
                                </tr>';
                                $i++;
                            }
                        endforeach;
                        ?>


                    </tbody>
                </table>

            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahLiburRutinModal">Update Libur Rutin</button>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->db->order_by('tanggal ASC');
                        $this->db->where('tahun', $tahun);
                        $this->db->where('keterangan', 'Rutin');
                        $hari_libur = $this->db->get('hari_libur')->result_array();
                        $i = 1;
                        foreach ($hari_libur as $hl) : {
                                $date = $hl['tanggal'];
                                $keterangan = $hl['keterangan'];
                                $tanggal = date('d-m-Y', $date);
                                $dayW = date('w', $date);
                                $hari = $daynames[$dayW]; // output "PETAK" (Friday)
                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $hari . '</td>
                                    <td scope="col">' . $tanggal . '</td>
                                    <td scope="col">' . $keterangan . '</td>
                                 
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

<!-- ModalTAMBAHLiburRutin-->
<div class="modal fade" id="tambahLiburRutinModal" tabindex="-1" aria-labelledby="tambahLiburRutinModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('pengaturan/hari_libur'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLiburRutinModalLabel">Update Hari Libur Rutin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?php echo date('Y'); ?>">
                        </div>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="sabtu" name="sabtu">
                        <label class="custom-control-label" for="sabtu">Sabtu</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="minggu" name="minggu" checked>
                        <label class="custom-control-label" for="minggu">Minggu</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="rutin" name="rutin" value=TRUE class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ModalTAMBAHLiburNasional-->
<div class="modal fade" id="tambahLiburNasionalModal" tabindex="-1" aria-labelledby="tambahLiburNasionalModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('pengaturan/hari_libur'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLiburNasionalModalLabel">Tambah Hari Libur Nasional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input id="datepicker" name="datepicker" />
                            <script>
                                $('#datepicker').datepicker({
                                    uiLibrary: 'bootstrap4',
                                    format: 'dd-mm-yyyy'

                                });
                            </script>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="nasional" name="nasional" value=TRUE class="btn btn-success">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ModalTAMBAHLiburNasional-->
<div class="modal fade" id="deleteLiburNasionalModal" tabindex="-1" aria-labelledby="deleteLiburNasionalModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('pengaturan/hari_libur'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLiburNasionalModalLabel">Hapus Hari Libur Nasional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="tanggal" name="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                    <input type="text" class="form-control" id="date" name="date">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="delete_nasional" name="delete_nasional" value=TRUE class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>