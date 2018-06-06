<?php
  session_start() ;
  
    /*if ( !empty($_SESSION["user"])) {
        header("Location: index.php");
        exit ;
    } */
    
  if ( isset($_POST["loginBtn"])) {
      require_once 'db.php';
      extract($_POST) ;
      $sql = "select * from user where mail = ?" ;
      $stmt = $db->prepare($sql);
      $stmt->execute([$username]) ;
      
      if ( $stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
        var_dump($user);
        echo "pass" . $password;
      //  var_dump($user) ;
        if ($password == $user["password"]) {
            //echo "Authenticated" ;
           
         $_SESSION["user"] = $user;
          header("Location: index.php") ;
            exit ;
//            
        } else {
           // echo "Authentication Failed" ;
           $login_error = true ;
        }
      } else {
          $login_error = true ;
      }
      
  } 
  
  
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table { margin: 30px auto; border-collapse: collapse; }
            td { border-bottom: 1px solid #666; padding: 10px;}
            .center { text-align: center;}
        </style>
    </head>
    <body>
        <form action="" method="post">
            <table>
                <tr>
                    <td colspan="2">Giriş Yap</td>
                </tr>
                <tr>
                    <td>Mail :</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Şifre :</td>
                    <td><input type="password" name="password"></td>
                </tr>
               
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Giriş Yap" name="loginBtn">
                    </td>
                </tr>
            </table>
            <p class="center"><?= isset($login_error) ? "Login Failed" : "" ; ?></p>
        </form>
    </body>
</html>
