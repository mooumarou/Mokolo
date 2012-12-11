<?php


  class messageStack extends tableBox {

// class constructor
    function messageStack() {
      global $messageToStack;

      $this->messages = array();

      if (mm_session_is_registered('messageToStack')) {
        for ($i=0, $n=sizeof($messageToStack); $i<$n; $i++) {
          $this->add($messageToStack[$i]['class'], $messageToStack[$i]['text'], $messageToStack[$i]['type']);
        }
        mm_session_unregister('messageToStack');
      }
    }

// class methods
    function add($class, $message, $type = 'error') {
      if ($type == 'error') {
        $this->messages[] = array('params' => 'class="messageStackError"', 'class' => $class, 'text' => mm_image(DIR_WS_ICONS . 'error.gif', ICON_ERROR) . '&nbsp;' . $message);
      } elseif ($type == 'warning') {
        $this->messages[] = array('params' => 'class="messageStackWarning"', 'class' => $class, 'text' => mm_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . '&nbsp;' . $message);
      } elseif ($type == 'success') {
        $this->messages[] = array('params' => 'class="messageStackSuccess"', 'class' => $class, 'text' => mm_image(DIR_WS_ICONS . 'success.gif', ICON_SUCCESS) . '&nbsp;' . $message);
      } else {
        $this->messages[] = array('params' => 'class="messageStackError"', 'class' => $class, 'text' => $message);
      }
    }

    function add_session($class, $message, $type = 'error') {
      global $messageToStack;

      if (!mm_session_is_registered('messageToStack')) {
        mm_session_register('messageToStack');
        $messageToStack = array();
      }

      $messageToStack[] = array('class' => $class, 'text' => $message, 'type' => $type);
    }

    function reset() {
      $this->messages = array();
    }

    function output($class) {
      $this->table_data_parameters = 'class="messageBox"';

      $output = array();
      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $output[] = $this->messages[$i];
        }
      }

      return $this->tableBox($output);
    }

    function size($class) {
      $count = 0;

      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $count++;
        }
      }

      return $count;
    }
  }
?>
