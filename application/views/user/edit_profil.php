<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $nama = $user['nama'];
    $foto = $user['foto'];
    $level_name = $this->db->get_where('user_level', ['level_id' => $user['level_id']])->row()->level_name;
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <div class="card mb-3" style="max-width: 540px;">
                <?php echo form_open_multipart('user/update_profil'); ?>
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <img class="img-fluid p-3" src="<?php echo base_url('assets/img/profil/') . $foto; ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" readonly class="form-control" id="email" nama="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Level</label>
                                <input type="text" readonly class="form-control" id="email" nama="email" value="<?php echo $level_name; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col form-group px-3">
                        <div class="custom-file ">
                            <input type="file" class="custom-file-input" id="foto" name="foto">
                            <label class="custom-file-label" for="gambar">foto baru (jpg/png/gif)</label>
                        </div>
                    </div>

                </div>

            </div>
            <button type="submit" class="btn btn-success" id="update" name="update" value=TRUE>Up Date</button>
            </form>
        </div>

    </div>

    <div class="col-lg-6 mb-4">



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