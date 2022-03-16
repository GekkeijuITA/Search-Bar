<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbName = "searchBarDB";
    $conn = mysqli_connect($hostname , $username , $password , $dbName);
    if(!$conn)
    {
        die("Connection error");
    }
    function sqlInjectionPrevention($input)
    {
        for($i = 0 ; $i < strlen($input) - 1 ; $i++)
        {
            if($input[$i] == "-" && $input[$i++] == "-")
            {
                return true;
            }
        }
        return false;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search Bar</title>
    </head>
    <body>
        <form method="post" action="">
            <input type="text" name="searchbar" placeholder="Search...">
        </form>
        <div>
            <?php
                if(isset($_POST["searchbar"]))
                {
                    if(!sqlInjectionPrevention($_POST["searchbar"]))
                    {
                        $searchItem = $_POST["searchbar"];
                        //You can change "title" and "description" in what you want
                        $sql = "SELECT title,description FROM products WHERE title LIKE '%$searchItem%'";
                        $result = $conn -> query($sql);
                        if($result -> num_rows > 0)
                        {
                            echo '
                                <table>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>
                            ';
                            while($row = $result -> fetch_assoc())
                            {
                                $title = $row["title"];
                                $description = $row["description"];
                                echo '
                                    <tr>
                                        <td>'.$title.'</td>
                                        <td>'.$description.'</td>
                                    </tr>
                                ';
                            }
                            echo '
                                </table>
                            ';
                        }
                        else
                        {
                            echo '<h1>0 Results</h1>';
                        }
                    } 
                    else
                    {
                        echo '<h1>Warning! SQL Injection detected.</h1>';
                    }
                }
            ?>
        </div>
    </body>
    <script>
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }    
    </script> 
</html>
