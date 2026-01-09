<?php
$Awal	= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : '';
$Gshift	= isset($_POST['gshift']) ? $_POST['gshift'] : '';
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
               <label for="tgl_awal" class="col-md-1">Tgl Transfer Out</label>
               <div class="col-md-2">  
                 <div class="input-group date" id="datepicker1" data-target-input="nearest">
                    <div class="input-group-prepend" data-target="#datepicker1" data-toggle="datetimepicker">
                      <span class="input-group-text btn-info">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input name="tgl_awal" value="<?php echo $Awal;?>" type="text" class="form-control form-control-sm" id=""  autocomplete="off" required>
                 </div>
			   </div>	
            </div>
			<div class="form-group row">
               <label for="gshift" class="col-md-1">Group Shift</label>
               <div class="col-md-1">  
                 <select name="gshift" class="form-control form-control-sm" required>
					 <option value="">Pilih</option>
					 <option value="PACKING A" <?php if($Gshift=="PACKING A"){echo "SELECTED";} ?> >PACKING A</option>
					 <option value="PACKING B" <?php if($Gshift=="PACKING B"){echo "SELECTED";} ?> >PACKING B</option>
					 <option value="PACKING C" <?php if($Gshift=="PACKING C"){echo "SELECTED";} ?> >PACKING C</option>
					 <option value="INSPEK MEJA A" <?php if($Gshift=="INSPEK MEJA A"){echo "SELECTED";} ?> >INSPEK MEJA A</option>
					 <option value="INSPEK MEJA B" <?php if($Gshift=="INSPEK MEJA B"){echo "SELECTED";} ?> >INSPEK MEJA B</option>
					 <option value="INSPEK MEJA C" <?php if($Gshift=="INSPEK MEJA C"){echo "SELECTED";} ?> >INSPEK MEJA C</option>
					 <option value="KRAH" <?php if($Gshift=="KRAH"){echo "SELECTED";} ?> >KRAH</option>
				 </select>
			   </div>	
            </div>  
				 
			  <button class="btn btn-info" type="submit">Cari Data</button>
          </div>		  
		  <!-- /.card-body -->          
        </div>  
			
		<div class="card">
              <div class="card-header">
                <h3 class="card-title">BUKTI MUTASI KAIN</h3>
				<?php if ($Awal!="" and $Gshift!=""){  ?> 
				<button class="btn btn-primary float-right" type="submit" value="MutasiKain" name="mutasikain">Mutasi Kain</button>
				<?php } ?>  
          </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example0" class="table table-sm table-bordered table-striped" style="font-size: 13px; text-align: center;">
                  <thead>
                  <tr>
                    <th valign="middle" style="text-align: center">Pilih Semua <br> <input type="checkbox" name="allbox" value="check" onClick="checkAll(0);" /></th>
                    <th valign="middle" style="text-align: center">No</th>
                    <th valign="middle" style="text-align: center">No MC</th>
                    <th valign="middle" style="text-align: center">Langganan</th>
                    <th valign="middle" style="text-align: center">PO</th>
                    <th valign="middle" style="text-align: center">Project</th>
                    <th valign="middle" style="text-align: center">Jenis Kain</th>
                    <th valign="middle" style="text-align: center">No Warna</th>
                    <th valign="middle" style="text-align: center">Warna</th>
                    <th valign="middle" style="text-align: center">L/Grm2</th>
                    <th valign="middle" style="text-align: center">Prd. Demand</th>
                    <th valign="middle" style="text-align: center">Jml Roll</th>
                    <th valign="middle" style="text-align: center">Grade A+B</th>
                    <th valign="middle" style="text-align: center">Grade C</th>
                    <th valign="middle" style="text-align: center">Keterangan (Grade C)</th>
                    <th valign="middle" style="text-align: center">Length</th>
                    <th valign="middle" style="text-align: center">Prd. Order</th>
                    <th valign="middle" style="text-align: center">Tempat</th>
                    <th valign="middle" style="text-align: center">Item</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
	 
$no=1;   
$c=0;
$sql=mysqli_query($con,"SELECT *,count(b.transid) as jmlrol,a.transid as kdtrans, 
SUM(if(b.grade=1 or b.grade=2,weight,0)) as grade_ab,SUM(if(b.grade=3,weight,0)) as grade_c,
SUM(if(b.grade=1 or b.grade=2,1,0)) as rol_ab,SUM(if(b.grade=3,1,0)) as rol_c,
sum(b.`length`) as panjang, group_concat(distinct b.ket_c) as ketc FROM tbl_mutasi_kain a 
LEFT JOIN tbl_prodemand b ON a.transid=b.transid 
WHERE isnull(a.no_mutasi) AND a.tujuan='GUDANG TAHANAN' AND date_format(a.tgl_buat ,'%Y-%m-%d')='$Awal' AND a.gshift='$Gshift'
GROUP BY a.transid");
while($r=mysqli_fetch_array($sql)){		
	
$sqlDB2 = " SELECT LANGGANAN, BUYER, PO_NUMBER, SALESORDERCODE, NO_ITEM, 
SUBCODE02, SUBCODE03 ,ITEMDESCRIPTION ,LEBAR, GRAMASI,PRODUCTIONORDERCODE,
WARNA ,NO_WARNA FROM ITXVIEWLAPORANAFTERSALES WHERE CODE ='$r[demandcode]' GROUP BY CODE,NO_WARNA,WARNA,LANGGANAN, BUYER, PO_NUMBER, SALESORDERCODE, NO_ITEM, 
SUBCODE02, SUBCODE03 ,ITEMDESCRIPTION ,LEBAR, GRAMASI,PRODUCTIONORDERCODE";
$stmt   = db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
$rowdb2 = db2_fetch_assoc($stmt);	
	if($rowdb2['NO_ITEM']!=""){
		$item=$rowdb2['NO_ITEM'];
	}else{
		$item=trim($rowdb2['SUBCODE02'])."".trim($rowdb2['SUBCODE03']);
	}
	   ?>
	  <tr>
	  <td><input type="checkbox" name="cek[<?php echo $no; ?>]" value="<?php echo trim($r['kdtrans']); ?>" /></td>
      <td style="text-align: center"><?php echo $no;?></td>
      <td style="text-align: center"><?php echo $r['no_mc'];?></td>
      <td style="text-align: left"><?php echo $rowdb2['LANGGANAN']."/".$rowdb2['BUYER']; ?></td>
      <td style="text-align: left"><?php echo $rowdb2['PO_NUMBER']; ?></td>
      <td><?php echo $rowdb2['SALESORDERCODE']; ?></td>
      <td style="text-align: left"><?php echo $rowdb2['ITEMDESCRIPTION']; ?></td>
      <td><?php echo $rowdb2['NO_WARNA']; ?></td>
      <td style="text-align: left"><?php echo $rowdb2['WARNA']; ?></td>
      <td><?php echo number_format($rowdb2['LEBAR'],2)."x".number_format($rowdb2['GRAMASI'],2); ?></td>
      <td><?php echo $r['demandcode'];?></td>
      <td><?php 
		  if (($r['rol_c']>0) and ($r['rol_ab']>0)) {
          $rol1=$r['rol_ab']."+".$r['rol_c'];
      } elseif ($r['rol_c']>0) {
          $rol1=$r['rol_c'];
      } else {
          $rol1=$r['rol_ab'];
      }
      echo $rol1;?></td>
      <td><?php echo $r['grade_ab'];?></td>
      <td><?php echo $r['grade_c'];?></td>
      <td style="text-align: left"><?php echo $r['ketc'];?></td>
      <td><?php echo $r['panjang'];?></td>
      <td><?php echo $rowdb2['PRODUCTIONORDERCODE']; ?></td>
      <td>&nbsp;</td>
      <td><?php echo $item;?></td>
      </tr>				  
	<?php 
	 $no++; } ?>
				  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div> 
	</form>		
      </div><!-- /.container-fluid -->
    <!-- /.content -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>	
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

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
<script type="text/javascript">
function checkAll(form1){
    for (var i=0;i<document.forms['form1'].elements.length;i++)
    {
        var e=document.forms['form1'].elements[i];
        if ((e.name !='allbox') && (e.type=='checkbox'))
        {
            e.checked=document.forms['form1'].allbox.checked;
			
        }
    }
}
</script>
<?php 
if($_POST['mutasikain']=="MutasiKain"){
	
function mutasiurut(){
include "koneksi.php";		
$format = "20".date("ymd");
$sql=mysqli_query($con,"SELECT no_mutasi FROM tbl_mutasi_kain WHERE substr(no_mutasi,1,8) like '%".$format."%' ORDER BY no_mutasi DESC LIMIT 1 ") or die (mysql_error());
$d=mysqli_num_rows($sql);
if($d>0){
$r=mysqli_fetch_array($sql);
$d=$r['no_mutasi'];
$str=substr($d,8,2);
$Urut = (int)$str;
}else{
$Urut = 0;
}
$Urut = $Urut + 1;
$Nol="";
$nilai=2-strlen($Urut);
for ($i=1;$i<=$nilai;$i++){
$Nol= $Nol."0";
}
$tidbr =$format.$Nol.$Urut;
return $tidbr;
}
$nomid=mutasiurut();	

$sql1=mysqli_query($con,"SELECT *,count(b.transid) as jmlrol,a.transid as kdtrans FROM tbl_mutasi_kain a 
LEFT JOIN tbl_prodemand b ON a.transid=b.transid 
WHERE isnull(a.no_mutasi) AND date_format(a.tgl_buat ,'%Y-%m-%d')='$Awal' AND a.gshift='$Gshift' 
GROUP BY a.transid");
$n1=1;
$noceklist1=1;	
while($r1=mysqli_fetch_array($sql1)){	
	if($_POST['cek'][$n1]!='') 
		{
		$transid1 = $_POST['cek'][$n1];
		mysqli_query($con,"UPDATE tbl_mutasi_kain SET
		no_mutasi='$nomid',
		tgl_mutasi=now()
		WHERE transid='$transid1'
		");
		}else{
			$noceklist1++;
	}
	$n1++;
	}
if($noceklist1==$n1){
	echo "<script>
  	$(function() {
    const Toast = Swal.mixin({
      toast: false,
      position: 'middle',
      showConfirmButton: false,
      timer: 2000
    });
	Toast.fire({
        icon: 'info',
        title: 'Data tidak ada yang di Ceklist',
		
      })
  });
  
</script>";	
}else{	
echo "<script>
	$(function() {
    const Toast = Swal.mixin({
      toast: false,
      position: 'middle',
      showConfirmButton: true,
      timer: 6000
    });
	Toast.fire({
  title: 'Data telah di Mutasi',
  text: 'klik OK untuk Cetak Bukti Mutasi',
  icon: 'success',  
}).then((result) => {
  if (result.isConfirmed) {
    	window.open('pages/cetak/cetak_mutasi_ulang.php?mutasi=$nomid', '_blank');
  }
})
  });
	</script>";
	
/*echo "<script>
	Swal.fire({
  title: 'Data telah di Mutasi',
  text: 'klik OK untuk Cetak Bukti Mutasi',
  icon: 'success',  
}).then((result) => {
  if (result.isConfirmed) {
    	window.location='Mutasi';
  }
});
	</script>";	*/
}
}
?>