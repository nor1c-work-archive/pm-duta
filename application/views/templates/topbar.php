<div id="content-wrapper" class="d-flex flex-column">

    
    <div id="content">

        
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            
            <h5><?php echo $title; ?></h5>



            
            <ul class="navbar-nav ml-auto">

                
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <h3></h3>
                    
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <?php

                $this->db->where('level_id', $user['level_id']);
                $user_level = $this->db->get('user_level')->row_array();
                $nama_unit_kerja = $user_level['nama_unit_kerja'];

                if ($nama_unit_kerja != '') {

                    $this->db->where('user_email', $user['email']);
                    $this->db->where('is_active', 1);

                    // $status = "(status = 'TUNDA' OR status='TUNDA-LANJUT' OR status='MULAI' OR status='LANJUT' OR status='BARU')";
                    // $this->db->where($status);
                    $this->db->where('status', 'BARU');
                    $banyak_proses = $this->db->get('progres_naskah')->num_rows();
                ?>


                    
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Notification
                            <i class="fas fa-bell fa-fw" style="font-size:30px;"></i>
                            <span class="badge badge-danger badge-counter"><?php if ($banyak_proses > 0) {
                                                                                echo $banyak_proses;
                                                                            } ?></span>
                        </a>
                        <?php

                        if ($banyak_proses > 0) {

                            $this->db->where('user_email', $user['email']);
                            $this->db->where('is_active', 1);

                            //  $status = "(status = 'TUNDA' OR status='TUNDA-LANJUT' OR status='MULAI' OR status='LANJUT' OR status='BARU')";
                            //  $this->db->where($status);
                            $this->db->where('status', 'BARU');
                            $progres_naskah = $this->db->get('progres_naskah')->result_array();

                        ?>
                            
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Job Baru
                                </h6>
                                <?php
                                foreach ($progres_naskah as $pn) : {
                                        echo '<a class="dropdown-item d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                  <!--  <div class="small text-gray-500">' . $pn['nojob'] . '</div> -->
                                        <form method="post" action="' . base_url('proses/progres_naskah_baru') . '">
                                        <input readonly type="submit" class="btn btn-light small text-gray-500" id="nojob" name="nojob" value="' . $pn['nojob'] . '">
                                        </form>
                                    <span class="font-weight-bold">' . $pn['nama_level_kerja'] . '-' . $pn['nama_objek_kerja'] . '</span>
                                </div>
                            </a>';
                                    }
                                endforeach;
                                ?>


                                <a class="dropdown-item text-center small text-gray-500" href="<?php echo base_url('proses/progres_naskah'); ?>">Daftar Job lengkap</a>
                            </div>

                    <?php }
                        echo '</li>';
                    } ?>
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user['nama']; ?></span>
                            <img class="img-profile rounded-circle" src="<?php echo base_url('assets/img/profil/') . $user['foto']; ?>">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('user/'); ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

            </ul>

        </nav>
     