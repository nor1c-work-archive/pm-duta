<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->

	<?php
	$email = $user['email'];
	$nama = $user['nama'];
	$foto = $user['foto'];
	$level_id = $user['level_id'];
	$level_name = $this->db->get_where('user_level', ['level_id' => $user['level_id']])->row()->level_name;
	?>

	<!-- Content Row -->
	<div class="row">

		<!-- Content Column -->
		<div class="col-lg-6 mb-4">
			<?php echo $this->session->flashdata('pesan'); ?>
			<div class="card mb-3" style="max-width: 540px;">
				<div class="row no-gutters">
					<div class="col-md-6">
						<img class="img-fluid p-3" src="<?php echo base_url('assets/img/profil/') . $foto; ?>">
					</div>
					<div class="col-md-6">
						<div class="card-body">
							<form>
								<div class="form-group">
									<label for="nama">Nama</label>
									<input type="text" readonly class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" readonly class="form-control" id="email" nama="email" value="<?php echo $email; ?>">
								</div>
								<div class="form-group">
									<label for="email">Level</label>
									<input type="text" readonly class="form-control" id="email" nama="email" value="<?php echo $level_name; ?>">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<a href="<?php echo base_url('user/edit_profil'); ?>" class="btn btn-success">Edit</a>

		</div>

		<div class="col-md-6 mb-9">

			<?php if ($level_id != 7) { ?>
				<div class="gallery">
					<center><a target="_blank" href="http://absensi.penerbitduta.top/">
							<img class="img-fluid p-3 mt-3" src="<?php echo base_url('assets/img/') . 'iconpermintaan.png'; ?>" width="300" height="200">
						</a></center><br>
					<center>Login Absensi Karyawan <br></center>
					<center><a href="http://absensi.penerbitduta.top/" target="_blank" rel="nofollow" class="btn" title="Aplikasi Absensi Penerbit Duta">Go</a></center>
				</div>
			<?php } ?>




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





<style>
	* {
		box-sizing: border-box;
	}

	.row::after {
		content: "";
		clear: both;
		display: table;
	}

	[class*="col-"] {
		display: inline-block;
		padding: 15px;
	}

	html {
		font-family: "Lucida Sans", sans-serif;
		background-color: #89D1D3;
		display: inline-block;
	}

	.menu ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
	}

	.menu li {
		padding: 8px;
		margin-bottom: 7px;
		background-color: #33b5e5;
		color: #ffffff;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
	}

	.menu li:hover {
		background-color: #0099cc;
	}

	.aside {
		background-color: #33b5e5;
		padding: 15px;
		color: #0099cc;
		font-size: 14px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
	}

	.desc {
		padding: 50px;
		text-align: center;
	}

	/* For mobile phones: */
	[class*="col-"] {
		width: 100%;
	}

	@media only screen and (min-width: 600px) {

		/* For tablets: */
		.col-s-1 {
			width: 8.33%;
		}

		.col-s-2 {
			width: 16.66%;
		}

		.col-s-3 {
			width: 25%;
		}

		.col-s-4 {
			width: 33.33%;
		}

		.col-s-5 {
			width: 41.66%;
		}

		.col-s-6 {
			width: 50%;
		}

		.col-s-7 {
			width: 58.33%;
		}

		.col-s-8 {
			width: 66.66%;
		}

		.col-s-9 {
			width: 75%;
		}

		.col-s-10 {
			width: 83.33%;
		}

		.col-s-11 {
			width: 91.66%;
		}

		.col-s-12 {
			width: 100%;
			margin-left: auto;
			margin-right: auto;
		}
	}

	@media only screen and (min-width: 768px) {

		/* For desktop: */
		.col-1 {
			width: 8.33%;
		}

		.col-2 {
			width: 16.66%;
		}

		.col-3 {
			width: 25%;
		}

		.col-4 {
			width: 33.33%;
		}

		.col-5 {
			width: 41.66%;
		}

		.col-6 {
			width: 50%;
			margin-left: auto;
			margin-right: auto;
		}

		.col-7 {
			width: 58.33%;
		}

		.col-8 {
			width: 66.66%;
		}

		.col-9 {
			width: 75%;
		}

		.col-10 {
			width: 83.33%;
		}

		.col-11 {
			width: 91.66%;
		}

		.col-12 {
			width: 100%;
		}
	}






	.btn {
		background-color: #fff;
		border: none;
		color: black;
		padding: 8px 16px;
		text-align: center;
		font-size: 16px;
		padding-bottom: -15px;
		transition: 0.3s;
		text-decoration: none;
	}

	.btn:hover {
		background-color: #fff;
		color: black;

	}
</style>
