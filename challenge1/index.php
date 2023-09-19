<?php 
    session_start();
    include 'Finance.php';
    $finance = new Finance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
</head>

<body>
    <div style="margin: auto; width: 50%; border: 3px solid green; padding: 10px;">
        <form action="index.php" method="GET">
            <input type="submit" name="act" value="deposit" />
            <input type="submit" name="act" value="withdraw" />
            <input type="submit" name="act" value="check_balance" />
        </form>
    </div>
    <div style="margin: auto; width: 50%; padding: 10px;">
        <?php
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
                case 'check_balance':
                    $balance = $finance->checkBalance();
                    echo "<h3>Your balance = $balance </h3>";
                    break;
                case 'deposit_req':
                    if (isset($_POST)){
                        $result = $finance->deposit();
                        echo "<h3>$result</h3>";
                    }
                    break;
                case 'withdraw_req':
                    if (isset($_POST)){
                        $result = $finance->withdraw();
                        echo "<h3>$result</h3>";
                    }
                    break;
                case 'reset':
                    session_destroy();
                    echo "<h3>Reset success.</h3>";
                    break;

                default:
                    break;
            }
        }
        ?>
    </div>
</body>

</html>