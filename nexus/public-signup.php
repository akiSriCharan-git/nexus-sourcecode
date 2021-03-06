<?php
function clean($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
$name=$age=$gender=$phone=$email=$address=$aadhar=$user=$password='';
$nameerr3=$ageerr3=$phoneerr3=$aadharerr3=$success3='';


if(isset($_POST['public-submit'])){
    $name=$age=$gender=$phone=$email=$address=$aadhar=$user=$password='';
    $name=clean($_POST['name']);
    $age=(int)clean($_POST['age']);
    $gender=clean($_POST['gender']);
    $phone=clean($_POST['phone']);
    $address=clean($_POST['address']);
    $email=clean($_POST['email']);
    $aadhar=clean($_POST['aadhar']);
    $user=clean($_POST['user']);
    $password=clean($_POST['password']);

    if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $nameerr3="name should contain only letters and whitespaces";
    }
    if($age<18){
        $ageerr3="you are not eligible as you are less than 18 years old";
    }
    if(!preg_match("/[0-9]{10}/",$phone)){
        $phoneerr3="invalid phone number";
    }
    if(!preg_match("/[0-9]{12}/",$aadhar)){
        $aadharerr3="invalid aadhar number";
    }
    if($nameerr3==""&&$ageerr3==""&&$phoneerr3==""&&$aadharerr3==""){
        $conn=new mysqli("localhost","root","","nexus");
        if($conn->connect_error){
            die("connection didn't established");
        }
        $sql="insert into public(name,age,gender,contact,address,email,aadhar,user_name,password) values('$name','$age','$gender','$phone','$address','$email','$aadhar','$user','$password');";
        if($conn->query($sql)==TRUE){?>
          <script type="text/javascript">
            alert("Your account has been created, please login");
            window.open('index.php', '_self');
          </script>
        <?php

        }
        else{$success3="username or aadhar already exits, please login or enter new user name";}
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>public-signup</title>
    <link rel="stylesheet" href="signup-styles.css">
    <link rel="icon" href="favicon.ico">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <h1 id="heading">PUBLIC USER SIGNUP</h1>
    <div class="after">
      <form action='public-signup.php' method='POST'>
      <label for='name'>name</label>
      <input type='text' name='name' required value="<?php echo $name; ?>"><br>
      <h3 class="red"><?php echo $nameerr3;?></h3><br>
      <label for="age">age</label>
      <input type='number' name='age' required value="<?php echo $age; ?>"><br>
      <h3 class="red"><?php echo $ageerr3;?></h3><br>
      <label for='gender'>gender</label>
      <select name="gender" required>
      <option value='male'>male</option>
      <option value='female'>female</option>
      <option value='others'>others</option>
      </select><br><br>
      <label for='phone'>phone number</label>
      <input type='text' name='phone' required value="<?php echo $phone; ?>"><br>
      <h3 class="red"><?php echo $phoneerr3;?></h3><br>
      <label for='email'>Email</label>
      <input type='email' name='email' required value="<?php echo $email; ?>"><br><br>
      <label for='address'>address</label>
      <textarea name='address' placeholder='enter your address here' required value="<?php echo $address; ?>"></textarea><br><br>
      <label for='aadhar'>aadhar number</label>
      <input type='text' name='aadhar' required value="<?php echo $aadhar; ?>"><br>
      <h3 class="red"><?php echo $aadharerr3;?></h3><br>
      <label for='user'>user name</label>
      <input type='text' name='user' required><br><br>
      <label for='password'>password</label>
      <input type='text' name='password' required><br><br>
      <input type='submit' name='public-submit' value='submit'><br>
      <h3 class="red"><?php echo $success3;?></h3><br><br>
      </form>
    </div>
  </body>
</html>
