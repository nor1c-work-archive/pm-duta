<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('nojob ASC');

    $naskah = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
    $kode = $naskah['kode'];
    $judul = $naskah['judul'];
    $jilid = $naskah['jilid'];
    $penulis = $naskah['penulis'];

    $last_update = $this->db->get_where('spek_naskah', ['nojob' => $nojob])->row()->last_update;
    $update_oleh = $this->db->get_where('spek_naskah', ['nojob' => $nojob])->row()->update_oleh;

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <form method="post" action="<?php echo base_url('master/spek_naskah'); ?>">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nojob" class="col-md-1 col-form-label text-right">Nojob</label>
                            <div class="col-md-2">
                                <input readonly type="text" class="form-control" id="nojob" name="nojob" value="<?php echo $nojob; ?>">
                            </div>
                            <label for="nojob" class="col-md-1 col-form-label text-right">Kode</label>
                            <div class="col-md-2">
                                <input readonly type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="judul" class="col-md-1 col-form-label text-right">Judul</label>
                            <div class="col-md-5">
                                <input readonly type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>">
                            </div> <label for="jilid" class="col-md-1 col-form-label text-right">Jilid</label>
                            <div class="col-md-1">
                                <input readonly type="text" class="form-control" id="jilid" name="jilid" value="<?php echo $jilid; ?>">
                            </div>
                            <label for="penulis" class="col-md-1 col-form-label text-right">Penulis</label>
                            <div class="col-md-3">
                                <input readonly type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                ?>
                <div class="card mb-2">

                    <div class="card-body">
                        <?php
                        $this->db->order_by('objek_kerja_id');
                        $objek_kerja = $this->db->get('objek_kerja')->result_array();





                        $this->db->order_by('objek_kerja_id ASC');
                        $spek_naskah = $this->db->get_where('spek_naskah', ['nojob' => $nojob])->result_array();
                        echo '
                            <div class="form-group row">
                                <label for="judul" class="col-md-2 col-form-label text-right">Update Terakhir</label>
                                <div class="col-md-2">
                                    <input readonly type="text" class="form-control" id="last_update" name="last_update" value="' . date('d-M-Y H:i', $last_update) . '">
                                </div>
                                <label for="jilid" class="col-md-2 col-form-label text-right">Oleh</label>
                                <div class="col-md-2">
                                    <input readonly type="text" class="form-control" id="update_oleh" name="update_oleh" value="' . $update_oleh . '">
                                </div>
                            </div>';
                        foreach ($objek_kerja as $ok) : {
                                $nama_objek_kerja = $ok['nama_objek_kerja'];
                                $objek_kerja_id = $ok['objek_kerja_id'];
                                $ada = $this->db->get_where('spek_naskah', ['nojob' => $nojob, 'nama_objek_kerja' => $nama_objek_kerja])->num_rows();
                                if ($ada == 0) {
                                    $this->db->set('nojob', $nojob);
                                    $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                                    $this->db->set('objek_kerja_id', $objek_kerja_id);
                                    $this->db->set('jumlah_halaman', 0);
                                    $this->db->set('last_update', now('Asia/Jakarta'));
                                    $this->db->set('update_oleh', $email);
                                    $this->db->set('is_active', 1);
                                    $this->db->insert('spek_naskah');
                                }
                                $jumlah_halaman = $this->db->get_where('spek_naskah', ['nojob' => $nojob, 'nama_objek_kerja' => $nama_objek_kerja])->row()->jumlah_halaman;
                                echo '
                                    <div class="form-group row">
                                        <label for="' . $nama_objek_kerja . '" class="col-md-2 col-form-label text-right">' . $nama_objek_kerja . '</label>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control" id="' . $objek_kerja_id . '" name="' . $objek_kerja_id . '" value="' . $jumlah_halaman . '">
                                        </div>
                                        <div class="col-md-1">
                                            <span>' . $ok['satuan'] . '</span>
                                        </div>
                                    </div>';
                            }
                        endforeach;
                        ?>
                    </div>
                </div>
                <a href="<?php echo base_url('master/naskah'); ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" id="update" name="update" value=TRUE class="btn btn-primary">Update</button>
            </form>


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
                        <div class="form-group col-md-5">
                            <label for="judul">Judul</label>
                            <input type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-5">
                            <label for="judul">Judul</label>
                            <input type="judul" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="jilid">Jilid</label>
                            <input type="text" class="form-control" id="jilid" name="jilid">
                        </div>
                        <div class="form-group col-md-4">
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


<!-- ModalSpek-->
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
                            <input disabled type="text" class="form-control" id="nojob" name="nojob">
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


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Spek</button>

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