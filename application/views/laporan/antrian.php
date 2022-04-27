<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">


            <?php
            if ($tampil) {

            ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
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
                                <th scope="col">Kirim ke PIC</th>
                            <tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($detail_rencana_produksi as $drp) : {
                                    $naskah_rencana_produksi_id = $drp['naskah_rencana_produksi_id'];
                                    $id = $drp['id'];
                                    $nojob = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->nojob;
                                    $urutan = $drp['urutan'];
                                    $this->db->where('nojob', $nojob);
                                    $naskah = $this->db->get('naskah')->row_array();



                                    $judul = $naskah['judul'];
                                    $jilid = $naskah['jilid'];
                                    $penulis = $naskah['penulis'];

                                    $detail_alur_kerja_id = $drp['detail_alur_kerja_id'];
                                    $detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row_array();
                                    $nama_objek_kerja = $detail_alur_kerja['nama_objek_kerja'];
                                    $nama_level_kerja = $this->db->get_where('level_kerja', ['inisial_level_kerja' => $detail_alur_kerja['inisial_level_kerja']])->row()->nama_level_kerja;
                                    $pic_email = $drp['pic'];
                                    if ($pic_email == 'tentatif') {
                                        $nama_pic = "Tentatif";
                                    } else {
                                        $nama_pic = $this->db->get_where('user', ['email' => $pic_email])->row()->nama;
                                    }
                                    $nama_unit_kerja = $drp['nama_unit_kerja'];
                                    $level_id = $this->db->get_where('user_level', ['nama_unit_kerja' => $nama_unit_kerja])->row()->level_id;
                                    $user_unit_kerja = $this->db->get_where('user', ['level_id' => $level_id])->result_array();
                                    echo '<tr  ';

                                    if ($urutan != 1) {
                                        echo 'class="table-active"';
                                    }


                                    echo '>';
                                    echo '<td scope="col">' . $i . '</td>';
                                    echo '<td >' . $nojob . '</td>';
                                    echo '<td >' . $judul . '</td>';
                                    echo '<td >' . $jilid . '</td>';
                                    echo '<td >' . $penulis . '</td>';
                                    echo '<td >' . $nama_objek_kerja . '</td>';
                                    echo '<td >' . $nama_level_kerja . '</td>';
                                    echo '<td >' . $nama_pic . '</td>';
                                    echo '<td >';
                                    echo '
                                    <form method="post" action="' . base_url('proses/kirim_naskah') . '">
                                        <input type="hidden" id="id" name="id" value="' . $id . '">
                                        <button type="submit"  class="btn btn-sm btn-primary mr-2">Kirim</button>
                                    </form>
                                    ';
                                    echo '</td>';

                                    echo '</tr>';
                                    $i++;
                                }
                            endforeach;
                            ?>

                        </tbody>
                    </table>
                </div>
            <?php
            }

            ?>
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