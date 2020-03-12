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

  protected function read($table, $params = [], $class)
  {
    $columns = '*';
    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';
    $offset = '';

    if (isset($params['fetchStyle'])) {
      $this->fetchStyle = $params['fetchStyle'];
    }

    if (isset($params['conditions'])) {
      if (is_array($params['conditions'])) {
        foreach ($params['conditions'] as $condition) {
          $conditionString .= " {$condition} AND";
        }
        $conditionString = rtrim(trim($conditionString), 'AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if ($conditionString !== '') {
        $conditionString = " WHERE {$conditionString}";
      }
    }

    if (array_key_exists('columns', $params)) {
      $columns = $params['columns'];
    }

    if (array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }

    if (array_key_exists('order', $params)) {
      $order = " ORDER BY {$params['order']}";
    }

    if (array_key_exists('limit', $params)) {
      $limit = " LIMIT {$params['limit']}";
    }

    if (array_key_exists('offset', $params)) {
      $offset = " OFFSET {$params['offset']}";
    }

    $sql = "SELECT {$columns} FROM {$table} {$conditionString} {$order} {$limit} {$offset}";

    if ($this->query($sql, $bind, $class)) {
      return count($this->result) ? true : false;
    }
    return false;
  }

  public function insert($table, $fields = [])
  {
    $fieldString = '';
    $valueString = '';
    $values = [];

    foreach ($fields as $field => $value) {
      $fieldString .= "`{$field}`,";
      $valueString .= '?,';
      array_push($values, $value);
    }

    $fieldString = rtrim($fieldString, ',');
    $valueString = rtrim($valueString, ',');
    $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

    return !$this->query($sql, $values)->error() ? true : false;
  }

  public function find($table, $params = [], $class = false)
  {
    return $this->read($table, $params, $class) ? $this->results() : false;
  }

  public function findFirst($table, $params = [], $class = false)
  {
    return $this->read($table, $params, $class) ? $this->first() : false;
  }

  public function update($table, $id, $fields = [])
  {
    $fieldString = '';
    $values = [];

    foreach ($fields as $field => $value) {
      $fieldString .= " {$field} = ?,";
      array_push($values, $value);
    }

    $fieldString = rtrim(trim($fieldString), ',');
    $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";

    return !$this->query($sql, $values)->error() ? true : false;
  }

  public function delete($table, $id)
  {
    $sql = "DELETE FROM {$table} WHERE id = {$id}";

    return !$this->query($sql)->error() ? true : false;
  }

  public function results()
  {
    return $this->result;
  }

  public function first()
  {
    return !empty($this->result) ? $this->result[0] : [];
  }

  public function count()
  {
    return $this->count;
  }

  public function lastId()
  {
    return $this->lastInsertId;
  }

  public function getColumns($table)
  {
    return $this->query("SHOW COLUMNS FROM {$table}")->results();
  }

  public function error()
  {
    return $this->error();
  }
}
