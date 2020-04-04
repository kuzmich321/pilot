<?php

class RequiredValidator extends Validator
{
  public function runValidation()
  {
    $value = trim($this->model->{$this->field});
    return ($value != '' && isset($value));
  }
}
