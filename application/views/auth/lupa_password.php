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
                                    <h1 class="h4 text-gray-900 mb-4">Lupa Password?</h1>
                                </div>

                                <?php echo $this->session->flashdata('pesan'); ?>

                                <form class="user" method="post" action="<?php echo base_url('auth/lupapassword'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="masukan email Anda...">
                                        <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        Reset Password
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