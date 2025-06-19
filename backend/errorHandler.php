<?php 
    function error_Handler(&$warning, $message){
        $warning['status'] = true;
        $warning['message'] = $message;
    }
?>