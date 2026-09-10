<div class="sponsors">
	<?
		$query_grade = "select * from booth_grade where del='N' order by sort_num asc";
		$result_grade=$conn->query($query_grade);
		if(DB::isError($result_grade)) die($result_grade->getMessage());
		while(is_array($g=$result_grade->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	
	<dl class="ebooth <?=$_Booth['class'][$g['sid']]?>">
		<dt><span><?=$g['title']?></span></dt>
		<dd>
			<ul <?if($g['sid']=='9'){?>class="bnr5ea"<?}?>>
				
				<?
					$query = "select * from booth where booth_sid='".$g['sid']."' and del='N' and booth_file!='' order by sort_num asc";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());
					while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				?>
				
				<li>
				
				<a href="index_kind_A_view.php?sid=<?=$d['sid']?>" -href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%' key="<?=$d['sid']?>">
			
				<img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_file']?>" alt=""></a></li>
				<?}?>
			</ul>
		</dd>
	</dl>
	<?}?>

	<!-- <dl class="gold">
		<dt><span>Gold</span></dt>
		<dd>
			<ul>
				<li><a href="#"><img src="/asset/ebooth/bnr_04.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_05.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_06.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_07.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_08.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_09.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_10.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_11.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_12.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_13.png" alt=""></a></li>
			</ul>
		</dd>
	</dl>

	<dl class="silver">
		<dt><span>Silver</span></dt>
		<dd>
			<ul>
				<li><a href="#"><img src="/asset/ebooth/bnr_14.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_15.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_16.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_17.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_18.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_19.png" alt=""></a></li>
			</ul>
		</dd>
	</dl>

	<dl class="supporter">
		<dt><span>Supporter</span></dt>
		<dd>
			<ul>
				<li><a href="#"><img src="/asset/ebooth/bnr_20.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_21.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_22.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_23.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_24.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_25.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_26.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_27.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_28.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_29.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_30.png" alt=""></a></li>
				<li><a href="#"><img src="/asset/ebooth/bnr_31.png" alt=""></a></li>
			</ul>
		</dd>
	</dl> -->
</div>