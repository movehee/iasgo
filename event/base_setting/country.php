<div class="contents">
	<form name="flagF" id="flagF" method="post" action="/base_setting/country_reg.php">
	<div class="tp10 bp5 fcRed" style="float:left;">
		☆ 국가명으로 사전등록 및 Faculty 명단의 국기를 매칭하실 수 있습니다.
	</div>
	<div class="btn tp10 bp5" style="float:right;">
		<a href="javascript:$('#flagF').submit()" class="btnBdLGrey withIcon"><i class="fas fa-code" ></i>HTML 생성</a>
	</div>

	<table class="tblDef">
		<colgroup>
			<col style="width: 3%;" />
			<col style="width: 6%;" />
			<col style="width: 23%" />
			<col style="width: 3%;" />
			<col style="width: 6%;" />
			<col style="width: 23%" />
			<col style="width: 3%;" />
			<col style="width: 6%;" />
			<col style="width: 23%" />
		</colgroup>
		<thead>
			<tr>
				<th>Code</th>
				<th>Flag</th>
				<th>Name</th>
				<th>Code</th>
				<th>Flag</th>
				<th>Name</th>
				<th>Code</th>
				<th>Flag</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?
			$query = "select * from country_tbl order by name_1 desc, code asc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<th><?=$d['code']?></th>
			<th style="background:#C3C3C3;"><img src="/upload/flag/thumb/<?=$d['code']?>.png"></th>
			<td class="al">
				<input type="hidden" name="code[]" value="<?=$d['code']?>">
				<input type="text" name="name_1[]" style="width:140px;" value="<?=$d['name_1']?>">
				<input type="text" name="name_2[]" style="width:140px;" value="<?=$d['name_2']?>">
			</td>
			<?
			if($n%3==0) echo "</tr><tr>";
			$n++;
			}
			?>
			</tr>
		</tbody>
	</table>
	<div class="btn tp10 bp5" style="float:right;">
		<a href="javascript:$('#flagF').submit()" class="btnBdLGrey withIcon"><i class="fas fa-code" ></i>HTML 생성</a>
	</div>
	</form>
</div>