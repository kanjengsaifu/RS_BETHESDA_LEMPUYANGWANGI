<?php
require_once("../lib/dbconn.php");


if($_GET['xls'] == 'true'){
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=laporan_transaksi_kasir.xls");
	echo "$headers\n$data";
	header("Content-type: Application/vnd.ms-excel");
}else{
	echo '<SCRIPT LANGUAGE="JavaScript">';
	echo ' window.print();';
	echo '</SCRIPT>';
}

	#$jam_cek_in1 = date("H:i", mktime($_GET["pukulM"],$_GET["pukuli"],0,0,0,0));
	#$jam_cek_in2 = date("H:i", mktime($_GET["pukul2M"],$_GET["pukul2i"],0,0,0,0));
$ts_check_in1 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal1M"],$_GET["tanggal1D"],$_GET["tanggal1Y"]));
$ts_check_in2 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal2M"],$_GET["tanggal2D"],$_GET["tanggal2Y"]));

if ($_GET["shift"]=="P"){
	$jam1="07:00:00";
	$jam2="14:00:00";
	$name = 'Pagi';
	}elseif($_GET["shift"]=="S"){
	$jam1="14:01:00";
	$jam2="21:00:00";
	$name = 'Siang';
	}elseif($_GET["shift"]=="M1"){
	$jam1="21:01:00";
	$jam2="23:59:00";
	$name = 'Malam 1';
	}elseif($_GET["shift"]=="M2"){
	$jam1="00:00:00";
	$jam2="06:59:00";
	$name = 'Malam 2';
	}else{
	$jam1="00:00:00";
	$jam2="23:59:59";
	}

$rowsTagihan   = pg_query($con, "SELECT rs00002.nama,sum(rs00005.piutang_penjamin) as kredit, rs00005.reg,rs00001.tdesc, rs00005.no_kwitansi, rs00005.tgl_entry, SUM(rs00005.jumlah) AS cash, to_char(waktu_bayar,'HH24:MI:SS') AS waktu_bayar
                                        FROM rs00005
                                        JOIN rs99995 ON rs00005.user_id = rs99995.uid
                                        JOIN rs00006 ON rs00005.reg = rs00006.id::text
                                        JOIN rs00002 ON rs00006.mr_no = rs00002.mr_no
                                        JOIN rs00001 ON rs00006.tipe::text = rs00001.tc::text AND rs00001.tt='JEP' 
										WHERE (rs00005.tgl_entry::date between '$ts_check_in1' AND '$ts_check_in2') AND (rs00005.kasir in('BYR','BYD','BYI') and layanan not in('DEPOSIT'))  and (rs00005.waktu_bayar between '$jam1' and '$jam2')
                                        AND uid like '%".$_GET["mKASIR"]."%'  GROUP BY reg, waktu_bayar, no_kwitansi, tgl_entry, rs00002.nama,rs00001.tdesc ORDER BY  tgl_entry, waktu_bayar ASC");
	$rowsUser = pg_query($con, "SELECT * FROM rs99995 WHERE uid = '".$_GET["mKASIR"]."' ");
$rowUser  = pg_fetch_row($rowsUser);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="lap_transaksi_kasir_files/filelist.xml">
<style id="lap_transaksi_kasir_22111_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1522111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6322111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6422111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6522111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6622111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6722111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\[$-421\]dd\\ mmmm\\ yyyy\;\@";
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6822111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6922111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7022111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7122111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7222111
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
-->
</style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="lap_transaksi_kasir_22111" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=649 style='border-collapse:
 collapse;table-layout:fixed;width:487pt'>
 <col width=44 style='mso-width-source:userset;mso-width-alt:1609;width:20pt'>
 <col width=127 style='mso-width-source:userset;mso-width-alt:4644;width:65pt'>
 <col width=94 style='mso-width-source:userset;mso-width-alt:3437;width:55pt'>
 <col width=129 style='mso-width-source:userset;mso-width-alt:4717;width:75pt'>
 <col width=229 style='mso-width-source:userset;mso-width-alt:4717;width:197pt'>
 <col width=128 style='mso-width-source:userset;mso-width-alt:4681;width:197pt'>
 <col width=127 style='mso-width-source:userset;mso-width-alt:4644;width:95pt'>
 <col width=127 style='mso-width-source:userset;mso-width-alt:4644;width:95pt'>
 <col width=127 style='mso-width-source:userset;mso-width-alt:4644;width:95pt'>
 <tr height=25 style='height:18.75pt'>
 <td colspan=8 height=25 class=xl6322111 width=649 style='height:18.75pt;
  width:487pt'>
  <h2>RUMAH SAKIT HOSANA MEDICA</h2>
  <h3>Jl. Utama BIIE NO.1 Lippo Cikarang</h3>
  </td>
  </tr>
  <tr>
  <td colspan=8 height=25 class=xl6322111 width=649 style='height:18.75pt;
  width:487pt'>LAPORAN TRANSAKSI KASIR</td>
 </tr>
  <tr>
  <td colspan=8>
  <hr width="100%">
  </td>
 </tr>
 <tr height=25 style='height:18.75pt'>
  <td colspan=8 height=25 class=xl6322111 style='height:18.75pt'><?php echo ($rowUser[4] == '' ? '' : 'Nama Petugas Kasir : ').$rowUser[4]?></td>
 </tr>
 <tr height=25 style='height:18.75pt'>
  <td colspan=8 height=25 class=xl6322111 style='height:18.75pt'><?php echo 'Shift : '.$name.', '.$jam1.' - '.$jam2; ?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1522111 style='height:15.0pt'></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
  <td class=xl1522111></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td rowspan=2 height=40 class=xl6422111 style='height:30.0pt'>NO</td>
  <td colspan=2 class=xl6422111 style='border-left:none'>WAKTU PEMBAYARAN</td>
  <td rowspan=2 class=xl6422111>NO. REGISTER</td>
  <td rowspan=2 class=xl6422111>NAMA</td>  
  <td rowspan=2 class=xl6422111>TIPE PASIEN</td>
  <td rowspan=2 class=xl6422111>CASH</td>
  <td rowspan=2 class=xl6422111>KREDIT</td>
  <td rowspan=2 class=xl6422111>TOTAL</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6422111 style='height:15.0pt;border-top:none;
  border-left:none'>TANGGAL</td>
  <td class=xl6422111 style='border-top:none;border-left:none'>JAM</td>
 </tr>
<?php
					$iData          = 0;
					$total1          = 0;
					$total2          = 0;
					$total3          = 0;
	while($rowTagihan=pg_fetch_array($rowsTagihan)){
		$iData++;
						$total1          = $total1 + $rowTagihan["cash"];
						$total2          = $total2 + $rowTagihan["kredit"];
						$total3          = $total3 + ($rowTagihan["cash"]+$rowTagihan["kredit"]);
			?>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6522111 align=right style='height:15.0pt;border-top: none'><?=$iData?></td>
  <td class=xl6722111 align=right style='border-top:none;border-left:none'><?=$rowTagihan["tgl_entry"]?></td>
  <td class=xl6822111 style='border-top:none;border-left:none'>&nbsp;<?=$rowTagihan["waktu_bayar"]?></td>
  <td class=xl6522111 align=center style='border-top:none;border-left:none'><?=$rowTagihan["reg"]?></td>
  <td class=xl6522111 style='border-top:none;border-left:none'><?=$rowTagihan["nama"]?></td>
  <td class=xl6522111 style='border-top:none;border-left:none'><?=$rowTagihan["tdesc"]?></td>
  <td class=xl6622111 align=right style='border-top:none;border-left:none'><?=number_format($rowTagihan["cash"],0,"",".")?></td>
  <td class=xl6622111 align=right style='border-top:none;border-left:none'><?=number_format($rowTagihan["kredit"],0,"",".")?></td>
  <td class=xl6622111 align=right style='border-top:none;border-left:none'><?=number_format($rowTagihan["cash"]+$rowTagihan["kredit"],0,"",".")?></td>
 </tr>
<?php
	}
?>
 <tr height=21 style='height:15.75pt'>
  <td colspan=6 height=21 class=xl7022111 style='border-right:.5pt solid black;
  height:15.75pt'>TOTAL</td>
  <td class=xl6922111 align=right style='border-top:none;border-left:none'><?php echo number_format($total1,0,"",".")?></td>
  <td class=xl6922111 align=right style='border-top:none;border-left:none'><?php echo number_format($total2,0,"",".")?></td>
  <td class=xl6922111 align=right style='border-top:none;border-left:none'><?php echo number_format($total3,0,"",".")?></td>
 </tr>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
