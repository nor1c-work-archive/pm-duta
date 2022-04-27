<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?php
    $nama_unit_kerja = $cari['nama_unit_kerja'];
    $dari_tgl = $cari['dari_tgl'];
    $sampai_tgl = $cari['sampai_tgl'];

    ?>


    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <div class="card  mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('laporan/unit_kerja'); ?>">
                        <div class="form-group row">
                            <label for="nojob" class="col-sm-2 col-form-label">Unit Kerja</label>
                            <div class="col-sm-3">
                                <select class="custom-select my-1 mr-sm-2" id="nama_unit_kerja" name="nama_unit_kerja">
                                    <option></option>
                                    <?php
                                    $this->db->order_by('nama_unit_kerja ASC');
                                    $unit_kerja = $this->db->get('unit_kerja')->result_array();
                                    foreach ($unit_kerja as $uk) : {
                                            echo '
                                        <option ';
                                            if ($nama_unit_kerja == $uk['nama_unit_kerja']) {
                                                echo "selected";
                                            }
                                            echo ' value="' . $uk['nama_unit_kerja'] . '">' . $uk['nama_unit_kerja'] . '</option>
                                            ';
                                        }
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dari_tgl" class="col-sm-2 col-form-label">Dari tanggal:</label>
                            <div class="col-sm-2">
                                <input id="dari_tgl" name="dari_tgl" value="<?php echo $dari_tgl; ?>" />
                                <script>
                                    $('#dari_tgl').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>
                            <label for="sampai_tgl" class="col-sm-2 col-form-label text-right">Sampai tanggal:</label>
                            <div class="col-sm-2">
                                <input id="sampai_tgl" name="sampai_tgl" value="<?php echo $sampai_tgl; ?>" />
                                <script>
                                    $('#sampai_tgl').datepicker({
                                        uiLibrary: 'bootstrap4',
                                        format: 'dd-mm-yyyy'
                                    });
                                </script>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" id="tampilkan" name="tampilkan" value=TRUE class="btn btn-primary">Tampilkan</button>
                            </div>

                        </div>
                    </form>

                    <br>
                </div>
            </div>
            <?php
            if ($tampil) {
            ?>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nojob</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Jilid</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Objek</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">Proses</th>
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($progres_naskah as $pn) : {
                                        $tanggal = date('d-m-Y', $pn['last_update']);
                                        $nojob = $pn['nojob'];
                                        $judul = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->judul;
                                        $jilid = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->jilid;
                                        $penulis = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->penulis;
                                        $nama_objek_kerja = $pn['nama_objek_kerja'];
                                        $nama_level_kerja = $pn['nama_level_kerja'];
                                        $proses = $pn['status'];
                                        $user_email = $pn['user_email'];
                                        $pic = $this->db->get_where('user', ['email' => $user_email])->row()->nama;



                                        echo '<tr>';
                                        echo '<td scope="col">' . $i . '</td>';
                                        echo '<td scope="col">' . $tanggal . '</td>';
                                        echo '<td >' . $nojob . '</td>';
                                        echo '<td >' . $judul . '</td>';
                                        echo '<td >' . $jilid . '</td>';
                                        echo '<td >' . $penulis . '</td>';
                                        echo '<td >' . $nama_objek_kerja . '</td>';
                                        echo '<td >' . $nama_level_kerja . '</td>';
                                        echo '<td >' . $pic . '</td>';
                                        echo '<td >' . $proses . '</td>';
                                        echo '</tr>';
                                        $i++;
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