<html>
<style>
    table, th, td {
        border: 1px solid black;
    }
    <?php

    $servername = "localhost";
    $username = "hmoye";
    $password = "7TR4xezk";
    $dbname = "hmoye";
    ?>
</style>
<body><br>
<p><h2> Kent State University Student ID Directory Search </h2></p>
<form action="student_id_search.php" method="POST" autocomplete="off">
    <fieldset><legend><b><h3>Search </h3></b></legend>
        Enter Student ID: <input type=number size=20 name="id">
        <p> <input type=submit value="submit">
            <input type="hidden" name="form_submitted" value="1" >
</form>

<?php
if (!isset($_POST["form_submitted"]))
{
    echo "Please enter a Student ID and Submit.";
}
else {
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (!empty($_POST["id"]))
    {
        $studentName= $_POST["id"];
        $sqlstatement = $conn->prepare("SELECT id, name, dept_name, tot_cred FROM student WHERE id LIKE '%$studentName%'");
        $sqlstatement->execute();
        $result = $sqlstatement->get_result();
        $sqlstatement->close();
    }



    if(!empty($result->num_rows)) {

        echo "<table><tr><th>ID</th><th>Name</th><th>Department</th><th>Total Number of Credit</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["dept_name"]."</td><td>".$row["tot_cred"]."</td></tr>";

        }
        echo "</table>"; // close the table
        echo "There are ". $result->num_rows . " results.";
        // Don't render the table if no results found
    }

    else {
        echo " <b>Please enter a student name </b>";
    }

    $conn->close();
}

?>
</body>
</html>