<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $jenjang_id = substr($standar_pc_id, 0, 2);
    $nama_jenjang = $this->db->get_where('jenjang', ['jenjang_id' => $jenjang_id])->row()->nama_jenjang;
    $mapel_id = substr($standar_pc_id, 2, 2);
    $nama_mapel = $this->db->get_where('mapel', ['mapel_id' => $mapel_id])->row()->nama_mapel;
    $kategori_id = substr($standar_pc_id, 4, 2);
    $nama_kategori = $this->db->get_where('kategori', ['kategori_id' => $kategori_id])->row()->nama_kategori;

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>

            <div class="card col-6 mb-1">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="mapel" class="col-sm-2 col-form-label">Mapel</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="mapel" name="mapel" value="<?php echo $nama_mapel; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="jenjang" name="jenjang" value="<?php echo $nama_jenjang; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $nama_kategori; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahAlurKerjaModal">Tambah Model Alur Kerja</button>

            <?php echo form_error('alur_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>

            <div class="table-responsive">
                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Model Alur Kerja</th>
                            <th scope="col">Aksi</th>
                            <th scope="col">Standar Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $this->db->where('standar_pc_id', $standar_pc_id);
                        $standar_model_alur_kerja = $this->db->get('standar_model_alur_kerja')->result_array();
                        $i = 1;
                        foreach ($standar_model_alur_kerja as $smak) : {
                                $alur_kerja_id = $smak['alur_kerja_id'];
                                $model_alur_kerja = $this->db->get_where('alur_kerja', ['alur_kerja_id' => $alur_kerja_id])->row()->model_alur_kerja;
                                echo '       <tr>
                            <th scope="col">' . $i . '</th>
                            <td scope="col">' . $model_alur_kerja . '</td>
                            <td scope="col">
                                <button id="tombolDeleteStandarWaktu" data-standar_pc_id="' . $standar_pc_id . '" data-model_alur_kerja="' . $model_alur_kerja . '" data-alur_kerja_id="' . $alur_kerja_id . '" type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal" data-target="#deleteStandarWaktuModal">Delete</button>
                            </td>
                            <td scope="col">
                                        <form method="post" action="' . base_url('pengaturan/atur_standar_waktu') . '">
                                        <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value ="' . $alur_kerja_id . '">
                                        <button type="submit" class="btn btn-sm btn-info" id="standar_pc_id" name="standar_pc_id" value="' . $standar_pc_id . '">Atur</button>
                                        </form>

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
<div class="modal fade" id="tambahAlurKerjaModal" tabindex="-1" aria-labelledby="tambahAlurKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAlurKerjaModalLabel">Tambah Alur Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/standar_waktu'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alur Kerja</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                                <option></option>
                                <?php
                                $this->db->order_by('alur_kerja_id ASC');
                                $alur_kerja = $this->db->get('alur_kerja')->result_array();
                                foreach ($alur_kerja as $ak) : {
                                        echo '<option value=' . $ak['alur_kerja_id'] . '>' . $ak['model_alur_kerja'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="standar_pc_id" name="standar_pc_id" value="<?php echo $standar_pc_id; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- ModalDELETE-->
<div class="modal fade" id="deleteStandarWaktuModal" tabindex="-1" aria-labelledby="deleteStandarWaktuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStandarWaktuModalLabel">Delete Alur Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/standar_waktu'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alur Kerja</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="model_alur_kerja" name="model_alur_kerja">
                        </div>
                    </div>
                    <input type="hidden" id="standar_pc_id" name="standar_pc_id" value="<?php echo $standar_pc_id; ?>">
                    <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>