<?php
date_default_timezone_set("Asia/Jakarta");
session_start();

include 'User.php';
include 'Finance.php';

$user = new User();
$user->init();
$finance = new Finance($user);
$finance->init();

$username = null;
if ($user->isLogin()) {
    $username = $user->getUserLogin();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php if ($user->isLogin()) { ?>
        <div style="margin: auto; width: 50%; border: 3px solid green; padding: 10px;">
            <form action="index.php" method="GET">
                <input type="submit" name="act" value="deposit" />
                <input type="submit" name="act" value="withdraw" />
                <input type="submit" name="act" value="transfer" />
                <input type="submit" name="act" value="check_balance" />
                <input type="submit" name="act" value="history" />
                <a style="float: right;" href="index.php?act=logout">Logout</a>
            </form>
            
        </div>
    <?php } ?>

    <div style="margin: auto; width: 50%; padding: 10px;">
        <?php
        if ($user->isLogin()) {
            echo "<span>Welcome <b>$username</b>,</span>";

            if (isset($_GET['act'])) {
                switch ($_GET['act']) {
                    case 'deposit':
                        ?>
                        <h4>Deposit</h4>
                        <form action="index.php?act=deposit_req" method="POST">
                            <label>Amount: </label>
                            <input type="number" min="0" name="amount" />
                            <input type="submit" value="Submit" />
                        </form>
                        <?php
                        break;
                    case 'withdraw':
                        ?>
                        <h4>Withdraw</h4>
                        <form action="index.php?act=withdraw_req" method="POST">
                            <label>Amount: </label>
                            <input type="number" min="0" name="amount" />
                            <input type="submit" value="Submit" />
                        </form>
                        <?php
                        break;
                    case 'transfer':
                        ?>
                        <h4>Withdraw</h4>
                        <form action="index.php?act=transfer_req" method="POST">
                            <label>Amount: </label>
                            <input type="number" min="0" name="amount" />
                            <label>To: </label>
                            <input type="text" min="0" name="to" />
                            <input type="submit" value="Submit" />
                        </form>
                        <?php
                        break;
                    case 'check_balance':
                        $balance = $finance->checkBalance();
                        echo "<h3>Your balance = $balance </h3>";
                        break;
                    case 'history':
                        $histories = $finance->getHistory();
                        ?>
                        <h4>History</h4>
                        <table>
                            <tr>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Description</th>
                            </tr>
                            <?php
                            if (empty($histories)) {
                                echo '<tr><td colspan="6" style="text-align: center;">no records found.</td></tr>';
                            } else {
                                foreach ($histories as $val) {
                                    echo '<tr>
                                            <td>' . $val["time"] . '</td>
                                            <td>' . $val["type"] . '</td>
                                            <td>' . $val["debit"] . '</td>
                                            <td>' . $val["credit"] . '</td>
                                            <td>' . $val["balance"] . '</td>
                                            <td>' . $val["description"] . '</td>
                                            </tr>';
                                }
                            }
                            ?>

                        </table>
                        <?php
                        break;
                    case 'deposit_req':
                        if (isset($_POST)) {
                            $result = $finance->deposit();
                            echo "<h3>$result</h3>";
                        }
                        break;
                    case 'withdraw_req':
                        if (isset($_POST)) {
                            $result = $finance->withdraw();
                            echo "<h3>$result</h3>";
                        }
                        break;
                    case 'transfer_req':
                        if (isset($_POST)) {
                            $result = $finance->transfer();
                            echo "<h3>$result</h3>";
                        }
                        break;
                    case 'reset':
                        session_destroy();
                        echo "<h3>Reset success.</h3>";
                        header("location:index.php");
                        break;
                     case 'logout':
                        $user->logout();
                        break;
                    default:
                        break;
                }
            }
        } else {
            ?>

            <h4>Login</h4>
            <form action="index.php?act=login_req" method="POST">
                <label>Username: </label>
                <input type="text" min="0" name="username" />
                <label>Password: </label>
                <input type="password" min="0" name="password" />
                <input type="submit" value="Submit" />
            </form>

            <?php
            if (isset($_GET['act'])) {
                if($_GET['act'] == "login_req"){
                    $user->login();
                }
            }
        }
        ?>
    </div>
</body>

</html>