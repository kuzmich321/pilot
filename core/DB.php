<?php

class DB
{
  private static $instance = null;
  private $pdo, $query, $error = false, $result, $count = 0, $lastInsertId = null, $fetchStyle = PDO::FETCH_OBJ;

  private function __construct()
  {
    try {
      $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function query($sql, $params = [], $class = false)
  {
    $this->error = false;
    if ($this->query = $this->pdo->prepare($sql)) {
      $x = 1;

      if (count($params)) {
        foreach ($params as $param) {
          $this->query->bindValue($x, $param);
          $x++;
        }
      }

      if ($this->query->execute()) {
        $this->result = ($class && $this->fetchStyle === PDO::FETCH_CLASS) ?
          $this->query->fetchAll($this->fetchStyle, $class) : $this->query->fetchAll($this->fetchStyle);

        $this->count = $this->query->rowCount();
        $this->lastInsertId = $this->pdo->lastInsertId();
      } else {
        $this->error = true;
      }
    }
    return $this;
  }
}
