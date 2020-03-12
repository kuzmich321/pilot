<?php

class Model
{
  protected static $db, $table, $softDelete = false;
  public $id;
  protected $modelName, $validates = true, $validationErrors = [];

  public function __construct()
  {
    $this->modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', static::$table)));
    $this->onConstruct();
  }

  public static function getDb()
  {
    if (!self::$db) {
      self::$db = DB::getInstance();
    }
    return self::$db;
  }

  public static function getColumns()
  {
    return static::getDb()->getColumns(static::$table);
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

  protected static function fetchStyleParams($params)
  {
    if (!isset($params['fetchStyle'])) {
      $params['fetchStyle'] = PDO::FETCH_CLASS;
    }
    return $params;
  }

  public static function find($params = [])
  {
    $params = static::fetchStyleParams($params);
    $params = static::softDeleteParams($params);
    $resultsQuery = static::getDb()->find(static::$table, $params, static::class);

    return $resultsQuery ? $resultsQuery : [];
  }

  public static function findFirst($params = [])
  {
    $params = static::fetchStyleParams($params);
    $params = static::softDeleteParams($params);

    return static::getDb()->findFirst(static::$table, $params, static::class);
  }

  public static function findById($id)
  {
    return static::findFirst(['conditions' => 'id = ?', 'bind' => [$id]]);
  }

  public function save()
  {
    $this->validator();
    $save = false;

    if ($this->validates) {
      $this->beforeSave();
      $fields = $this->getColumnsForSaving();
      if ($this->isNew()) {
        $save = $this->insert($fields);
        if ($save) {
          $this->id = static::getDb()->lastId();
        }
      } else {
        $save = $this->update($fields);
      }
      if ($save) {
        $this->afterSave();
      }
    }
    return $save;
  }

  public function insert($fields)
  {
    if (empty($fields)) return false;
    if (array_key_exists('id', $fields)) unset($fields['id']);
    return static::getDb()->insert(static::$table, $fields);
  }

  public function update($fields)
  {
    return (empty($fields) || $this->id === '') ? false : static::getDb()->update(static::$table, $this->id, $fields);
  }

  public function beforeSave()
  {
    //
  }

  public function afterSave()
  {
    //
  }

  public function validator()
  {
    //
  }

  public function onConstruct()
  {
    //
  }

  protected function isNew()
  {
    return (property_exists($this, 'id') && !empty($this->id)) ? false : true;
  }
}
