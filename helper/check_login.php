<?php 
    echo "test";

if(isset($_POST["username"]) /* && isset($_POST["pwd"]) */){
    
    $db_user = "root";
    $db_pwd = "";
    $db_name = "Azure";
    $db = mysqli_connect("localhost", $db_user, $db_pwd, $db_name);

    if(!$db) {
        exit("Verbindungsfehler: ".mysqli_connect_error());
    }
    

    $user = $_POST["username"];
    //$pwd = md5($_POST["pwd"]);
    
    $sql = "SELECT * FROM users WHERE username='$user';";
    
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $type = $row["type"];
        session_start();
        $_SESSION["uname"] = $user;
        $_SESSION["type"] = $type;
        $db->close();
        
        header("Location: ../index.php");
            
    } else {
        $db->close();
        header("Location: ../login.php?msg=falscherUser");
    }
   
} else {
    header("Location: ../login.php?msg=keinRequest");
}
?>
