<?php

namespace App\Models;
use DateTime;

class Now implements NowInterface
{
  public function returnNow():string
  {
    return (new DateTime())->format('Y-m-d H:i:s.v');
  }
}