<html>
<style>
    table, th, td {
        border: 1px solid black;
    }
    <?php

    //Define connection parameters in this PHP code block
    $servername = "localhost";
    $username = "hmoye";
    $password = "7TR4xezk";
    $dbname = "hmoye";

     $conn = mysqli_connect($servername, $username, $password, $dbname);

     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }

    $sqlstatement = $conn->prepare("SELECT distinct dept_name FROM department order by dept_name asc");
    $sqlstatement->execute();
    $departments = $sqlstatement->get_result();
    $sqlstatement->close();
    ?>

</style
<body>

<br>
<p><h2>New Faculty Students:</h2></p>
<form action="add_student.php" method="POST" autocomplete="off">
    <fieldset><legend><b><h3>Registration </h3></b></legend>
    Create New Student ID: <input type=text placeholder="create an id" size=20 name="id">
    <p>Enter New Student name: <input type=text placeholder="enter your name" size=20 name="name">
    <p>Select Faculty Department Name:
    <select name="department"
    <?php
    while($department = $departments->fetch_assoc()) {
        ?>
        <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?>
        </option>
    <?php } //end while loop ?>
        </select></p>
    <p>Credit score: <input type=number size=10 placeholder="enter with two digits :00"  name="tot_cred"><p></p>
    <p>    <input type="submit" name="form_submitted" value="submit" /> </p>
</form>


<?php //starting php code again!
if (!isset($_POST["form_submitted"]))
{
    echo "Please enter new student details and submit the form.";
}
else {
    if (!empty($_POST["id"]) && !empty($_POST["name"]) && !empty($_POST["tot_cred"]))
    {
        $profID = $_POST["id"];
        $profName = $_POST["name"];
        $profDepart = $_POST["department"];
        $profTot = $_POST["tot_cred"];
        $sqlstatement = $conn->prepare("INSERT INTO student values(?, ?, ?, ?)");
        $sqlstatement->bind_param("sssd",$profID,$profName,$profDepart,$profTot);
        $sqlstatement->execute();
        echo $sqlstatement->error;
        $sqlstatement->close();

        echo "You have registered successfully.";

        function refresh( $time ){
            $current_url = $_SERVER[ 'REQUEST_URI' ];
            return header( "Refresh: " . $time . "; URL=add_student.php" );
        }
        // call the function in the appropriate place
        refresh( 3 );
    }

    else {
        echo "<b> Error: Please complete the process and enter your credit score with two digits.</b>";

        function refresh( $time ){
            $current_url = $_SERVER[ 'REQUEST_URI' ];
            return header( "Refresh: " . $time . "; URL=add_student.php" );
        }

        // call the function in the appropriate place
        refresh( 3 );

    }
    $conn->close();
}
?>

</body>
</html>
