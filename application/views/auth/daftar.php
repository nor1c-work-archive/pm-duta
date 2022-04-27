<div class="container">
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
                                    <h1 class="h4 text-gray-900 mb-4">Daftar</h1>
                                </div>
                                <form class="user" method="post" action="<?php echo base_url('auth/daftar'); ?>">
                                    <div class="form-group row">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama">
                                            <?php echo form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="email">
                                        <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                        <?php echo form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>


                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Konfirmasi Password">

                                    </div>
                                    <button type="submit" class="btn btn-outline-success btn-user btn-block">
                                        Daftar
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Lupa Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?php echo base_url('auth'); ?>">Sudah terdaftar? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>