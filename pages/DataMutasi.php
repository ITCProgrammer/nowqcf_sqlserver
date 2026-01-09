<?php
$Mutasi	= isset($_POST['no_mutasi']) ? $_POST['no_mutasi'] : '';
$Demand	= isset($_POST['demandno']) ? $_POST['demandno'] : '';
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Filter Data</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->		  
          <div class="card-body">
             <div class="form-group row">
               <label for="no_mutasi" class="col-md-1">No Mutasi</label>
               <div class="col-md-2"> 
                    <input name="no_mutasi" value="<?php echo $Mutasi;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" >
                 </div>
			   	
            </div>
			<div class="form-group row">
               <label for="demandno" class="col-md-1">Prd. Demand</label>
               <div class="col-md-2"> 
                    <input name="demandno" value="<?php echo $Demand;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" >
                 </div>
			   	
            </div>
				 
			  <button class="btn btn-primary" type="submit">Cari Data</button>
          </div>		  
		  <!-- /.card-body -->          
        </div>  
		</form>	
		<div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mutasi Kain</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">No Mutasi</th>
                    <th style="text-align: center">Prod. Demand</th>
                    <th style="text-align: center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
	<?php
if($Demand!=""){
	$WDemand=" AND b.demandcode='$Demand' ";
}else{ $WDemand=""; }	 
if($Mutasi!=""){
	$WMutasi=" AND a.no_mutasi='$Mutasi' ";
}else{ $WMutasi=""; }
$no=1;   
$c=0;
$sql=mysqli_query($con,"SELECT a.no_mutasi, group_concat( distinct b.demandcode) as demand  FROM tbl_mutasi_kain a
left join tbl_prodemand b on a.transid=b.transid  
WHERE not isnull(a.no_mutasi) $WMutasi $WDemand GROUP BY a.no_mutasi LIMIT 100");
while($r=mysqli_fetch_array($sql)){				  
	   ?>				  
	  <tr>
      <td style="text-align: center"><?php echo $no; ?></td>
      <td style="text-align: center"><?php echo $r['no_mutasi']; ?></td>
      <td style="text-align: center"><?php echo $r['demand']; ?></td>
      <td style="text-align: center">
        <div class="btn-group">
          <a href="pages/cetak/cetak_mutasi_ulang.php?mutasi=<?php echo $r['no_mutasi']; ?>" class="btn btn-success btn-xs" target="_blank"><i class="fas fa-print"></i>
            <span>Cetak</span></a>	
          <button type="button" class="btn btn-primary btn-xs">
            <i class="fas fa-upload"></i>
            <span>Stok</span>
            </button>
          <button type="button" class="btn btn-warning btn-xs">
            <i class="fas fa-times-circle"></i>
            <span>Stok Masalah</span>
            </button>
          </div>
      </td>
      </tr>
<?php $no++; } ?>					  
				  </tbody>
                  <!--<tfoot>
                  <tr>
                    <th>No</th>
                    <th>No Mc</th>
                    <th>Sft</th>
                    <th>User</th>
                    <th>Operator</th>
					<th>Leader</th>
                    <th>NoArt</th>
                    <th>TgtCnt (100%)</th>
                    <th>Rpm</th>
                    <th>Cnt/Roll</th>
					<th>Jam Kerja</th>
				    <th>Count</th>
				    <th>Count</th>
				    <th>RL</th>
				    <th>Kgs</th>
				    <th>Grp</th>
      				<th>Tgt Grp (%)</th>
      				<th>Eff (%)</th>
      				<th>Hasil (%)</th>  
				    <th>Kd</th>
				    <th>Min</th>
				    <th>Kd</th>
				    <th>Min</th>
				    <th>Kd</th>
				    <th>Min</th> 
					<th>Tanggal</th>
      				<th>Keterangan</th>
                  </tr>
                  </tfoot>-->
                </table>
              </div>
              <!-- /.card-body -->
            </div>  
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<script>
	$(function () {
		//Datepicker
    $('#datepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker1').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker2').datetimepicker({
      format: 'YYYY-MM-DD'
    });
	
});		
</script>