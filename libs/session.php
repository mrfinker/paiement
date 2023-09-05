<?php

class Session
{

  public static function init()
  {
    @session_start();
  }

  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }else{
      header("Location".LOGIN);
      exit;
    }
  }

  public static function destroy()
  {
    // session.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_start();
  // Vous pouvez exécuter d'autres actions de nettoyage ici si nécessaire
  session_unset();
  session_destroy();
  header("location:".LOGIN);
  exit;
}

 }
}
