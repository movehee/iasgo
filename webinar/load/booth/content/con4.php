<?php
$query = "select t1.* from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' ";
$query .= "order by t2.sort_num asc, t1.sort_num asc";
$result=$conn->query($query);
if(DB::isError($result)) die($result->getMessage());
?>
<div class="qrEvent">
    <ul class="eventBooth">
        <?php
			$mycnt=0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
			if($d['stamp_file']){	
				$my_stamp = $conn->getOne("select count(*) from booth_stamp where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$d['sid']."'");
				if($my_stamp>0){
					$mycnt++;
				}
			?>
			<li <?if($my_stamp>0){?>class="comp"<?}?>>
			<a href="#"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['stamp_file']?>"></a>
			</li>
		<?}}?>
    </ul>

    <div class="eventInfo">

        <h3>Scan the QR images and Complete Puzzle!</h3>

        <dl>
            <dt>참여 방법</dt>
            <dd>
                후원사 24개의 오프라인 부스에 설치된 QR 코드를 모바일로 스캔하여 퍼즐 완성<br>
                완성된 이미지를 가지고 AOCR 2022 사무국으로 방문
            </dd>

            <dt>상품</dt>
            <dd>
                (현장) 국내 참가자 : 스타벅스 상품권 1만원권 + 경품 추첨권<br>
                (현장) 국외 참가자 : 도자 코스터
            </dd>

            <dt>비고</dt>
            <dd>
                중복 참여는 불가, 5일 간 현장 1회 참여 가능<br>
                현장 참여 상품은 일 별 선착순으로 지급
            </dd>
        </dl>
    </div>
    <!-- //eventInfo -->


</div>