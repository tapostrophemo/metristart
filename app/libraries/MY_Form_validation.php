<?php

class MY_Form_validation extends CI_Form_validation
{
  function mm_yyyy($str, $field) {
    if (empty($str)) {
      $flag = false;
    }
    else {
      $flag = preg_match('/^\d{2}\/\d{4}$/', $str) > 0;
    }

    if (!$flag) {
      $this->set_message('mm_yyyy', 'The %s field must be a date in MM/YYYY format.');
    }

    return $flag;
  }
}

