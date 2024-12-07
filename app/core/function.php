<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

function showPre($txt)
{
    echo '<pre>';
    print_r($txt);
    echo '</pre>';
}