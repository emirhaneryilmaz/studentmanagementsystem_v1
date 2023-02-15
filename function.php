<?php

$conn = mysqli_connect("localhost", "root", "", "student");

if (isset($_GET["action"])) {
  if ($_GET["action"] == "delete") {
    delete();
  } else if ($_GET["action"] == "insert") {
    insert();
  } else if ($_GET["action"] == "update") {
    update();
  } else if ($_GET["action"] == "search") {
    search();
  }
}

function delete()
{
  
 global $conn;

 $sid = mysqli_real_escape_string($conn,$_GET["sid"]);
 $result= mysqli_query($conn, $sql = "DELETE FROM student WHERE sid=$sid") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
  
 if($result)
 echo "1";
 else  
 echo '0';
 
}

function insert()
{
  global $conn;

  //$sid = mysqli_real_escape_string($conn,$_GET["sid"]);
  $fname = mysqli_real_escape_string($conn,$_GET["fname"]);
  $lname = mysqli_real_escape_string($conn,$_GET["lname"]);
  $birthplace = mysqli_real_escape_string($conn,$_GET["birthplace"]);
  $birthDate = mysqli_real_escape_string($conn,$_GET["birthDate"]);

  mysqli_query($conn, $sql = "INSERT INTO student (fname, lname , birthplace , birthDate) VALUES ('$fname', '$lname', '$birthplace','$birthDate')") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
  //echo array(1,$sid);
  $sid = $conn->insert_id;
  if($sid){
    echo $sid;
  }
  else{
    echo '';
  }
  //$arr=[1,$sid];
  //echo json_encode($arr);
}

function update()
{
  global $conn;

  $sid = mysqli_real_escape_string($conn,$_GET["sid"]);
  $fname = mysqli_real_escape_string($conn,$_GET["fname"]);
  $lname = mysqli_real_escape_string($conn,$_GET["lname"]);
  $birthplace = mysqli_real_escape_string($conn,$_GET["birthplace"]);
  $birthDate = mysqli_real_escape_string($conn,$_GET["birthDate"]);

  $result =  mysqli_query($conn, $sql = "UPDATE student SET  sid='$sid', fname='$fname', lname='$lname' , birthplace='$birthplace', birthDate='$birthDate' WHERE sid=$sid") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
  if($result)
    echo "1";
  else  
    echo '0';
}

function search()
{
  global $conn;

  $sid = mysqli_real_escape_string($conn,$_GET["sid"]);
  $fname = mysqli_real_escape_string($conn,$_GET["fname"]);
  $lname = mysqli_real_escape_string($conn,$_GET["lname"]);
  $birthplace = mysqli_real_escape_string($conn,$_GET["birthplace"]);
  $birthDate = mysqli_real_escape_string($conn,$_GET["birthDate"]);

  $result2 = mysqli_query($conn, $sql = "SELECT * FROM student WHERE sid LIKE '{$sid}%' AND fname LIKE '{$fname}%' AND lname LIKE '{$lname}%' AND birthplace LIKE '{$birthplace}%' AND birthDate LIKE '{$birthDate}%'") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);

  while ($row = mysqli_fetch_assoc($result2)) {

    echo "<tr id=$row[sid]>
    <td id='0$row[sid]'>" . $row["sid"] . "</td>
    <td id='$row[fname]'>" . $row["fname"] . "</td>
    <td id='$row[lname]'> " . $row["lname"] . "</td>
    <td id='$row[birthplace]'>" . $row["birthplace"] . "</td>
    <td id='$row[birthDate]'>" . $row["birthDate"] . "</td>
    <td> 
    <button type='button' name='button' onclick = 'deletedata(" . $row['sid'] . ")'>SİL</button>
    </td>
                  
    <td id='updateCell$row[sid]'>
     <button class='btn btn-secondary' id='edit' value='edit' 
        onclick='updatedata(" . $row['sid'] . "," . "\"" . $row['fname'] . "\"" . ",
        " . "\"" . $row['lname'] . "\"" . "," . "\"" . $row['birthplace'] . "\"" . "," . "\"" . $row['birthDate'] . "\"" . ")'
        >GÜNCELLE
     </button>
    </td>
    
    </tr>";
  }
}
?>