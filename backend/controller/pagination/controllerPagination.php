<?php

include '../../config/config.php';

class PagePagination  extends Database
{
        
   function displayPaginationBelow($page, $per_page, $table = "barcode_info" ){
        
        $DB = new Database;
        $DB->connect();
        $DB->select($table, 'COUNT(*) as totalCount', '1');
        $getRow = $DB->getResult();
       
      
        echo "<pre>" . print_r($page, 1) . "</pre>";
        
        $page_url= '?' . $_SERVER['QUERY_STRING'] . '&';
   
    	$total =$getRow[0]['totalCount'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $setLastpage = ceil($total/$per_page);
    	$lpm1 = $setLastpage - 1;
    
    	$setPaginate = "";
    	if($setLastpage > 1)
    	{	
            
                $setPaginate .= '<div class="col col-xs-offset-3 col-xs-6">';
                    $setPaginate .= '<nav aria-label="Page navigation" class="text-center">';
                        $setPaginate .= "<ul class='pagination'>";
                            $setPaginate .= "<li class='setPage'>Страници $page от $setLastpage</li>";
                        if ($setLastpage < 7 + ($adjacents * 2))
                        {	
                                for ($counter = 1; $counter <= $setLastpage; $counter++)
                                {
                                        if ($counter == $page)
                                                $setPaginate.= "<li><a aria-label='Предишна'>$counter</a></li>";
                                        else
                                                $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                                }
                        }
                        elseif($setLastpage > 5 + ($adjacents * 2))
                        {
                                if($page < 1 + ($adjacents * 2))		
                                {
                                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                                        {
                                                if ($counter == $page)
                                                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                                                else
                                                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                                        }
                                        $setPaginate.= "<li class='dot'>...</li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                                }
                                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                                {
                                        $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                                        $setPaginate.= "<li class='dot'>...</li>";
                                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                                        {
                                                if ($counter == $page)
                                                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                                                else
                                                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                                        }
                                        $setPaginate.= "<li class='dot'>..</li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                                }
                                else
                                {
                                        $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                                        $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                                        $setPaginate.= "<li class='dot'>..</li>";
                                        for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
                                        {
                                                if ($counter == $page)
                                                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                                                else
                                                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                                        }
                                }
                        }
    		
                        if ($page < $counter - 1){ 
                                $setPaginate.= "<li><a href='{$page_url}page=$next'>Следваща</a></li>";
                        $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Последна</a></li>";
                        }else{
                                $setPaginate.= "<li><a class='current_page'>Следваща</a></li>";
                        $setPaginate.= "<li><a class='current_page'>Последна</a></li>";

                        }

                    $setPaginate.= "</ul>\n";		
            $setPaginate .="</div>\n";		
        $setPaginate .="</div>\n";		
    	}   
        
        return $setPaginate;
    } 
}
