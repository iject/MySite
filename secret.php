<?php

require_once "Page.php";

class secret extends Page
{
    protected function showContent()
    {
        $name = DbHelper::getInstance()->getUserName($_SESSION['login']);
        print "<div>Приветствуем, ".$name."</div>";
        print "<div>Личный кабинет...</div>";
    }
}

(new secret())->show();