<ul class="pager">
	<!-- <li class="first"><a href="<?=$_SERVER['PHP_SELF']?>?page=1<?=$search_url?>" style="width: auto;"><img alt="처음" src="/image/block_first.gif" ></a></li> -->
	<?if($blockNav->loadPreviousBlock()):?>
		<li class="first"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$firstPageInBlock?><?=$search_url?>"><img alt="처음" src="/asset/layout/block_prev.png"></a></li>
	<?else:?>
		<li class="first"><a href="#"><img alt="처음" src="/asset/layout/block_prev.png"></a></li>
	<?endif?>

	<?if($pageNav->loadPreviousPage()):?>
		<li class="prev"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page-1?><?=$search_url?>"><img alt="이전" src="/asset/layout/prev.png"></a></li>
	<?else:?>
		<li class="prev"><a href="#"><img alt="이전" src="/asset/layout/prev.png"></a></li>
	<?endif?>

	<?for($direct_page = $firstPageInBlock+1; $direct_page <= $lastPageInBlock; $direct_page++):?>
		<?if($page == $direct_page):?>
			<li><a class="on" href="#"><?=$direct_page?></a></li>
		<?else:?>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$direct_page?><?=$search_url?>"><?=$direct_page?></a></li>
		<?endif?>
	<?endfor?>
	
	<?if($pageNav->loadNextPage()):?>
		<li class="next"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page+1?><?=$search_url?>"><img alt="다음" src="/asset/layout/next.png"></a></li>
	<?else:?>
		<li class="next"><a href="#"><img alt="다음" src="/asset/layout/next.png"></a></li>
	<?endif?>

	<?if($blockNav->loadNextBlock()):?>
		<li class="last"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$lastPageInBlock+1?><?=$search_url?>"><img alt="마지막" src="/asset/layout/block_next.png"></a></li>
	<?else:?>
		<li class="last"><a href="#"><img alt="마지막" src="/asset/layout/block_next.png"></a></li>
	<?endif?>
	<!-- <li class="last"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$totalPage?><?=$search_url?>" style="width: auto;"><img alt="마지막" src="/image/block_last.gif" ></a></li> -->
</ul>						
