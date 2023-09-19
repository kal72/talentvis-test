<?php
class Finance
{

  function __construct()
  {
    if (!isset($_SESSION["balance"])) {
      $_SESSION["balance"] = 0;
    }

    if (!isset($_SESSION["history"])) {
      $_SESSION["history"] = array();
    }
  }

  function deposit()
  {
    $amount = $_POST["amount"];
    if ($amount > 0) {
      $balance = $_SESSION["balance"];
      $balance += $amount;
      $_SESSION["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Deposit",
          "debit" => $amount,
          "credit" => null,
          "balance" => $balance
        )
      );

      return "Success";
    }
  }

  function withdraw()
  {
    $amount = $_POST["amount"];
    $balance = $_SESSION["balance"];
    if ($balance >= $amount) {
      $balance -= $amount;
      $_SESSION["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Withdraw",
          "debit" => null,
          "credit" => $amount,
          "balance" => $balance
        )
      );

      return "Success";
    } else {
      return "Your balance is insufficient";
    }
  }

  function checkBalance()
  {
    return $_SESSION["balance"];
  }

  function getHistory()
  {
    return $_SESSION["history"];
  }
}
?>