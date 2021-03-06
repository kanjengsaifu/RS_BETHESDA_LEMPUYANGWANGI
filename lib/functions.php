<?php
// Nugraha, 31/12/2003
// Nugraha, 02/02/2004, sqlGetVal

require_once("dbconn.php");

/*
 * Fungsi pembulatan jika nilai nominal memiliki 
 * nilai sisa < 50 (ex. 1149) dibulatkan jadi 1100 
 * dan jika nilai sisa > 50 (ex. 1259) dibulatkan jadi 1300
 * 
 */
function pembulatan($nilai){
    $sisa = $nilai%100;
    if($sisa==0){
        $nilai -= $sisa;
    } else if($sisa>=1){
        $nilai = 100*($nilai/100)+(100-$sisa);
    }
    return floor($nilai);
}

function coa_id() {
	$prefix		= "COA"; //strtoupper($_GET["rg"]);
	$monthYear 	= date('my') ;
	$noKwitansi = getFromTable("select no_faktur from jurnal_umum_m order by no_faktur desc limit 1");
	
	if(!empty($noKwitansi))
	{
		$next =  $noKwitansi;
		$a = explode('/',$next);
		$no = $a[2]; 

		$next = "$prefix/$monthYear/".sprintf("%05s",$no+1);
	}
	else
	{
		$next = "$prefix/$monthYear/00001";
	}
	
	return $next;
	}

function new_id() {
	$prefix		= strtoupper($_GET["kas"]);
	$monthYear 	= date('my') ;
	$noKwitansi = getFromTable("select new_id from rs00005 where kasir = 'BYR' or kasir = 'BYI' or kasir = 'BYD' order by id desc limit 1");
	
	if(!empty($noKwitansi))
	{
		$next =  $noKwitansi;
		$a = explode('/',$next);
		$no = $a[2]; 

		$next = "$prefix/$monthYear/".sprintf("%05s",$no+1);
	}
	else
	{
		$next = "$prefix/$monthYear/00001";
	}
	
	return $next;
	}
	
function reg_id() {
	$prefix		= "REG";
	$month 	= date('m') ;
	$noKwitansi = getFromTable("select reg_akun from c_po where reg_akun!='' order by reg_akun desc limit 1");
	
	if(!empty($noKwitansi))
	{
		$next =  $noKwitansi;
		$a = explode('/',$next);
		$month2=$a[1];
		$no = $a[2]; 
		
		if($month!=$month2){
		$next = "$prefix/$month/00001";
		}else{
		$next = "$prefix/$month/".sprintf("%05s",$no+1);
		}
	}
	else
	{
		$next = "$prefix/$month/00001";
	}
	
	return $next;
	}
	
	function nopo() {
	$monthYear 	= date('my') ;
	$noKwitansi = getFromTable("select po_id from c_po order by oid desc limit 1");
	
	if(!empty($noKwitansi))
	{
		$next =  $noKwitansi;
		$a = explode('/',$next);
		$no = $a[3]; 

		$next = sprintf($no+1);
	}
	else
	{
		$next = "1";
	}
	
	return $next;
	}

/*
 * Fungsi pembulatan jika nilai nominal memiliki 
 * nilai sisa < 500 (ex. 1499) dibulatkan jadi 1000 
 * dan jika nilai sisa >= 500 (ex. 1599) dibulatkan jadi 2000
 * 
 */
 
function pembulatan2Range($nilai){
    $sisa = $nilai%1000;
    if($sisa<500){
        $nilai -= $sisa;
    } else if($sisa==500){
        $nilai = 500*($nilai/500)+(500-$sisa);
    } else if($sisa>500){
        $nilai = 1000*($nilai/1000)+(1000-$sisa);
    }
    return floor($nilai);
}

/*
 * Fungsi pembulatan jika nilai nominal memiliki 
 * nilai sisa < 200 (ex. 1199) dibulatkan jadi 1000 
 * dan jika nilai sisa > 200 (ex. 1209) dibulatkan jadi 1500
 * 
 */
function pembulatan5Range($nilai){
    $sisa = $nilai%1000;
    if($sisa<200){
        $nilai -= $sisa;
    } else if($sisa>=200 && $sisa<400){
        $nilai = 500*($nilai/500)+(500-$sisa);
    } else if($sisa>=400 && $sisa<600){
        $nilai = 500*($nilai/500)+(500-$sisa);
    } else if($sisa>=600 && $sisa<750){
        $nilai = 500*($nilai/500)+(500-$sisa);
    } else if($sisa>=750){
        $nilai = 1000*($nilai/1000)+(1000-$sisa);
    }
    return floor($nilai);
}

function pgsql2phpDate($mysqlStr)
{
    $s = explode("-",$mysqlStr);
    return getdate(mktime(0,0,0,$s[1],$s[2],$s[0]));
}

function pgsql2mktime($mysqlStr)
{
    $s = explode("-",$mysqlStr);
    return mktime(0,0,0,$s[1],$s[2],$s[0]);
}

function errmsg($title,$msg,$tipe)
{
    echo "<DIV CLASS=$tipe>";
    echo "<B>$title</B><BR>$msg";
    echo "</DIV>";
}

function info($title,$msg)
{
    echo "<DIV CLASS=INFO>";
    echo "<B>$title</B><BR>$msg";
    echo "</DIV>";
}

function icon($name, $alt = "")
{
    return "<IMG ALT='$alt' BORDER=0 SRC='images/icon-{$name}.png' title='$alt' >";
}

function img($src,$onclick, $alt = "")
{
    return "<IMG ALT='$alt' onclick=$onclick BORDER=0 valign='bottom' SRC='$src' title='$alt' >";
}

function title($str)
{
    echo "<DIV ALIGN=LEFT CLASS=FORM_TITLE><B>$str</B></DIV>";
}
function titlecashier($str)
{
    echo "<DIV ALIGN=CENTER CLASS=FORM_TITLE><B>$str</B></DIV>";
}

function titlecashier1($str)
{
    echo "<DIV ALIGN=CENTER CLASS=TITLE_SIM1><B>$str</B></DIV>";
}

function titlecashier2($str)
{
    echo "<DIV ALIGN=CENTER CLASS=TITLE_SIM2><B>$str</B></DIV>";
}

function titlecashier3($str)
{
    echo "<DIV ALIGN=center CLASS=TITLE_SIM3><B>$str</B></DIV>";
}

function titlecashier4($str)
{
    echo "<DIV ALIGN=center CLASS=TITLE_SIM4><B>$str</B></DIV>";
}
//hery
function title_print($title,$align = 'left')
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='$align' >$title</td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'>$title</td>\n";
        echo "<td width=1 align=right><a href=\"javascript:printPage()\"><img border=0 src=\"images/printer.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
        echo "function printPage() {\n";
        echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
        echo "  oWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
    }
}

function title_print2($title,$align = 'left')
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='$align' >$title</td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'>$title</td>\n";
        echo "<td width=1 align=right><a href=\"javascript:printPage()\"><img border=0 src=\"images/printer.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
        echo "function printPage() {\n";
        echo "  oWin = window.open('print2.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
        echo "  oWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
    }
}

function pendapatan_dokter($title,$align = 'left')
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='$align' >$title</td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'>$title</td>\n";
        echo "<td width=1 align=right><a href=\"javascript:printPage()\"><img border=0 src=\"images/printer.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
        echo "function printPage() {\n";
        echo "  oWin = window.open('pendapatan_dokter.print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
        echo "  oWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
    }
}

function laporan_ogb($title,$align = 'left')
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='$align' >$title</td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'>$title</td>\n";
        echo "<td width=1 align=right><a href=\"javascript:printPage()\"><img border=0 src=\"images/printer.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
        echo "function printPage() {\n";
        echo "  oWin = window.open('laporan_ogb.print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
        echo "  oWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
    }
}

function title_excel($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"Excelprint.php?p=$link\"><img border=0 src=\"icon/Excel-22.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
     //   echo "function printPage() {\n";
     //   echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
     //   echo "  oWin.focus();\n";
     //   echo "}\n";
        echo "</script>\n";
    }
}

function edit_laporan($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"index2.php?p=$link\"><img border=0 src=\"icon/medical-record.gif\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
    //    echo "function printPage() {\n";
    //    echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
    //    echo "  oWin.focus();\n";
    //    echo "}\n";
        echo "</script>\n";
    }
}

function lihat_laporan($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"index2.php?p=$link\"><img border=0 src=\"icon/icon-back.png\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
    //    echo "function printPage() {\n";
    //    echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
    //    echo "  oWin.focus();\n";
    //    echo "}\n";
        echo "</script>\n";
    }
}
function sms_index($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"index2.php?p=$link\"><img border=0 src=\"icon/log_message.png\" title=\"SMS Index\" ></a></td>\n";
        echo "</table>\n";
        echo "<script language=\"JavaScript\">\n";
    //    echo "function printPage() {\n";
    //    echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
    //    echo "  oWin.focus();\n";
    //    echo "}\n";
        echo "</script>\n";
    }
}
function sms_sentitems($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"index2.php?p=$link\"><img border=0 src=\"icon/medical-record.gif\" title=\"Sent items\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
    //    echo "function printPage() {\n";
    //    echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
    //    echo "  oWin.focus();\n";
    //    echo "}\n";
        echo "</script>\n";
    }
}
function sms_outbox($link)
{
    if ($GLOBALS['print']) {
    	echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='FORM_TITLE' align='left' ></td></tr></table>\n";

    } else {
        echo "<table width='100%' cellspacing=0 cellpadding=2><tr><td CLASS='PAGE_TITLE'></td>\n";
        echo "<td width=1 align=right><a href=\"index2.php?p=$link\"><img border=0 src=\"icon/message.jpg\" title=\"Send\"></a></td>\n";
        echo "</tr></table>\n";
        echo "<script language=\"JavaScript\">\n";
    //    echo "function printPage() {\n";
    //    echo "  oWin = window.open('print.php?{$_SERVER['QUERY_STRING']}', 'zWin', 'width=800,height=600,scrollbars=yes');\n";
    //    echo "  oWin.focus();\n";
    //    echo "}\n";
        echo "</script>\n";
    }
}
function subtitle($str)
{
    echo "<DIV ALIGN=CENTER CLASS=SUBTITLE><B>$str</B></DIV>";
}

function subtitle_print($str)
{
    echo "<DIV ALIGN=CENTER CLASS=SUBTITLEPRINT><B>$str</B></DIV>";
}
function subtitle_rs($str)
{
    echo "<DIV ALIGN=left CLASS=SUBTITLEPRINT><B>$str</B></DIV>";
}

function subtitle2($str,$align)
{
    echo "<DIV ALIGN=$align CLASS=SUBTITLE2><B>$str</B></DIV>";
}

function formatRegNo($reg)
{
    $s = false;
    //for ($n = 0; $n < 9; $n++) {
        $r = $reg;
        $ret = "$r";
    //}
    return trim($ret);
}
function umur($usia)
{
$search = array ("'years'",
				 "'mons'",
                                 "'Bulan'",
				 "'days'",
                                 "'hari'",
				 "'Tahun'");
$replace = array ("Tahun",
				  "Bulan",
                                  "Bulan",
				  "Hari",
                                  "Hari",
				  "Tahun");
	$text = preg_replace ($search, $replace, $usia);
 return ($text);
}

function nav_db2($start,$rec_no,$max_view,$go_to,$par)
/*
Fungsi Navigasi database : start = Awal Record , Posisi record, jml data yang di tampilkan, next appl, parameter lain 
*/

{global $first_nya,$prev_nya,$next_nya,$last_nya ;
	if (($start-$max_view) >=0 ){
		$ke=$start-$max_view;		
		$prev_nya="<a href='".$go_to."&rec=".$ke.$par."'><img border=0 src='images/moveprev.png'></a>";		
		$first_nya="<a href='".$go_to."&rec=0".$par."'><img border=0 src='images/movefirst.png'></a>";		
	}else{$prev_nya="<img border=0 src='images/moveprev-d.png' >"; $first_nya="<img border=0 src='images/movefirst-d.png'>";}
	
	if (($start+$max_view) <=$rec_no ){
		$ke = $start+$max_view ;
		$next_nya="<a href='".$go_to."&rec=".$ke.$par."'><img border=0 src='images/movenext.png'></a>";				
	$ke = ($rec_no-$max_view)+1 ;
		$last_nya="<a href='".$go_to."&rec=".$ke.$par."'><img border=0 src='images/movelast.png'></a>";	
	}else{$next_nya="<img border=0 src='images/movenext-d.png'>";$last_nya="<img border=0 src='images/movelast-d.png'>";}	
}
function tanggal_format($tanggal, $format){
	$date = date_create($tanggal);
	return $date->format($format);
	}
?>
