<?php

require_once "Page.php";

class auth extends Page
{
    private ?bool $auth;

    public function __construct()
    {
        parent::__construct();
        if (isset($_REQUEST['exit']))
        {
            unset($_SESSION['login']);
            header("Location: /PHPsite/index.php");
        }
        else
            $this->auth = $this->auth();
        if ($this->auth){
//            header("Location: {$_SESSION['requested_page']}");
            header("Location: /PHPsite/index.php");
        }
    }

    protected function showContent()
    {
        if ($this->auth === false) {
            print "<div class='error'>Введен неверный логин или пароль</div>";
            // Тут добавить варианты ошибок
        }
        elseif ($this->auth === null)
        {
            print "<div class='error'>Заполните все поля</div>";
        }
        ?>
        <form method="post" action="/PHPsite/auth.php">
            <div class="container">
                <label>
                    <b>Логин</b>
                    <input type="text" placeholder="Введите логин"
                           value="<?php print($_POST['login'] ?? '');?>"
                           name="login">
                </label>

                <label>
                    <b>Пароль</b>
                    <input type="password" placeholder="Введите пароль"
                           value="<?php print($_POST['psw'] ?? '');?>"
                           name="psw">
                </label>

                <button type="submit" class="registerbtn">Войти</button>
                <div class="signin">
                    <p>Вы не зарегистрированы? <a href="/PHPsite/reg.php">Зарегистрироваться</a>.</p>
                </div>
            </div>
        </form>
        <?php
    }

    private function auth(): ?bool
    {
        if (!isset($_POST['login']) || !isset($_POST['psw']) || mb_strlen($_POST['login']) < 3 || mb_strlen($_POST['psw']) < 6)
            return null;
        // Тут добавить проверку на ошибки

        $login = $_POST['login'];
        $psw = $_POST['psw'];
        $save_psw = DbHelper::getInstance()->getUserPassword($login) ?? "";
//        $auth = strcmp($password, $save_pwd) === 0;
        $auth = password_verify($psw, $save_psw);

        if ($auth) $_SESSION['login'] = $login;
        else unset($_SESSION['login']);
        return $auth;
    }
}

(new auth())->show_table();