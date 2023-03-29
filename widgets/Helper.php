<?php
function dd($data,$exit=true)
{
    echo "<pre>"; 
    print_r($data); 
    echo "</pre>"; 
    if($exit){
        exit;
    }
}