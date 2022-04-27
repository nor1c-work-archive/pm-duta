<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <?php
		$email = $user['email'];
		$this->db->order_by('kode ASC');

		if ($filter_subj['kode'] != '')
			$this->db->where('kode', $filter_subj['kode']);
		if ($filter_subj['judul'] != '')
			$this->db->like('judul', $filter_subj['judul']);
		if ($filter_subj['mapel_id'] != '')
			$this->db->where('SUBSTRING(standar_pc_id, 3, 2)=', $filter_subj['mapel_id']);
		if ($filter_subj['jenjang_id'] != '')
			$this->db->where('SUBSTRING(standar_pc_id, 1, 2)=', $filter_subj['jenjang_id']);
		if ($filter_subj['kategori_id'] != '')
			$this->db->where('SUBSTRING(standar_pc_id,5, 2)=', $filter_subj['kategori_id']);

		$current_page = $this->input->get('page');
		if ($current_page) {
			$page = $current_page-1;
		} else {
			$current_page = 1;
			$page = 0;
		}

		$temp_db = clone $this->db;
		$found_rows = $temp_db->from('buku')->count_all_results();

		$per_page = 10;
		$this->db->limit($per_page, $page*$per_page);

		$query = $this->db->get('buku');
		$buku = $query->result_array();

		$previous_number = $current_page-1;
		$pagination = '';

		$max_page = explode('.', $found_rows/$per_page)[0]+1;

		// build last 2 previous page
		$prev_page = $current_page-2;
		if ($current_page >= 3) {
			for ($i=($prev_page == 0 ? $prev_page+1 : $prev_page); $i <= $current_page-1; $i++) {
				$pagination .= '<li class="page-item"><a class="page-link" href="'.site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/?page='.$i).'">'.$i.'</a></li>';
			}
		} else {
			if ($page != 0 && $current_page != 1)
				$pagination .= '<li class="page-item"><a class="page-link" href="'.site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/?page=1').'">1</a></li>';
		}
		
		// current page
		$pagination .= '<li class="page-item active"><a class="page-link" href="'.site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/?page='.$current_page).'">'.$current_page.'</a></li>';

		// build next 2 page
		if ($i != $max_page) {
			for ($i=$current_page+1; $i <= ($current_page+2 > $max_page ? $max_page : $current_page+2); $i++) {
				$pagination .= '<li class="page-item"><a class="page-link" href="'.site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/?page='.$i).'">'.$i.'</a></li>';
			}
		}
    ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col">
            <?php echo $this->session->flashdata('pesan'); ?>
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahBukuModal">Tambah Buku</button>
            <?php echo form_error('kode', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('judul', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jilid', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('penulis', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('jenjang_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <?php echo form_error('mapel_id', '<small class="text-danger pl-3">', '</small>'); ?>
            <form method="post" action="<?php echo base_url('master/buku'); ?>">
                <div class="row mb-1">
                    <div class="col col-sm-2">
                        <input type="text" id="kode" value="<?php echo $filter_subj['kode']; ?>" name="kode" class="form-control" placeholder="kode">
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
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Jilid</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Aksi</th>
                        <th scope="col">Cetak</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = (($current_page-1)*$per_page)+1;
                    foreach ($buku as $b) : {

                            $standar_pc_id = $b['standar_pc_id'];
                            $jenjang_id = substr($standar_pc_id, 0, 2);
                            $mapel_id = substr($standar_pc_id, 2, 2);
                            $kategori_id = substr($standar_pc_id, 4, 2);


                            echo '
                                <tr>
                                    <th scope="col">' . $i . '</th>
                                    <td scope="col">' . $b['kode'] . '</td>
                                    <td scope="col">' . $b['judul'] . '</td>
                                    <td scope="col">' . $b['jilid'] . '</td>
                                    <td scope="col">' . $b['penulis'] . '</td>
                                    <td scope="col">
                                        <button id="tombolEditBuku" type="button"   data-kategori_id="' . $kategori_id . '" data-mapel_id="' . $mapel_id . '" data-jenjang_id="' . $jenjang_id . '" data-id="' . $b['id'] . '" data-kode="' . $b['kode'] . '" data-judul="' . $b['judul'] . '" data-jilid="' . $b['jilid'] . '" data-penulis="' . $b['penulis'] . '" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#editBukuModal">Edit</button>                      
                                        <button id="tombolDeleteBuku" type="button"  data-kategori_id="' . $kategori_id . '" data-mapel_id="' . $mapel_id . '" data-jenjang_id="' . $jenjang_id . '" data-id="' . $b['id'] . '" data-kode="' . $b['kode'] . '" data-judul="' . $b['judul'] . '" data-jilid="' . $b['jilid'] . '" data-penulis="' . $b['penulis'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteBukuModal">Delete</button>
                                        <button id="tombolDetailBuku" type="button"  data-kategori_id="' . $kategori_id . '" data-mapel_id="' . $mapel_id . '" data-jenjang_id="' . $jenjang_id . '" data-id="' . $b['id'] . '" data-kode="' . $b['kode'] . '" data-judul="' . $b['judul'] . '" data-jilid="' . $b['jilid'] . '" data-penulis="' . $b['penulis'] . '" class="btn btn-sm btn-secondary mr-2" data-toggle="modal" data-target="#detailBukuModal">Detail</button>                      
                                        <button id="tombolInfoBuku" type="button" data-tgl_update="' . date('d-M-Y H:i', $b['last_update']) . ' WIB" data-update_oleh="' . $b['update_oleh'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#infoModal"><span class="badge badge-light"><i class="fas fa-info"></i></span></button>
                                    </td>
                                    <td scope="col">
                                        <div class="row">
                                        <form method="post" action="' .  base_url('proses/order_cetak_baru') . '">
                                        <input type="hidden" id="kode" name="kode" value="' . $b['kode'] . '">
                                        <input type="hidden" id="cari" name="cari" value=TRUE>
                                                <button type="submit" id="dari_daftar_buku" name="dari_daftar_buku" value=TRUE class="btn btn-primary btn-sm mx-1">Order Baru</button>
                                            </form>
                                            <form method="post" action="' . base_url('proses/order_cetak') . '">
                                            <input type="hidden" id="kode" name="kode" value="' . $b['kode'] . '">
                                                <button type="submit" id="dari_daftar_buku" name="dari_daftar_buku" value=TRUE class="btn btn-success btn-sm">Riwayat</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>';
                            $i++;
                        }
                    endforeach;
                    ?>


                </tbody>
            </table>
			
			<!-- To-do: Pagination -->
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-center">
					<li class="page-item <?=$page == 0 ? "disabled" : ""?>">
						<a class="page-link" href="<?=site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'?page='.$previous_number)?>" tabindex="-1">Previous</a>
					</li>

					<?php if ($page >= 4) { ?>
						<li class="page-item">
							<a class="page-link" href="<?=site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'?page=1')?>">1</a>
						</li>	
						<li class="page-item disabled"><a class="page-link" href="#">...</a></li>
					<?php } ?>

					<?=$pagination?>

					<?php if ($page == $max_page-5) { ?>
						<li class="page-item disabled"><a class="page-link" href="#">...</a></li>
						<li class="page-item">
							<a class="page-link" href="<?=site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'?page='.$max_page)?>"><?=$max_page?></a>
						</li>	
					<?php } ?>

					<li class="page-item <?=$current_page == $max_page ? "disabled" : ""?>">
						<a class="page-link" href="<?=site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'?page='.($page+2))?>">Next</a>
					</li>
				</ul>
			</nav>

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
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBukuModalLabel">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('master/buku'); ?>">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="editBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBukuModalLabel">Edit Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/buku'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Kode</label>
                            <input readonly type="text" class="form-control" id="kode" name="kode">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
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
<div class="modal fade" id="deleteBukuModal" tabindex="-1" aria-labelledby="deleteBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBukuModalLabel">Anda akan menghapus buku ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('master/buku'); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Kode</label>
                            <input readonly type="text" class="form-control" id="kode" name="kode">
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
                        <div class="form-group col-md-4">
                            <label for="inputState">Jenjang</label>
                            <select disabled class="form-control" id="jenjang_id" name="jenjang_id">
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
                            <select disabled class="form-control" id="mapel_id" name="mapel_id">
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
                        <div class="form-group col-md-4">
                            <label for="inputState">Kategori</label>
                            <select disabled class="form-control" id="kategori_id" name="kategori_id">
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


<!-- ModalDETAIL-->
<div class="modal fade" id="detailBukuModal" tabindex="-1" aria-labelledby="detailBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailBukuModalLabel">Detail Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputAddress">Kode</label>
                        <input disabled type="text" class="form-control" id="kode" name="kode">
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
                    <div class="form-group col-md-4">
                        <label for="inputState">Jenjang</label>
                        <select disabled class="form-control" id="jenjang_id" name="jenjang_id">
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
                        <select disabled class="form-control" id="mapel_id" name="mapel_id">
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
                    <div class="form-group col-md-4">
                        <label for="inputState">Kategori</label>
                        <select disabled class="form-control" id="kategori_id" name="kategori_id">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                </div>

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
