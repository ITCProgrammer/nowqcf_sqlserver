<?php 
ini_set("error_reporting",1);
include("../../koneksi.php");
?>
<html>

  <head>
    <title>:: Cetak SERAH TERIMA KAIN TAHANAN</title>
    <link href="styles_cetak.css" rel="stylesheet" type="text/css">
    <style>
      input{
text-align:center;
border:hidden;
}
@media print {
  ::-webkit-input-placeholder { /* WebKit browsers */
      color: transparent;
  }
  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
      color: transparent;
  }
  ::-moz-placeholder { /* Mozilla Firefox 19+ */
      color: transparent;
  }
  :-ms-input-placeholder { /* Internet Explorer 10+ */
      color: transparent;
  }
}
</style>
    <link rel="icon" type="image/png" href="../../images/icon.png">
  </head>

  <body>


    <table width="100%" border="0" class="table-list1">
      <tr>
        <?php    
    $lth=mysqli_query($con,"SELECT *,now() as tgl_skrng FROM tbl_mutasi_kain WHERE no_mutasi='$_GET[mutasi]'");
    $rowlth=mysqli_fetch_array($lth);
    ?>
        <div align="center">
          <h2>SERAH TERIMA KAIN TAHANAN</h2>
        </div>
        <?php ?>
        <td colspan="21"><table width="100%" class="table-list1">
          <tr>
            <td width="79%"><b>Tanggal : <?php echo date("d F Y", strtotime($rowlth['tgl_mutasi']));?> <br>
              GROUP SHIFT:
              <?php
 echo $rowlth['gshift']; ?>
              <br>
              SHIFT :
              <?php
  /* if(date("H:i:s",strtotime($rowlth['tanggal_update']))>="23:00:00" && date("H:i:s",strtotime($rowlth['tanggal_update']))<="06:59:59")
  {$rsift=3;}
  else  */if (date("H:i:s", strtotime($rowlth['tgl_mutasi']))>="07:00:00" && date("H:i:s", strtotime($rowlth['tgl_mutasi']))<="14:59:59") {
      $rsift=1;
  } elseif (date("H:i:s", strtotime($rowlth['tgl_mutasi']))>="15:00:00" && date("H:i:s", strtotime($rowlth['tgl_mutasi']))<="22:59:59") {
      $rsift=2;
  } else {
      $rsift=3;
  }
 echo $rsift;?>
              <br>
              No Mutasi : <?php echo $rowlth['no_mutasi'];?></b></td>
            <td width="21%"><table width="100%" border="0" class="table-list1">
              <tr>
                <td width="43%" scope="col">No Form</td>
                <td width="10%" scope="col">:</td>
                <td width="47%" scope="col">&nbsp;</td>
              </tr>
              <tr>
                <td>No. Revisi</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tgl. Terbit</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td rowspan="3" bgcolor="#F5F5F5">No MC</td>
        <td rowspan="3" bgcolor="#F5F5F5">Langganan</td>
        <td rowspan="3" bgcolor="#F5F5F5">PO</td>
        <td rowspan="3" bgcolor="#F5F5F5">Order</td>
        <td rowspan="3" bgcolor="#F5F5F5" style="width:1.5in;">Jenis Kain</td>
        <td rowspan="3" bgcolor="#F5F5F5">No. Warna</td>
        <td rowspan="3" bgcolor="#F5F5F5">Warna</td>
        <td rowspan="3" bgcolor="#F5F5F5">L/Grm<sup>2</sup></td>
        <td rowspan="3" bgcolor="#F5F5F5">Prd. Order</td>
        <td rowspan="3" bgcolor="#F5F5F5" style="width:0.05in;">Jml. Roll</td>
        <td colspan="4" bgcolor="#F5F5F5">Netto (KG)</td>
        <td rowspan="3" bgcolor="#F5F5F5">
          <?php if ($rowlth['gshift']=="KRAH") {
     echo "PCS";
 } else {
     echo "Yard / Meter";
 } ?>
        </td>
        <td rowspan="3" bgcolor="#F5F5F5">Prd. Demand</td>
        <td rowspan="3" bgcolor="#F5F5F5">Tempat</td>
        <td rowspan="3" bgcolor="#F5F5F5">Item.</td>
      </tr>
      <tr align="center" bgcolor="#0099FF">
        <td colspan="3" bgcolor="#F5F5F5">Grade</td>
        <td rowspan="2" bgcolor="#F5F5F5">Keterangan<br />(Grade C)</td>
      </tr>
      <tr align="center" bgcolor="#0099FF">
        <td bgcolor="#F5F5F5">A</td>
        <td bgcolor="#F5F5F5">B</td>
        <td bgcolor="#F5F5F5"> C</td>
      </tr>
      <?php 
 $sql=mysqli_query($con,"SELECT *,count(b.transid) as jmlrol,a.transid as kdtrans, 
SUM(if(b.grade=1,weight,0)) as grade_a,SUM(if(b.grade=2,weight,0)) as grade_b,
SUM(if(b.grade=3,weight,0)) as grade_c,
SUM(if(b.grade=1 or b.grade=2,1,0)) as rol_ab,SUM(if(b.grade=3,1,0)) as rol_c,
sum(b.`length`) as panjang, group_concat(distinct b.ket_c) as ketc FROM tbl_mutasi_kain a 
LEFT JOIN tbl_prodemand b ON a.transid=b.transid 
WHERE a.no_mutasi='$_GET[mutasi]'
GROUP BY a.transid");
$totqty=0;
$totqty1=0;
$grab=0;
$grc=0;
  while ($row=mysqli_fetch_array($sql)) {
	 $sqlDB2 = " SELECT LANGGANAN, BUYER, PO_NUMBER, QTY_BRUTO , SALESORDERCODE, NO_ITEM, 
SUBCODE02, SUBCODE03 ,ITEMDESCRIPTION ,LEBAR, GRAMASI,PRODUCTIONORDERCODE,
WARNA ,NO_WARNA FROM ITXVIEWLAPORANAFTERSALES WHERE CODE ='$row[demandcode]' GROUP BY CODE,NO_WARNA,WARNA,LANGGANAN, BUYER, PO_NUMBER, SALESORDERCODE, NO_ITEM, 
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
        <td>
          <font size="-2">
            <?php echo $row['no_mc']; ?>
          </font>
        </td>

        <td>
          <font size="-2">
            <?php echo $rowdb2['LANGGANAN']."/".$rowdb2['BUYER']; ?>
          </font>
        </td>
        <td>
          <font size="-2">
            <?php echo substr($rowdb2['PO_NUMBER'], 0, 13)." ".substr($rowdb2['PO_NUMBER'], 13, 13)." ".substr($rowdb2['PO_NUMBER'], 26, 13); ?>
          </font>
        </td>
        <td>
          <font size="-2">
            <?php echo substr($rowdb2['SALESORDERCODE'], 0, 6)." ".substr($rowdb2['SALESORDERCODE'], 6, 15); ?>
          </font>
        </td>
        <td>
          <font size="-2">
            <?php echo $rowdb2['ITEMDESCRIPTION']; ?>
          </font>
        </td>
        <td>
          <font size="-2">
            <?php echo substr($rowdb2['NO_WARNA'], 0, 7)." ".substr($rowdb2['NO_WARNA'], 7, 20); ?>
        </td>
        <td>
          <font size="-2">
            <?php echo substr($rowdb2['WARNA'], 0, 7)." ".substr($rowdb2['WARNA'], 7, 20); ?>
        </td>
        <td>
          <font size="-2">
            <?php if ($rowlth['gshift']=="KRAH") {
          echo "<center>-</center>";
      } else {
          echo number_format($rowdb2['LEBAR'],2)."x".number_format($rowdb2['GRAMASI'],2);;
      } ?>
        </td>
        <td><font size="-2"><?php echo $rowdb2['PRODUCTIONORDERCODE']; ?></font></td>
        <td align="right">
          <font size="-2">
            <?php $rol=$row['jmlrol'];
		  if (($row['rol_c']>0) and ($row['rol_ab']>0)) {
          $rol1=$row['rol_ab']."+".$row['rol_c'];
      } elseif ($row['rol_c']>0) {
          $rol1=$row['rol_c'];
      } else {
          $rol1=$row['rol_ab'];
      }
      echo $rol1;?>
          </font>
        </td>
        <td align="right">
          <font size="-2">
            <?php	echo number_format($row['grade_a'], '2', '.', ','); ?>
          </font>
        </td>
        <td align="right">
		  <font size="-2">
            <?php	echo number_format($row['grade_b'], '2', '.', ','); ?>
          </font></td>
        <td align="right">
          <font size="-2">
            <?php echo number_format($row['grade_c'], '2', '.', ','); ?>
          </font>
        </td>
        <td>
          <font size="-2">
            <?php if ($row['sisa']=="SISA" || $row['sisa']=="FKSI") {
          echo "SISA";
      } elseif ($row['sisa']=="FOC") {
          echo "EXTRA FULL";
      } elseif ($row['sisa']=="BS") {
          echo "BS";
      }
      echo " ".$row['ketc']; ?>
          </font>
        </td>
        <td align="right">
          <font size="-2">
            <?php if ($rowlth['gshift']=="KRAH") {
          echo "<center>-</center>";
      } else {
          echo number_format($row['panjang'], '2', '.', ',')." ".$row['satuan'];
      } ?>
          </font>
        </td>
        <td><font size="-2"><?php echo $row['demandcode']; ?></font></td>
        <td>&nbsp;</td>
        <td>
          <font size="-2">
            <?php echo $item; ?>
          </font>
        </td>
      </tr>

      <?php
     if ($row['sisa']=="SISA" || $row['sisa']=="FKSI" || $row['sisa']=="FOC") {
         $brtoo=0;
     } else {
         $brtoo=$row['bruto'];
     }
      $grdab=$grab;
      $grdc=$grc;
      $totbruto=$totbruto+$brtoo;
      $totyard=$totyard+$row['panjang'];
      $totrol=$totrol+$rol;
      $totqty=$totqty+$row['grade_ab'];
	  $totqtya=$totqtya+$row['grade_a'];
	  $totqtyb=$totqtyb+$row['grade_b'];
      $totqtyc=$totqtyc+$row['grade_c'];
      if (trim($row['satuan'])=="m") {
          $kartot=$kartot + $row['panjang'];
          $totrolm = $totrolm + $row['jmlrol'];
      }
      if (trim($row['satuan'])=="yd") {
          $pltot=$pltot + $row['panjang'];
          $totroly = $totroly + $row['jmlrol'];
      }
  }
  ?>

      <tr>
        <td bgcolor="#F5F5F5">&nbsp;</td>

        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
        <td bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
      <tr bgcolor="#99FFFF">
        <td bgcolor="#FFFFFF">&nbsp;</td>

        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="2" bgcolor="#FFFFFF">Meter</td>
        <td align="right" bgcolor="#FFFFFF">
          <?php echo number_format($totrolm); ?>
        </td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">Meter</td>
        <td align="right" bgcolor="#FFFFFF">
          <?php echo number_format($kartot, '2', '.', ','); ?>
        </td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr bgcolor="#99FFFF">
        <td bgcolor="#FFFFFF">&nbsp;</td>

        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="2" bgcolor="#FFFFFF">Yard</td>
        <td align="right" bgcolor="#FFFFFF">
          <?php echo  number_format($totroly);?>
        </td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">Yard</td>
        <td align="right" bgcolor="#FFFFFF">
          <?php echo  number_format($pltot, '2', '.', ',');?>
        </td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr bgcolor="#99FFFF">
        <td bgcolor="#FFFFFF">&nbsp;</td>

        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="3" bgcolor="#FFFFFF"><b>Total</b></td>
        <td align="right" bgcolor="#FFFFFF">
          <?php echo $totrol;?><b></td>
        <td align="right" bgcolor="#FFFFFF"><b>
            <?php echo number_format($totqtya, '2', '.', ',');?></b></td>
        <td align="right" bgcolor="#FFFFFF"><b>
			<?php echo number_format($totqtyb, '2', '.', ',');?></b></td>
        <td align="right" bgcolor="#FFFFFF"><b>
            <?php echo number_format($totqtyc, '2', '.', ',');?></b></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="right" bgcolor="#FFFFFF">&nbsp;</td>

        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>

      <tr>
        <td colspan="21">&nbsp;</td>
      </tr>
    </table>
    <table width="100%" border="0" class="table-list1">
      <tr align="center">
        <td colspan="3">&nbsp;</td>
        <td colspan="8">Departemen QCF</td>
        <td colspan="10">Departemen Gudang Kain Jadi</td>
      </tr>
      <tr align="center">
        <td colspan="3">&nbsp;</td>
        <td colspan="3">Diserahkan Oleh :</td>
        <td colspan="5">Diketahui Oleh :</td>
        <td colspan="6">Diterima Oleh :</td>
        <td colspan="4"> Diketahui Oleh :</td>
      </tr>
      <tr>
        <td colspan="3">Nama</td>
        <td colspan="3" align="center"><input type=text name=nama placeholder="Ketik disini"></td>
        <td colspan="5" align="center"><input type=text name=nama1 placeholder="Ketik disini"></td>
        <td colspan="6">&nbsp;</td>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">Jabatan</td>
        <td colspan="3" align="center"><input type=text name=nama2 placeholder="Ketik disini"></td>
        <td colspan="5" align="center"><input type=text name=nama3 placeholder="Ketik disini"></td>
        <td colspan="6" align="center">Leader</td>
        <td colspan="4" align="center">Asst. SPV</td>
      </tr>
      <tr>
        <td colspan="3">Tanggal</td>
        <td colspan="3" align="center">
          <?php echo date("d-M-Y", strtotime($rowlth['tgl_mutasi']));?>
        </td>
        <td colspan="5" align="center">
          <?php echo date("d-M-Y", strtotime($rowlth['tgl_mutasi']));?>
        </td>
        <td colspan="6" align="center">
          <?php echo date("d-M-Y", strtotime($rowlth['tgl_mutasi']));?>
        </td>
        <td colspan="4" align="center">
          <?php echo date("d-M-Y", strtotime($rowlth['tgl_mutasi']));?>
        </td>
      </tr>
      <tr>
        <td colspan="3" height="60" valign="top">Tanda Tangan</td>
        <td colspan="3">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </td>
        <td colspan="5">&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
  </table>
    <b>PrintDate :
      <?php echo date("d F Y H:i:s", strtotime($rowlth['tgl_skrng']));?></b>
    <script>
      alert('cetak');
      window.print();

    </script>

  </body>
