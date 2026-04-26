<?php
$conn = new mysqli("localhost","root","1234","timetablesystem");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

// CHECK ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid ID");
}

$id = (int)$_GET['id'];

// FETCH DATA
$stmt = $conn->prepare("SELECT * FROM timetable WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if(!$row){
    die("Record not found");
}

// UPDATE DATA
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $course    = $_POST['course'];
    $division  = $_POST['division'];
    $day       = $_POST['day'];
    $time_slot = $_POST['time_slot'];
    $subject   = $_POST['subject'];
    $faculty   = $_POST['faculty'];
    $room      = $_POST['room'];

    $type = (strpos($room,"Lab") !== false) ? "Lab" : "CR";

    $update = $conn->prepare("
        UPDATE timetable 
        SET course=?, division=?, day=?, time_slot=?, subject=?, faculty=?, room=?, type=? 
        WHERE id=?
    ");

    $update->bind_param(
        "ssssssssi",
        $course,$division,$day,$time_slot,
        $subject,$faculty,$room,$type,$id
    );

    if($update->execute()){
        header("Location: view_timetable.php");
        exit;
    } else {
        echo "Update Failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Timetable</title>

<!-- ✅ CSS FILE LINK -->
<link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Edit Timetable</h2>

<form method="POST">

<!-- COURSE -->
<select name="course" required>
    <option value="">Select Course</option>
    <option <?= $row['course']=="BCA"?"selected":"" ?>>BCA</option>
    <option <?= $row['course']=="BCA (AI & DS)"?"selected":"" ?>>BCA (AI & DS)</option>
    <option <?= $row['course']=="MCA"?"selected":"" ?>>MCA</option>
    <option <?= $row['course']=="MCA (AI & DS)"?"selected":"" ?>>MCA (AI & DS)</option>
    <option <?= $row['course']=="B.Tech CSE"?"selected":"" ?>>B.Tech CSE</option>
    <option <?= $row['course']=="B.Tech (AI & ML)"?"selected":"" ?>>B.Tech (AI & ML)</option>
</select>

<br><br>

<!-- DIVISION -->
<input type="text" name="division"
value="<?= htmlspecialchars($row['division']) ?>" required>

<br><br>

<!-- DAY -->
<select name="day" required>
<?php
$days = ["Monday","Tuesday","Wednesday","Thursday","Friday"];
foreach($days as $d){
    $sel = ($row['day']==$d) ? "selected" : "";
    echo "<option value='$d' $sel>$d</option>";
}
?>
</select>

<br><br>

<!-- TIME SLOT -->
<select name="time_slot" required>
<?php
$slots = [
"1st: 9:00 - 9:55",
"2nd: 9:55 - 10:50",
"Break: 10:50 - 11:30",
"3rd: 11:30 - 12:25",
"4th: 12:25 - 1:20",
"Break: 1:20 - 2:00",
"5th: 2:00 - 2:55",
"6th: 2:55 - 3:50",
"Break: 3:50 - 4:10",
"7th: 4:10 - 5:00"
];

foreach($slots as $s){
    $sel = ($row['time_slot']==$s) ? "selected" : "";
    echo "<option value='$s' $sel>$s</option>";
}
?>
</select>

<br><br>

<!-- SUBJECT -->
<input type="text" name="subject"
value="<?= htmlspecialchars($row['subject']) ?>" required>

<br><br>

<!-- FACULTY TYPE -->
<select id="facultyType" onchange="loadFaculty()" required>
    <option value="">Select Type</option>
    <option value="hod_cse">HOD CSE</option>
    <option value="hod_soc">HOD SOC</option>
</select>

<br><br>

<!-- FACULTY -->
<select name="faculty" id="faculty" required onchange="showImg()">
    <option value="<?= htmlspecialchars($row['faculty']) ?>">
        <?= htmlspecialchars($row['faculty']) ?>
    </option>
</select>

<br><br>

<img id="facultyImg" src="img/default.png" width="120" height="120">

<br><br>

<!-- ROOM -->
<select name="room" required>

<optgroup label="Class Rooms">
<?php
for($i=1;$i<=18;$i++){
    $r="CR$i";
    $sel=($row['room']==$r)?"selected":"";
    echo "<option value='$r' $sel>$r</option>";
}
?>
</optgroup>

<optgroup label="NB CR Rooms">
<?php
$nb = ["CR101","CR102","CR103","CR104","CR201","CR202","CR203","CR204","CR401","CR402","CR403","CR404","CR501","CR502"];

foreach($nb as $r){
    $sel=($row['room']==$r)?"selected":"";
    echo "<option value='$r' $sel>$r</option>";
}
?>
</optgroup>
<optgroup label="LT Rooms">
<?php
for($i=1;$i<=4;$i++){
    $r="LT$i";
    $sel=($row['room']==$r)?"selected":"";
    echo "<option value='$r' $sel>$r</option>";
}
?>
</optgroup>

<optgroup label="Labs">
<?php
for($i=1;$i<=5;$i++){
    $r="Lab $i";
    $sel=($row['room']==$r)?"selected":"";
    echo "<option value='$r' $sel>$r</option>";
}
?>
</optgroup>

</select>

<br><br>

<input type="submit" value="Update">

</form>

<script>
const facultyData = {
    hod_cse: [
        {name:"Dr. Manoj Chandra Lohani", img:"img2/Btg2tYqp-Dr-MC-Lohani.jpg"},
        {name:"Mr. Ishwari Singh Rajput", img:"img2/ishwari-img-2.webp"},
        {name:"Dr. Shubhro Chakrabartty", img:"img2/pawan-img-removebg-preview-1.png"},
        {name:"Dr. Manoj Singh Adhikari", img:"img2/manoj-img-removebg-preview.png"},
        {name:"Mr. Trilok Singh", img:"img2/trilok-img-1.webp"},
        {name:"Mr. Amit Karmakar", img:"img2/amit-img-1.webp"},
        {name:"Dr. Manisha Koranga", img:"img2/manisha-img-2.webp"},
        {name:"Ms. Neha Sharma", img:"img/neha-img.webp"}
    ],

    hod_soc: [
        {name:"Mr. Kamlesh Padaliya", img:"img/kamlesh-img.webp"},
        {name:"Mr. Anuj Kumar Dixit", img:"img/anuj-img-1.webp"},
        {name:"Ms. Sujata Negi", img:"img/sujata-img.webp"},
        {name:"Mr. Gautam Kumar", img:"img/gautam-img-1.webp"},
        {name:"Ms. Mayurika Joshi", img:"img/mayurika-img.webp"},
        {name:"Mr. Yogesh Bhatt", img:"img/yogesh-bhatt.webp"},
        {name:"Ms. Akansha Tiwari", img:"img/akansha-tiwari.webp"}
    ]
};

function loadFaculty(){
    let type = document.getElementById("facultyType").value;
    let select = document.getElementById("faculty");

    select.innerHTML = `<option value="">Select Faculty</option>`;

    if(facultyData[type]){
        facultyData[type].forEach(f=>{
            let opt = document.createElement("option");
            opt.value = f.name;
            opt.textContent = f.name;
            opt.setAttribute("data-img", f.img);
            select.appendChild(opt);
        });
    }

    document.getElementById("facultyImg").src = "img/default.png";
}

function showImg(){
    let select = document.getElementById("faculty");
    let img = select.options[select.selectedIndex]?.getAttribute("data-img");
    document.getElementById("facultyImg").src = img ? img : "img/default.png";
}
</script>

</body>
</html>