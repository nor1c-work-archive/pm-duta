<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://pmduta.penerbitduta.top/user/">
            <img class="img-fluid p-3 mt-1" src="<?php echo base_url('assets/img/') . 'logo.png'; ?>">
        </a>
        <h6 class="text-center text-warning">PROJECT MANAGEMENT</h6>

        <!-- Divider -->
        <hr class="sidebar-divider mb-4">





        <!-- Heading -->

        <?php
        $level_id = $user['level_id'];

        $this->db->where('is_active', 1);
        $this->db->where('antre <=', date('Y-m-d', now('Asia/Jakarta')) . ' 23:59');
        $this->db->where('status', 'ANTRE');

        $banyak_antrean = $this->db->get('detail_rencana_produksi')->num_rows();
        if ($banyak_antrean == 0) {
            $banyak_antrean = '';
        }
        $this->db->where('menu_name', 'Antrean');
        $this->db->set('notif', $banyak_antrean);
        $this->db->update('menu');

        $this->db->where('is_active', 1);
        $this->db->where('last_update >=', strtotime(date('Y-m-d', now('Asia/Jakarta')) . ' 00:00'));
        $this->db->where('last_update <=', strtotime(date('Y-m-d', now('Asia/Jakarta')) . ' 23:59'));
        $this->db->where('status', 'FINISH');

        $banyak_finish = $this->db->get('detail_rencana_produksi')->num_rows();
        if ($banyak_finish == 0) {
            $banyak_finish = '';
        }
        $this->db->where('menu_name', 'Job FINISH');
        $this->db->set('notif', $banyak_finish);
        $this->db->update('menu');

        $this->db->order_by('urutan ASC');
        $menu = $this->db->get_where('menu', ['parent' => 0])->result_array();
        foreach ($menu as $m) : {
                $menu_id = $m['id'];
                $this->db->where('level_id', $level_id);
                $this->db->where('menu_id', $menu_id);
                $ada_hak = $this->db->get('hak_akses')->num_rows();
                if ($ada_hak != 0) {
                    $this->db->where('level_id', $level_id);
                    $this->db->where('menu_id', $menu_id);
                    $hak = $this->db->get('hak_akses')->row()->hak;
                    if ($hak == 1) {
                        echo '
                <div class="sidebar-heading">';
                        echo $m['menu_name'];
                        echo '</div>';
                        $id_parent1 = $m['id'];
                        $this->db->order_by('urutan ASC');
                        $submenu = $this->db->get_where('menu', ['parent' => $id_parent1])->result_array();

                        foreach ($submenu as $sm) : {
                                $submenu_id = $sm['id'];
                                $this->db->where('level_id', $level_id);
                                $this->db->where('menu_id', $submenu_id);
                                $ada_hak1 = $this->db->get('hak_akses')->num_rows();
                                if ($ada_hak1 != 0) {
                                    $this->db->where('level_id', $level_id);
                                    $this->db->where('menu_id', $submenu_id);
                                    $hak1 = $this->db->get('hak_akses')->row()->hak;
                                    if ($hak1 == 1) {
                                        $link_ = $sm['link'];
                                        $link = base_url($link_);
                                        $id_parent2 = $sm['id'];
                                        $this->db->order_by('urutan ASC');
                                        $banyak_subsubmenu = $this->db->get_where('menu', ['parent' => $id_parent2])->num_rows();

                                        if ($banyak_subsubmenu > 0) {
                                            $this->db->order_by('urutan ASC');
                                            $subsubmenu = $this->db->get_where('menu', ['parent' => $id_parent2])->result_array();
                                            echo '<!-- Nav Item - Pages Collapse Menu -->
                                                <li class="nav-item">
                                                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapse' . $id_parent2 . '" aria-expanded="true" aria-controls="collapse' . $id_parent2 . '">';
                                            echo '<i class="' . $sm['icon'] . '"></i>
                                                    <span>' . $sm['menu_name'] . '</span>
                                                    </a>';
                                            echo '<div id="collapse' . $id_parent2 . '" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                                    <div class="bg-white py-2 collapse-inner rounded">';
                                            foreach ($subsubmenu as $ssm) : {
                                                    $links_ = $ssm['link'];
                                                    $links = base_url($links_);
                                                    echo '
                                                    <a class="collapse-item" href="' . $links . '">' . $ssm['menu_name'] . '</a>';
                                                }
                                            endforeach;
                                            echo '    </div>
                                                </div> ';
                                        } else {
                                            echo '<!-- Nav Item - Pages Collapse Menu -->
                                                <li class="nav-item">
                                                <a class="nav-link collapsed" href="' . $link . '" aria-expanded="true" >';
                                            echo '<i class="' . $sm['icon'] . '"></i>
                                                    <span>' . $sm['menu_name'] . ' </span>';
                                            if ($sm['notif'] != '') {

                                                echo '<span class="badge badge-light">' . $sm['notif'] . '</span>';
                                            }


                                            echo '
                                                </a>';
                                        }
                                        echo '  </li>';
                                    }
                                }
                            }
                        endforeach;
                        echo '    <!-- Divider -->
        <hr class="sidebar-divider mb-4">';
                    }
                }
            }
        endforeach;


        ?>






        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->