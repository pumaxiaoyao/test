<?php  
  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */  
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "bank/bankViewHelper"));

class Bank  
{  
  
    function cardList()
    {  
        showCardList();   
    }  

    function cardListAjax(){
        $ret = array("sEcho"=>"1","iTotalRecords"=>"1","iTotalDisplayRecords"=>"1","aaData"=>array(),
            "pageIn"=>"54,421.10","pageOut"=>"0.00","totalIn"=>"62,471.10","totalOut"=>"0.00");
        echo json_encode($ret);
    }

    function bankPayment(){
        showbankPayment();
    }

    function merChant(){
        showmerChant();
    }
    
    function deposit(){
        showdeposit();
    }

    function depositAjax(){
        $ret = array("sEcho"=>"1","iTotalRecords"=>"1","iTotalDisplayRecords"=>"1","total_amount"=>"7,204,837.24","amount"=>"54,421.10",
        "aaData"=>array());
        echo json_encode($ret);
    }
}  
  
  
?>  