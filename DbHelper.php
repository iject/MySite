<?php

/*use Exception;
use mysqli;*/

class DbHelper
{
    private const dbName = "lectionsite"; // const указывается без '$'
    private static ?DbHelper $instance = null;
    private $conn;

    public static function getInstance(
        $host = null, $port = null, $user = null, $pass = null
    ) : DbHelper
    {
        if (self::$instance === null)
            self::$instance = new DbHelper($host, $port, $user, $pass);
        return self::$instance;
    }

    public function __construct(
        $host, $port, $user, $pass
    )
    {
        $this->conn = new mysqli();
        $this->conn->connect(
            hostname: $host,
            username: $user,
            password: $pass,
            database: self::dbName, // self - это как this,
            // но для статических переменных
            port: $port
        );
    }

    public function getTitle($url): string
    {
        $sql = "SELECT title FROM pages2 WHERE url=? or alias = ?";
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $url, $url);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $stmt->close();
        $this->conn->commit(); // завершает транзакцию
        return ($row !== null && $row !== false) ? $row[0] : "";
    }

    public function getPagesInfo() : array
    {
        $sql = "SELECT * FROM pages2";
        $this->conn->begin_transaction();
        $result = $this->conn->query($sql);
        $rec_arr = $result->fetch_all(MYSQLI_ASSOC);
        $result->free_result();
        $this->conn->commit();

        return $rec_arr;
    }

    public function getUserPassword(string $user): ?string
    {
        $sql = "SELECT password FROM users WHERE login = ?";
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $this->conn->commit(); // завершает транзакцию
        return ($row === null) ? $row : $row['password'];
    }

    public function isSecure(string $page)
    {
        $sql = "SELECT secure FROM pages2 WHERE url = ? or alias = ?";
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $page, $page);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $this->conn->commit(); // завершает транзакцию
        return $row !== null && $row['secure'];
    }

    public function getUserName(string $user): ?string
    {
        $sql = "SELECT name FROM users WHERE login = ?";
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $this->conn->commit(); // завершает транзакцию
        return ($row === null) ? $row : $row['name'];
    }

    public function saveUser(string $login, string $password, string $name)
    {
        $sql = "INSERT INTO users (login, password, name) VALUES(?, ?, ?)";
        try {
            $this->conn->begin_transaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $login, $password, $name);
            if (!$stmt->execute()) throw new Exception("Ошибка добавления пользователя");
            $this->conn->commit();
            return true;
        } catch (\Throwable $ex){
            $this->conn->rollback();
            return false;
        }
    }
}