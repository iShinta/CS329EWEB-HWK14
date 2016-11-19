<!DOCTYPE html>

<?php
  function start(){
    //Selon l'avancee du quiz, on va inclure une version differente
    if(!isset($_COOKIE["id"])){ //Not in a session
      //echo "Not signed in<br />";
      //If session variable exist, that means Quiz has ended
      session_start();
      if(isset($_SESSION["score"])){
        echo "Quiz ended.<br />";
        print_r("Final score: ".$_SESSION["score"]."<br />");
        print_r("You arrived at question ".$_SESSION["question"]."<br />");
        //Destroy session
        destroySession();
      }

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
            echo "Sorry. " .$username. " already took the test<br />";
          }else{
            //echo "You didn't take the test yet<br />";
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
              $_SESSION["name"] = $username;
              $_SESSION["question"] = 1;
              //echo "Session ".$_SESSION["question"]."<br />";
              $_SESSION["score"] = 0;
              //echo "Score ".$_SESSION["score"]."<br />";
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
      session_start();
      echo "You're logged in ".$_SESSION["name"]."<br/>";
      print_r("Current score: ".$_SESSION["score"]."<br /><br />");
      print_r("<h2>Question ".$_SESSION["question"]."</h2><br /><br />");

      if($_SESSION["question"] == 1){ //Q1
        if(isset($_POST["q1"])){
          echo "Check Question 1<br/>";
          if($_POST["q1"] == "q1b"){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </form>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div>1) According to Kepler the orbit of the earth is a circle with the sun at the center.
        		<br /><input value="q1a" name="q1" type="radio" />a) True
        		<br /><input value="q1b" name="q1" type="radio" />b) False</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 2){ //Q2
        if(isset($_POST["q2"])){
          echo "Check Question 2<br/>";

          if($_POST["q2"] == 'q2a'){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </form>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div><br />2) Ancient astronomers did consider the heliocentric model of the solar system but rejected it because they could not detect parallax.
        		<br /><input value="q2a" name="q2" type="radio" />a) True
      		  <br /><input value="q2b" name="q2" type="radio" />b) False</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 3){ //Q3
        if(isset($_POST["q3a"]) || isset($_POST["q3b"]) || isset($_POST["q3c"]) || isset($_POST["q3d"])){
          echo "Check Question 3<br/>";
          if($_POST["q3b"] == "q3b" && $_POST["q3a"] != "q3a" && $_POST["q3c"] != "q3c" && $_POST["q3d"] != "q3d"){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </form>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div><br />3) The total amount of energy that a star emits is directly related to its
        		<br /><input value="q3a" name="q3a" type="checkbox" />a) surface gravity and magnetic field
        		<br /><input value="q3b" name="q3b" type="checkbox" />b) radius and temperature
        		<br /><input value="q3c" name="q3c" type="checkbox" />c) pressure and volume
        		<br /><input value="q3d" name="q3d" type="checkbox" />d) location and velocity</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 4){ //Q4
        if(isset($_POST["q4a"]) || isset($_POST["q4b"]) || isset($_POST["q4c"]) || isset($_POST["q4d"])){
          echo "Check Question 4<br/>";
          if($_POST["q4d"] == "q4d" && $_POST["q4a"] != "q4a" && $_POST["q4b"] != "q4b" && $_POST["q4c"] != "q4c"){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </form>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div><br />4) Stars that live the longest have
        		<br /><input value="q4a" name="q4a" type="checkbox" />a) high mass
        		<br /><input value="q4b" name="q4b" type="checkbox" />b) high temperature
        		<br /><input value="q4c" name="q4c" type="checkbox" />c) lots of hydrogen
        		<br /><input value="q4d" name="q4d" type="checkbox" />d) small mass</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 5){ //Q5
        if(isset($_POST["q5"])){
          echo "Check Question 5";
          if($_POST["q5"] == "galaxy"){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </form>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div>5) A collection of a hundred billion stars, gas, and dust is called a <input id="q5" name="q5" type="text" />.</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 6){ //Q6
        if(isset($_POST["q6"])){
          echo "Check Question 6";
          if($_POST["q6"] == "age"){
            echo "Right answer";
            $_SESSION["score"] += 1;
          }else{
            echo "Wrong answer";
          }
          $_SESSION["question"] +=1;
          ?>
          <form name="quiz" method="post">
            <input type="submit" name="submit" value="Next Question" />
          </quiz>
          <?php
        }else{
          ?>
          <form name="quiz" method="post">
            <div><br />6) The inverse of the Hubble's constant is a measure of the <input id="q6" name="q6" type="text" /> of the universe.</div>
            <br /><input name="submit" type="submit" value="Grade this question" /><input name="reset" type="reset" value="Clear" />
          </form>
          <?php
        }
      }else if($_SESSION["question"] == 7){
        echo "Reached the last question. Quiz ended.<br />";
        //If time is up, destroy session
        //Check questions via Session Variable
        //If last question, destroy session
        destroySession();
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
    echo "Saving Scores<br/>";
    //Save state in results
    $fh2 = fopen("results", "a");
    fwrite($fh2, $_SESSION["name"].":".$_SESSION["score"]."\n");
    fclose($fh2);

    echo "Destrying Session<br/>";
    setcookie("id", "", time()-3600);
    setcookie("timeloggedin", "", time()-3600);
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
  <div class="container">
    <h1>Astronomy Quiz</h1>
    <?php start(); ?>
  </div>
</body>
</html>
