<?php
$Demand1	= isset($_POST['demand']) ? $_POST['demand'] : '';
$Project	= isset($_POST['projectcode']) ? $_POST['projectcode'] : '';
$CustPO		= isset($_POST['nopo']) ? $_POST['nopo'] : '';
$TransF		= isset($_POST['transferke']) ? $_POST['transferke'] : '';
$Ket		= isset($_POST['ket']) ? $_POST['ket'] : '';
$Gshift		= isset($_POST['gshift']) ? $_POST['gshift'] : '';
$Demand		= trim($Demand1);
if($_POST['cari']=="Cari"){
$sqlDB2 = " SELECT SALESORDER.EXTERNALREFERENCE,ITXVIEWKK.PROJECTCODE,ITXVIEWKK.ORDERLINE,ITXVIEWKK.PRODUCTIONORDERCODE 
FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWKK ITXVIEWKK ON SALESORDER.CODE=ITXVIEWKK.PROJECTCODE 
WHERE ITXVIEWKK.DEAMAND ='$Demand' ";
$stmt   = db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
$rowdb2 = db2_fetch_assoc($stmt);

$sqlDB21 = " SELECT EXTERNALREFERENCE FROM SALESORDERLINE WHERE ORDERLINE='$rowdb2[ORDERLINE]' AND SALESORDERCODE='$rowdb2[PROJECTCODE]' ";
	$stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	$rowdb21 = db2_fetch_assoc($stmt1);
	if($rowdb2['EXTERNALREFERENCE']!=""){
		$PO=$rowdb2['EXTERNALREFERENCE'];
	}else{
		$PO=$rowdb21['EXTERNALREFERENCE'];
	}
}
if($_POST['cekdata']=="CekData"){
	   $sqlDB2 = " SELECT SALESORDER.EXTERNALREFERENCE,ITXVIEWKK.PROJECTCODE,ITXVIEWKK.ORDERLINE,ITXVIEWKK.PRODUCTIONORDERCODE 
	   FROM DB2ADMIN.SALESORDER SALESORDER LEFT OUTER JOIN DB2ADMIN.ITXVIEWKK ITXVIEWKK ON SALESORDER.CODE=ITXVIEWKK.PROJECTCODE 
	   WHERE ITXVIEWKK.DEAMAND ='$Demand' ";
	   $stmt   = db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
	   $rowdb2 = db2_fetch_assoc($stmt);

	   $sqlDB21 = " SELECT EXTERNALREFERENCE FROM SALESORDERLINE WHERE ORDERLINE='$rowdb2[ORDERLINE]' AND SALESORDERCODE='$rowdb2[PROJECTCODE]' ";
	   $stmt1   = db2_exec($conn1,$sqlDB21, array('cursor'=>DB2_SCROLLABLE));
	   $rowdb21 = db2_fetch_assoc($stmt1);
		if($rowdb2['EXTERNALREFERENCE']!=""){
			$PO=$rowdb2['EXTERNALREFERENCE'];
		}else{
			$PO=$rowdb21['EXTERNALREFERENCE'];
		}
	   if($TransF=="GUDANG KAIN JADI"){
		   $Where1= " AND (QUALITYREASONCODE IS NULL OR QUALITYREASONCODE='100' OR QUALITYREASONCODE='FOC' OR QUALITYREASONCODE='SP') ";
	   }else if($TransF=="INSPEK MEJA"){
		   $Where1= " AND (QUALITYREASONCODE='011' OR QUALITYREASONCODE='012' OR QUALITYREASONCODE='013' 
		   OR QUALITYREASONCODE='014' OR QUALITYREASONCODE='015' OR QUALITYREASONCODE='017' ) ";
	   }else if($TransF=="GUDANG TAHANAN"){
		   $Where1= " AND (QUALITYREASONCODE='011' OR QUALITYREASONCODE='012' OR QUALITYREASONCODE='013' 
		   OR QUALITYREASONCODE='014' OR QUALITYREASONCODE='015' OR QUALITYREASONCODE='017' OR QUALITYREASONCODE='018' OR QUALITYREASONCODE='019'
		   OR QUALITYREASONCODE='020' OR QUALITYREASONCODE='021' OR QUALITYREASONCODE='022' OR QUALITYREASONCODE='023' OR QUALITYREASONCODE='024'
		   OR QUALITYREASONCODE='025' OR QUALITYREASONCODE='026' OR QUALITYREASONCODE='027' OR QUALITYREASONCODE='028' OR QUALITYREASONCODE='029'
		   OR QUALITYREASONCODE='030' OR QUALITYREASONCODE='031' OR QUALITYREASONCODE='032') ";  	   
	   }else{
		   $Where1= " AND QUALITYREASONCODE='0' ";
	   } 
	   $Where=" AND DEMANDCODE='$Demand' ";
   }else{
	   $Where=" AND DEMANDCODE='0' ";
   }
?>
<!-- Main content -->
      <div class="container-fluid">
		<form role="form" method="post" enctype="multipart/form-data" name="form1">  
		<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Data Pokok</h3>

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
			<div class="form-group row">
               <label for="demand" class="col-md-1 col-form-label">Prod. Demand</label>  
				 <div class="col-sm-2">
					<div class="input-group input-group-sm"> 
                 	<input class="form-control" value="<?php echo $Demand;?>" type="text" name="demand" id="demand" placeholder="Prod. Demand">
					<span class="input-group-append">
                   	  <button type="submit" class="btn btn-success btn-flat" value="Cari" name="cari">  <i class="fa fa-search"></i></button>
               		</span>	
					</div>	
				 </div>	 
            </div>
			<div class="form-group row">
               <label for="projectcode" class="col-md-1 col-form-label">Project Code</label>  
				 <div class="col-sm-2">
                 	<input class="form-control form-control-sm" value="<?php if($rowdb2['PROJECTCODE']!=""){echo $rowdb2['PROJECTCODE'];}else{echo $Project;}?>" type="text" name="projectcode" id="projectcode" placeholder="Project Code">	
				 </div>	 
            </div>
			<div class="form-group row">
               <label for="nopo" class="col-md-1 col-form-label">Cust. PO</label>  
				 <div class="col-sm-4">
                 	<input class="form-control form-control-sm" value="<?php if($PO!=""){echo $PO;}else{echo $CustPO;} ?>" type="text" name="nopo" id="nopo" placeholder="Cust. PO">	
				 </div>	 
            </div>  			 
			  	  
          </div>
		  
		  <!-- /.card-body -->
          
        </div> 
	<?php if($Demand!=""){ ?>		
		<div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Data Tujuan</h3>

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
               <label for="transferke" class="col-md-1 col-form-label">Transfer Ke</label> 
				 <div class="col-sm-2">
                 <select class="form-control select2bs4" style="width: 100%;" name="transferke">
				   <option value="">Pilih</option>	 
				   <option value="GUDANG KAIN JADI" <?php if($TransF=="GUDANG KAIN JADI"){echo "SELECTED"; } ?>>GUDANG KAIN JADI</option>
				   <option value="INSPEK MEJA" <?php if($TransF=="INSPEK MEJA"){echo "SELECTED"; } ?>>INSPEK MEJA</option>
				   <option value="GUDANG TAHANAN" <?php if($TransF=="GUDANG TAHANAN"){echo "SELECTED"; } ?>>GUDANG TAHANAN</option> 
                  </select>	
				 </div>	 
            </div>
				 <div class="form-group row">
                    <label for="ket" class="col-md-1 col-form-label"> Keterangan</label>
					<div class="col-sm-2"> 
					<select class="form-control select2bs4 " style="width: 100%;" name="ket">
                    <option value="">Pilih</option>	
                    <option value="EXPORT" <?php if($Ket=="EXPORT"){echo "SELECTED"; } ?>>EXPORT</option>
                    <option value="LOCAL" <?php if($Ket=="LOCAL"){echo "SELECTED"; } ?>>LOCAL</option>
					<option value="BS" <?php if($Ket=="BS"){echo "SELECTED"; } ?>>BS</option>
					<option value="BB" <?php if($Ket=="BB"){echo "SELECTED"; } ?>>BB</option>
					<option value="STOCK" <?php if($Ket=="STOCK"){echo "SELECTED"; } ?>>STOCK</option>
					<option value="TAHANAN" <?php if($Ket=="TAHANAN"){echo "SELECTED"; } ?>>TAHANAN</option>	
                  </select>	
					 </div>	
                  </div> 
			  <button class="btn btn-info" type="submit" value="CekData" name="cekdata">Cek Data</button>
          </div>
		  
		  <!-- /.card-body -->
          
        </div>	
	<?php } ?>
		  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detail Kain Jadi</h3>
				<?php if($TransF!="" AND $Ket!=""){ ?>  
				<button class="btn btn-primary float-right" type="submit" value="TransferOut" name="transferout">Transfer Out</button>
				<?php } ?>  
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example0" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">Pilih Semua <br> <input type="checkbox" name="allbox" value="check" onClick="checkAll(0);" /></th>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">SN</th>
                    <th style="text-align: center">No Rol</th>
                    <th style="text-align: center">KGs</th>
                    <th style="text-align: center">Length</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Grade</th>
                    <th style="text-align: center">Ket Grade C</th>
                    <th style="text-align: center">Ket</th>
                    </tr>
                  </thead>
                  <tbody>
<?php	
   				  
   $no=1;   
   $c=0;
   //$sqlDB22 = " SELECT * FROM ELEMENTSINSPECTION WHERE NUMBERGROUPSHIFT='1' AND NUMBERSHIFT='1' AND LENGTH(TRIM(ELEMENTCODE))= 13 $Where $Where1 ";
   $sqlDB22 = " SELECT * FROM ELEMENTSINSPECTION WHERE LENGTH(TRIM(ELEMENTCODE))= 13 $Where $Where1 ";					  
   $stmt2   = db2_exec($conn1,$sqlDB22, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb22 = db2_fetch_assoc($stmt2)){
	if($rowdb22['QUALITYCODE']==1){
		$grade="A";
	}else if($rowdb22['QUALITYCODE']==2){
		$grade="B";
	}else if($rowdb22['QUALITYCODE']==3){
		$grade="C";
	} 	
	$sqlDB23 = " SELECT LONGDESCRIPTION FROM QUALITYREASON  WHERE CODE='$rowdb22[QUALITYREASONCODE]' ";
   	$stmt3   = db2_exec($conn1,$sqlDB23, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb23 = db2_fetch_assoc($stmt3);
	$sqlDB24 = " SELECT x.LONGDESCRIPTION FROM DB2ADMIN.INSPECTIONEVENTTEMPLATE x
		WHERE (x.COMPANYCODE = '100') AND (x.ITEMTYPECODE = 'KFF') AND (x.EVENTCODE = '$rowdb22[PREDOMINANTDEFECTEVENTCODE]') ";
   	$stmt4   = db2_exec($conn1,$sqlDB24, array('cursor'=>DB2_SCROLLABLE));	
	$rowdb24 = db2_fetch_assoc($stmt4);
		
	$sql1=mysqli_query($con,"SELECT itemelement FROM tbl_prodemand WHERE itemelement='$rowdb22[ELEMENTCODE]' LIMIT 1 ") or die (mysql_error());	
	$r1=mysqli_fetch_array($sql1);
	if($r1['itemelement']==""){	
?>
	  <tr>
      <td style="text-align: center"><input type="checkbox" name="cek[<?php echo $no; ?>]" value="<?php echo $rowdb22['ELEMENTCODE']; ?>" /></td>
      <td style="text-align: center"><?php echo $no; ?></td>
      <td style="text-align: center"><?php echo $rowdb22['ELEMENTCODE']; ?></td>
      <td style="text-align: center"><?php echo substr($rowdb22['ELEMENTCODE'],8,5); ?></td>
      <td style="text-align: right"><?php echo $rowdb22['WEIGHTNET']; ?></td>
      <td style="text-align: right"><?php echo $rowdb22['LENGTHGROSS']; ?></td>
      <td style="text-align: center"><?php echo $rowdb22['LENGTHUOMCODE']; ?></td>
      <td style="text-align: center"><?php echo $grade; ?></td>
      <td style="text-align: left"><?php if($grade=="C"){echo $rowdb24['LONGDESCRIPTION'];} ?></td>
      <td style="text-align: center"><?php echo $rowdb23['LONGDESCRIPTION'];?></td>
      </tr>				  
<?php	$no++;}} ?>
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
if($_POST['transferout']=="TransferOut"){
	
function mutasiurut(){
include "koneksi.php";		
$format = "10".date("ymd");
$sql=mysqli_query($con,"SELECT transid FROM tbl_prodemand WHERE substr(transid,1,8) like '%".$format."%' ORDER BY transid DESC LIMIT 1 ") or die (mysql_error());
$d=mysqli_num_rows($sql);
if($d>0){
$r=mysqli_fetch_array($sql);
$d=$r['transid'];
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
$notid=mutasiurut();	
	
	
if($TransF=="GUDANG KAIN JADI"){
		   $Where1= " AND (QUALITYREASONCODE IS NULL OR QUALITYREASONCODE='100' OR QUALITYREASONCODE='FOC' OR QUALITYREASONCODE='SP') ";
	   }else if($TransF=="INSPEK MEJA"){
		   $Where1= " AND (QUALITYREASONCODE='011' OR QUALITYREASONCODE='012' OR QUALITYREASONCODE='013' 
		   OR QUALITYREASONCODE='014' OR QUALITYREASONCODE='015' OR QUALITYREASONCODE='017' ) ";
	   }else if($TransF=="GUDANG TAHANAN"){
		   $Where1= " AND (QUALITYREASONCODE='011' OR QUALITYREASONCODE='012' OR QUALITYREASONCODE='013' 
		   OR QUALITYREASONCODE='014' OR QUALITYREASONCODE='015' OR QUALITYREASONCODE='017' OR QUALITYREASONCODE='018' OR QUALITYREASONCODE='019'
		   OR QUALITYREASONCODE='020' OR QUALITYREASONCODE='021' OR QUALITYREASONCODE='022' OR QUALITYREASONCODE='023' OR QUALITYREASONCODE='024'
		   OR QUALITYREASONCODE='025' OR QUALITYREASONCODE='026' OR QUALITYREASONCODE='027' OR QUALITYREASONCODE='028' OR QUALITYREASONCODE='029'
		   OR QUALITYREASONCODE='030' OR QUALITYREASONCODE='031' OR QUALITYREASONCODE='032' ) ";	
	   }else{
		   $Where1= " AND QUALITYREASONCODE='0' ";
	   } 
	   $Where=" AND DEMANDCODE='$Demand' ";   	
$n=1;	
$noceklist=1;	
//$sqlDB20 = " SELECT * FROM ELEMENTSINSPECTION WHERE NUMBERGROUPSHIFT='1' AND NUMBERSHIFT='1'  AND LENGTH(TRIM(ELEMENTCODE))= 13 $Where $Where1 ";
$sqlDB20 = " SELECT * FROM ELEMENTSINSPECTION WHERE LENGTH(TRIM(ELEMENTCODE))= 13 $Where $Where1 ";	
$stmt0   = db2_exec($conn1,$sqlDB20, array('cursor'=>DB2_SCROLLABLE));
    while($rowdb20 = db2_fetch_assoc($stmt0)){
		if($_POST['cek'][$n]!='') 
		{
		$elementC=$_POST['cek'][$n];
		$sqlDB201 = " SELECT * FROM ELEMENTSINSPECTION WHERE ELEMENTCODE='$elementC' ";
   		$stmt01   = db2_exec($conn1,$sqlDB201, array('cursor'=>DB2_SCROLLABLE));
		$rowdb201 = db2_fetch_assoc($stmt01);
		if($rowdb201['QUALITYCODE']==1){
		$grade1="A";
		}else if($rowdb201['QUALITYCODE']==2){
		$grade1="B";
		}else if($rowdb201['QUALITYCODE']==3){
		$grade1="C";
		} 	
		$sqlDB202 = " SELECT LONGDESCRIPTION FROM QUALITYREASON  WHERE CODE='$rowdb20[QUALITYREASONCODE]' ";
   		$stmt02   = db2_exec($conn1,$sqlDB202, array('cursor'=>DB2_SCROLLABLE));	
		$rowdb202 = db2_fetch_assoc($stmt02);
		$sqlDB203 = " SELECT x.LONGDESCRIPTION FROM DB2ADMIN.INSPECTIONEVENTTEMPLATE x
		WHERE (x.COMPANYCODE = '100') AND (x.ITEMTYPECODE = 'KFF') AND (x.EVENTCODE = '$rowdb20[PREDOMINANTDEFECTEVENTCODE]') ";
   		$stmt03   = db2_exec($conn1,$sqlDB203, array('cursor'=>DB2_SCROLLABLE));	
		$rowdb203 = db2_fetch_assoc($stmt03);
		if($grade1=="C"){
		$ketc=$rowdb203['LONGDESCRIPTION'];	
		}else{$ketc="";}	
		mysqli_query($con,"INSERT INTO tbl_prodemand SET
		transid='$notid',
		gshift='$Gshift',
		demandcode='$rowdb201[DEMANDCODE]',
		itemelement='$rowdb201[ELEMENTCODE]',
		weight='$rowdb201[WEIGHTNET]',
		length='$rowdb201[LENGTHGROSS]',
		no_mc='$rowdb201[WINDINGMACHINE]',
		grade='$grade1',
		satuan='$rowdb201[LENGTHUOMCODE]',
		ket='$rowdb202[LONGDESCRIPTION]',
		ket_c='$ketc',
		tgl_buat=now()
		");
	   }else{
		$noceklist++;
	}
		$n++;
	}
if($noceklist==$n){

echo "<script>
  	$(function() {
    const Toast = Swal.mixin({
      toast: false,
      position: 'middle',
      showConfirmButton: false,
      timer: 2000
    });
	Toast.fire({
        icon: 'error',
        title: 'Data tidak ada yang di Ceklist'
      });
  });
  
</script>";
}
	else{
mysqli_query($con,"INSERT INTO tbl_mutasi_kain SET
		transid='$notid',
		ket='$Ket',
		tujuan='$TransF',
		gshift='$Gshift',
		tgl_buat=now()
		");
	
 echo "<script>
  	$(function() {
    const Toast = Swal.mixin({
      toast: false,
      position: 'middle',
      showConfirmButton: false,
      timer: 2000
    });
	Toast.fire({
        icon: 'success',
        title: 'Data telah di Transfer Out'
      });
  });
  
</script>";
	}
}
?>