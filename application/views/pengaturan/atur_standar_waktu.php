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

    $this->db->where('alur_kerja_id', $alur_kerja_id);
    $alur_kerja = $this->db->get('alur_kerja')->row_array();
    $model_alur_kerja = $alur_kerja['model_alur_kerja'];
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>

            <div class="card col-6 mb-2">
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
            <h4> <span class="badge badge-secondary">MODEL : <?php echo $model_alur_kerja; ?></span></h4>
            <form method="post" action="<?php echo base_url('pengaturan/atur_standar_waktu'); ?>">
                <div class="card-columns">
                    <?php
                    $this->db->order_by('objek_kerja_id');
                    $objek_kerja = $this->db->get('objek_kerja')->result_array();

                    foreach ($objek_kerja as $ok) : {
                            if ($ok['perhitungan_durasi'] == 'sat_hari') {
                                $perhitungan_durasi = $ok['satuan'] . "/hari";
                            } else {
                                if ($ok['perhitungan_durasi'] == 'hari_sat') {
                                    $perhitungan_durasi = "hari/" . $ok['satuan'];
                                } else {
                                    $perhitungan_durasi = "";
                                }
                            }
                            echo '
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">' . $ok['nama_objek_kerja'] . '</h5>';
                    ?>
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">Urutan</th>
                                                <th scope="col">Level Kerja</th>
                                                <th scope="col">Standar <?php echo '(' . $perhitungan_durasi . ')'; ?></th>
                                            <tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $this->db->order_by('urutan ASC');
                                            $this->db->where('alur_kerja_id', $alur_kerja_id);
                                            $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                                            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();
                                            $i = 1;
                                            foreach ($detail_alur_kerja as $dak) : {
                                                    $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                    $this->db->where('standar_pc_id', $standar_pc_id);
                                                    $ada = $this->db->get_where('standar_waktu', ['standar_pc_id' => $standar_pc_id, 'detail_alur_kerja_id' => $detail_alur_kerja_id])->num_rows();
                                                    if ($ada == 0) {
                                                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                        $this->db->set('standar_pc_id', $standar_pc_id);
                                                        $this->db->set('waktu', 0);
                                                        $this->db->set('last_update', now('Asia/Jakarta'));
                                                        $this->db->set('update_oleh', $email);
                                                        $this->db->set('is_active', 1);
                                                        $this->db->insert('standar_waktu');
                                                    }

                                                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                    $this->db->where('standar_pc_id', $standar_pc_id);
                                                    $waktu = $this->db->get('standar_waktu')->row()->waktu;
                                                    $last_update = $this->db->get('standar_waktu')->row()->last_update;
                                                    $update_oleh = $this->db->get('standar_waktu')->row()->update_oleh;

                                                    echo '<tr>';
                                                    echo '<td scope="col">' . $dak['urutan'] . '</td>';
                                                    echo '<td scope="col">' . $dak['inisial_level_kerja'] . '</td>';
                                                    echo '<td >
                                                <input type="text" class="form-control text-right" id=' . $detail_alur_kerja_id . ' name=' . $detail_alur_kerja_id . ' value="' . $waktu . '">                   
                                            ';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                </div>

        </div>
<?php
                        }
                    endforeach;
?>
    </div>
    <p><small><?php echo "Last Update: " . date('d-M-Y', $last_update); ?></small></p>
    <p><small><?php echo "Oleh : " . $update_oleh; ?></small></p>
    <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
    <input type="hidden" id="standar_pc_id" name="standar_pc_id" value="<?php echo $standar_pc_id; ?>">
    <div class="row">
        <div class="col">
            <button type="submit" id="update" name="update" value=TRUE class="btn btn-primary mb-1">Update</button>
            </form>
        </div>
        <div class="col">
            <form method="post" action="<?php echo base_url('pengaturan/standar_waktu'); ?>">
                <button type="submit" class="btn btn-secondary" id="standar_pc_id" name="standar_pc_id" value="<?php echo $standar_pc_id; ?>">Kembali</button>
            </form>
        </div>
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
            </div>
            <div class="modal-footer">
                <input type="hidden" id="standar_pc_id" name="standar_pc_id" value="<?php echo $standar_pc_id; ?>">
                <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>