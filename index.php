<!DOCTYPE html>

<?php
  function start(){
    //Selon l'avancee du quiz, on va inclure une version differente
    if(!isset($_COOKIE["id"])){ //Not in a session
      echo "Not signed in";
      if($_SERVER['REQUEST_METHOD'] === 'POST'){ //POST
        //If session is open, that means Quiz has ended
        if(isset($_SESSION)){
          echo "Quiz ended.";
          //Destroy session
          destroySession();
        }

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
            echo "Sorry. " .$username. " already took the test";
          }else{
            echo "You didn't take the test yet";
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
              echo "Login Succeeded. Welcome ".$username. ".<br />";
              setcookie("id", $username, time()+900);
              setcookie("timeloggedin", time(), time()+900);
              session_start();
              $_SESSION["question"] = 1;
              $_SESSION["score"] = 0;
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
      print_r("Current score: ".$_SESSION["score"]."<br />");
      print_r("Question ".$_SESSION["question"]."<br />");

      if($_SESSION["question"] == 1){
        if(isset($_POST["q1"])){
          echo "Check Question 1";
          if($_POST["q1"] == "q1b"){
            $_SESSION["score"] += 1;
          }
          $_SESSION["question"] +=1;
          ?>
          <input type="submit" name="submit" value="Next Question" />
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div>1) According to Kepler the orbit of the earth is a circle with the sun at the center.
        		<br /><input id="q1a" name="q1" type="radio" />a) True
        		<br /><input id="q1b" name="q1" type="radio" />b) False</div>
            <br /><input name="submit" type="button" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }
    }
  }

  function showLogin(){ ?>
    <h3>Please Log In</h3>
    <form method="post" action="#">
      <input type="text" name="username" />
      <input type="text" name="password" /><br />
      <input type="submit" name="submit" value="Log In" />
      <input type="reset" name="reset" value="Reset" />
    </form>
  <?php }

  function destroySession(){
    //Save state in results
    $fh2 = fopen("passwd.txt", "a");
    fwrite($fh2, $username.":".$_SESSION["score"]."\n");
    fclose($fh2);

    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
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
