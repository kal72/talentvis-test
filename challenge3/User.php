<?php 
class User {

    function init(){
        if (!isset($_SESSION["user"])) {
            $_SESSION["user"] = array(
                array(
                    "username" => "Feon",
                    "password" => "Feon"
                ),
                array(
                    "username" => "Vira",
                    "password" => "Vira"
                )
            );
        }
    }
    
    function login() {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $users = $_SESSION["user"];
        foreach($users as $user){
            if(($user["username"] == $username) && ($user["password"] == $password)){
                $_SESSION["user_login"] = $username;
                break;
            } 
        }

        header("location: index.php");
    }

    function logout() {
        unset($_SESSION["user_login"]);
        header("location: index.php");
    }

    function getUserLogin() {
        return $_SESSION["user_login"];
    }

    function isLogin() {
        if(isset($_SESSION["user_login"]))
            return true;
        else
            return false;
    }

    function getUsers(){
        return $_SESSION["user"];
    }

    function checkUser($username){
        $users = $_SESSION["user"];
        foreach($users as $user){
            if(($user["username"] == $username)){
               return true;
            } 
        }

        return false;
    }
}
?>