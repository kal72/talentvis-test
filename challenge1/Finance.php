<?php
  class Finance {
  
    function __construct() {
      if (!isset($_SESSION["balance"])) {
        $_SESSION["balance"] = 0;
      }
    }

    function deposit() {
      $amount =  $_POST["amount"];
      if ($amount > 0){
        $balance = $_SESSION["balance"];
        $_SESSION["balance"] = $balance + $amount;
        return "Success";
      } 
    }
  
    function withdraw() {
      $amount =  $_POST["amount"];
      $balance = $_SESSION["balance"];
      if ($balance >= $amount){
        $_SESSION["balance"] = $balance - $amount;
        return "Success";
      } else {
        return "Your balance is insufficient";
      }
    }
  
    function checkBalance() {
      return $_SESSION["balance"];
    }
  }
?>