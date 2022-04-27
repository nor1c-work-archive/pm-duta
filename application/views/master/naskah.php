<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('last_update DESC');


    if ($filter_subj['nojob'] != '') {
        $this->db->where('nojob', $filter_subj['nojob']);
    }
    if ($filter_subj['judul'] != '') {
        $this->db->like('judul', $filter_subj['judul']);
    }
    if ($filter_subj['mapel_id'] != '') {
        $this->db->where('SUBSTRING(standar_pc_id, 3, 2)=', $filter_subj['mapel_id']);
    }
    if ($filter_subj['jenjang_id'] != '') {
        $this->db->where('SUBSTRING(standar_pc_id, 1, 2)=', $filter_subj['jenjang_id']);
    }
    if ($filter_subj['kategori_id'] != '') {
        $this->db->where('SUBSTRING(standar_pc_id,5, 2)=', $filter_subj['kategori_id']);
    }


    $naskah = $this->db->get('naskah')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahNaskahModal">Tambah Naskah</button>
            <?php echo form_error('nojob', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('judul', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jilid', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('penulis', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jenjang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('mapel_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <form method="post" action="<?php echo base_url('master/naskah'); ?>">
                <div class="row mb-1">
                    <div class="col col-sm-2">
                        <input type="text" id="nojob" value="<?php echo $filter_subj['nojob']; ?>" name="nojob" class="form-control" placeholder="nojob">
                    </div>
                    <div class="col col-sm-3">
                        <input type="text" id="judul" name="judul" value="<?php echo $filter_subj['judul']; ?>" class="form-control" placeholder="judul">
                    </div>
                    <div class="col col-sm-2"">
                    <select id=" mapel_id" name="mapel_id" class="form-control">
                        <option value=''>mapel</option>
                        <?php
                        $mapel = $this->db->get('mapel')->result_array();
                        foreach ($mapel as $m) : {
                                echo '<option value="' . $m['mapel_id'] . '">' . $m['nama_mapel'] . '</option>';
                            }
                        endforeach;

                        ?>
                        </select>
                    </div>
                    <div class="col col-sm-2"">
                    <select id=" jenjang_id" name="jenjang_id" class="form-control">
                        <option value=''>jenjang</option>
                        <?php
                        $jenjang = $this->db->get('jenjang')->result_array();
                        foreach ($jenjang as $m) : {
                                echo '<option value="' . $m['jenjang_id'] . '">' . $m['nama_jenjang'] . '</option>';
                            }
                        endforeach;

                        ?>
                        </select>
                    </div>
                    <div class="col col-sm-2"">
                    <select id=" kategori_id" name="kategori_id" class="form-control">
                        <option value=''>kategori</option>
                        <?php
                        $kategori = $this->db->get('kategori')->result_array();
                        foreach ($kategori as $m) : {
                                echo '<option value="' . $m['kategori_id'] . '">' . $m['nama_kategori'] . '</option>';
                            }
                        endforeach;

                        ?>
                        </select>
                    </div>
                    <div class="col col-sm-1">
                        <button type="submit" id="filter" name="filter" value=TRUE class="btn btn-primary">Filter</button>
                    </div>
            </form>
        </div>



        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nojob</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Jilid</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Identitas</th>
                        <th scope="col">Spek</th>
                        <th scope="col">Rencana Produksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($naskah as $b) : {

                            $standar_pc_id = $b['standar_pc_id'];
                            $jenjang_id = substr($standar_pc_id, 0, 2);
                            $mapel_id = substr($standar_pc_id, 2, 2);
                            $kategori_id = substr($standar_pc_id, 4, 2);


                            echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $b['nojob'] . '</td>
                                    <td scope="col">' . $b['kode'] . '</td>
                                    <td scope="col">' . $b['judul'] . '</td>
                                    <td scope="col">' . $b['jilid'] . '</td>
                                    <td scope="col">' . $b['penulis'] . '</td>
                                    <td scope="col">
                                    <button id="tombolEditNaskah" type="button" data-kode="' . $b['kode'] . '"  data-kategori_id="' . $kategori_id . '" data-mapel_id="' . $mapel_id . '" data-jenjang_id="' . $jenjang_id . '" data-id="' . $b['id'] . '" data-nojob="' . $b['nojob'] . '" data-judul="' . $b['judul'] . '" data-jilid="' . $b['jilid'] . '" data-penulis="' . $b['penulis'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editNaskahModal">Edit</button>                      
                                    <button ';
                            $this->db->where('nojob', $b['nojob']);
                            $banyak = $this->db->get('naskah_rencana_produksi')->num_rows();

                            if ($banyak != 0) {
                                echo 'disabled';
                            }


                            echo ' id="tombolDeleteNaskah" type="button"  data-kode="' . $b['kode'] . '"  data-kategori_id="' . $kategori_id . '" data-mapel_id="' . $mapel_id . '" data-jenjang_id="' . $jenjang_id . '" data-id="' . $b['id'] . '" data-nojob="' . $b['nojob'] . '" data-judul="' . $b['judul'] . '" data-jilid="' . $b['jilid'] . '" data-penulis="' . $b['penulis'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteNaskahModal">Delete</button>
                                    <button id="tombolInfoNaskah" type="button" data-tgl_update="' . date('d-M-Y H:i', $b['last_update']) . ' WIB" data-update_oleh="' . $b['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
                                    </td>
                                    <td scope="col">
                                     <form method="post" action="' . base_url('master/spek_naskah') . '">
                                            <button type="submit" class="btn btn-sm btn-info">Lihat/Edit</button>
                                            <input type="hidden" id="nojob" name="nojob" value="' . $b['nojob'] . '">
                                    </form>
                                    
                                    </td>
                                    <td scope="col">';
                            $this->db->where('nojob', $b['nojob']);


                            $banyak = $this->db->get('naskah_rencana_produksi')->num_rows();

                            echo '     <form method="post" action="' . base_url('pengaturan/perencanaan_produksi') . '">
                                            <button type="submit" ';
                            if ($banyak == 0) {
                                echo "disabled";
                            }


                            echo ' id="lihat" name="lihat" value=TRUE class="btn btn-sm btn-info">Lihat Versi Terakhir</button>
                                            <input type="hidden" id="nojob" name="nojob" value="' . $b['nojob'] . '">
<button type="submit" id="cari" name="cari" value=TRUE class="btn btn-sm btn-success">Atur</button>
                                            
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
<div class="modal fade" id="tambahNaskahModal" tabindex="-1" aria-labelledby="tambahNaskahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahNaskahModalLabel">Tambah Naskah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/naskah'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">nojob</label>
                            <input type="text" class="form-control" id="nojob" name="nojob">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="kode">Kode</label>
                            <input type="judul" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="judul">Judul</label>
                            <input type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Jenjang</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Mapel</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Kategori</label>
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
</div>



<!-- ModalEDIT-->
<div class="modal fade" id="editNaskahModal" tabindex="-1" aria-labelledby="editNaskahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNaskahModalLabel">Edit Naskah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/naskah'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">nojob</label>
                            <input readonly type="text" class="form-control" id="nojob" name="nojob">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputAddress">kode</label>
                            <input type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="judul">Judul</label>
                            <input type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Jenjang</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Mapel</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Kategori</label>
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
                        <input type="hidden" id="id" name="id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Up Date</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- ModalDELETE-->
<div class="modal fade" id="deleteNaskahModal" tabindex="-1" aria-labelledby="deleteNaskahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNaskahModalLabel">Anda akan menghapus Naskah ini?</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/naskah'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">nojob</label>
                            <input readonly type="text" class="form-control" id="nojob" name="nojob">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputAddress">kode</label>
                            <input readonly type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="judul">Judul</label>
                            <input disabled type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input disabled type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="penulis">Penulis</label>
                            <input disabled type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Jenjang</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Mapel</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Kategori</label>
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
                        <input type="hidden" id="id" name="id">

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


<!-- ModalSPEK-->
<div class="modal fade" id="spekNaskahModal" tabindex="-1" aria-labelledby="spekNaskahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="spekNaskahModalLabel">Spek Naskah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/spek_naskah'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">nojob</label>
                            <input readonly type="text" class="form-control" id="nojob" name="nojob">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="judul">Judul</label>
                            <input disabled type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input disabled type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="penulis">Penulis</label>
                            <input disabled type="text" class="form-control" id="penulis" name="penulis">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputState">Jenjang</label>
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
                        <div class="form-group col-md-4">
                            <label for="inputState">Mapel</label>
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
                        <div class="form-group col-md-3">
                            <label for="inputState">Kategori</label>
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
                        <input type="hidden" id="id" name="id">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-success">Spek</button>
            </div>
            </form>
        </div>
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
                        <input disabled type="text" class="form-control" id="tgl_update" name="tgl_update">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-5 col-form-label">Update Oleh Akun</label>
                    <div class="col-sm-7">
                        <input disabled type="text" class="form-control" id="update_oleh" name="update_oleh">
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>