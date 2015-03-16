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
<title>DB Manipulation</title>
<h1>SPACE MISSIONS DATABASE</h1>


<?php



// Adding data to the DB

// Add to missions
if ($_POST != NULL && isset($_POST['missionAdd'])) {


	// Data validation - name is required field
	if ($_POST['m_name'] == "") {
		echo 'Name is a required field.<br>';
		exit;
	}
	$m_name = $_POST['m_name'];
	$m_budget = $_POST['m_budget'];
	$m_url = $_POST['m_url'];
	$a_name = $_POST['selectAgency'];
	$d_name = $_POST['selectDestination'];


		// User data is valid - add mission to missions table
		if (!($stmt = $mysqli->prepare("INSERT INTO missions (name, budget, URL, a_id, d_id) VALUES
		(?, ?, ?, (SELECT id FROM agencies WHERE name = ?), (SELECT id FROM destinations WHERE name = ?));"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("sisss", $m_name, $m_budget, $m_url, $a_name, $d_name)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    if ($mysqli->errno == 1062) {
		    	echo "<br>Duplicate entry. Try again<br>";
		    }
		    exit;
		}
	echo "$m_name added to missions table.";
}


// Update mission budget
if ($_POST != NULL && isset($_POST['budgetUpdate'])) {

	$m_name = $_POST['updateMission'];
	$m_budget = $_POST['m_budget'];


		if (!($stmt = $mysqli->prepare("UPDATE missions SET budget = ? WHERE name = ?;"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("is", $m_budget, $m_name)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
	echo "The budget for $m_name was updated to $m_budget.";
}



// Delete mission
if ($_POST != NULL && isset($_POST['missionDelete'])) {

	$m_name = $_POST['deleteMission'];	

		if (!($stmt = $mysqli->prepare("DELETE FROM missions WHERE name = ?;"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("s", $m_name)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
	echo "$m_name deleted from missions table.";
}




// Add to spacecraft
if ($_POST != NULL && isset($_POST['spacecraftAdd'])) {

		// Data validation - name is required field
	if ($_POST['s_name'] == "") {
		echo 'Name is a required field.<br>';
		exit;
	}
	$s_name = $_POST['s_name'];
	$s_cost = $_POST['s_cost'];
	$s_url = $_POST['s_url'];
	$d_name = $_POST['selectDestination'];


		// User data is valid - add spacecraft to spacecraft table
		if (!($stmt = $mysqli->prepare("INSERT INTO spacecraft (name, cost, imageURL, d_id) VALUES
		(?, ?, ?, (SELECT id FROM destinations WHERE name = ?));"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("siss", $s_name, $s_cost, $s_url, $d_name)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    if ($mysqli->errno == 1062) {
		    	echo "<br>Duplicate entry. Try again<br>";
		    }
		    exit;
		}
	echo "$s_name added to spacecraft table.";
}


// Assigning spacecraft to mission (add to spacecraft_missions)
if ($_POST != NULL && isset($_POST['assignSpacecraftMission'])) {

	// Data validation - both dropdwon selectons must be selected
	if ($_POST['assignMission'] == "none_selected" || $_POST['assignSpacecraft'] == "none_selected" ) {
		echo 'Select an item from both dropdown menus.<br>';
		exit;
	}
	$mission = $_POST['assignMission'];
	$spacecraft = $_POST['assignSpacecraft'];


		// User data is valid - add mission to missions table
		if (!($stmt = $mysqli->prepare("INSERT INTO missions_spacecraft (m_id, s_id) VALUES
		((SELECT id FROM missions WHERE name = ?), (SELECT id FROM spacecraft WHERE name = ?));"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("ss", $mission, $spacecraft)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

	echo "Assigned $spacecraft to $mission.";
}


// Add to agencies
if ($_POST != NULL && isset($_POST['agencyAdd'])) {

		// Data validation - name is required field
	if ($_POST['a_name'] == "") {
		echo 'Name is a required field.<br>';
		exit;
	}
	$a_name = $_POST['a_name'];
	$a_country = $_POST['a_country'];
	$a_budget = $_POST['a_budget'];
	$a_url = $_POST['a_url'];


// User data is valid - add agency to agencies table
		if (!($stmt = $mysqli->prepare("INSERT INTO agencies (name, country, annualbudget, URL) VALUES
		(?, ?, ?, ?);"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("ssis", $a_name, $a_country, $a_budget, $a_url)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    if ($mysqli->errno == 1062) {
		    	echo "<br>Duplicate entry. Try again<br>";
		    }
		    exit;
		}
	echo "Added $a_name to agencies table.";
}



// Add to destinations
if ($_POST != NULL && isset($_POST['destinationAdd'])) {

		// Data validation - name is required field
	if ($_POST['d_name'] == "") {
		echo 'Name is a required field.<br>';
		exit;
	}
	$d_name = $_POST['d_name'];
	$d_description = $_POST['d_description'];
	$d_distance = $_POST['d_distance'];

		// User data is valid - add agency to agencies table
		if (!($stmt = $mysqli->prepare("INSERT INTO destinations (name, description, distance) VALUES
		(?, ?, ?);"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}

		if (!$stmt->bind_param("ssi", $d_name, $d_description, $d_distance)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    if ($mysqli->errno == 1062) {
		    	echo "<br>Duplicate entry. Try again<br>";
		    }
		    exit;
		}
	echo "Added $d_name to destinations table.";
}
?>


<!-- -----------------------------------------------------FORMS ----------------------------------------------------------------- -->

<!-- Links to Search and Display -->
<fieldset>
	<form action="DB_Results.php" method="POST">
		<input type="submit" name = "displayAll" value = "Display Entire Database">
		&nbsp&nbsp&nbsp
		<a href="DB_SearchForms.php">Search Database</a>
	</form>
</fieldset>

<br>

<!-- Add Missions Form -->
<fieldset>
	<legend><h3>Add Mission</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
	<p>To add a mission to the database, enter the relevent info, and click on "Add Mission" below</p>
	Name: <input type="text" name="m_name"><br>
	Budget: <input type ="text" name="m_budget"><br>
	URL: <input type ="text" name="m_url"><br>

		<p>Choose associations.  If you do not see the item you want, add it first in its respective form. </p>

		Agency: 
		<select name="selectAgency"> 
			<option value="none_selected">Select</option>	
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

		Destination: 
		<select name="selectDestination"> 
			<option value="none_selected">Select</option>	
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

		<input type="submit" name = "missionAdd" value = "Add Mission"><br>
	</form>
</fieldset>

<br>



<!-- Update Missions Form -->
<fieldset>
	<legend><h3>Update Mission Budget</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
	<p>To update the budget for a mission, select the mission, enter the new budget amount, and click on "Update Budget" below</p>

		Mission: 
		<select name="updateMission"> 
			<option value="none_selected">Select</option>	
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

	Budget: <input type ="text" name="m_budget"><br>

		<br>
		<br>

		<input type="submit" name = "budgetUpdate" value = "Update Budget"><br>
	</form>
</fieldset>

<br>



<!-- Delete Missions Form -->
<fieldset>
	<legend><h3>Delete Mission</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
	<p>To delete a mission, select the mission, and click on "Delete Mission" below.  This cannot be undone.</p>

		Mission: 
		<select name="deleteMission"> 
			<option value="none_selected">Select</option>	
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

		<input type="submit" name = "missionDelete" value = "Delete Mission"><br>
	</form>
</fieldset>

<br>
<!-- Add Spacecraft Form -->
<fieldset>
	<legend><h3>Add Spacecraft</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
		<p>To add a spacecraft to the database, enter the relevent info, and click on "Add Spacecraft" below</p>
		Name: <input type="text" name="s_name"><br>
		Cost: <input type ="text" name="s_cost"><br>
		URL: <input type ="text" name="s_url"><br>

		<p>Choose association.  If you do not see the item you want, add it first in its respective form. </p>

		Destination: 
		<select name="selectDestination"> 
			<option value="none_selected">Select</option>	
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

		<input type="submit" name = "spacecraftAdd" value = "Add Spacecraft"><br>
	</form>
</fieldset>

<br>

<!-- Assign Spacecraft to Missions Form -->
<fieldset>
	<legend><h3>Assign Spacecraft to Missions</h3></legend>
	<form action="DB_Manipulation.php" method="POST">

<p>Assign a spacecraft to its mission.  If you do not see the items you want, add them first in their respective forms. </p>
<p>This can be repeated for multiple assignments.</p>

		Spacecraft: 
		<select name="assignSpacecraft"> 
			<option value="none_selected">Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM spacecraft WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_spacecraft = NULL;

		if (!$stmt->bind_result($out_spacecraft)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_spacecraft" . '">' . "$out_spacecraft" . '</option>';
		}

?>
		</select>

		Mission: 
		<select name="assignMission"> 
			<option value="none_selected">Select</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT name FROM missions WHERE name != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}

		$out_mission = NULL;

		if (!$stmt->bind_result($out_mission)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}

		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_mission" . '">' . "$out_mission" . '</option>';
		}
?>
		</select>

		<br>
		<br>

		<input type="submit" name = "assignSpacecraftMission" value = "Assign"><br>
	</form>
</fieldset>

<br>

<!-- Add Agency Form -->
<fieldset>
	<legend><h3>Add Agency</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
		<p>To add an agency to the database, enter the relevent info, and click on "Add Agency" below</p>
		Name: <input type="text" name="a_name"><br>
		Country: <input type="text" name="a_country"><br>
		Annual Budget: <input type ="text" name="a_budget"><br>
		URL: <input type ="text" name="a_url"><br>

		<br>

		<input type="submit" name = "agencyAdd" value = "Add Agency"><br>
	</form>
</fieldset>

<br>

<!-- Add Destination Form -->
<fieldset>
	<legend><h3>Add Destination</h3></legend>
	<form action="DB_Manipulation.php" method="POST">
		
		<p>To add a destination to the database, enter the relevent info, and click on "Add Destination" below</p>
		Name: <input type="text" name="d_name"><br>
		Description: <input type ="text" name="d_description"><br>
		Distance from Earth: <input type ="text" name="d_distance"><br>

		<br>

		<input type="submit" name = "destinationAdd" value = "Add Destination"><br>
	</form>
</fieldset>

<br>

</html>


<?php
$stmt->close();
?>

