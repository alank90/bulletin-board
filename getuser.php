<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 60%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

$q = $_REQUEST['q'];

include 'dbinfo.inc.php'; //include login info file

$fullname = explode(" ", $q);
$lastname = array_pop($fullname);
$firstname = implode(" ", $fullname);

// have check for apostrophe's and escape them
$lastname = addslashes($lastname);
/*
echo "Lastname: $lastname\n";
echo "Firstname: $firstname\n";
*/

try
    {
      $conn = new PDO($dsn, $username, $password);
      
    }
catch (PDOException $e)
    {
    $error_message=$e->getMessage();
    echo "<h1>Resource Unavailable. Please contact the System Administrator</h1>";
    }
//End of Connection

$sql = "SELECT * FROM Staff_Info WHERE FName LIKE '%$firstname%' && LName LIKE '%$lastname%'";
$query = $conn->prepare($sql);
$query->execute();

// Check if any rows were returned
$count = $query->rowCount();
if ($count==0) {
 print("Query: Returned 0 results. Try expanding your search.");
}
else {

echo "<table>
<tr>
<th>Extention Telephone</th>
<th>First Name</th>
<th>Last Name</th>
<th>Office Room<th>
</tr>";

while ($row = $query->fetch()) { 

    echo "<tr>";
    echo "<td>" . $row['Ext'] . "</td>";
    echo "<td>" . $row['FName'] . "</td>";
    echo "<td>" . $row['LName'] . "</td>";
    echo "<td>" . $row['Office_Rm'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}

?>
</body>
</html>