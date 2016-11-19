<!DOCTYPE html>

<?php
  function start(){
    //Selon l'avancee du quiz, on va inclure une version differente
    if(!isset($_COOKIE["id"])){ //Not in a session
      if($_SERVER['REQUEST_METHOD'] === 'POST'){ //POST
        //Check credentials
        if(isset($_POST["username"])){

          //Get list of usernames and passwords
          $fh = fopen("passwd", "r");
          //Check if username is already taken
          $userlist = Array();
          while(!feof($fh)){
            //Read Line
            $line = fgets($fh);
            $line_pieces = explode(":", $line);
            $userlist[$line_pieces[0]] = $line_pieces[1];
          }
          fclose($fh);

          //Check if name is authorized
          if(array_key_exists($username, $userlist) && strcmp($userlist[$username], $password)){
            //echo "Login Succeeded. Welcome ".$username. ".<br />";
            setcookie("id", $username, time()+120);
            setcookie("timeloggedin", time(), time()+120);
            showLogged();
          }else{
            echo "Login Failed.<br />Bad username or password";
            echo "<br />You entered username: ".$username;
            echo "<br />and Password: ".$password;
            echo "<br /><a href=\"index.php\"> Back to the homepage </a>";
          }

          //If ok
          session_start();
        }
      }else{ //GET
        showLogin();
      }
    }else{ //In a session
      //Check questions via Session Variable
    }

    if($etape == 0){ //log in
      include 'login.php';
    }else if($etape == 1){ //question1
      include 'q1.php';
    }else if($etape == 2){ //question2
      include 'q2.php';
    }else if($etape == 3){ //question3
      include 'q3.php';
    }else if($etape == 4){ //question4
      include 'q4.php';
    }else if($etape == 5){ //question5
      include 'q5.php';
    }else if($etape == 6){ //question6
      include 'q6.php';
    }
  }

  function showLogin(){ ?>
    <h3>Please Log In</h3>
    <form method="post" action="#">
      <input type="text" name="username" />
      <input type="text" name="password" /><br />
      <input type="submit" name="submit" value="Submit" />
      <input type="reset" name="reset" value="Reset" />
    </form>
  <?php }

?>

<html>
<head>
  <title>Astronomy Quiz</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <div class="content">
    <h1>Astronomy Quiz</h1>
    <?php start(); ?>
  </div>
</body>
</html>
