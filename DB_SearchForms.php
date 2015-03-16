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

<!-- Links to Search and Display -->
<fieldset>
	<form action="DB_Results.php" method="POST">
		<input type="submit" name = "displayAll" value = "Display Entire Database"> 
		&nbsp&nbsp&nbsp
		<a href="DB_Manipulation.php">Add / Update / Delete from Database</a>
	</form>
</fieldset>

<br>


<!-- Search Missions Table -->
<fieldset>
	<legend><h3>Search Missions</h3></legend>
	<form action="DB_Results.php" method="POST">
		<p> Who is sending missions where? (and for how much $?)</p>		
		<p>Filter the results by Agency: 
		<select name="selectAgency"> 
			<option value='NULL'>Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM agencies WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_agency = NULL;

		if (!$stmt->bind_result($out_agency)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_agency" . '">' . "$out_agency" . '</option>';
		}

?>
		</select>

		<p>Filter the results by Destination: 
		<select name="selectDestination"> 
			<option value='NULL'>Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM destinations WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_destination = NULL;

		if (!$stmt->bind_result($out_destination)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_destination" . '">' . "$out_destination" . '</option>';
		}

?>
		</select>

		<p>Filter the results by budget:  Greater than: 
		<input type="text" name="m_budget"><br>

		<br>

		<input type="submit" name = "missionsSearch" value = "Search Missions"><br>
	</form>
</fieldset>


<br>

<!-- Search Spacecraft Table -->
<fieldset>
	<legend><h3>Search Spacecraft</h3></legend>
	<form action="DB_Results.php" method="POST">
		<p> Who has spacecraft out there? (and how far away?)</p>
		<p>Filter the results by Agency: 
		<select name="selectAgency"> 
			<option value='NULL'>Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM agencies WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_agency = NULL;

		if (!$stmt->bind_result($out_agency)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_agency" . '">' . "$out_agency" . '</option>';
		}

?>
		</select>

		<p>Filter the results by distance from Earth:  Greater than: 
		<input type="text" name="d_distance"><br>
		<br>


		<input type="submit" name = "spacecraftSearch" value = "Search Spacecraft"><br>
	</form>
</fieldset>


<br>

<!-- Search Destinations Table -->
<fieldset>
	<legend><h3>Search Destinations</h3></legend>
	<form action="DB_Results.php" method="POST">
		<p> Who is sending what missions where?</p>
		<p>Filter the results by Agency: 
		<select name="selectAgency"> 
			<option value='NULL'>Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM agencies WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_agency = NULL;

		if (!$stmt->bind_result($out_agency)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_agency" . '">' . "$out_agency" . '</option>';
		}

?>
		</select>

		<p>Filter the results by Mission: 
		<select name="selectMission"> 
			<option value='ALL'>All Missions</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM missions WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_agency = NULL;

		if (!$stmt->bind_result($out_agency)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_agency" . '">' . "$out_agency" . '</option>';
		}

?>
		</select>
		<br>
		<br>

		<input type="submit" name = "destinationsSearch" value = "Search Destinations"><br>
	</form>
</fieldset>

<br>

<!-- Search Agencies Table -->
<fieldset>
	<legend><h3>Search Agencies</h3></legend>
	<form action="DB_Results.php" method="POST">
		<p> Who is spending the most $$ on each destination?</p>
		<p>Filter the results by Destination: 
		<select name="selectDestination"> 
			<option value='NULL'>Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM destinations WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_destination = NULL;

		if (!$stmt->bind_result($out_destination)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_destination" . '">' . "$out_destination" . '</option>';
		}

?>
		</select>
		<br>
		<br>

		<input type="submit" name = "agenciesSearch" value = "Search Agencies"><br>
	</form>
</fieldset>

<br>

</body>
</html>


<?php
$stmt->close();
?>

