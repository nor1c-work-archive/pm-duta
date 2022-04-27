<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];

    $user = $this->db->get_where('user_level', ['level_id' => $level_idx])->row_array();
    $level_name = $user['level_name'];

    ?>
    <!-- Content Row -->
    <div class="row">
        <?php echo $this->session->flashdata('pesan'); ?>
    </div>
    <div class="row">
    </div>
    <!-- Content Column -->
    <div class="col">

        <form method="post" action="<?php echo base_url('pengaturan/hak_akses'); ?>">
            <?php
            echo '      <div class="card mb-2">
                <div class="card-header">
                    ' . $level_name . '
                </div>
                <div class="card-body">
                    <h5 class="card-title">Menu</h5>';

            $this->db->order_by('urutan ASC');
            $menu = $this->db->get_where('menu', ['parent' => 0])->result_array();
            foreach ($menu as $m) {
                $id = $m['id'];
                $banyak = $this->db->get_where('menu', ['parent' => $id])->num_rows();
                if ($banyak != 0) {
                    $submenu = $this->db->get_where('menu', ['parent' => $id])->result_array();
                    foreach ($submenu as $sm) : {
                            $this->db->where('menu_id', $sm['id']);
                            $this->db->where('level_id', $level_idx);
                            $ada = $this->db->get('hak_akses')->num_rows();
                            if ($ada == 0) {
                                $hak = 0;
                            } else {
                                $this->db->where('menu_id', $sm['id']);
                                $this->db->where('level_id', $level_idx);
                                $hak = $this->db->get('hak_akses')->row()->hak;
                            }

                            echo '      <div class="custom-control custom-switch">
                        <input ';
                            if ($sm['menu_name'] == 'Menu') {
                                //  echo "disabled ";
                            }

                            if ($hak == 1) {
                                echo 'checked';
                            }



                            echo ' value=1 type="checkbox" class="custom-control-input" id="' . $sm['id'] . '" name="' . $sm['id'] . '">
                            <label class="custom-control-label" for="' . $sm['id'] . '">' . $m['menu_name'] . ' > ' . $sm['menu_name'] . '</label>
                        </div>';
                        }
                    endforeach;
                }
            }
            echo ' 
            <a class="btn btn-secondary mt-2" href="' . base_url('master/user_level') . '">Batal</a>
                    <button type="submit" id="update" name="update" value=TRUE class="btn btn-primary mt-2">Update</button>
                </div>
            </div>';

            ?>
            <input type="hidden" id="level_idx" name="level_idx" value="<?php echo $level_idx; ?>">
        </form>
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