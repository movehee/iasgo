<ul class="pager">
	<?php if($blockNav->loadPreviousBlock()): ?>
		<li class="first">
			<a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$firstPageInBlock?><?=$search_url?>">
				<img alt="처음" src="/did/css/block_prev.png">
			</a>
		</li>
	<?php else: ?>
		<li class="first">
			<a href="javascript:void(0);">
				<img alt="처음" src="/did/css/block_prev.png">
			</a>
		</li>
	<?php endif; ?>
	<?php if($pageNav->loadPreviousPage()): ?>
		<li class="prev">
			<a href="javascript:void(0);">
				<img src="/did/css/prev.png" class="hand" alt="이전 페이지로 이동합니다." onclick="location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$page-1?><?=$search_url?>'"/>
			</a>
		</li>
	<?php else: ?>
		<li class="prev">
			<a href="javascript:void(0);">
				<img src="/did/css/prev.png" alt="이전 페이지로 이동합니다.">
			</a>
		</li>
	<?php endif; ?>

	<?php for($direct_page = $firstPageInBlock+1; $direct_page <= $lastPageInBlock; $direct_page++): ?>
		<?php if($page == $direct_page): ?>
			<li>
				<a class="on" href="javascript:void(0);"><?=$direct_page?></a>
			</li>
		<?php else: ?>
			<li>
				<a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$direct_page?><?=$search_url?>"><?=$direct_page?></a>
			</li>
		<?php endif; ?>
	<?php endfor; ?>

	<?php if($pageNav->loadNextPage()): ?>
		<li class="next">
			<a href="javascript:void(0);">
				<img src="/did/css/next.png" class="hand" alt="다음 페이지로 이동합니다." onclick="location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$page+1?><?=$search_url?>'"/>
			</a>
		</li>
	<?php else: ?>
		<li class="next">
			<a href="javascript:void(0);">
				<img src="/did/css/next.png" alt="다음 페이지로 이동합니다.">
			</a>
		</li>
	<?php endif; ?>
	<?php if($blockNav->loadNextBlock()): ?>
		<li class="last">
			<a href="javascript:void(0);">
				<img src="/did/css/block_next.png" class="hand" alt="다음 10 개 페이지를 불러들입니다." onclick="location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$lastPageInBlock+1?><?=$search_url?>'"/>
			</a>
		</li>
	<?php else: ?>
		<li class="last">
			<a href="javascript:void(0);">
				<img src="/did/css/block_next.png" alt="다음 10 개 페이지를 불러들입니다.">
			</a>
		</li>
	<?php endif; ?>
</ul>