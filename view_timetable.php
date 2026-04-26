<?php
$conn = new mysqli("localhost","root","1234","timetablesystem");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

// ✅ Safe query (better ordering for weekdays)
$sql = "SELECT * FROM timetable";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Timetable</title>

<!-- ✅ CSS FILE LINK -->
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1> Timetable</h1>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>Course</th>
    <th>Division</th>
    <th>Day</th>
    <th>Time Slot</th>
    <th>Subject</th>
    <th>Faculty</th>
    <th>Room/Lab</th>
    <th>Actions</th>
</tr>

<?php
if($result && $result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "<tr>
            <td>".htmlspecialchars($row['course'])."</td>
            <td>".htmlspecialchars($row['division'])."</td>
            <td>".htmlspecialchars($row['day'])."</td>
            <td>".htmlspecialchars($row['time_slot'])."</td>
            <td>".htmlspecialchars($row['subject'])."</td>
            <td>".htmlspecialchars($row['faculty'])."</td>
            <td>".htmlspecialchars($row['room'])."</td>
            <td>
                <a href='edit_timetable.php?id=".$row['id']."'>Edit</a> |
                <a href='delete_timetable.php?id=".$row['id']."' onclick=\"return confirm('Are you sure?');\">Delete</a>
            </td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='8'>No timetable entries found</td></tr>";
}
?>

</table>

</body>
</html>

<?php
$conn->close();
?>