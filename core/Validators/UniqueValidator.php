<?php

class UniqueValidator extends Validator
{

  public function runValidation()
  {
    $value = $this->model->{$this->field};

    // allow unique validator to be used with empty strings for fields that are not required
    if ($value === '' || !isset($value)) return true;

    $conditions = ["{$this->field} = ?"];
    $bind = [$value];

    if (!empty($this->model->id)) {
      $conditions[] = "id != ?";
      $bind[] = $this->model->id;
    }

    foreach ($this->additionalFieldData as $adds) {
      $conditions[] = "{$adds} = ?";
      $bind[] = $this->model->{$adds};
    }

    $queryParams = ['conditions' => $conditions, 'bind' => $bind];

    return !$this->model::findFirst($queryParams);
  }
}
