<?php

//!! pageNavigator 
//! 컨텐츠를 지정한 분량만큼 가져와 출력하는 클래스이다.
/*!
  테이블에 저장되어 있는 레코드를 지정한 개수만큼 분할하여 출력하는 데 필요한 함수를 제공한다. 
*/

class Page 
{   

   /// 현재 페이지
   var $page;

   /// 대상 레코드의 총 개수
   var $numberOfRecords;

   /// 페이지별로 할당된 레코드의 개수
   var $recordPerPage;
     
   /*!
     클래스의 생성자이다.
   */
   function Page($page,$numberOfRecords,$recordPerPage) 
   {
      $this->page = $page;
      $this->numberOfRecords = $numberOfRecords;
      $this->recordPerPage = $recordPerPage;
   }

   /*!
     현재 객체의 page 멤버 변수의 값을 지정한 값으로 변경한다.
   */
   function setPage($page) 
   {
      $this->page = $page;
   }
   
   /*!
     현재 객체의 page 멤버 변수의 값을 반환한다.
   */
   function getPage() 
   {
      return $this->page;
   }
   
   /*!
     현재 객체의 numberOfRecords 멤버 변수의 값을 지정한 값으로 변경한다.
   */
   function setNumberOfRecords($no) 
   {
      $this->numberOfRecords = $no;
   }
   
   /*!
     현재 객체의 numberOfRecords 멤버 변수의 값을 반환한다.
   */
   function getNumberOfRecords() 
   {
      return $this->numberOfRecords;
   }
   
   /*!
     현재 객체의 recordPerPage 멤버 변수의 값을 지정한 값으로 변경한다.
   */
   function setRecordPerPage($no) 
   {
      $this->recordPerPage = $no;
   }
   
   /*!
     현재 객체의 recordPerPage 멤버 변수의 값을 반환한다.
   */
   function getRecordPerPage() 
   {
      return $this->recordPerPage;
   }
   
   /*!
     분할할 수 있는 페이지의 개수를 계산하여 반환한다.  
   */
   function getTotalPage() 
   {
      return ceil($this->numberOfRecords/$this->recordPerPage);
   }

   /*!
     지정한 페이지에서 최초로 출력할 순차 번호값을 반환한다. 
   */
   function getVirtualRecordNoInPage($totalRecords) 
   {
      return $totalRecords - $this->recordPerPage * ($this->page - 1);
   }
      
   /*!
     지정한 페이지에서 첫번째로 출력할 레코드 번호를 반환한다.
   */
   function getFirstRecordInPage() 
   {
      return ($this->page - 1) * $this->recordPerPage;      
   }
   
   /*!
     이동할 수 있는 이전 페이지가 존재하면 true를, 그렇지 않으면 false를 반환한다.
   */
   function loadPreviousPage() 
   {
      if($this->page > 1)
         return true;
      else
         return false;
   }
   
   /*!
     이동할 수 있는 다음 페이지가 존재하면 true를, 그렇지 않으면 false를 반환한다.
   */
   function loadNextPage() 
   {
      if($this->page < $this->getTotalPage())  
         return true;
      else 
         return false;
   }
}
?>
