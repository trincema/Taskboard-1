<?php
include "../db_connection.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST['EditTaskId'];
	$task_name = $_POST['EditTaskName'];
	$skill = $_POST['EditSkill'];
	$skill_level = $_POST['EditSkillLevel'];
	$duration = $_POST['EditDuration'];
	$assigned_to = $_POST['EditAssignedTo'];
	$status = $_POST['EditStatus'];

	$skill_id = 0;
	$level_id = 0;
	$status_id = 0;

	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if(!$connection) {
		echo "Database Connection Error...".mysqli_connect_error();
	} else {
		$sql="SELECT * FROM $database.Skills WHERE skill='$skill'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table Skills".mysqli_error($connection);
		}
		if (mysqli_num_rows($retval) == 1) {
			while($row = mysqli_fetch_assoc($retval)) {
				$skill_id = $row["id"];
			}
		}
		$sql="SELECT * FROM $database.SkillLevel WHERE skill_level='$skill_level'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table SkillLevel".mysqli_error($connection);
		}
		if (mysqli_num_rows($retval) == 1) {
			while($row = mysqli_fetch_assoc($retval)) {
				$level_id = $row["id"];
			}
		}
		$sql="SELECT * FROM $database.TaskStatus WHERE task_status='$status'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table TaskStatus".mysqli_error($connection);
		}
		if (mysqli_num_rows($retval) == 1) {
			while($row = mysqli_fetch_assoc($retval)) {
				$status_id = $row["id"];
			}
		}

		$pieces = explode(" ", $assigned_to);
		$first_name = $pieces[0];
		$last_name = $pieces[1];
		$sql = "SELECT * FROM $database.TeamMembers WHERE first_name='$first_name' AND last_name='$last_name'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table TeamMembers".mysqli_error($connection);
		}
		if (mysqli_num_rows($retval) == 1) {
			while($row = mysqli_fetch_assoc($retval)) {
				$user_id = $row["id"];
			}
		}

		$sql = "UPDATE Taskboard.Tasks SET task_name='$task_name',skill_required=$skill_id,level_required=$level_id,duration=$duration,".
				"task_status=$status_id,assigned_member=$user_id WHERE id=$id";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo"Error access in table TeamMembers".mysqli_error($connection);
        }
        mysqli_close($connection);
	}
}
?>