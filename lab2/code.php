<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if ($_POST) {
   
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $address = htmlspecialchars($_POST['address']);
    $country = htmlspecialchars($_POST['country']);
    $gender = htmlspecialchars($_POST['gender']);
    $skills = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "No skills selected"; 
    $uname = htmlspecialchars($_POST['uname']);
    $passwd = htmlspecialchars($_POST['passwd']);
    $department = htmlspecialchars($_POST['Department']);

    $data = $fname . "|" . $lname . "|" . $address . "|" . $country . "|" . $gender . "|" . $skills . "|" . $uname . "|" . $passwd . "|" . $department;

    
    file_put_contents("data.txt", $data . "\n", FILE_APPEND);
    

    $title = ($gender == "male") ? "Mr." : "Miss";
    ?>

        <table border='1'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Country</th>
                <th>Gender</th>
                <th>Skills</th>
                <th>User Name</th>
                <th>Password</th>
                <th>Department</th>
            </tr>

            <?php
           
            $lines = file("data.txt");

            
            foreach ($lines as $line) {
                
                if (trim($line) !== "") {
                    echo "<tr>";

                    
                    $arr = explode("|", $line);

                    
                    if (count($arr) == 9) {
                        
                        foreach ($arr as $data) {
                            
                            echo "<td>" . trim($data) . "</td>";
                        }
                    } else {
                        
                        echo "<td colspan='9'>Error in data format</td>";
                    }

                    echo "</tr>";
                }
            }
            ?>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "<p>No data received.</p>";
}
?>
