<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];




    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo form_error('gudang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('dari_tgl', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('sampai_tgl', '<small class="text-danger pl-3">', '</small>'); ?>

            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title">Berdasarkan Kode Buku</h5>
                    <form method="post" action="<?php echo base_url('laporan/stok_akhir'); ?>">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>" placeholder="kode buku">
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select" id="gudang_id" name="gudang_id">
                                    <option selected value="X">Semua Gudang</option>
                                    <?php
                                    $gudang = $this->db->get('gudang')->result_array();
                                    foreach ($gudang as $g) : {
                                            echo '
                                            <option ';
                                            if ($gudang_id == $g['id']) {
                                                echo 'selected';
                                            }
                                            echo ' value="' . $g['id'] . '">' . $g['nama_gudang'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" id="tampilkan_kode" name="tampilkan_kode" value=TRUE class="btn btn-primary">Tampilkan</button>
                            </div>
                            <div class="col-sm-3">
                                <p class="text-danger">
                                    <small><?php echo $error1; ?></small>
                                </p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title">Berdasarkan Filter</h5>
                    <form method="post" action="<?php echo base_url('laporan/stok_akhir'); ?>">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <select class="custom-select" id="gudang_id" name="gudang_id">
                                    <option selected value="X">Semua Gudang</option>
                                    <?php
                                    $gudang = $this->db->get('gudang')->result_array();
                                    foreach ($gudang as $g) : {
                                            echo '
                                            <option ';
                                            if ($gudang_id == $g['id']) {
                                                echo 'selected';
                                            }
                                            echo ' value="' . $g['id'] . '">' . $g['nama_gudang'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select" id="jenjang_id" name="jenjang_id">
                                    <option selected value="X">Semua Jenjang</option>
                                    <?php
                                    $jenjang = $this->db->get('jenjang')->result_array();
                                    foreach ($jenjang as $j) : {
                                            echo '
                                            <option  ';

                                            if ($tampil_filter['jenjang_id'] == $j['jenjang_id']) {
                                                echo 'selected';
                                            }

                                            echo ' value="' . $j['jenjang_id'] . '">' . $j['nama_jenjang'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select" id="mapel_id" name="mapel_id">
                                    <option selected value="X">Semua Mapel</option>
                                    <?php
                                    $mapel = $this->db->get('mapel')->result_array();
                                    foreach ($mapel as $m) : {
                                            echo '
                                            <option ';

                                            if ($tampil_filter['mapel_id'] == $m['mapel_id']) {
                                                echo 'selected';
                                            }


                                            echo ' value="' . $m['mapel_id'] . '">' . $m['nama_mapel'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select" id="kategori_id" name="kategori_id">
                                    <option selected value="X">Semua Kategori</option>
                                    <?php
                                    $kategori = $this->db->get('kategori')->result_array();
                                    foreach ($kategori as $k) : {
                                            echo '
                                            <option  ';

                                            if ($tampil_filter['kategori_id'] == $k['kategori_id']) {
                                                echo 'selected';
                                            }


                                            echo ' value="' . $k['kategori_id'] . '">' . $k['nama_kategori'] . '</option>
                                            
                                             ';
                                        }
                                    endforeach
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" id="tampilkan_filter" name="tampilkan_filter" value=TRUE class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if ($tampilkan) {

            ?>
                <div class="card mb-1">
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Jilid</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Gudang</th>
                                    <th scope="col">Stok Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($gudang_id != "X") {
                                    $this->db->where('id', $gudang_id);
                                }
                                $gudang = $this->db->get('gudang')->result_array();
                                $total_stok = 0;
                                $i = 1;
                                foreach ($buku as $buku) : {
                                        foreach ($gudang as $g) : {
                                                $kode = $buku['kode'];
                                                $nama_gudang = $g['nama_gudang'];
                                                $gudang_id = $g['id'];
                                                $saldo = $stok_akhir[$gudang_id][$kode];
                                                echo '<tr>
                                        <th scope="row">' . $i . '</th>
                                        <td>' . $buku['kode'] . '</td>
                                        <td>' . $buku['judul'] . '</td>
                                        <td>' . $buku['jilid'] . '</td>
                                        <td>' . $buku['penulis'] . '</td>
                                        <td>' . $nama_gudang . '</td>
                                        
                                        <td class="text-right">' . number_format($saldo, 0, ",", ".") . '</td>
                                    </tr>';
                                                $i++;
                                                $total_stok = $total_stok + $saldo;
                                            }
                                        endforeach;
                                    }
                                endforeach;
                                echo '<tr class="text-light">
                                        
                                        <td colspan="5"></td>
                                        <td class="bg-secondary">Total Stok</td>
                                                                
                                        <td class="text-right bg-secondary">' . number_format($total_stok, 0, ",", ".") . '</td>
                                    </tr>';
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php

            }


            ?>

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