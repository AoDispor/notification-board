<?php 
include('list.php');

session_start();

function show_msg()
{
  	if(isset($_SESSION["info_msg"])) 
	{	
		echo '<br>';
		echo '<div id="notebox">';
		echo $_SESSION["info_msg"];
		echo '</div>';
		$_SESSION["info_msg"]=null;
	}
}

?>
<!DOCTYPE html>
<!-- Notification page. CSS and Bootstrap still needed :( -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="styles.css"/>
	<!-- SCRIPTS -->
    <script src="jquery-3.1.1-dist/jquery-3.1.1.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
    <title>Ao Dispor | Notification Board</title>
  </head>

  <body class="bg-ao-dispor-2">
  
    <!-- TITLE -->
    <div id="title" class="txt-ao-dispor-1">
      <h1> Ao Dispor | </h1> <h4> Notification Board</h4>
    </div>

	  <?php show_msg();?>
	
    <!-- MAIN NOTIFICATION PANEL -->
    <div id="main-container" class="container-fluid">
      <div class="panel row">
        <div id="main-panel" class="col-xs-12 col-md-8">
		
          <!-- MAIN NOTIFICATION PANEL TITLE -->
          <div id="main-title" class="txt-ao-dispor-1">
            <h2> Create New Push Notification </h2>
          </div>

          <!-- NOTIFICATION INFORMATION -->
          <div id="notification-info">
            <form id="notification-form" action="insert.php" method="post">
              <label for="phone-id">Phone Id</label>
              <input class="form-control" type="text" name="phone-id" value="">
              <label for="notification">Notification Body</label>
              <input class="form-control" type="text" name="notification" value="">

              <!-- Postal codes to send (must be dynamic)-->
              <div id="zip-codes">
                <div id="zip-template">
                  <label for="zip1-1">Zip 1</label>
                  <input class="form-control" type="text" name="postalCodes[0]" value=""/>
                </div>
              </div>
			  
              <button id="postal-button" class="btn btn-success" type="button" name="button"> + Add Postal Code </button>
			  <br>
			  <button class="btn btn-info" type="submit" name="button" > Send! </button>
            </form>
          </div>

        </div>

        <!-- NOTIFICATION LIST PANEL-->
        <div id="notifiaction-list-panel" class="col-xs-12 col-md-4">

          <!-- NOTIFICATION LIST TITLE -->
          <div id="notification-list-title" class="txt-ao-dispor-1">
            <h2> Saved Notification List </h2>
          </div>

      <!-- NOTIFICATION LIST -->
      <ul id="notification-list">
		<?php
			foreach($notifications as $notification){
			echo "<li>";
			echo $notification['username'];
			echo "  -  ";
			echo $notification['sentdate'];
			echo "</li>";
			}
		?>
      </ul>
    </div>

       </div>
    </div>

  </body>
</html>