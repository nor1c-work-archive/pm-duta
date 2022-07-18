<style>
  #customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }
  
  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  #customers tr:nth-child(even){background-color: #f2f2f2;}
  
  #customers tr:hover {background-color: #ddd;}
  
  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
</style>

<!-- content -->
<div style="width:230px;float:right;">
  <b>Tanggal : <?php echo $this->input->get("mulai").' - '.$this->input->get("sampai"); ?></b>
  <br><br>
</div>


<div class="row">
	<div class="col-md-12">
		<table id="customers">
			<thead class="text-white alert-success">
				<tr>
					<th style="text-align:center;">No</th>
					<th style="text-align:center;">NIK</th>
					<th style="text-align:center;">Nama</th>
					<th style="text-align:center;">Hari</th>
					<th style="text-align:center;">Tanggal</th>
					<th style="text-align:center;">Waktu Datang</th>
					<th style="text-align:center;">Datang Melalui</th>
					<th style="text-align:center;">Waktu Pulang</th>
					<th style="text-align:center;">Pulang Melalui</th>
					<th style="text-align:center;">Keterangan</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          $no = 1;
          foreach ($data as $attendance) {
        ?>
          <tr>
            <td><?=$no++?></td>
            <td><?=$attendance->nik?></td>
            <td><?=$attendance->nama?></td>
            <td><?=$attendance->hari?></td>
            <td><?=$attendance->tanggal?></td>
            <td><?=$attendance->jam_datang?></td>
            <td><?=$attendance->ip_datang?></td>
            <td><?=$attendance->jam_pulang?></td>
            <td><?=$attendance->ip_pulang?></td>
            <td><?=$attendance->keterangan?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  window.print()
  window.close()
</script>