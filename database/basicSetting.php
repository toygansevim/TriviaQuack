<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/13/18
 * Time: 12:02 AM
 *
 * This class instantiates a database object using Toygan Sevim's cpanel account.
 *
 */

require '/home/tsevimgr/config.php';

try
{
    //instantiate a databse obejct
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database!";


    /* INSERT ELEMENT

    //define the query
     $sql = "INSERT INTO pets(type,name,color) VALUES (:type, :name, :color)";

     //prepare the statement
     $statement = $conn->prepare($sql);

     //Bind the parameters
     $type = 'Kangaroo';
     $name = 'Toygan';
     $color = 'purple';
     $statement->bindParam(':type', $type, PDO::PARAM_STR);
     $statement->bindParam(':name', $name, PDO::PARAM_STR);
     $statement->bindParam(':color', $color, PDO::PARAM_STR);



     //insert different animals
     $type = 'Elephant';
     $name = 'Fil';
     $color = 'Gray';
     $statement ->bindParam(':type',$type,PDO::PARAM_STR);
     $statement ->bindParam(':name',$name,PDO::PARAM_STR);
     $statement ->bindParam(':color',$color,PDO::PARAM_STR);

     //execute
     $statement->execute();

     //tell info about the last inserted position
     $id = $conn->lastInsertId();
     echo "<p>pet $id inserted successfully.</p>";*/


    /* //UPDATE ELEMENT
      $sql = "UPDATE pets SET name = :new WHERE name = :old";

      //prepare
      $statement = $conn->prepare($sql);

      //bind the parameters
      $old = 'Selma';
      $new = 'Troy';
      $statement->bindParam(':new', $new, PDO::PARAM_STR);
      $statement->bindParam(':old', $old, PDO::PARAM_STR);

      //execute
      $statement->execute();*/
    /*
       //delete element

        $sql = "DELETE FROM pets WHERE id = :id";

        //prepare
        $statement = $conn->prepare($sql);

        //bind
        $id = 1;
        $statement->bindParam(':id',$id,PDO::PARAM_INT);

        //execute
        $statement->execute();*/

    //SELECT A SINGLE ROW
    //define the query
    //$sql = "SELECT * FROM pets WHERE id = :id";

    //MULTIPLE RESULTS
    $sql = "SELECT * FROM pets";

    //prepare
    $statement = $conn->prepare($sql);

    //binding
    $id = 3;
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    //execute
    $statement->execute();

    //Process the results
    /*
     * SINGLE RESULT
        $row = $statement->fetch(PDO::FETCH_ASSOC);; //fetch is used for 1 row
        echo $row['name'] . ", " . $row['type'] . ", ". $row['color'];
    */

    //MULTIPLE RESULTS
    /*    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
            echo $row['name'] . ", " . $row['type'] . ", ". $row['color'] . "<br>";
        }*/

} catch (PDOException $ex)
{
    echo "Connection failed<br>";
    echo $ex->getMessage();
    return;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
          integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy"
          crossorigin="anonymous">

    <title>{{@pageTitle}}</title>
</head>
<body>

<table>

    <?php
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
        echo "<tr class='border'>";
        echo "<td class='border'>" . $row['name'] . "</td><td> " . $row['type'] . "</td><td> " . $row['color'] . "</td><br>";
        echo "  </tr>";
    }
    ?>

</table>


<!--Bootstrap cdn's-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"
        integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4"
        crossorigin="anonymous"></script>
</body>
</html>
