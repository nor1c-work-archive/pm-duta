<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-5 col-md-5">
            <img class="img-fluid px-5" src="<?php echo base_url('assets/img/') . 'logo.png'; ?>">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col">
                            <div class="p-3">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900">Ubah Password</h1>
                                    <h5 class="mb-4"><?php echo $this->session->userdata('reset_email'); ?> </h5>
                                </div>

                                <?php echo $this->session->flashdata('pesan'); ?>

                                <form class="user" method="post" action="<?php echo base_url('auth/ubahpassword'); ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="masukan password baru">
                                        <?php echo form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="konfirmasi password baru">
                                        <?php echo form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        Ubah Password
                                    </button>

                                </form>
                                <div class="text-center">
                                    <a class="small" href="<?php echo base_url('auth'); ?>">Login</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?php echo base_url('auth/daftar'); ?>">Belum punya akun? Daftar di sini!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>