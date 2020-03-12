<?php

class Model
{
  protected static $db, $table, $softDelete = false;
  public $id;
  protected $modelName;

  public function __construct()
  {
    $this->modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', static::$table)));
    $this->onConstruct();
  }

  public function onConstruct()
  {
  }

  public static function find($params = [])
  {
    $params = static::fetchStyleParams($params);
    $params = static::softDeleteParams($params);
    $resultsQuery = static::getDb()->find(static::$table, $params, static::class);

    return $resultsQuery ? $resultsQuery : [];
  }

  protected static function fetchStyleParams($params)
  {
    if (!isset($params['fetchStyle'])) {
      $params['fetchStyle'] = PDO::FETCH_CLASS;
    }
    return $params;
  }

  protected static function softDeleteParams($params)
  {
    if (static::$softDelete) {
      if (array_key_exists('conditions', $params)) {
        if (is_array($params['conditions'])) {
          $params['conditions'][] = "deleted != 1";
        } else {
          $params['conditions'] .= " AND deleted != 1";
        }
      } else {
        $params['conditions'] = "deleted != 1";
      }
    }
    return $params;
  }

  public static function findById($id)
  {
    return static::findFirst(['conditions' => 'id = ?', 'bind' => [$id]]);
  }

  public static function findFirst($params = [])
  {
    $params = static::fetchStyleParams($params);
    $params = static::softDeleteParams($params);

    return static::getDb()->findFirst(static::$table, $params, static::class);
  }

  public function getColumnsForSaving()
  {
    $columns = static::getColumns();
    $fields = [];

    foreach ($columns as $column) {
      $key = $column->Field;
      $fields[$key] = $this->{$key};
    }

    return $fields;
  }

  public static function getColumns()
  {
    return static::getDb()->getColumns(static::$table);
  }

  public static function getDb()
  {
    if (!self::$db) {
      self::$db = DB::getInstance();
    }
    return self::$db;
  }
}
