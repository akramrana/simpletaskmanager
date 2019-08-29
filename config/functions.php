<?php

function debugPrint($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
function generateRecursiveTaskList($tasks)
{
    $htm = '<ul>';
    if(!empty($tasks)){
        foreach ($tasks as $t){
            $htm.='<li>'.$t['title'].'</li>';
            if(!empty($t['sub_task'])){
                $htm.='<li>'.generateRecursiveTaskList($t['sub_task']).'</li>';
            }
        }
    }
    $htm.= '</ul>';
    return $htm;
}