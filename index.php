<?php

require_once "Page.php";


class index extends Page
{
    protected function showContent()
    {
        print "<b>ОСНОВНОЙ КОНТЕНТ СТРАНИЦЫ</b>";
    }
}

(new index())->show();