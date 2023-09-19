<?php
class Finance
{

  private User $user;

  function __construct(User $user)
  {
    $this->user = $user;
  }

  function init(){
    $users = $this->user->getUsers();
    foreach($users as $user) {
      $username = $user["username"];
      if (!isset($_SESSION[$username])) {
        $_SESSION[$username] = array(
          "balance" => 0,
          "history" => array()
        );
      }
    }
  }

  function deposit()
  {
    $username = $this->user->getUserLogin();
    $amount = $_POST["amount"];
    if ($amount > 0) {
      $balance = $_SESSION[$username]["balance"];
      $balance += $amount;
      $_SESSION[$username]["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION[$username]["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Deposit",
          "debit" => $amount,
          "credit" => null,
          "balance" => $balance,
          "description" => null
        )
      );

      return "Success";
    }
  }

  function withdraw()
  {
    $username = $this->user->getUserLogin();
    $amount = $_POST["amount"];
    $balance = $_SESSION[$username]["balance"];
    if ($balance >= $amount) {
      $balance -= $amount;
      $_SESSION[$username]["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION[$username]["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Withdraw",
          "debit" => null,
          "credit" => $amount,
          "balance" => $balance,
          "description" => null
        )
      );

      return "Success";
    } else {
      return "Your balance is insufficient";
    }
  }

  function transfer()
  {
    $from = $this->user->getUserLogin();
    $amount = $_POST["amount"];
    $to = $_POST["to"];
    if(!$this->user->checkUser($to)){
      return "Failed";
    }

    if ($amount > 0 && !empty($to)) {
      $balance = $_SESSION[$from]["balance"];
      $balance -= $amount;
      $_SESSION[$from]["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION[$from]["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Transfer",
          "debit" => null,
          "credit" => $amount,
          "balance" => $balance,
          "description" => "Transfer to $to"
        )
      );

      $balance = $_SESSION[$to]["balance"];
      $balance += $amount;
      $_SESSION[$to]["balance"] = $balance;

      $timestamp = time();
      array_push(
        $_SESSION[$to]["history"],
        array(
          "time" => date("Y-m-d G:i", $timestamp),
          "type" => "Transfer",
          "debit" => $amount,
          "credit" => null,
          "balance" => $balance,
          "description" => "Transfer from $from"
        )
      );

      return "Success";
    }
  }

  function checkBalance()
  {
    $username = $this->user->getUserLogin();
    return $_SESSION[$username]["balance"];
  }

  function getHistory()
  {
    $username = $this->user->getUserLogin();
    return $_SESSION[$username]["history"];
  }
}
?>