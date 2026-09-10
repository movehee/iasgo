<?if($event_col['gubun']=="WEB"){?>	
	<?
		$cnt=0;
		if($event_col['agendaYN']=="Y") {
			$cnt++;
		}
		if($event_col['votingYN']=="Y") {
			$cnt++;
		}
		if($event_col['questionYN']=="Y") {
			$cnt++;
		}
		if($event_col['feedbackYN']=="Y") {
			$cnt++;
		}

	
	?>
	<?if($cnt>1){

	?>
	<div id="fixedArea<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>"  style="position:fixed;left:0;bottom:0;width:100%;background:transparent;text-align:center">
	<?
		if($event_col['agendaYN']=="Y") {?>
			<li class="menu <?if($temp[3]=="agenda"){?>on<?}?>" style="width:<?=100/$cnt?>%;"><a href="/php/agenda/view.php?code=<?=$code?>"><?=$setting_col['Agenda_txt']?></a></li>
		<?}

		if($event_col['votingYN']=="Y") {?>
			<li class="menu <?if($temp[3]=="voting"){?>on<?}?>" style="width:<?=100/$cnt?>%;"><a href="/php/view.php?code=<?=$code?>"><?=$setting_col['Voting_txt']?></a></li>
		<?}

		if($event_col['questionYN']=="Y") {?>
			<li class="menu <?if($temp[3]=="question"){?>on<?}?>" style="width:<?=100/$cnt?>%;"><a href="/php/question/view.php?code=<?=$code?>"><?=$setting_col['Question_txt']?></a></li>
		<?}

		if($event_col['feedbackYN']=="Y") {?>
			<li class="menu <?if($temp[3]=="feedback"){?>on<?}?>" style="width:<?=100/$cnt?>%;"><a href="/php/feedback/view.php?code=<?=$code?>"><?=$setting_col['feedback_txt']?></a></li>
		<?}?>
	</div>

	<?}?>
<?}?>

</body>
</html>