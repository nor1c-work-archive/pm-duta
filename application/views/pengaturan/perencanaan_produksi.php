<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $nojob = $naskah['nojob'];
    $judul = $naskah['judul'];
    $jilid = $naskah['jilid'];
    $penulis = $naskah['penulis'];
    $standar_pc_id = $naskah['standar_pc_id'];
    $ada_model = TRUE;

    if ($standar_pc_id != '') {

        $jenjang_id = substr($standar_pc_id, 0, 2);
        $jenjang = $this->db->get_where('jenjang', ['jenjang_id' => $jenjang_id])->row()->nama_jenjang;
        $mapel_id = substr($standar_pc_id, 2, 2);
        $mapel = $this->db->get_where('mapel', ['mapel_id' => $mapel_id])->row()->nama_mapel;
        $kategori_id = substr($standar_pc_id, 4, 2);
        $kategori = $this->db->get_where('kategori', ['kategori_id' => $kategori_id])->row()->nama_kategori;
        $banyak_standar_model_alur_kerja = $this->db->get_where('standar_model_alur_kerja', ['standar_pc_id' => $standar_pc_id])->num_rows();
        if ($banyak_standar_model_alur_kerja == 0) {
            $ada_model = FALSE;
        } else {
            $ada_model = TRUE;
        }
    } else {
        $mapel = '';
        $jenjang = '';
        $kategori = '';
    }


    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>


            <div class="card  mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('pengaturan/perencanaan_produksi'); ?>">
                        <div class="form-group row">
                            <label for="nojob" class="col-sm-1 col-form-label">No Job</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" id="cari" name="cari" value=TRUE class="btn btn-primary">Cari</button>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-danger">
                                    <?php echo $error1; ?>
                                </p>
                                <?php echo form_error('nojob', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                            </div>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="judul">Judul</label>
                            <input readonly type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="jilid">Jilid</label>
                            <input readonly type="text" class="form-control" id="jilid" name="jilid" value="<?php echo $jilid; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="penulis">Penulis</label>
                            <input readonly type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="mapel">Mapel</label>
                            <input readonly type="text" class="form-control" id="mapel" name="mapel" value="<?php echo $mapel; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="jenjang">Jenjang</label>
                            <input readonly type="text" class="form-control" id="jenjang" name="jenjang" value="<?php echo $jenjang; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="kategori">Kategori</label>
                            <input readonly type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori; ?>">
                        </div>
                    </div>

                    <?php
                    $this->db->order_by('objek_kerja_id');
                    $objek_kerja = $this->db->get('objek_kerja')->result_array();
                    foreach ($objek_kerja as $ok) : {
                            $id = $ok['id'];
                            $nama_objek_kerja = $ok['nama_objek_kerja'];
                            $inisial_objek_kerja = $ok['inisial_objek_kerja'];
                            if ($nojob == '') {
                                $jumlah_halaman = 0;
                            } else {
                                $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                                $this->db->where('nojob', $nojob);
                                $ada_halaman = $this->db->get('spek_naskah')->row_array();
                                if (!isset($ada_halaman)) {
                                    $jumlah_halaman = 'tidak terdaftar';
                                } else {
                                    $jumlah_halaman = $ada_halaman['jumlah_halaman'];
                                }
                            }
                            $banyak_halaman[$id] = $jumlah_halaman;
                            if ($ok['perhitungan_durasi'] == 'sat_hari') {
                                $perhitungan_durasi = $ok['satuan'] . "/hari";
                            } else {
                                if ($ok['perhitungan_durasi'] == 'hari_sat') {
                                    $perhitungan_durasi = "hari/" . $ok['satuan'];
                                } else {
                                    $perhitungan_durasi = "";
                                }
                            }
                        }
                    endforeach;
                    ?>

                    <?php
                    if (!$ada_model) {
                        echo '
                            <div class="form-group row">
                                <label for="kategori" class="col-sm-5 col-form-label text-danger">Belum ada opsi model alur kerja untuk kategori ini</label>
                                <div class="col-sm-3 ">
                                    <form method="post" action="' . base_url('pengaturan/standar_waktu') . '">
                                        <input type="hidden" id="standar_pc_id" name="standar_pc_id" value="' . $standar_pc_id . '">
                                        <button type="submit" class="btn btn-primary ">Buat di sini</button>
                                    </form>
                                </div>
                            </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('pengaturan/perencanaan_produksi'); ?>">
                        <div class="form-row">
                            <div class="form-group col-sm-2">
                                <label for="model">Pilih Model Alur Kerja</label>
                                <select class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                                    <?php
                                    $this->db->where('standar_pc_id', $standar_pc_id);
                                    $this->db->order_by('alur_kerja_id ASC');
                                    $standar_model_alur_kerja = $this->db->get('standar_model_alur_kerja')->result_array();
                                    foreach ($standar_model_alur_kerja as $smak) : {
                                            $this->db->where('alur_kerja_id', $smak['alur_kerja_id']);
                                            $model_alur_kerja = $this->db->get('alur_kerja')->row()->model_alur_kerja;
                                            echo '<option value=' . $smak['alur_kerja_id'] . '>' . $model_alur_kerja . '</option>';
                                        }
                                    endforeach;
                                    ?>

                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                        <button <?php
                                if ($nojob == '') {
                                    echo 'disabled';
                                }
                                ?> type="submit" id="atur" name="atur" value=TRUE class="btn btn-primary">Preview</button>
                    </form>
                </div>
            </div>
            <?php
            if ($tampil) {
            ?>

                <form method="post" action="<?php echo base_url('pengaturan/perencanaan_produksi'); ?>">
                    <?php
                    $this->db->order_by('objek_kerja_id');
                    $objek_kerja = $this->db->get('objek_kerja')->result_array();
                    foreach ($objek_kerja as $ok) : {

                            echo '
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h5 class="card-title">' . $ok['nama_objek_kerja'] . ' = ' . $halaman[$ok['id']] . ' ' . $ok['satuan'] . '</h5>';

                    ?>
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">Urutan</th>
                                                <th scope="col">Level Kerja</th>
                                                <th scope="col">Mulai</th>
                                                <th scope="col">Kecepatan (<?php echo $perhitungan_durasi; ?>)</th>
                                                <th scope="col">durasi</th>
                                                <th scope="col">libur</th>
                                                <th scope="col">Selesai</th>
                                                <th scope="col">Available PIC</th>
                                            <tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $this->db->where('alur_kerja_id', $alur_kerja_id);
                                            $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                                            $this->db->order_by('urutan ASC');
                                            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();
                                            foreach ($detail_alur_kerja as $dak) : {
                                                    $nama_unit_kerja = $dak['nama_unit_kerja'];
                                                    $level_id = $this->db->get_where('user_level', ['nama_unit_kerja' => $nama_unit_kerja])->row()->level_id;

                                                    $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                                    echo '<input type="hidden" id="' . $detail_alur_kerja_id . 'mulai" name="' . $detail_alur_kerja_id . 'mulai" value="' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['mulai'] . '">';
                                                    echo '<input type="hidden" id="' . $detail_alur_kerja_id . 'selesai" name="' . $detail_alur_kerja_id . 'selesai" value="' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['selesai'] . '">';
                                                    echo '<tr>';
                                                    echo '<td scope="col">' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['urutan'] . '</td>';
                                                    echo '<td scope="col">' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['inisial_level_kerja'] . '</td>';
                                                    echo '<td>';

                                            ?>
                                                    <?php
                                                    if ($ada_standar) {
                                                        echo '<div class="row">';
                                                        echo '<input class="ml-1" width="200" id="mulai-' . $dak['detail_alur_kerja_id'] . '" name="mulai-' . $dak['detail_alur_kerja_id'] . '" value="' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['mulai'] . '" />';
                                                    ?>

                                                        <script>
                                                            $('#<?php echo 'mulai-' . $dak['detail_alur_kerja_id']; ?>').datepicker({
                                                                uiLibrary: 'bootstrap4',
                                                                format: 'dd-mm-yyyy'

                                                            });
                                                        </script>
                                            <?php



                                                        echo '<input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">';
                                                        echo '<input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="' . $alur_kerja_id . '">';
                                                        echo '<input type="hidden" id="hitung_ulang" name="hitung_ulang" value="TRUE">';

                                                        if ($ada_standar) {
                                                            echo '<button type="submit" value=TRUE id="refresh-' . $dak['detail_alur_kerja_id'] . '" name="refresh-' . $dak['detail_alur_kerja_id'] . '" class="btn btn-outline-primary ml-1"><i class="fas fa-sync-alt"></i></button>';
                                                        }

                                                        echo '</div>';
                                                    } else {
                                                        echo "-";
                                                    }

                                                    echo '</td>';;

                                                    echo '<td>' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['kecepatan'] . '</td>';
                                                    echo '<td>' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['durasi'] . '</td>';
                                                    echo '<td>' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['libur'] . '</td>';
                                                    echo '<td>' . $rencana[$ok['nama_objek_kerja']][$dak['urutan']]['selesai']  . '</td>';
                                                    echo '<td>';

                                                    echo '<select ';
                                                    if (!$ada_standar) {
                                                        echo 'disabled ';
                                                    }


                                                    echo 'class="custom-select my-1 mr-sm-2" id="' . $detail_alur_kerja_id . 'pic' . '" name="' . $detail_alur_kerja_id . 'pic' . '">';
                                                    $this->db->where('level_id', $level_id);
                                                    $user = $this->db->get('user')->result_array();
                                                    echo '<option value="tentatif">Tentatif</option>';
                                                    foreach ($user as $u) : {
                                                            $this->db->where('email', $u['email']);
                                                            $this->db->where('substr(naskah_rencana_produksi_id,1,6) !=', $nojob);
                                                            $this->db->where('is_active', 1);
                                                            $this->db->where('mulai_int <=', STRTOTIME($rencana[$ok['nama_objek_kerja']][$dak['urutan']]['mulai']));
                                                            $this->db->where('selesai_int >=', STRTOTIME($rencana[$ok['nama_objek_kerja']][$dak['urutan']]['mulai']));
                                                            $opsi1 = $this->db->get('pic_rencana')->num_rows();

                                                            $this->db->where('email', $u['email']);
                                                            $this->db->where('is_active', 1);
                                                            $this->db->where('substr(naskah_rencana_produksi_id,1,6) !=', $nojob);
                                                            $this->db->where('mulai_int <=', STRTOTIME($rencana[$ok['nama_objek_kerja']][$dak['urutan']]['selesai']));
                                                            $this->db->where('selesai_int >=', STRTOTIME($rencana[$ok['nama_objek_kerja']][$dak['urutan']]['selesai']));
                                                            $opsi2 = $this->db->get('pic_rencana')->num_rows();

                                                            if ($opsi1 == 0 and $opsi2 == 0) {
                                                                echo '<option ';
                                                                if ($rencana[$ok['nama_objek_kerja']][$dak['urutan']]['pic'] == $u['email']) {
                                                                    echo 'selected';
                                                                }
                                                                echo ' value="' . $u['email'] . '">' . $u['nama'] . '</option>';
                                                            }
                                                        }
                                                    endforeach;

                                                    echo '</select>';


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
<input type="hidden" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
<input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="<?php echo $alur_kerja_id; ?>">
<?php
                if ($ada_standar) {
                    echo '<button type="sumbit" ';
                    if ($nojob == '' or $alur_kerja_id == '' or !$save) {
                        echo "disabled";
                    }
                    echo ' class="btn btn-primary" id="tambah" name="tambah" value=TRUE>Save</button>
';
                }


?>
</form>

<?php
                if (!$ada_standar) {
                    if ($spek) {

                        echo '
    <form method="post" action="' . base_url('pengaturan/atur_standar_waktu') . '">
        <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="' . $alur_kerja_id . '">
        <button type="submit" class="btn btn-sm btn-info mt-1" id="standar_pc_id" name="standar_pc_id" value="' . $standar_pc_id . '">Tetapkan Standar Waktu</button>
    </form>
';
                    } else {
                        echo '
                            <form method="post" action="' . base_url('master/spek_naskah') . '">
                                            <button type="submit" class="btn btn-sm btn-info">Edit Spek</button>
                                            <input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">
                            </form>
';
                    }
                }
?>

<?php
            }

?>
<br>
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