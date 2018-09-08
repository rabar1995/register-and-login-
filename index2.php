<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=regform','root','');
        
    }catch(Exception $ex){
    die('you got some error in connection');
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Document</title>
</head>
<body>
<?php
$errors=array();
$sucsess='';
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    if (empty($username)) {
        array_push($errors,"username is required") ;
     }
    if (empty($email)) {
        array_push($errors,"email is required") ;
     }
     if (empty($password)) {
        array_push($errors,"password is required") ;
     }
     if(count($errors) == 0)
     {
    $sql = $pdo ->prepare(" INSERT INTO rform (username,email,password)
    VALUES('$username','$email','$password') ");
    $sql->execute(array($username,$email,$password));
    $datas=$sql->fetchAll(PDO::FETCH_ASSOC);
    $sucsess = "you are registered  '-' ";
    }
}

$message ='';
if(isset($_POST['login'])) {

    $user = $_POST['uname'];
    $pass = $_POST['pword'];
    
    
    if(empty($user) || empty($pass)) {
    $message = 'All field are required';
    } else {
    $query = $pdo->prepare("SELECT username, password FROM rform WHERE 
    username=? AND password=? ");
    $query->execute(array($user,$pass));
    $row = $query->fetch(PDO::FETCH_BOTH);
    
    if($query->rowCount() > 0) {
     $message = 'you are logged in !';
    } else {
      $message = "Username/Password is wrong";
    }
    
    
    }
    
    }
?>
    <form action="" method="post" >
    <?php 
    if (count($errors) > 0) {
        # code...
        foreach ($errors as $error) {
            # code...
            echo '<p>'.$error. '</p>';
        }
    }
    echo $sucsess.'</br>';
    ?>
    <input type="text" placeholder="username" name="username">
    </br></br>
    <input type="text" placeholder="email" name="email">
    </br></br>
    <input type="password" placeholder="password" name="password">
    </br></br>
    <button type="submit" name="submit" > submit </button>
    </form>

    <div></br></br></div>

    <form action="" method="post">
    <?php
        echo $message;
    ?>
    </br>
    <input type="text" placeholder="username" name="uname">
    </br></br>
    <input type="text" placeholder="password" name="pword">
    <button type="submit" name="login" > login </button>
    </form>
</body>
</html>