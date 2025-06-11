<?php
    function group1(){
        return ['2'];
    }
    
    function group2(){
        return ['6'];
    }

    function group3(){
        return ['1', '3', '5'];
    }

    function roleAvailable(){
        return ['2', '6'];
    }

    function canAddModul($role){
        if (in_array($role, group1())) {
            return true;
        }
    }
?>