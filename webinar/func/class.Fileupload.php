<?php

//!! fileUpload
//! 파일업로드를 수행하는 클래스이다.
/*!
  이 클래스는 PHP에서 파일 업로드시 단일 및 다중 파일 업로드를 위해 필요한 함수를 제공한다.
*/

class FileUpload 
{

   /// 업로드된 파일을 가리키는 2차원 배열로 1차수는 파일의 name속성값, 2차수는 파일의 이름, 타입 또는 크기등을 가리킨다.
   var $fileInfo;

   /// 업로드할 수 없는 파일의 확장자를 그 원소로 갖는 배열
   var $prohibitedExt;
   
   /*!
      파일 업로드 클래스의 생성자이다.
   */
   function FileUpload($formName,$fileName,$fileType,$fileSize) 
   {
      @$this->fileInfo[$formName]["name"] = $fileName;
      @$this->fileInfo[$formName]["type"] = $fileType;
      @$this->fileInfo[$formName]["size"] = $fileSize;      
   }
   
   /*!
     업로드된 파일의 이름을 지정한 이름으로 변경한다.
   */
   function setUploadedFileName($formName,$name) 
   {
      $this->fileInfo[$formName]["name"] = $name;
   }

   /*!
     지정한 이름으로 업로드된 파일의 이름을 반환한다.
   */
   function getUploadedFileName($formName) 
   {
      return @$this->fileInfo[$formName]["name"];
   }

   /*!
     업로드된 파일의 MIME 형식을 지정한 형식으로 변경한다.
   */
   function setUploadedFileType($formName,$type) 
   {
      $this->fileInfo[$formName]["type"] = $type;
   }
   
   /*!
     지정한 이름으로 업로드된 파일의 MIME 형식을 반환한다.
   */
   function getUploadedFileType($formName) 
   {
      return $this->fileInfo[$formName]["type"];
   }
   
   /*!
     업로드된 파일의 크기를 지정한 값으로 변경한다.
   */
   function setUploadedFileSize($formName,$byteSize) 
   {
      $this->fileInfo[$formName]["size"] = $byteSize;
   }
   
   /*!
     지정한 이름으로 업로드된 파일의 크기를 반환한다.
   */
   function getUploadedFileSize($formName) 
   {
      return $this->fileInfo[$formName]["size"];
   }

   /*!
     업로드가 허용되지 않는 확장자를 인자로 취하여 이 확장자를 갖는 파일의 업로드를 허용 불가로 설정한다. 
   */
   function setProhibitedExt($ext) 
   {
      $this->prohibitedExt[] = $ext;
   }
   
   /*!
     업로드가 허용되지 않는 파일의 확장자를 원소로 갖는 배열을 인자로 취하여 해당 파일의 확장자를 갖는 파일의 업로드를 허용 불가로 설정한다.
   */
   function setProhibitedExtByArray($extArray) 
   {
      $this->prohibitedExt = $extArray;
   }

   /*!
     업로드 허용 불가로 설정되어 있는 파일의 확장자를 반환한다.
   */
   function getProhibitedExt() 
   {
      return $this->prohibitedExt;
   }

   /*!
     지정한 이름으로 업로드된 파일의 확장자를 반환한다.
   */
   function getFileExt($formName) 
   {
      $arrFileElement = explode(".", $this->getUploadedFileName($formName));
      if(sizeof($arrFileElement) == 1)
         return false;
      else 
         return $arrFileElement[sizeof($arrFileElement)-1];	   
   }

   /*!
     지정한 이름으로 업로드된 파일이 있으면 true를 반환한다.
   */
   function isUploaded($formName) 
   {
      if($this->getUploadedFileName($formName))
         return true;
      else
         return false;
   }

   /*!
     지정한 이름으로 업로드된 파일이 업로드가 가능한 파일이면  true를, 그렇지 않으면 false를 반환한다.
   */
   function isUploadable($formName) 
   {
      $ext = $this->getFileExt($formName);
      for($i = 0; $i < sizeof($this->prohibitedExt); $i++) {
         if(strcmp($ext,$this->prohibitedExt[$i]))
            continue;
         else
            return false;
      }

      return true;
   }

   /*!
     지정한 이름으로 업로드된 파일이 인자로 전달한 디렉토리에 존재하면 true를, 그렇지 않으면 false를 반환한다.
   */
   function isDuplicate($formName,$directory) 
   {
      $filePath = $directory . $this->getUploadedFileName($formName);
      if(file_exists($filePath))
         return true;
      else 
         return false;
   }
}
?>
