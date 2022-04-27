

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <form method="post" action="<?php echo base_url('laporan/detail_proses_job'); ?>">
                <div class="form-row">
                    <div class="col col-sm-3">
                        <select id="tipe" name="tipe" class="form-control">
                            <option value=''></option>
                            <option value="mulai">Tanggal Rencana Mulai</option>
                            <option value="selesai">Tanggal Rencana Selesai</option>
                        </select>
                    </div>
                    <div class="col col-sm-2">
                        <select id="batas" name="batas" class="form-control">
                            <option value=''></option>
                            <option value='sebelum'>sebelum </option>
                            <option value='sampai'>sampai </option>
                            <option value='pada'>pada </option>
                            <option value='mulai'>mulai </option>
                            <option value='setelah'>setelah </option>
                        </select>
                    </div>

                    <div class="col col-sm-2">
                        <input id="tanggal" name="tanggal" />
                        <script>
                            $('#tanggal').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'dd-mm-yyyy'
                            });
                        </script>
                    </div>
                    <div class="col col-sm-2">
                        <select class="custom-select" id="inisial_level_kerja" name="inisial_level_kerja">
                            <option value=""></option>
                            <?php
                            $level_kerja = $this->db->get('level_kerja')->result_array();
                            foreach ($level_kerja as $lk) : {
                                    echo '
                                            <option value="' . $lk['inisial_level_kerja'] . '">' . $lk['nama_level_kerja'] . '</option>
                                            
                                            
                                             ';
                                }
                            endforeach
                            ?>
                        </select>
                    </div>


                    <div class="col">
                        <button type="sumbit" id="filter" name="filter" value=TRUE class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-1">
                <table class="table table-bordered table-sm" style="font-size: small;">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No Job</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Jilid</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Objek</th>
                            <th scope="col">Level</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Rencana Mulai</th>
                            <th scope="col">Rencana Selesai</th>
                            <th scope="col">Status</th>
                            <th scope="col">Progres (hari)</th>
                            <th scope="col">Aksi</th>
                        <tr>
                    </thead>
                    <tbody>

                        <?php
                              
                        $i = 0;

                        foreach ($detail_proses_job as $dpj) : {


                                $nojob = substr($dpj['naskah_rencana_produksi_id'], 0, 6);
                                $judul = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->judul;
                                $jilid = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->jilid;
                                $penulis = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->penulis;

                                $id = $dpj['id'];
                                $detail_alur_kerja_id = $dpj['detail_alur_kerja_id'];
                                $nama_objek_kerja = $dpj['nama_objek_kerja'];
                                $inisial_level_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row()->inisial_level_kerja;
                                $nama_level_kerja = $this->db->get_where('level_kerja', ['inisial_level_kerja' => $inisial_level_kerja])->row()->nama_level_kerja;
                                $status =  $dpj['status'];
                                $batas_selesai =  $dpj['selesai'];
                                $mulai =  $dpj['mulai'];
                                $mulai_int =  $dpj['mulai_int'];
                                $selesai_int =  $dpj['selesai_int'];
                                $progres = round(((now('Asia/Jakarta') - $mulai_int) / ($selesai_int - $mulai_int)) * 100);
                                if ($progres < 0) {
                                    $progres = 0;
                                }
                                if ($status == 'ANTRE') {
                                    $i = $i + 1;
                                    $nama_pic = '-';
                                    echo '
                                    <tr>
                                        <td style="vertical-align:middle;" scope="col">' . $i . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $nojob . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $judul . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $jilid . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $penulis . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $nama_objek_kerja . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $nama_level_kerja . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $nama_pic . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $mulai . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $batas_selesai . '</td>
                                        <td style="vertical-align:middle;" scope="col">' . $status . '</td>
                                       ';

                                    if ($progres >= 0 and $progres <= 50) {
                                        $green = 100;
                                        $red = ($progres / 50) * 100;
                                    } else {
                                        if ($progres <= 100) {
                                            $red = 100;
                                            $green = ((100 - $progres) / 50) * 100;
                                        } else {
                                            $red = 0;
                                            $green = 0;
                                        }
                                    }
                                    $redvalue = 255 * ($red / 100);
                                    $greenvalue = 255 * ($green / 100);
                                    $bluevalue = 0;
                                    $rgb = array($redvalue, $greenvalue, $bluevalue);

                                    $hex = "#";
                                    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
                                    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
                                    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

                                    echo '
                                        <th scope="col">
                                            <button type="button" class="btnt ';


                                    if ($progres <= 65) {
                                        echo "text-dark";
                                    } else {
                                        echo "text-light";
                                    }
                                    echo '" style=" width: 70px; height: 70px; padding: 10px 16px; border-radius: 35px; border-width: 0pt; font-size: 15px; font-weight: bolder; text-align: center; background-color: ' . $hex . '; ">' . $progres . ' % </button>
                                        </th>';
                                    echo '<td style="text-align:center">';
                                    echo '
                                    <form method="post" action="' . base_url('proses/kirim_naskah') . '">
                                        <input type="hidden" id="id" name="id" value="' . $id . '">
                                        <button type="submit"  class="btn btn-sm btn-primary mr-2">';

                                    echo '<input type="hidden" id="kirim2" name="kirim2" value=TRUE>';
                                    echo "Kirim";
                                    echo '</button>
                                    </form>
                                    ';
									echo '<form target="_blank" method="post" action="' . base_url('laporan/job') . '">
										<input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">
                                        <br>
										<button type="submit" id="cari" name="cari" value=TRUE class="btn btn-success btn-sm">
											Detail Job ini
										</button>
									</form>';
                                    echo '</td>';

                                    echo '</tr>';
                                    echo '    <tr>';
                                } else {
                                    $this->db->where('nojob', $nojob);
                                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                    $this->db->where('is_active', 1);
                                    $this->db->where('status !=', 'SELESAI');
                                    $progres_naskah = $this->db->get('progres_naskah')->result_array();

                                    foreach ($progres_naskah as $pn) : {
                                            $pic_real = $pn['user_email'];
                                            $status = $pn['status'];
                                            $nama_pic =  $this->db->get_where('user', ['email' => $pic_real])->row()->nama;
                                            $i = $i + 1;
                                            echo '
                                    <tr>
                                        <td style="vertical-align:middle" scope="col">' . $i . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $nojob . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $judul . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $jilid . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $penulis . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $nama_objek_kerja . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $nama_level_kerja . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $nama_pic . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $mulai . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $batas_selesai . '</td>
                                        <td style="vertical-align:middle" scope="col">' . $status . '</td>
                                       ';

                                            if ($progres >= 0 and $progres <= 50) {
                                                $green = 100;
                                                $red = ($progres / 50) * 100;
                                            } else {
                                                if ($progres <= 100) {
                                                    $red = 100;
                                                    $green = ((100 - $progres) / 50) * 100;
                                                } else {
                                                    $red = 0;
                                                    $green = 0;
                                                }
                                            }
                                            $redvalue = 255 * ($red / 100);
                                            $greenvalue = 255 * ($green / 100);
                                            $bluevalue = 0;
                                            $rgb = array($redvalue, $greenvalue, $bluevalue);

                                            $hex = "#";
                                            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
                                            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
                                            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

                                            echo '
                                        <th scope="col">
                                            <button type="button" class="btnt ';
                                            if ($progres <= 65) {
                                                echo "text-dark";
                                            } else {
                                                echo "text-light";
                                            }
                                            echo '" style=" width: 70px; height: 70px; padding: 10px 16px; border-radius: 35px; border-width: 0pt; font-size: 15px; font-weight: bolder; text-align: center; background-color: ' . $hex . '; ">' . $progres . ' % </button>
                                        </th>';
											echo '<td style="text-align:center">';
                                            echo '
                                    <form method="post" action="' . base_url('proses/kirim_naskah') . '">
                                        <input type="hidden" id="id" name="id" value="' . $id . '">
                                        <button type="submit"  class="btn btn-sm btn-primary mr-2">';
                                            echo "Bagi";
                                            echo '<input type="hidden" id="bagi" name="bagi" value=TRUE>';
                                            echo '<input type="hidden" id="pic_real" name="pic_real" value=' . $pic_real . '>';
                                            echo '</button>
                                    </form>
                                    ';
									
											echo '<form target="_blank" method="post" action="' . base_url('laporan/job') . '">
												<input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">
                                                <br>
												<button type="submit" id="cari" name="cari" value=TRUE class="btn btn-success btn-sm">
													Detail Job ini
												</button>
											</form>';
											
                                            echo '</td>';
                                            echo '</tr>';
                                            echo '    <tr>';
                                        }
                                    endforeach;
                                }
                            }
                        endforeach;
                        ?>

                    </tbody>
                </table>
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
<a class=" scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
