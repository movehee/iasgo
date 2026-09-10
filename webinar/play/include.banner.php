<!-- <?
	$bquery = "select * from booth where booth_sid='3' and booth_bottom_file!=''";
	$bresult=$conn->query($bquery);
	if(DB::isError($bresult)) die($bresult->getMessage());
?>
<dl id="eBooth">
	<dt><a href="#">e-Booth 보기</a></dt>
	<dd>
		<ul>
			<?while(is_array($b=$bresult->fetchRow(DB_FETCHMODE_ASSOC))){?>
			<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=<?=$b['sid']?>" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/<?=$b['booth_bottom_file']?>" alt=""></a></li>
			<?}?>
			
		</ul>
	</dd>
</dl> -->
<dl id="eBooth">
	<dt><a href="#" class="view">e-Booth 보기</a></dt>
	<dd>
		<ul style="width: 2615%; position: relative; transition-duration: 0.5s; transform: translate3d(-1260px, 0px, 0px);">
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=42" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_42_1618897417.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=45" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_45_1619004665.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=47" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_47_1619005340.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=49" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_49_1618898000.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=51" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_51_1619005576.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=54" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_54_1618900671.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=56" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_56_1618983835.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=8" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_8_1618999363.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=10" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_10_1618648095.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=13" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_13_1619000236.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=16" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_16_1618798293.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=18" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_18_1618999816.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=19" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_19_1618798907.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=21" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_21_1618816505.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=23" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_23_1618817515.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=26" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_26_1618818965.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=27" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_27_1619002468.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=28" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_28_1618818674.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=30" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_30_1618883945.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=31" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_31_1618884157.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=35" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_35_1619004190.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=37" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_37_1618884750.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=39" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_39_1618896783.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=40" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_40_1619004561.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=42" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_42_1618897417.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=45" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_45_1619004665.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=47" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_47_1619005340.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=49" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_49_1618898000.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=51" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_51_1619005576.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=54" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_54_1618900671.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=56" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_56_1618983835.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=8" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_8_1618999363.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=10" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_10_1618648095.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=13" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_13_1619000236.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=16" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_16_1618798293.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=18" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_18_1618999816.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=19" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_19_1618798907.png" alt=""></a></li>
		<li style="float: left; list-style: none; position: relative; width: 116px; margin-right: 10px;" class="bx-clone"><a href="/booth/company.php?sid=21" class="iframe_booth cboxElement"><img src="<?=$_Azure['link']?>upload/booth/booth_bottom_file_21_1618816505.png" alt=""></a></li>
		</ul>
	</dd>
</dl>