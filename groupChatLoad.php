<?php
    require_once('connection.php');//gets the connections.php
    require_once("functions.php");
    require_once("groupChatFunctions.php");
    echo '<script src="groupChat.js"></script>';
    $db = getConnection();//returns the connection for the database.

    session_start();
    $studentInfo = getStudentDetails(); //gets all student details
    $studentFirstName = $studentInfo['firstName'];//firstname
    $studentLastName = $studentInfo['lastName']; //lastname
    $studentID = $studentInfo['studentID'];//student ID
    $studentCourseID = $studentInfo['courseID'];//courseID

    $courseName = courseNameConversion($studentCourseID); //conversion for course ID
    $messages = groupChatMessage($courseName);//gets all the messages associated with the courseName

    $messageAmount = 0;

    while ($row = $messages->fetchObject()) { //fetchObject
        //shows information for users
        $sendID = $row->senderStudentID;
        $studentNames = studentName($sendID);

        echo '<div id=messageSent>';
        echo $studentNames['firstName'] . " " . $studentNames['lastName'] . " (" . $row->senderStudentID . "):\n";
        echo $row->chatMessage . "\n";
        echo '<div id=timestamp>';
        echo $row->timeSent ."<br />\n";
        echo '</div>';
        echo "\n";
        echo '</div>';

        $messageAmount = $messageAmount + 1;
    }

    //sets the load amount to messageAmountLoad
    $messageAmountString = strval($messageAmount);
    echo '<Script> 
        var message = "'; echo $messageAmountString; echo'";
        localStorage.setItem("messageAmountLoad", message);    
    </Script>';

    //javascript - uncomment these for fixed version
    //$messageAmountString = strval($messageAmount);
    //echo '<script> alertFunction('; echo $messageAmount; echo','; echo $messageAmountString; echo') </script>';
?>



