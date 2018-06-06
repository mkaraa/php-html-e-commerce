<!DOCTYPE html>
<?php
if(isset($_POST["createBtn"])){
    //extract($_POST);
    $sanitized = [] ;
      foreach( $_POST as $k=>$v) {
          $sanitized[$k] = filter_var($v, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
      }
      $login_fail = [] ;
      //var_dump($sanitized);
      $static_id = 2;
      //Not really sure if below needed, just in case:)
      $sanitized['name'] = filter_var($sanitized['name'], FILTER_SANITIZE_STRING);
      $sanitized['surname'] = filter_var($sanitized['surname'], FILTER_SANITIZE_STRING);
      //$sanitized['email'] = filter_var($sanitized['email'], FILTER_SANITIZE_STRING);
      $sanitized['address'] = filter_var($sanitized['address'], FILTER_SANITIZE_STRING);
      
    if(strlen(trim($sanitized['name'])) === 0 || strlen(trim($sanitized['surname'])) === 0 || strlen(trim($sanitized['address'])) === 0){
        $login_fail[] = "other"; //name, surname, address check
    } 
    if(!filter_var($sanitized['email'], FILTER_VALIDATE_EMAIL)){//Email check
        $login_fail[] = "email";
    }
      
    if($sanitized['password'] !== $sanitized['password_verify']){//Password match correct;
        $login_fail[] = "password_unmatch";
    }
    
    if(strlen($sanitized['password'] < 6)){//Password length correct
        $login_fail[] = "password_length";
    }
    
    if(empty($login_fail)){
        echo "<script>javascript: alert('Account information validated!')></script>";
        require_once './db.php';
        $sql = "insert into user (id, name, surname, mail, address, password, role) values(?, ?, ?, ?, ?, ?, ?)";
        $state = $db->prepare($sql);
        $sanitized['id'] = $static_id++;
        $sanitized['role'] = 0;
        $result = $state->execute(array($sanitized['id'], $sanitized['name'], $sanitized['surname'], $sanitized['email'], $sanitized['address'], $sanitized['password'], $sanitized['role']));
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
    <title></title>
    <style>
        #signup td{text-align: left;  padding-left: 10px;}
        #signup{margin-left: 500px;}
        //#btn{text-align: center;}
        
    </style>
</head>
<body>
    <form action="" method="post">
        <table id="signup">
            //id?
            <tr><td>
                    Name:
                </td>
                <td>
                    <input id="name" type="text" name="name"></input>
                </td>
            </tr>
            <tr><td>
                    Surname:
                </td>
                <td>
                    <input id="surname" type="text" name="surname"></input>
                </td>
            </tr>
            <tr><td>
                    Email:
                </td>
                <td>
                    <input id="email" type="text" name="email"></input>
                </td>
            </tr>
            <tr><td>
                    Password:
                </td>
                <td>
                    <input id="password" type="text" name="password"></input>
                </td>
            </tr>
            <tr><td>
                    Retype password:
                </td>
                <td>
                    <input id="password_verify" type="text" name="password_verify"></input>
                </td>
            </tr>
            <tr><td>
                    Address:
                </td>
                <td>
                    <input id="address" type="text" name="address"></input>
                </td>
            </tr>
            //Role?
            <tr id="btn"><td>
                        </td>
            <td>
            <input type="submit" value="Create Account" name="createBtn"></input>
            </td>
            </tr>
        </table>
        <p><?= isset($login_fail['other']) ? "Oops! Check name/surname/address and try again." : "" ?></p>
        <p><?= isset($login_fail['email']) ? "Invalid email, please try again." : "" ?></p>
        <p><?= isset($login_fail['password_unmatch']) ? "Password mismatch, try again." : "" ?></p>
        <p><?= isset($login_fail['password_length']) ? "Enter 6 digit long password please." : "" ?></p>
        
    </form>
</body>
</html>
