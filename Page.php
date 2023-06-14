<?php


abstract class Page
{
    public function show()
    {
        print "<html lang = 'ru'>";
        $this->createHeading();
        $this->createBody();
        print "</html>";
    }

    private function createHeading()
    {
        ?>
        <head>
            <link rel="stylesheet" type="text/css" href="main.css">
            <meta charset="utf-8"/>
            <title><?php print($this->getTitle()) ?></title>
        </head>
        <?php

    }

    private function createBody()
    {
        print "<body>";
        print "<div class='main'>";

        $this->showHeader();
        $this->showMenu();

        print "<div class='content'>";
        $this->showContent();
        print "</div>";

        $this->showFooter();

        print "</div>";
        print "</body>";
    }

    protected abstract function showContent();

    private function showHeader()
    {
        ?>
        <div class='header'>
            <?php print($this->getTitle())?>
        </div>
        <?php
    }

    private function showMenu()
    {
        print "<div class='menu'>Тут будет меню";
        /*$pages_info = $this->dbh->getPagesInfo();
        foreach ($pages_info as $index => $page_info)
        {
            $curr_page = (($page_info['url'] === $this->getUrl()) || ($page_info['alias'] === $this->getUrl()));
            print "<div class = 'menuitem'>";
            if (!$curr_page)
                print "<a class='l_menuitem' href={$page_info['url']}>";
            print $page_info['name'];
            if (!$curr_page) print "</a>";
            print "</div>";
        }*/
        print "</div>";

    }

    private function showFooter()
    {
        print "<div class='footer'>(づ｡◕‿‿◕｡)づ";
//        if (isset($_SESSION['login']))
//        {
//            print "<br><a href='/27.04.23/auth.php?exit=1'>Выход</a>";
//        }
        print "</div>";
    }

    private function getTitle() : string
    {
        //return $this->dbh->getTitle($this->getUrl());
        return "Тут будет заголовок";
    }

    private function getUrl(): string
    {
        // Заменил mb_split на explode, и лимит увеличил с 1 до 2
        return explode("?", $_SERVER['REQUEST_URI'], 2)[0] ;
    }


}