<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'VIRUS.php'; // Don't even THINK of opening this file for any reason....

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "haskelda-db", $myPassword, "haskelda-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
} /*else {
	echo "Successfully connected to haskelda-db<br>";
}

if ($_POST != NULL) {
	var_dump ($_POST);
}
*/
?>

<!DOCTYPE html>
<title>DB Search</title>

<body>
<h1>SPACE MISSIONS DATABASE</h1>

<!-- Links to Search and Manipulate -->
<fieldset>
	<form action="DB_Results.php" method="POST">
		<input type="submit" name = "displayAll" value = "Display Entire Database"> 
		&nbsp&nbsp&nbsp
		<a href="DB_SearchForms.php">Search Database</a>
		&nbsp&nbsp&nbsp
		<a href="DB_Manipulation.php">Add / Update / Delete from Database</a>
	</form>
</fieldset>



<?php

if ($_POST == NULL || isset($_POST['displayAll'])) {  
	//  Display entire missions table
	// All tables and rows will be displayed.  no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Missions</bold></h2></caption>
		<tr>
		<th>Name
		<th>Budget
		<th>URL";

		if (!($stmt = $mysqli->prepare("SELECT name, budget, URL FROM missions ORDER BY id"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td><a href="' . "$_out3" . '">' . "$_out3" . '</a></td>
				</tr>';
		}
	echo "</table><br>";
} 
?>


<?php

if ($_POST == NULL || isset($_POST['displayAll'])) {  
	//  Display entire spacecraft table
	// All tables and rows will be displayed.  no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Spacecraft</bold></h2></caption>
		<tr>
		<th>Name
		<th>Cost
		<th>imageURL";

		if (!($stmt = $mysqli->prepare("SELECT name, cost, imageURL FROM spacecraft ORDER BY id"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td><a href="' . "$_out3" . '">' . "$_out3" . '</a></td>
				</tr>';
		}
	echo "</table><br>";
} 
?>

<?php

if ($_POST == NULL || isset($_POST['displayAll'])) {  
	//  Display entire destinations table
	// All tables and rows will be displayed.  no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Destinations</bold></h2></caption>
		<tr>
		<th>Name
		<th>Description
		<th>Distance from Earth";

		if (!($stmt = $mysqli->prepare("SELECT name, description, distance FROM destinations ORDER BY id"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
				</tr>';
		}
	echo "</table><br>";
} 
?>



<?php

if ($_POST == NULL || isset($_POST['displayAll'])) {  
	//  Display entire agencies table
	// All tables and rows will be displayed.  no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Agencies</bold></h2></caption>
		<tr>
		<th>Name
		<th>Country
		<th>Budget
		<th>URL";

		if (!($stmt = $mysqli->prepare("SELECT name, country, annualbudget, URL FROM agencies ORDER BY id"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;
		$_out4 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3, $_out4)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
		    	 	<td><a href="' . "$_out4" . '">' . "$_out4" . '</a></td>
				</tr>';
		}
	echo "</table><br>";
} 
?>
		

<?php

if ($_POST != NULL && isset($_POST['missionsSearch'])) {  
	//  Display partial missions table - according to user selection
	// no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Missions</bold></h2></caption>
		<tr>
		<th>Name
		<th>Budget
		<th>URL";

		if (!($stmt = $mysqli->prepare("SELECT m.name, m.budget, m.URL FROM missions m
										INNER JOIN agencies a ON m.a_id = a.id
										INNER JOIN destinations d ON m.d_id = d.id
										WHERE a.name = ? AND d.name = ? AND m.budget > ?
										ORDER BY m.id"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$a_name = $_POST['selectAgency'];
		$d_name = $_POST['selectDestination'];
		$m_budget = $_POST['m_budget'];

		if (!$stmt->bind_param("ssi", $a_name, $d_name, $m_budget)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills missions table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td><a href="' . "$_out3" . '">' . "$_out3" . '</a></td>
				</tr>';
		}
	echo "</table><br>";
} 
?>


<?php

if ($_POST != NULL && isset($_POST['spacecraftSearch'])) {  
	//  Display partial spacecraft table - according to user selection
	//   no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Spacecraft</bold></h2></caption>
		<tr>
		<th>Name
		<th>Location
		<th>Distance from Earth
		<th>Image URL";

		if (!($stmt = $mysqli->prepare("SELECT s.name, d.name, distance, imageURL FROM spacecraft s
										INNER JOIN missions_spacecraft m_s ON s.id = m_s.s_id
										INNER JOIN missions m ON m.id = m_s.m_id
										INNER JOIN agencies a ON m.a_id = a.id
										INNER JOIN destinations d ON m.d_id = d.id
										WHERE a.name = ? AND d.distance > ?
										ORDER BY d.distance"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$a_name = $_POST['selectAgency'];
		$d_distance = $_POST['d_distance'];

		if (!$stmt->bind_param("si", $a_name, $d_distance)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;
		$_out4 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3, $_out4)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
		    	 	<td><a href="' . "$_out4" . '">' . "$_out4" . '</a></td>
				</tr>';
		}
	echo "</table><br>";
} 
?>


<?php

if ($_POST != NULL && isset($_POST['destinationsSearch'])) {  
	//  Display partial destinations table - according to user selection
	//   no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Destination</bold></h2></caption>
		<tr>
		<th>Destination
		<th>Description
		<th>Agency
		<th>Mission";
	if ($_POST['selectMission'] != 'ALL') {	
		if (!($stmt = $mysqli->prepare("SELECT d.name, d.description, a.name, m.name FROM destinations d
										INNER JOIN missions m ON m.d_id = d.id
										INNER JOIN agencies a ON m.a_id = a.id
										WHERE a.name = ? AND m.name = ?
										ORDER BY d.distance"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$a_name = $_POST['selectAgency'];
		$m_name = $_POST['selectMission'];

		if (!$stmt->bind_param("ss", $a_name, $m_name)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;
		$_out4 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3, $_out4)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
		    	 	<td>' . "$_out4" . '</td>
				</tr>';
		}
	echo "</table><br>";
	}


		if ($_POST['selectMission'] == 'ALL') {	
		if (!($stmt = $mysqli->prepare("SELECT d.name, d.description, a.name, m.name FROM destinations d
										INNER JOIN missions m ON m.d_id = d.id
										INNER JOIN agencies a ON m.a_id = a.id
										WHERE a.name = ? 
										ORDER BY d.distance"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$a_name = $_POST['selectAgency'];

		if (!$stmt->bind_param("s", $a_name)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;
		$_out4 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3, $_out4)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
		    	 	<td>' . "$_out4" . '</td>
				</tr>';
		}
	echo "</table><br>";
	}
} 
?>


<?php

if ($_POST != NULL && isset($_POST['agenciesSearch'])) {  
	//  Display partial agencies table - according to user selection
	//   no 'id' columns
	echo "<table border='1'>
		<caption><h2><bold>Agencies</bold></h2></caption>
		<tr>
		<th>Destination
		<th>Agency
		<th>Agency Budget for this Destination
		<th>Agency Annual Budget";

		if (!($stmt = $mysqli->prepare("SELECT d.name, a.name, SUM(m.budget), a.annualbudget AS sum FROM destinations d
										INNER JOIN missions m ON m.d_id = d.id
										INNER JOIN agencies a ON m.a_id = a.id
										WHERE d.name = ? 
										ORDER BY sum"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$d_name = $_POST['selectDestination'];

		if (!$stmt->bind_param("s", $d_name)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		$_out1 = NULL;
		$_out2 = NULL;
		$_out3 = NULL;
		$_out4 = NULL;

		if (!$stmt->bind_result($_out1, $_out2, $_out3, $_out4)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		// fills table rows from DB
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$_out1" . '</td>
		    	  	<td>' . "$_out2" . '</td>
		    	 	<td>' . "$_out3" . '</td>
		    		 <td>' . "$_out4" . '</td>
				</tr>';
		}
	echo "</table><br>";
} 
?>

</body>
</html>


<?php
$stmt->close();
?>
