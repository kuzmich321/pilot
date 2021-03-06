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

  public function delete()
  {
    if ($this->id === '' || !isset($this->id)) return false;
    $this->beforeDelete();
    $deleted = static::$softDelete ? $this->update(['deleted' => 1]) : static::getDb()->delete(static::$table, $this->id);
    $this->afterDelete();

    return $deleted;
  }

  public function query($sql, $bind = [])
  {
    return static::getDb()->query($sql, $bind);
  }

  public function data()
  {
    $data = new stdClass();
    foreach (static::getColumns() as $column) {
      $columnName = $column->Field;
      $data->{$columnName} = $this->{$columnName};
    }
    return $data;
  }

  public function assign($params)
  {
    if (!empty($params)) {
      foreach ($params as $key => $value) {
        if (property_exists($this, $key)) {
          $this->$key = sanitize($value);
        }
      }
      return true;
    } else {
      return false;
    }
  }

  public function runValidation($validator)
  {
    $key = $validator->field;
    if (!$validator->success) {
      $this->addErrorMessage($key, $validator->msg);
    }
  }

  public function getErrorMessages()
  {
    return $this->validationErrors;
  }

  public function validationPassed()
  {
    return $this->validates;
  }

  public function addErrorMessage($field, $msg)
  {
    $this->validates = false;
    if (array_key_exists($field, $this->validationErrors)) {
      $this->validationErrors[$field] .= " {$msg}";
    } else {
      $this->validationErrors[$field] = $msg;
    }
  }

  public function beforeSave()
  {
    //
  }

  public function afterSave()
  {
    //
  }

  public function beforeDelete()
  {
    //
  }

  public function afterDelete()
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
