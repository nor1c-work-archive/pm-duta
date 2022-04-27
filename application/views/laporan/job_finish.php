<?php
if ($this->input->get('excel')) {
	header('Content-Type: application/force-download');
	header('Content-disposition: attachment; filename=Laporan_Pekerjaan__'.date('Y-m-d H:i:s').'.xls');
	header("Pragma: ");
	header("Cache-Control: ");
}
?>
<link href="<?php echo base_url(''); ?>assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<style>
	td {
		vertical-align: middle !important;
	}
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="row">




        <!-- Content Column -->
        <div class="col">
            <?php if (!$print_mode) { ?>
							<form method="post" action="<?php echo base_url('laporan/job_finish'); ?>">
                <div class="form-row">

                    <label for="staticEmail" class="col-sm-1 col-form-label text-right">Dari tanggal</label>

                    <div class="col col-sm-2">
                        <input id="dari_tanggal" name="dari_tanggal" value="<?php echo $dari_tanggal; ?>" />
                        <script>
                            $('#dari_tanggal').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'dd-mm-yyyy'
                            });
                        </script>
                    </div>
                    <label for="staticEmail" class="col-sm-2 col-form-label text-right">sampai tanggal</label>

                    <div class="col col-sm-2">
                        <input id="sampai_tanggal" name="sampai_tanggal" value="<?php echo $sampai_tanggal; ?>" />
                        <script>
                            $('#sampai_tanggal').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'dd-mm-yyyy'
                            });
                        </script>
                    </div>

					<div class="col col-sm-2">
						<select class="custom-select my-1 mr-sm-2" id="level_kerja" name="level_kerja">
							<option value="all" <?=($this->input->post('level_kerja') == 'all' ? 'selected' : '')?>>All</option>
							<?php
								$this->db->where('urutan !=', NULL);
								$level_kerja = $this->db->get('level_kerja')->result_array();
								foreach ($level_kerja as $lk) {
									echo '<option '.($lk['inisial_level_kerja']==$this->input->post('level_kerja') ? 'selected' : '').' value="' . $lk['inisial_level_kerja'] . '">' . $lk['inisial_level_kerja'] . '</option>';
								}
							?>
						</select>
					</div>

                    <div class="col">
                        <button type="submit" id="filter" name="filter" value=TRUE class="btn btn-primary mr-2">Filter</button>
												<a target="_blank" href="<?=site_url('laporan/job_finish_print?startdate='.str_replace('-', '/', date('m/d/Y', strtotime($dari_tanggal))).'&enddate='.str_replace('-', '/', date('m/d/Y', strtotime($sampai_tanggal))).'&level_kerja='.$this->input->post('level_kerja'))?>" class="btn btn-info">PDF</a>
												<a target="_blank" href="<?=site_url('laporan/job_finish_print?excel=true&startdate='.str_replace('-', '/', date('m/d/Y', strtotime($dari_tanggal))).'&enddate='.str_replace('-', '/', date('m/d/Y', strtotime($sampai_tanggal))).'&level_kerja='.$this->input->post('level_kerja'))?>" class="btn btn-success">Excel</a>
                    </div>
                </div>
            </form>
						<?php } ?>

						<?php if ($print_mode) { ?>
							<h4 style="text-align:center;padding:50px 0;"><b>Laporan Pekerjaan per Tanggal <?=date('d/m/Y', strtotime($this->input->get('startdate'))) . "-" . date('d/m/Y', strtotime($this->input->get('enddate')))?></b></h4>
						<?php } ?>

            <div class="table-responsive mt-1">
                <table class="table table-bordered table-sm" style="font-size: small;">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No Job</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Jilid</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Objek</th>
							<th scope="col">Level Kerja</th>
                            <th scope="col">Tgl Mulai</th>
                            <th scope="col">Tgl Selesai</th>
                            <?php if (!$print_mode) { echo '<th scope="col">Aksi</th>'; } ?>
                        <tr>
                    </thead>
                    <tbody>
                        <?php
							$i = 1;
							$tr = '';
							foreach ($jobs as $jf) {
								$naskah_rencana_produksi_id = $jf['naskah_rencana_produksi_id'];
								$last_update = $jf['last_update'];
								$tanggal_finish = date('d-m-Y H:m', $last_update) . ' WIB';
								$nojob = substr($naskah_rencana_produksi_id, 0, 6);
								$naskah = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
								$judul = $naskah['judul'];
								$jilid = $naskah['jilid'];
								$penulis = $naskah['penulis'];
								$detail_alur_kerja_id = $jf['detail_alur_kerja_id'];
								$detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row_array();
								$nama_objek_kerja = $detail_alur_kerja['nama_objek_kerja'];
								
								$tgl_mulai = $jf['mulai_real'] != '' ? date('d-m-Y', strtotime($jf['mulai_real'])) : '-';
								$tgl_selesai = $jf['selesai_real'] != '' ? date('d-m-Y', strtotime($jf['selesai_real'])) : '-';

								if ($jf['latest'] == 1 /* || $jf['urutan'] == $this->input->post('level_kerja')*/) {
									$tr .= '<tr style="vertical-align:center">
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $i . '</td>
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $nojob . '</td>
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $judul . '</td>
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $jilid . '</td>
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $penulis . '</td>
										<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).'>' . $nama_objek_kerja . '</td>
										<td scope="col">' . $jf['inisial_level_kerja'] . '</td>
										<td scope="col">' . $tgl_mulai . '</td>
										<td scope="col">' . $tgl_selesai . '</td>'.
										(!$print_mode ? '<td scope="col" rowspan='.($jf_count[$jf['naskah_rencana_produksi_id']]+1).' style="text-align:center">
											<form target="_blank" method="post" action="' . base_url('laporan/job') . '">
												<input type="hidden" id="nojob" name="nojob" value="' . $nojob . '">
												<button type="submit" id="cari" name="cari" value=TRUE class="btn btn-primary btn-sm">
													Detail Job ini
												</button>
											</form>
										</td>' : '')
									.'<tr>';
									$i++;
								} else {
									if (in_array($jf['naskah_rencana_produksi_id'], $naskahs)) {
										$tr .= '<tr style="vertical-align:center">
													<td scope="col">' . $jf['inisial_level_kerja'] . '</td>
													<td scope="col">' . $tgl_mulai . '</td>
													<td scope="col">' . $tgl_selesai . '</td>
												</tr>';
									}
								}
							}

							echo $tr;
						?>
                    </tbody>
                </table>
            </div>
          <br>
          <br>
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
<a class=" scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php if ($print_mode) { ?>
	<script>
		window.print();
	</script>
<?php } ?>