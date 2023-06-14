<?php

require_once "Page.php";

class reg extends Page
{
    protected function showContent()
    {
        ?>
        <form method="post" action="reg.php">
            <div class="container">
                <label>
                    <b>Логин</b>
                    <input type="text" placeholder="Введите логин" name="login">
                </label>

                <label>
                    <b>Пароль</b>
                <input type="password" placeholder="Введите пароль" name="psw">
                </label>

                <label>
                    <b>Повторите пароль</b>
                <input type="password" placeholder="Повторите пароль" name="psw-repeat">
                </label>

                <button type="submit" class="registerbtn">Зарегистрироваться</button>
                <div class="signin">
                    <p>У вас уже есть аккаунт? <a href="#">Войти</a>.</p>
                </div>
            </div>
        </form>
    <?php
    }
}
(new reg())->show_table();