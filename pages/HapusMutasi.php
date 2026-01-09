<?php
$Mutasi	= isset($_POST['no_mutasi']) ? $_POST['no_mutasi'] : '';
if ($_GET['no_mutasi']!=""){
	$NoMutasi=$_GET['no_mutasi'];
}else{
	$NoMutasi=$Mutasi;
}

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
                    <input name="no_mutasi" value="<?php echo $NoMutasi;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" >
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
                    <th style="text-align: center">No MC</th>
                    <th style="text-align: center">Langganan</th>
                    <th style="text-align: center">PO</th>
                    <th style="text-align: center">Order</th>
                    <th style="text-align: center">Jenis Kain</th>
                    <th style="text-align: center">No. Warna</th>
                    <th style="text-align: center">Warna</th>
                    <th style="text-align: center">L/Grm2</th>
                    <th style="text-align: center">Prd. Order</th>
                    <th style="text-align: center">Rol</th>
                    <th style="text-align: center">A</th>
                    <th style="text-align: center">B</th>
                    <th style="text-align: center">C</th>
                    <th style="text-align: center">Length</th>
                    <th style="text-align: center">Prd. Demand</th>
                    <th style="text-align: center">Tempat</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
	<?php
$no=1;   
$c=0;
$sql=mysqli_query($con,"SELECT *,count(b.transid) as jmlrol,a.transid as kdtrans, 
SUM(if(b.grade=1,weight,0)) as grade_a,SUM(if(b.grade=2,weight,0)) as grade_b,
SUM(if(b.grade=3,weight,0)) as grade_c,
SUM(if(b.grade=1 or b.grade=2,1,0)) as rol_ab,SUM(if(b.grade=3,1,0)) as rol_c,
sum(b.`length`) as panjang, group_concat(distinct b.ket_c) as ketc FROM tbl_mutasi_kain a 
LEFT JOIN tbl_prodemand b ON a.transid=b.transid 
WHERE a.no_mutasi='$NoMutasi'
GROUP BY a.transid");
while($r=mysqli_fetch_array($sql)){	
	$sqlDB2 = " SELECT LANGGANAN, BUYER, PO_NUMBER, QTY_BRUTO , SALESORDERCODE, NO_ITEM, 
SUBCODE02, SUBCODE03 ,ITEMDESCRIPTION ,LEBAR, GRAMASI,PRODUCTIONORDERCODE,
WARNA ,NO_WARNA FROM ITXVIEWLAPORANAFTERSALES WHERE CODE ='$r[demandcode]' GROUP BY CODE,NO_WARNA,WARNA,LANGGANAN, BUYER, PO_NUMBER, SALESORDERCODE, NO_ITEM, 
SUBCODE02, SUBCODE03 ,ITEMDESCRIPTION ,LEBAR, GRAMASI,PRODUCTIONORDERCODE,QTY_BRUTO ";
$stmt   = db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
$rowdb2 = db2_fetch_assoc($stmt);
	if($rowdb2['NO_ITEM']!=""){
		$item=$rowdb2['NO_ITEM'];
	}else{
		$item=trim($rowdb2['SUBCODE02'])."".trim($rowdb2['SUBCODE03']);
	}
	   ?>				  
	  <tr>
      <td style="text-align: center"><?php echo $no; ?></td>
      <td style="text-align: center"><?php echo $r['no_mc']; ?></td>
      <td style="text-align: left"><?php echo $rowdb2['LANGGANAN']."/".$rowdb2['BUYER']; ?></td>
      <td style="text-align: left"><?php echo substr($rowdb2['PO_NUMBER'], 0, 13)." ".substr($rowdb2['PO_NUMBER'], 13, 13)." ".substr($rowdb2['PO_NUMBER'], 26, 13); ?></td>
      <td style="text-align: center"><?php echo $rowdb2['SALESORDERCODE']; ?></td>
      <td style="text-align: left"><?php echo $rowdb2['ITEMDESCRIPTION']; ?></td>
      <td style="text-align: left"><?php echo substr($rowdb2['NO_WARNA'], 0, 7)." ".substr($rowdb2['NO_WARNA'], 7, 20); ?></td>
      <td style="text-align: left"><?php echo substr($rowdb2['WARNA'], 0, 7)." ".substr($rowdb2['WARNA'], 7, 20); ?></td>
      <td style="text-align: center"><?php if ($rowlth['gshift']=="KRAH") {
          echo "<center>-</center>";
      } else {
          echo number_format($rowdb2['LEBAR'],2)."x".number_format($rowdb2['GRAMASI'],2);;
      } ?></td>
      <td style="text-align: center"><?php echo $rowdb2['PRODUCTIONORDERCODE']; ?></td>
      <td style="text-align: center">
        <?php $rol=$r['jmlrol'];
		  if (($r['rol_c']>0) and ($r['rol_ab']>0)) {
          $rol1=$r['rol_ab']."+".$r['rol_c'];
      } elseif ($r['rol_c']>0) {
          $rol1=$r['rol_c'];
      } else {
          $rol1=$r['rol_ab'];
      }
      echo $rol1;?>
      </td>
      <td style="text-align: right"><?php echo $r['grade_a']; ?></td>
      <td style="text-align: right"><?php echo $r['grade_b']; ?></td>
      <td style="text-align: right"><?php echo $r['grade_c']; ?></td>
      <td style="text-align: right">
        <?php if ($rowlth['gshift']=="KRAH") {
          echo "<center>-</center>";
      } else {
          echo number_format($r['panjang'], '2', '.', ',')." ".$r['satuan'];
      } ?>
      </td>
      <td style="text-align: center"><?php echo $r['demandcode']; ?></td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><?php echo $item; ?></td>
      <td style="text-align: center">
        <div class="btn-group">
          <a href="#" class="btn btn-danger btn-sm" onclick="confirm_delete('DelMutasi-<?php echo $r['kdtrans'] ?>');"><i class="fas fa-trash"></i>
            </a>
        </div>
      </td>
      </tr>
<?php $no++; } ?>					  
				  </tbody>                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>  
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<!-- Modal Popup untuk delete-->
            <div class="modal fade" id="delPros" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
					<h4 class="modal-title">INFOMATION</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                  </div>
					<div class="modal-body">
						<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
					</div>	
                  <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
<script type="text/javascript">
              function confirm_delete(delete_url) {
                $('#delPros').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delete_link').setAttribute('href', delete_url);
              }
</script>
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