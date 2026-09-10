<?php
 
//!! multiplePageLinker 
//! 게시판의 각 페이지로 이동할 수 있는 하이퍼링크를 출력한다. 
/*!
  이 클래스는 게시판의 하단에 각 페이지로 직접 이동할 수 있는 하이퍼링크를 출력한다.
*/

class Block 
{   

   /// 현재 블럭
   var $block;

   /// Page Navigator Class로부터 분할된 총 페이지 수
   var $numberOfPages;

   /// 구역(블럭)별 출력 가능한 하이퍼 링크의 개수
   var $pagePerBlock;
      
   /*! 
     Block 클래스에 대한 생성자(Class Constructor)
   */
   function Block($block,$numberOfPages,$pagePerBlock) 
   {
      $this->block = $block;
      $this->numberOfPages = $numberOfPages;
      $this->pagePerBlock = $pagePerBlock;
   }

   /*! 
     현재 블럭번호를 지정한 값으로 변경한다.
     arguments - 현재 페이지
     return - 현재 페이지가 속해있는 구역(블럭)번호
   */
   function setBlock($current_page) 
   {
      $this->block = ceil($current_page / $this->pagePerBlock);
   }
    
   /*!
     현재 블럭번호를 반환한다.  
   */
   function getBlock() 
   {
      return $this->block;
   }
    
   /*!
     현재 총 페이지 수를 지정한 값으로 변경한다.
   */
   function setNumberOfPages($no) 
   {
      $this->numberOfPages = $no;
   }
    
   /*!
     현재의 총 페이지 수를 반환한다.
   */
   function getNumberOfPages() 
   {
      return $this->numberOfPages;
   }
    
   /*!
     블럭당 페이지의 수를 지정한 값으로 변경한다.
   */
   function setPagePerBlock($no) 
   {
      $this->pagePerBlock = $no;
   }
    
   /*!
     현재 블럭당 페이지의 수를 반환한다.
   */
   function getPagePerBlock() 
   {
      return $this->pagePerBlock;
   }
    
   /*! 
     현재 총 페이지 수로부터 전체 출력 가능한 구역의 수를 반환한다.
   */
   function getTotalBlock() 
   {
      return ceil($this->numberOfPages/$this->pagePerBlock);
   }
 
   /*! 
     현재 블럭에서 출력할 첫번째 페이지 번호를 반환한다.
   */
   function getFirstPageInBlock() 
   {
      return ($this->block - 1) * $this->pagePerBlock;      
   }
    
   /*! 
     현재 블럭에서 출력할 마지막 페이지 번호를 반환한다.
   */
   function getLastPageInBlock() 
   {
      return $this->getBlock() * $this->getPagePerBlock();
   }
    
   /*! 
     이전 블록이 존재하면 true를 반환하고 그렇지 않으면 false를 반환한다.
   */
   function loadPreviousBlock() 
   {
      if($this->getBlock() > 1)
         return true;
      else
         return false;
   }
   
   /*! 
     다음 블록이 존재하면 true를 반환하고 그렇지 않으면 false를 반환한다.
   */
   function loadNextBlock() 
   {
      if($this->getBlock() < $this->getTotalBlock())  
         return true;
      else 
         return false;
   }
}
?>
