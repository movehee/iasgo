<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(!empty($sid)){
        $query="update voting_tbl set ";

        $query .= "question='".$question."'";

        if(!empty($answer1)){
            $query .= ",answer1='".$answer1."'";
        }
        if(!empty($answer2)){
            $query .= ",answer2='".$answer2."'";
        }
        if(!empty($answer3)){
            $query .= ",answer3='".$answer3."'";
        }else{
          $query .= ",answer3=NULL";
        }
        if(!empty($answer4)){
            $query .= ",answer4='".$answer4."'";
        }else{
          $query .= ",answer4=NULL";
        }
        if(!empty($answer5)){
            $query .= ",answer5='".$answer5."'";
        }else{
          $query .= ",answer5=NULL";
        }
        if(!empty($answer6)){
            $query .= ",answer6='".$answer6."'";
        }else{
          $query .= ",answer6=NULL";
        }
        $query .= " where sid='".$sid."'";

        $result = mysqli_query($conn, $query);
        echo "update";
}else{

      $result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where lecture='".$lecture."'and room='$room' and del='N'");
      $row = mysqli_fetch_array($result);

      $max = $row['maxs'];

      $query = "INSERT INTO voting_tbl SET ";
      $query .= "lecture='".$lecture."'";
      $query .= ",code='".$code."'";

      $query .= ",question='".$question."'";

      if(!empty($answer1)){
          $query .= ",answer1='".$answer1."'";
      }
      if(!empty($answer2)){
          $query .= ",answer2='".$answer2."'";
      }
      if(!empty($answer3)){
          $query .= ",answer3='".$answer3."'";
      }
      if(!empty($answer4)){
          $query .= ",answer4='".$answer4."'";
      }
      if(!empty($answer5)){
          $query .= ",answer5='".$answer5."'";
      }
      if(!empty($answer6)){
          $query .= ",answer6='".$answer6."'";
      }

      $query .= ",correct=''";
      $query .= ",delay='5'";
      $query .= ",orderby='".($max+1)."'";
      $query .= ",type='1'";
      $query .= ",signdate='".time()."'";
      $query .= ",status='0'";
      $query .= ",ui='1'";
      $query .= ",room='$room'";

      mysqli_query($conn, $query);

      echo "insert";
}
?>
