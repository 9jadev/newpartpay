<?php

namespace App\Channels\Messages;

class SmartMessage
{
   public $content;
  
   public function __construct($content = '')
   {
       $this->content = $content;
   }
   /**
    * Set the message content.
    *
    * @param string $content
    *
    * @return $this
    */
   public function content(string $content)
   {
       $this->content = trim($content);
       return $this;
   }
}