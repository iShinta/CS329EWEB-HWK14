<?php
  $cat = "True/False";
  $question = "1) According to Kepler the orbit of the earth is a circle with the sun at the center. a) True b) False";
  $answer = "a";

  function showQuestion(){
    ?>
    <form method="post" action="index.php">
      <div><?php echo $question; ?>
  		<br /><input id="q1a" name="q1" type="radio" />a) True
  		<br /><input id="q1b" name="q1" type="radio" />b) False
      <input type="submit" name="submit" value="Next Question" /></div>
    </form>
    <?
  }

  function showTitle(){
    echo $cat;
  }

  function testAnswer(){

  }
?>
