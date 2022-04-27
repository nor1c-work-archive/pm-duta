<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $nojob = $naskah['nojob'];
    $judul = $naskah['judul'];
    $jilid = $naskah['jilid'];
    $penulis = $naskah['penulis'];



    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>


            <div class="card  mb-1">
                <div class="card-body">

                    <form method="post" action="<?php echo base_url('laporan/job'); ?>">
                        <div class="form-group row">
                            <label for="nojob" class="col-sm-1 col-form-label">No Job</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" id="cari" name="cari" value=TRUE class="btn btn-primary">Cari</button>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-danger">
                                    <small><?php echo $error1; ?></small>
                                </p>
                                <?php echo form_error('nojob', '<small class="text-danger pl-3">', '</small>'); ?>
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

                    <br>
                </div>
            </div>
            <?php
            if ($tampil) {
            ?>

                <?php

                $naskah_rencana_produksi = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row_array();
                $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];

                $this->db->order_by('objek_kerja_id');
                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                foreach ($objek_kerja as $ok) : {
                        $id = $ok['id'];
                        $nama_objek_kerja = $ok['nama_objek_kerja'];
                        $inisial_objek_kerja = $ok['inisial_objek_kerja'];
                        if ($nojob == '') {
                            $jumlah_halaman = 0;
                        } else {
                            $jumlah_halaman = $this->db->get_where('spek_naskah', ['nama_objek_kerja' => $nama_objek_kerja, 'nojob' => $nojob])->row()->jumlah_halaman;
                        }
                        echo '
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h5 class="card-title">' . $ok['nama_objek_kerja'] . '</h5>';
                ?>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" style="font-size:x-small;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">Urutan</th>
                                        <th rowspan="2">Level Kerja</th>
                                        <th colspan="6">Rencana</th>
                                        <th colspan="9">Realisasi</th>
                                    </tr>
                                    <tr>
                                        <th>PIC</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Libur</th>
                                        <th>Durasi Kerja</th>
                                        <th>Perencana</th>
                                        <th>PIC</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Libur</th>
                                        <th>Durasi Kerja</th>
                                        <th>Total Durasi</th>
                                        <th>Pengarah</th>
                                        <th>Status</th>
                                        <th>Halaman</th>
                                    </tr>
                                </thead>
                                <?php
                                if ($jumlah_halaman != 0) {
                                ?>
                                    <tbody>
                                        <?php

                                        $this->db->order_by('urutan ASC');
                                        $this->db->where('alur_kerja_id', $alur_kerja_id);
                                        $this->db->where('nama_objek_kerja', $ok['nama_objek_kerja']);
                                        $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();

                                        foreach ($detail_alur_kerja as $dak_k => $dak) : {
                                                $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                                $rencana_oleh = $this->db->get('naskah_rencana_produksi')->row()->update_oleh;
                                                $nama_perencana = $this->db->get_where('user', ['email' => $rencana_oleh])->row()->nama;


                                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                                $detail_rencana_produksi = $this->db->get('detail_rencana_produksi')->row_array();

                                                $pic_rencana = $detail_rencana_produksi['pic'];

                                                if ($pic_rencana != 'tentatif') {
                                                    $this->db->where('email', $pic_rencana);
                                                    $user = $this->db->get('user')->row_array();
                                                    $nama_pic_rencana = $user['nama'];
                                                } else {
                                                    $nama_pic_rencana = 'Tentatif';
                                                }

                                                $status = $detail_rencana_produksi['status'];
                                                $mulai = $detail_rencana_produksi['mulai'];
                                                $selesai = $detail_rencana_produksi['selesai'];
                                                //  $mulai_real = $detail_rencana_produksi['mulai_real'];
                                                //  $selesai_real = $detail_rencana_produksi['selesai_real'];

                                                $update_oleh = $detail_rencana_produksi['update_oleh'];
                                                $mulai_int = strtotime($mulai);
                                                $selesai_int = strtotime($selesai);
                                                //  $mulai_real_int = strtotime($mulai_real);
                                                //   $selesai_real_int = strtotime($selesai_real);
                                                $this->db->where('tanggal >=', $mulai_int);
                                                $this->db->where('tanggal <=', $selesai_int);
                                                $libur_rencana = $this->db->count_all_results('hari_libur');
                                                $durasi_rencana = (($selesai_int - $mulai_int) / (60 * 60 * 24)) - $libur_rencana + 1;

                                                //   $libur_real = $this->db->count_all_results('hari_libur');

                                                //   $durasi_real = (($selesai_real_int - $mulai_real_int) / (60 * 60 * 24)) - $libur_real + 1;

                                                $pic = $this->db->get_where('user', ['email' => $update_oleh])->row()->nama;

                                                $banyak_pic = $rekap[$detail_alur_kerja_id]['banyak_pic'];
                                                $total_durasi_real = $rekap[$detail_alur_kerja_id]['total_durasi_real'];
                                                if ($banyak_pic == 0) {
                                                    $rowspan = 1;
                                                } else {
                                                    $rowspan = $banyak_pic;
                                                }

                                                echo '<tr>';
                                                echo '<td rowspan="' . $rowspan . '" scope="col">' . $dak['urutan'] . '</td>';
                                                echo '<td rowspan="' . $rowspan . '" scope="col">' . $dak['inisial_level_kerja'] . '</td>';
                                                if ($banyak_pic == 0) {
                                                    echo '<td scope="col">' . $nama_pic_rencana . '</td>';
                                                    echo '<td scope="col">' . $mulai . '</td>';
                                                    echo '<td scope="col">' . $selesai . '</td>';
                                                    echo '<td scope="col">' . $libur_rencana . '</td>';
                                                    echo '<td scope="col">' .  $durasi_rencana . '</td>';
                                                    echo '<td scope="col">' . $nama_perencana . '</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '<td scope="col">-</td>';
                                                    echo '</tr>';
                                                } else {
                                                    $sql = "SELECT
                                                                P.user_email,
                                                                (
                                                                    select
                                                                        pengarah
                                                                    FROM progres_naskah
                                                                    WHERE nojob='".$nojob."' 
                                                                    AND detail_alur_kerja_id='".$dak['detail_alur_kerja_id']."' 
                                                                    AND user_email=P.user_email
                                                                    AND pengarah!=''
                                                                ) AS pengarah,
                                                                (
                                                                    SELECT
                                                                        mulai_real_int 
                                                                    FROM
                                                                        progres_naskah 
                                                                    WHERE
                                                                        nojob = '".$nojob."'  
                                                                        AND detail_alur_kerja_id = '".$dak['detail_alur_kerja_id']."'  
                                                                        AND status = 'MULAI'
                                                                        AND user_email=P.user_email
                                                                    GROUP BY
                                                                        user_email 
                                                                )
                                                                AS mulai_real_int,
                                                                MAX(P.selesai_real_int) AS selesai_real_int,
                                                                MAX(P.halaman) as halaman
                                                            FROM
                                                                progres_naskah P
                                                            WHERE
                                                                P.nojob = '".$nojob."'  
                                                                AND P.detail_alur_kerja_id = '".$dak['detail_alur_kerja_id']."' 
                                                            GROUP BY
                                                                P.user_email";
                                                    $pics = $this->db->query($sql)->result_array();

                                                    $i = 1;
                                                    $max_durasi = 0;
                                                    foreach ($pics as $pic_k => $pic) : {
                                                            if ($pic['mulai_real_int'] == 0) {
                                                                $mulai_real = '-';
                                                                $selesai_real = '-';
                                                                $libur_real = '-';
                                                                $durasi_real = '-';
                                                            } else {
                                                                $mulai_real = date('d-m-Y', $pic['mulai_real_int']);
                                                                $selesai_real = date('d-m-Y', $pic['selesai_real_int']);

                                                                if ($pic['selesai_real_int'] == 0) {
                                                                    $selesai_real = date('d-m-Y', now('Asia/Jakarta'));
                                                                }
                                                                $this->db->where('tanggal >=', $pic['mulai_real_int']);
                                                                $this->db->where('tanggal <=', $pic['selesai_real_int']);
                                                                $libur_real = $this->db->count_all_results('hari_libur');

                                                                $firstDate  = new DateTime($mulai_real);
                                                                $secondDate = new DateTime($selesai_real);
                                                                $intvl = $firstDate->diff($secondDate);
                                                                $durasi_bruto = $intvl->days;
                                                                $durasi_real = $durasi_bruto  - $libur_real + 1;
                                                            }
                                                            if ($durasi_real > $max_durasi) {
                                                                $max_durasi = $durasi_real;
                                                            }

                                                            $pic_real = $pic['user_email'];
                                                            $nama_pic_real = $this->db->get_where('user', ['email' => $pic_real])->row()->nama;
                                                            $pic_pengarah = $pic['pengarah'];
                                                            $nama_pic_pengarah = $this->db->get_where('user', ['email' => $pic_pengarah])->row()->nama;


                                                            $this->db->where('nojob', $nojob);
                                                            $this->db->where('user_email', $pic_real);
                                                            $this->db->where('is_active', 1);
                                                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                                            $status = $this->db->get('progres_naskah')->row()->status;

                                                            if ($i == 1) {
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . $nama_pic_rencana . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . $mulai . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . $selesai . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . $libur_rencana . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' .  $durasi_rencana . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . $nama_perencana . '</td>';
                                                                echo '<td scope="col">' . $nama_pic_real . '</td>';
                                                                echo '<td scope="col">' . $mulai_real . '</td>';
                                                                echo '<td scope="col">' . ($pic['selesai_real_int'] != 0 ? $selesai_real : '-') . '</td>';
                                                                echo '<td scope="col">' . $libur_real . '</td>';
                                                                echo '<td scope="col">' . $durasi_real . '</td>';
                                                                echo '<td rowspan="' . $banyak_pic . '" scope="col">' . /*$total_durasi_real*/ $max_durasi . '</td>';
                                                                echo '<td scope="col">' . $nama_pic_pengarah . '</td>';
                                                                echo '<td scope="col">' . $status . '</td>';
                                                                echo '<td scope="col">' . $pic['halaman'] . '</td>';
                                                                echo '</tr>';
                                                            } else {
                                                                echo '<tr>';
                                                                echo '<td >' . $nama_pic_real . '</td>';
                                                                echo '<td scope="col">' . $mulai_real . '</td>';
                                                                echo '<td scope="col">' . ($pic['selesai_real_int'] != 0 ? $selesai_real : '-') . '</td>';
                                                                echo '<td scope="col">' . $libur_real . '</td>';
                                                                echo '<td scope="col">' . $durasi_real . '</td>';

                                                                echo '<td >' . $nama_pic_pengarah . '</td>';
                                                                echo '<td >' . $status . '</td>';
                                                                echo '<td >' . $pic['halaman'] . '</td>';
                                                                echo '</tr>';
                                                            }
                                                            $i++;
                                                        }
                                                    endforeach;
                                                }
                                            }
                                        endforeach;


                                        ?>
                                    </tbody>
                                <?php }
                                ?>
                            </table>
                        </div>


        </div>

    </div>
<?php
                    }
                endforeach;
?>
<?php
            }


?>
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