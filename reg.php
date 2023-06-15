<?php

require_once "Page.php";

class reg extends Page
{
    private $error;

    public function __construct()
    {
        parent::__construct();
        if (isset($_POST['login']))
            $this->error = $this->regUser();
    }
    protected function showContent()
    {
        switch ($this->error){
            case 1:{
                $e_msg = "Неверный логин!";
                break;
            }
            case 2:{
                $e_msg = "Неверный пароль!";
                break;
            }
            case 3:{
                $e_msg = "Пароли не совпадают!";
                break;
            }
            case 4:{
                $e_msg = "Неверное имя пользователя!";
                break;
            }
            case -1:{
                $e_msg = "Заполните все поля формы!";
                break;
            }
            case -2:{
                $e_msg = "Не удалось зарегистрировать пользователя. Возможно такое имя уже занято!";
                break;
            }
        }
        if (isset($e_msg)) print ("<div class='error'>$e_msg</div>");
        ?>
        <form method="post" action="/PHPsite/reg.php">
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

                <label>
                    <b>Повторите пароль</b>
                    <input type="password" placeholder="Повторите пароль"
                           value="<?php print($_POST['psw-repeat'] ?? '');?>"
                           name="psw-repeat">
                </label>
                <label>
                    <b>Ваше имя</b>
                    <input type="text" placeholder="Введите фамилию и имя"
                           value="<?php print($_POST['name'] ?? '');?>"
                           name="name">
                </label>

                <button type="submit" class="registerbtn">Зарегистрироваться</button>
                <div class="signin">
                    <p>У вас уже есть аккаунт? <a href="/PHPsite/auth.php">Войти</a>.</p>
                </div>
            </div>
        </form>
    <?php
    }

    private function regUser()
    {
        $error = 0;
        if (!empty($_POST['login']) &&
            !empty($_POST['psw']) &&
            !empty($_POST['psw-repeat']) &&
            !empty($_POST['name']))
        {
            $login = htmlspecialchars($_POST['login']);
            if (mb_strlen($login) < 4 || mb_strlen($login) > 30) $error = 1;
            $psw = htmlspecialchars($_POST['psw']);
            if (mb_strlen($psw) < 6 || mb_strlen($psw) > 30) $error = 2;if (mb_strlen($psw) < 6 || mb_strlen($psw) > 30) $error = 2;if (mb_strlen($psw) < 6 || mb_strlen($psw) > 30) $error = 2;
            $psw_rep = htmlspecialchars($_POST['psw-repeat']);
            if ($psw !== $psw_rep) $error = 3;
            $name = htmlspecialchars($_POST['name']);
            if (mb_strlen($name) < 2 || mb_strlen($psw) > 100) $error = 4;
        } else $error = -1;
        if ($error === 0)
        {
            $dbh = DbHelper::getInstance();
            $hash = password_hash($psw, PASSWORD_DEFAULT);
            if (!$dbh->saveUser($login, $hash, $name)) $error = -2;
            // Если рег-я прошла успешно, то войти в аккаунт
        }
        return $error;
    }
}
(new reg())->show_table();