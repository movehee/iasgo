<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";




$result = mysqli_query($conn, "SELECT * FROM lecture_tbl where code='".$code."' and room='$room' and del='N'");

while($row = mysqli_fetch_array($result)){

		$votings = array();
		$result2 = mysqli_query($conn, "SELECT * FROM voting_tbl where code='".$code."' and room='$room' and lecture='".$row['sid']."' and del='N' order by 'orderby'");
		while($row2 = mysqli_fetch_array($result2)){

			// echo $row['sid'];
			// echo ":";
			// echo $row2['sid'];
			// echo "  ";

		// 보팅을 하고 난 이후라면 결과를 같이 뽑음
						if($row2['status']=='2'){

							$query3 = "SELECT ";

							$query3 .= "(SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='1') value1";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='2') value2";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='3') value3";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='4') value4";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='5') value5";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='6') value6";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='7') value7";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='8') value8";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='9') value9";
							$query3 .= ", (SELECT count(*) FROM voting_result_tbl where code='".$code."' and voting_sid='".$row2['sid']."' and val='10') value10";


							$result3 = mysqli_query($conn, $query3);
							$votingResult = mysqli_fetch_array($result3);

								$row2['result'] = $votingResult;

						}

// echo "\n";
			$votings[] = $row2;
		}
	$row['votings'] = $votings;

	$lectures[] = $row;

}


echo json_encode($lectures);









// $result = mysqli_query($conn, "select * from voting_tbl where code='".$code."' and del='N' group by lecture order by orderby");
//
//
// while($row = mysqli_fetch_array($result)){
//
//   $lecture = array(
//     'lecture_id'=>$row['sid'],
//     'lecture_name'=>$row['lecture'],
//     'lecture_order'=>$row['orderby']
//   );
//
//
//
//
//
//
//     $quiz_lists = array();
//
//     $lecture_id = $row['lecture'];
//
//     $result2 = mysqli_query($conn, "select * from voting_tbl where lecture='".$lecture_id."'");
//     // echo $result;
//     while($row2 = mysqli_fetch_array($result2)){
//       $quiz_list = array(
//         'correct' => $row['correct'],
//         'num1' => $row2['answer1'],
//         'num2' => $row2['answer2'],
//         'num3' => $row2['answer3'],
//         'num4' => $row2['answer4'],
//         'num5' => $row2['answer5'],
//         'number' => $row2['orderby'],
//         'question' => $row2['question'],
//         'quiz_id' => $row2['sid'],
//         'state' => $row2['status'],
//         'statistics_state' => $row2['status'],
//         'vote_num_state' => $row2['status']
//       );
//
//       $quiz_lists[] = $quiz_list;
//     }
//
//     $lecture['quiz_list'] = $quiz_lists;
//
//     $lectures[] = $lecture;
//
//
//
//
//
// }
//
// $lectures2 = $lectures;
// foreach ($lecture as $lectures2) {
//
//
//
// }
//
// $json = array(
// 	'chair_state'=>$chair_state,
//   'lecture_list'=>$lectures,
// );
// echo json_encode($json);


?>
