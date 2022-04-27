<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    if ($filter_jenjang_id != "semua") {
        $this->db->where('jenjang_id', $filter_jenjang_id);
    }
    if ($filter_mapel_id != "semua") {
        $this->db->where('mapel_id', $filter_mapel_id);
    }
    if ($filter_kategori_id != "semua") {
        $this->db->where('kategori_id', $filter_kategori_id);
    }
    $banyak_standar_pracetak = $this->db->get('standar_pracetak')->num_rows();

    $this->db->order_by('jenjang_id ASC, mapel_id ASC, kategori_id ASC');
    if ($filter_jenjang_id != "semua") {
        $this->db->where('jenjang_id', $filter_jenjang_id);
    }
    if ($filter_mapel_id != "semua") {
        $this->db->where('mapel_id', $filter_mapel_id);
    }
    if ($filter_kategori_id != "semua") {
        $this->db->where('kategori_id', $filter_kategori_id);
    }
    $standar_pracetak = $this->db->get('standar_pracetak')->result_array();


    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">

            <?php echo $this->session->flashdata('pesan'); ?>
            <?php

            $this->db->select_max('last_update');
            $x = $this->db->get('standar_tarif_pracetak')->row_array();


            $last_update = $x['last_update'];
            $standar = $this->db->get_where('standar_tarif_pracetak', ['last_update' => $last_update])->row_array();

            $ilustrasi = $standar['ilustrasi'];
            $update_oleh = $standar['update_oleh'];
            $cover = $standar['cover'];

            ?>

            <div class="row mb-2">
                <div class="col col-md-3">
                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahStandarPracetaklModal">Tambah Standar Produk</button>
                </div>
                <div class="col col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="<?php echo base_url('pengaturan/standar_pracetak'); ?>">
                                <div class="row">
                                    <div class="col col-md-4">
                                        <select class="form-control" id="mapel_id" name="mapel_id">
                                            <option value="semua" <?php if ($filter_mapel_id == "semua") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Semua Mapel</option>
                                            <?php
                                            $this->db->order_by('nama_mapel ASC');
                                            $mapel = $this->db->get('mapel')->result_array();
                                            foreach ($mapel as $m) : {
                                                    echo '<option ';
                                                    if ($filter_mapel_id == $m['mapel_id']) {
                                                        echo "selected";
                                                    }
                                                    echo ' value=' . $m['mapel_id'] . '>' . $m['nama_mapel'] . '</option>';
                                                }
                                            endforeach;
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col col-md-3">
                                        <select class="form-control" id="jenjang_id" name="jenjang_id">
                                            <option value="semua" <?php if ($filter_jenjang_id == "semua") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Semua Jenjang</option>
                                            <?php
                                            $this->db->order_by('nama_jenjang ASC');
                                            $jenjang = $this->db->get('jenjang')->result_array();
                                            foreach ($jenjang as $j) : {
                                                    echo '<option ';
                                                    if ($filter_jenjang_id == $j['jenjang_id']) {
                                                        echo "selected";
                                                    }
                                                    echo ' value=' . $j['jenjang_id'] . '>' . $j['nama_jenjang'] . '</option>';
                                                }
                                            endforeach;
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col col-md-3">
                                        <select class="form-control" id="kategori_id" name="kategori_id">
                                            <option value="semua" <?php if ($filter_kategori_id == "semua") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Semua Kategori</option>
                                            <?php
                                            $this->db->order_by('kategori_id ASC');
                                            $kategori = $this->db->get('kategori')->result_array();
                                            foreach ($kategori as $k) : {
                                                    echo '<option ';
                                                    if ($filter_kategori_id == $k['kategori_id']) {
                                                        echo "selected";
                                                    }
                                                    echo ' value=' . $k['kategori_id'] . '>' . $k['nama_kategori'] . '</option>';
                                                }
                                            endforeach;
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col col-md-2">
                                        <button type="submit" id="filter" name="filter" value=TRUE class="btn btn-dark">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_error('mapel_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jenjang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('kategori_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('standar_setting', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('standar_editing', '<small class="text-danger pl-3">', '</small>'); ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <?php if ($banyak_standar_pracetak == 0) {
                        echo '
                                <div class="alert alert-danger" role="alert">
                                    Tidak ada data dengan filter tersebut

                                    <button id="tombolTambahPraCetakDariFilter" type="button" data-mapel_id="' . $filter_mapel_id . '" data-jenjang_id="' . $filter_jenjang_id . '" data-kategori_id="' . $filter_kategori_id . '" data-toggle="modal" data-target="#tambahStandarPracetaklModal" class="btn btn-sm btn-success">Tambahkan</button>

                                </div>';
                    } else {
                        echo '
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Standar Produk</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Standar Waktu</th>
                                </tr>
                            </thead>';
                    }


                    ?>

                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($standar_pracetak as $sp) : {
                                $jenjang = $this->db->get_where('jenjang', ['jenjang_id' => $sp['jenjang_id']])->row()->nama_jenjang;
                                $mapel = $this->db->get_where('mapel', ['mapel_id' => $sp['mapel_id']])->row()->nama_mapel;
                                $kategori = $this->db->get_where('kategori', ['kategori_id' => $sp['kategori_id']])->row()->nama_kategori;
                                $standar = $mapel . ' - ' . $jenjang . ' - kategori ' . $kategori;
                                $id = $sp['id'];
                                $standar_setting = $sp['standar_setting'];
                                $standar_editing = $sp['standar_editing'];
                                $standar_pc_id = $sp['standar_pc_id'];


                                $setting_per_hal = $standar_setting;
                                $editing_per_hal = $standar_editing;
                                echo '
                                    <tr>
                                        <th scope="col">' . $i . '</th>
                                        <td scope="col">' . $standar . '</td>                                      
                                        <td scope="col">
                                    <button id="tombolEditStandarPraCetak" type="button" data-kategori_id="' . $sp['kategori_id'] . '" data-mapel_id="' . $sp['mapel_id'] . '" data-jenjang_id="' . $sp['jenjang_id'] . '" data-standar_editing="' . $sp['standar_editing'] . '" data-standar_setting="' . $sp['standar_setting'] . '" data-id="' . $id . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editStandarPraCetakModal">Edit</button>                      
                              <!--      <button disabled id="tombolDeleteStandarPraCetak" type="button" data-kategori_id="' . $sp['kategori_id'] . '" data-mapel_id="' . $sp['mapel_id'] . '" data-jenjang_id="' . $sp['jenjang_id'] . '" data-standar_editing="' . $sp['standar_editing'] . '" data-standar_setting="' . $sp['standar_setting'] . '" data-id="' . $id . '"   class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStandarPraCetakModal">Delete</button> -->
                                    <button id="tombolInfoStandarPraCetak" type="button" data-tgl_update="' . date('d-M-Y H:i', $sp['last_update']) . ' WIB" data-update_oleh="' . $sp['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
                                   
                                        </td>
                                        <td scope="col">
                                        <form method="post" action="' . base_url('pengaturan/standar_waktu') . '">
                                        <button type="submit" class="btn btn-sm btn-info" id="standar_pc_id" name="standar_pc_id" value="' . $sp['standar_pc_id'] . '">Atur Model Alur Kerja</button>
                                        </form>

                                        </td>
                                    </tr>';
                                $i++;
                            }
                        endforeach;
                        ?>

                    </tbody>
                </table>

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

<!-- ModalTAMBAH-->
<div class="modal fade" id="tambahStandarPracetaklModal" tabindex="-1" aria-labelledby="tambahStandarPracetaklModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahStandarPracetaklModalLabel">Tambah Standar Pra Cetak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/standar_pracetak'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mapel</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="mapel_id" name="mapel_id">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_mapel ASC');
                                $mapel = $this->db->get('mapel')->result_array();
                                foreach ($mapel as $m) : {
                                        echo '<option value=' . $m['mapel_id'] . '>' . $m['nama_mapel'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenjang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenjang_id" name="jenjang_id">
                                <option></option>
                                <?php
                                $this->db->order_by('jenjang_id ASC');
                                $jenjang = $this->db->get('jenjang')->result_array();
                                foreach ($jenjang as $j) : {
                                        echo '<option value=' . $j['jenjang_id'] . '>' . $j['nama_jenjang'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="kategori_id" name="kategori_id">
                                <option></option>
                                <?php
                                $this->db->order_by('kategori_id ASC');
                                $kategori = $this->db->get('kategori')->result_array();
                                foreach ($kategori as $k) : {
                                        echo '<option value=' . $k['kategori_id'] . '>' . $k['nama_kategori'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- ModalEDIT-->
<div class="modal fade" id="editStandarPraCetakModal" tabindex="-1" aria-labelledby="editStandarPraCetakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStandarPraCetakModalLabel">Edit Standar Pra Cetak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/standar_pracetak'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mapel</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="mapel_id" name="mapel_id">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_mapel ASC');
                                $mapel = $this->db->get('mapel')->result_array();
                                foreach ($mapel as $m) : {
                                        echo '<option value=' . $m['mapel_id'] . '>' . $m['nama_mapel'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenjang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenjang_id" name="jenjang_id">
                                <option></option>
                                <?php
                                $this->db->order_by('jenjang_id ASC');
                                $jenjang = $this->db->get('jenjang')->result_array();
                                foreach ($jenjang as $j) : {
                                        echo '<option value=' . $j['jenjang_id'] . '>' . $j['nama_jenjang'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="kategori_id" name="kategori_id">
                                <option></option>
                                <?php
                                $this->db->order_by('kategori_id ASC');
                                $kategori = $this->db->get('kategori')->result_array();
                                foreach ($kategori as $k) : {
                                        echo '<option value=' . $k['kategori_id'] . '>' . $k['nama_kategori'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Up Date</button>
            </div>
            </form>
        </div>
    </div>
</div>




<!-- ModalDELETE-->
<div class="modal fade" id="deleteStandarPraCetakModal" tabindex="-1" aria-labelledby="deleteStandarPraCetakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStandarPraCetakModalLabel">Anda akan menghapus Standar ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/standar_pracetak'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mapel</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="mapel_id" name="mapel_id">
                                <option></option>
                                <?php
                                $this->db->order_by('nama_mapel ASC');
                                $mapel = $this->db->get('mapel')->result_array();
                                foreach ($mapel as $m) : {
                                        echo '<option value=' . $m['mapel_id'] . '>' . $m['nama_mapel'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenjang</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="jenjang_id" name="jenjang_id">
                                <option></option>
                                <?php
                                $this->db->order_by('jenjang_id ASC');
                                $jenjang = $this->db->get('jenjang')->result_array();
                                foreach ($jenjang as $j) : {
                                        echo '<option value=' . $j['jenjang_id'] . '>' . $j['nama_jenjang'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">kategori</label>
                        <div class="col-sm-9">
                            <select readonly class="form-control" id="kategori_id" name="kategori_id">
                                <option></option>
                                <?php
                                $this->db->order_by('kategori_id ASC');
                                $kategori = $this->db->get('kategori')->result_array();
                                foreach ($kategori as $k) : {
                                        echo '<option value=' . $k['kategori_id'] . '>' . $k['nama_kategori'] . '</option>';
                                    }
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- ModaINFO-->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Info Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="nama" class="col-sm-5 col-form-label">Tanggal Update Terakhir</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="tgl_update" name="tgl_update">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-5 col-form-label">Update Oleh AKun</label>
                    <div class="col-sm-7">
                        <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh">
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>


<!-- Modal EDIT TARIF PRACETAK-->
<div class="modal fade" id="editStandarTarifPraCetakModal" tabindex="-1" aria-labelledby="editStandarPraCetakTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStandarPraCetakModalLabel">Edit Tarif Pra Cetak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('pengaturan/tarif_pracetak'); ?>">

                    <div class="form-group row">
                        <label for="level_name" class="col-sm-5 col-form-label">Ilustrasi per satuan (Rp)</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-right" id="ilustrasi" name="ilustrasi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level_name" class="col-sm-5 col-form-label">Cover Per Satuan (Rp)</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-right" id="cover" name="cover">
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Up Date</button>
            </div>
            </form>
        </div>
    </div>
</div>