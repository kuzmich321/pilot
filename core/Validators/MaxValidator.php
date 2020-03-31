<?php

class MaxValidator extends Validator
{

  public function runValidation()
  {
    $value = $this->model->{$this->field};

    return strlen($value) <= $this->rule;
  }
}
