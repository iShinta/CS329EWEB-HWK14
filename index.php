<!DOCTYPE html>

<?php
  function start(){
    //Selon l'avancee du quiz, on va inclure une version differente
    if(!isset($_COOKIE["id"])){ //Not in a session
      echo "Not in a session";
      if($_SERVER['REQUEST_METHOD'] === 'POST'){ //POST
        //Check credentials
        if(isset($_POST["username"])){
          $username = $_POST["username"];
          $password = $_POST["password"];

          //Get list of users who finished the test
          $fh = fopen("results", "r");
          //Check if username is already taken
          $usertest = Array();
          while(!feof($fh)){
            //Read Line
            $line = fgets($fh);
            $line_pieces = explode(":", $line);
            $usertest[$line_pieces[0]] = $line_pieces[1];
          }
          fclose($fh);

          if(array_key_exists($username, $usertest)){ //Already took the test
            echo "Sorry. That person already took the test";
          }else{
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
              setcookie("id", $username, time()+900);
              setcookie("timeloggedin", time(), time()+900);
              session_start();
              ?><a href="index.php">Start the Quiz</a><?php
            }else{
              echo "Login Failed.<br />Bad username or password";
              echo "<br />You entered username: ".$username;
              echo "<br />and Password: ".$password;
              echo "<br /><a href=\"index.php\"> Back to the homepage </a>";
            }
          }
        }
      }else{ //GET
        showLogin();
      }
    }else{ //In a session
      echo "You're logged in";
      //Check if time is up


      //If time is up, destroy session
      //Check questions via Session Variable
      //If last question, destroy session
      destroySession();
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

  function destroySession(){
    //Save state in results

    //Destroy session
  }
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
