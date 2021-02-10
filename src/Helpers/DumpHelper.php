<?php

if(!function_exists("dd") && function_exists("dump")){
    function dd($var){
        dump($var);
    }
}
