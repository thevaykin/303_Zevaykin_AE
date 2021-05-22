<?php
    function employee_number_validation( $id, $rows){
        if ( !is_numeric($id) ) return False;
    
        if( !empty($rows) )
            if( $rows[0][0] <= $id && $rows[ count($rows)-1 ][0] >= $id )
                return True;
        
        return False;
    }
?>