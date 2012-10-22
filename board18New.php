<?php
$welcome = '';
// require_once('php/auth.php');
require_once('php/config.php');

function prepareDatabase() {
  $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
  if (!$link) {
    error_log('Failed to connect to server: ' . mysql_error());
    exit;
  }
  $db = mysql_select_db(DB_DATABASE);
  if (!$db) {
    error_log("Unable to select database");
    exit;
  }
}

function showBoxes() {
  $qry = "SELECT box_id, name, version, author, create_date FROM box";
  $result = mysql_query($qry);
  if ($result) {
    echo "<table border='1'> <tr>
        <th>ID</th> <th>Box Name</th> <th>Version</th>
        <th>Author</th> <th>Date</th> </tr>";
    while ($row = mysql_fetch_array($result)) {
      echo "<tr> <td>$row[0]</td> <td>$row[1]</td> <td>$row[2]</td>
        <td>$row[3]</td> <td>$row[4]</td> </tr>";
    }
    echo "</table>";
  } else {
    echo "<p style='color: red'>There are no game boxes in the database</p>";
  }
}

function showPlayers() {
  $qry = "SELECT login, firstname, lastname FROM players";
  $result = mysql_query($qry);
  if ($result) {
    echo "<h3 style='text-indent: 15px'>Players<br></h3>";
    while ($row = mysql_fetch_array($result)) {
      echo "<p class='plid'>$row[0] 
        <span><br>$row[1] $row[2]</span></p>";
    }  
  } else {
    echo "<p class='error'>There are no players in the database.</p>";
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>BOARD18 - Remote Play Tool For 18xx Style Games</title>
    <link rel="shortcut icon" href="images/favicon.ico" >
    <link rel="stylesheet" href="style/board18com.css" />
    <link rel="stylesheet" href="style/board18New.css" />
    <script type="text/javascript" src="scripts/jquery.js">
    </script> 
    <script type="text/javascript" src="scripts/board18com.js">
    </script>
    <script type="text/javascript" src="scripts/board18New.js">
    </script>
    <script type="text/javascript" >
      $(function() {
        $('.error').hide();
        $('.plid').children("span").hide(); 
        $('#logout').click(function() {
          $.post("php/logout.php", logoutOK);
        }); // end logout
        $('.plid').mouseover(function() {
          $(this).children("span").show();
        });
        $('.plid').mouseout(function() {
          $(this).children("span").hide();
        });
      }); // end ready
    </script>
  </head>
  <body>
    <?php prepareDatabase(); ?>
    <div id="topofpage">
      <div id="logo">
        <img src="images/logo.png" alt="Logo" /> 
      </div>
      <div id="heading">
        <h1>BOARD18 - Remote Play Tool For 18xx Style Games </h1>
        <h3 id="lognote"><?php echo "Welcome $welcome"; ?>. 
          <span style="font-size: 60%">
            Click <a href="index.html">here</a> 
            if you are not <?php echo $welcome; ?>.
          </span>
        </h3>
      </div>
    </div>
    <div id="leftofpage">
      <div id='sidebar'>
        <p id="logout" class="sidebaritem">Logout</p>
        <?php showPlayers(); ?>
      </div>
    </div>
    <div id="rightofpage"> 
      <div id="content">   
        <div>
          <h3>Start a New Game Session</h3>
          <p>Please use this form to strt a new game session. 
          <br>For your convenience, a list of registered players appears to
          <br>the right and a table of available game boxes appears below.
          </p>
        </div>
        <div id="newgame">
          <form name="newgame" action="">
            <fieldset>
              <p>
                <label for="sessionname">Game Name:</label>
                <input type="text" name="sessionname" id="sessionname">
                <label class="error" for="sessionname" id="sn_error">
                  This field is required.</label>
              </p>
              <p>
                <label for="playercount"># of Players:</label>
                <input type="text" name="playercount" id="playercount">
                <label class="error" for="playercount" id="pc_error">
                  This field is required.</label>
              </p>
              <p>
                <label for="boxidnumb">Game Box ID:</label>
                <input type="text" name="boxidnumb" id="boxidnumb">
                <label class="error" for="boxidnumb" id="bi_error">
                  This field is required.</label>
              </p>
              <p>
                <input type="submit" name="pwbutton" class="pwbutton" 
                       id="button1" value="Submit" >
                <label class="error" for="button1" id="signon_error">
                  Duplicate Game Name.</label>
              </p>
            </fieldset>
          </form>
        </div>
        <div id="boxes">
          <h3>Available Game Boxes</h3>
              <?php showBoxes(); ?>
        </div>
      </div> 
      <footer>
        This is a nonfunctional mockup.
      </footer>
    </div>  
  </body>
</html>