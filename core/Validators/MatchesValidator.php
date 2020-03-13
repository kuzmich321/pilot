<?php

class MatchesValidator extends Validator
{
  public function runValidation()
  {
    return $this->model->{$this->field} === $this->rule;
  }
}
