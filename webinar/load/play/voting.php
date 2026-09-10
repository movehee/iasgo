<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<dl class="voting">
	<dt>Voting</dt>
	<dd>
		<?if($room_sid=='1' && strtotime("2022-05-13 15:50")<$_Time['ing'] && strtotime("2022-05-13 17:40")>$_Time['ing']){?>
			<p>
				강의 중 보팅이 시작되면 번호를 선택해 주세요.<br>
				Please select a number when voting starts.
			</p>
			<ul class="votingOption">
				<?for($i=1;$i<=5;$i++){?>
				<li><a href="javascript:send_voting(<?=$i?>)"><?=$i?></a></li>
				<?}?>
			</ul>
		<?}else if($room_sid=='3' && strtotime("2022-05-13 14:10")<$_Time['ing'] && strtotime("2022-05-13 15:40")>$_Time['ing']){?>
			<p>
				강의 중 보팅이 시작되면 번호를 선택해 주세요.<br>
				Please select a number when voting starts.
			</p>
			<ul class="votingOption">
				<?for($i=1;$i<=5;$i++){?>
				<li><a href="javascript:send_voting(<?=$i?>)"><?=$i?></a></li>
				<?}?>
			</ul>
		<?}else{?>
		<p>
			<?if($room_sid=='1'){?>
				Start : 2022-05-13 16:00 ~ 17:30<br /><br />
				보팅은 Symposium 5. Challenging Cases in IBD <br />에서만 진행됩니다.<br>
				Voting only takes place at Symposium 5. <br />Challenging Cases in IBD.
			<?}else if($room_sid=='3'){?>
				Start : 2022-05-13 14:10 ~ 15:40<br /><br />
				보팅은 IMOTICON <br />에서만 진행됩니다.<br>
				Voting only takes place at IMOTICON
			<?}?>
		</p>
		<?}?>
	</dd>
</dl>