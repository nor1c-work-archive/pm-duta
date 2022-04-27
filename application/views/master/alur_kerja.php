<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <?php
    $email = $user['email'];
    $this->db->order_by('alur_kerja_id ASC');
    $alur_kerja = $this->db->get('alur_kerja')->result_array();

    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahAlurKerjaModal">Tambah Alur Kerja </button>
            <?php echo form_error('alur_kerja_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('nama_alur_kerja', '<small class="text-danger pl-3">', '</small>'); ?>


            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Alur Kerja ID</th>
                            <th scope="col">Nama Alur Kerja</th>
                            <th scope="col">Identitas</th>
                            <th scope="col">Detail</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($alur_kerja as $ak) : {

                                echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $ak['alur_kerja_id'] . '</td>
                                    <td scope="col">' . $ak['model_alur_kerja'] . '</td>
                 
                                    <td scope="col">
                                    <button id="tombolEditAlurKerja" type="button" data-alur_kerja_id="' . $ak['alur_kerja_id'] . '"  data-model_alur_kerja="' . $ak['model_alur_kerja'] . '"  class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editAlurKerjaModal">Edit</button>                      
                                    <button id="tombolDeleteAlurKerja" type="button"  data-alur_kerja_id="' . $ak['alur_kerja_id'] . '"  data-model_alur_kerja="' . $ak['model_alur_kerja'] . '"  class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAlurKerjaModal">Delete</button>
                                    <button id="tombolInfoAlurKerja" type="button" data-tgl_update="' . date('d-M-Y H:i', $ak['last_update']) . ' WIB" data-update_oleh="' . $ak['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
                                    </td>
                                    <td scope="col">
                                     <form method="post" action="' . base_url('master/detail_alur_kerja') . '">
                                            <button type="submit" class="btn btn-sm btn-success">Lihat/Edit</button>
                                            <input type="hidden" id="alur_kerja_id" name="alur_kerja_id" value="' . $ak['alur_kerja_id'] . '">
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
<div class="modal fade" id="tambahAlurKerjaModal" tabindex="-1" aria-labelledby="tambahAlurKerjaModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('master/alur_kerja'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAlurKerjaModalLabel">Tambah Alur Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="inputAddress">Alur Kerja ID</label>
                            <input type="text" class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode">Model Alur Kerja</label>
                            <input type="judul" class="form-control" id="model_alur_kerja" name="model_alur_kerja">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="tambah" name="tambah" value=TRUE class="btn btn-success">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>




<!-- ModalEDIT-->
<div class="modal fade" id="editAlurKerjaModal" tabindex="-1" aria-labelledby="editAlurKerjaModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo base_url('master/alur_kerja'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlurKerjaModalLabel">Edit Alur Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="inputAddress">Alur Kerja ID</label>
                            <input readonly type="text" class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode">Model Alur Kerja</label>
                            <input type="judul" class="form-control" id="model_alur_kerja" name="model_alur_kerja">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="edit" name="edit" value=TRUE class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>




<!-- ModalDELETE-->
<div class="modal fade" id="deleteAlurKerjaModal" tabindex="-1" aria-labelledby="deleteAlurKerjaModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo base_url('master/alur_kerja'); ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAlurKerjaModalLabel">Anda akan menghapus Alur Kerja ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="inputAddress">Alur Kerja ID</label>
                            <input readonly type="text" class="form-control" id="alur_kerja_id" name="alur_kerja_id">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kode">Model Alur Kerja</label>
                            <input readonly type="judul" class="form-control" id="model_alur_kerja" name="model_alur_kerja">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>

    </form>
</div>



<!-- Modaldetail-->
<div class="modal fade" id="detailAlurKerjaModal" tabindex="-1" aria-labelledby="detailAlurKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailAlurKerjaModalLabel">detail Alur Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/detail_alur_kerja'); ?>">
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
                <button type="submit" id="delete" name="delete" value=TRUE class="btn btn-success">detail</button>
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