<?php
    
    $id = $student['id'];
    $fname = $student['fname'];
    $lname = $student['lname'];
    $email = $student['email'];
    $regDate = new DateTime($student['regDate']);
    $regDate = date('d.m.Y', $regDate->getTimestamp());
    echo "<tr class='student_item'>
            <td>$id</td>
            <td>$fname</td>
            <td>$lname</td>
            <td>$email</td>
            <td>$regDate</td>
        </tr>";

?>