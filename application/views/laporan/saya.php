<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?php
    $user_email = $cari['user_email'];

    $dari_tgl = $cari['dari_tgl'];
    $sampai_tgl = $cari['sampai_tgl'];
    $nama = $this->db->get_where('user', ['email' => $user_email])->row()->nama;
    $level_id = $this->db->get_where('user', ['email' => $user_email])->row()->level_id;
    $nama_unit_kerja = $this->db->get_where('user_level', ['level_id' => $level_id])->row()->nama_unit_kerja;

    ?>


    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <div class="card  mb-1">
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('laporan/saya'); ?>">
                        <div class="form-group row">
                            <label for="nojob" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-3">
                                <input readonly type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama . ' (' . $nama_unit_kerja . ')'; ?>">
                            </div>
                            <input type="hidden" id="user_email" name="user_email" value="<?php echo $user_email; ?>">
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
                                    <th scope="col">Status</th>
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($progres_naskah as $pn) : {
                                        $tanggal = date('d-m-Y', $pn['last_update']);

                                        $status = $pn['status'];
                                        $nojob = $pn['nojob'];
                                        $nama_objek_kerja = $pn['nama_objek_kerja'];
                                        $nama_level_kerja = $pn['nama_level_kerja'];
                                        $judul = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->judul;
                                        $jilid = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->jilid;
                                        $penulis = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->penulis;

                                        echo '<tr>';
                                        echo '<td scope="col">' . $i . '</td>';
                                        echo '<td scope="col">' . $tanggal . '</td>';
                                        echo '<td >' . $nojob . '</td>';
                                        echo '<td >' . $judul . '</td>';
                                        echo '<td >' . $jilid . '</td>';
                                        echo '<td >' . $penulis . '</td>';
                                        echo '<td >' . $nama_objek_kerja . '</td>';
                                        echo '<td >' . $nama_level_kerja . '</td>';
                                        echo '<td >' . $status . '</td>';
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