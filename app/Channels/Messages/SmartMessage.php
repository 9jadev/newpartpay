<?php

namespace App\Channels\Messages;

class SmartMessage
{
   public $content;
  
  public function content($content)
  {
    $this->content = $content;

    return $this;
  }
}