<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	
	$csv = new CSVF($_FILES['csvf']['tmp_name'] , $eventcode);
	$csv->memberRegister();
	
	

/**
* CSV
*/
class CSVF  {
	
	private $conn;
	private $file;
	private $eventCode;
	private $memberArr = array();
	

	public function __construct( $file , $eventcode )  {
		$this->file = $file;
		$this->eventCode = $eventcode;
		$this->csv_processing();
		$this->include_call();
	}
	
	
	private function csv_processing() {
		
		$row = 1;
		$handle = fopen($this->file, "r");
		$bool = false;
		
		$fields_values = array();
		
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    //첫 컬럼  건너띔
	        if ($bool == false) {
	            $bool = true;
	            continue;
	        }
	       
	       foreach ( $data as $key => $value ) {
		       $fields_values['info'.$key] = $value ;
	       }

	       array_push($this->memberArr, $fields_values);

		}
		
		fclose($handle);
		
	}
	
	public function print_member() {
		echo "<pre>";
		print_r($this->memberArr);
		echo "</pre>";
	}
	
	private function getInfo () {
		
	}
	
	public function memberRegister () {

		
		for ( $i = 0 , $j = count($this->memberArr); $i < $j ; $i ++ ) {
			
			$code = 42;
			if ( $this->memberArr[$i]["info0"] == "Moderator" ) {
				$code = 40;
			} else if ( $this->memberArr[$i]["info0"] == "Speaker" ) {
				$code = 41;
			} 
			echo $i;
			echo "<pre>";
		print_r($this->memberArr[$i]);			
		echo "</pre>";
		
		$office = str_replace("'", "\'",$this->memberArr[$i]["info2"]);
		
			$query = "insert into regist_tbl (code , info1 , info2 , info3) values( '".$this->eventCode."' , '".$this->memberArr[$i]["info1"]."','".$office."' , $code )";
			
			
			//$this->query($query);
			
			
		}
	}
	
	
	
	private function query($query) {
		return mysqli_query($this->conn, $query);
	}

	private function include_call(){
		include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
		$this->conn = $conn;
	}	
	

}







