
<html>
<?php require("verify_login.php");?>


<?php
$db = new SQLite3('/xampp/Data/test.db');
if(isset($_POST['submit'])){
    $location = $_POST['locationDropdown'];
    $searchValue = $_POST['searchValue'];
    $features_array= [];
    if(!empty($_POST['features'])) {    
        foreach($_POST['features'] as $value){
            array_push($features_array, $value);
        }
    }
    $features_string= implode(",",$features_array);
}
$sql_stmnt = "SELECT Business_Name, Venue_Type, Business_Description, Access_Features, Location FROM Business_Owner 
WHERE Business_Name IS NOT NULL";
if(!empty($location)){
    $sql_stmnt.= " AND Location = '$location'";
}
if(!empty($searchValue)){
    $sql_stmnt.= " AND LOWER(Business_Description) LIKE LOWER('%$searchValue%') ";
}
if(!empty($features_string)){
    $sql_stmnt.= " AND Access_Features LIKE '$features_string'";
}
$stmt = $db->prepare($sql_stmnt);

$result = $stmt->execute();
$rows_array = [];
$amount = 0;


while ($row=$result->fetchArray())
{
    $amount += 1;
    $rows_array[]=$row;
}
?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="homepage_style.css">
        <title>Access for All</title>
    </head>
<main>
    <div class = "homepage-grid">
        <div class = "homepage-search">
        <form method = "POST">
        <body>  
            Location :  
            <select name="locationDropdown" id="locationDropdown">
                <option value="">Any</option>  
                <option value="Sheffield" <?php if(!empty($location)){if(strpos($location, "Sheffield") !== FALSE){?> selected = "true" <?php }}?>>Sheffield</option>
                <option value="Derby" <?php if(!empty($location)){if(strpos($location, "Derby") !== FALSE){?> selected = "true" <?php }}?>>Derby</option>  
                <option value="London" <?php if(!empty($location)){if(strpos($location, "London") !== FALSE){?> selected = "true" <?php }}?>>London</option>  
            </select>
            <input type="text" name="searchValue" value=<?php if(isset($_POST['submit'])){;}?>>
            <button class="w-20 btn btn-lg btn-primary" style="align: center" type="submit" name="submit" value="submitLocation">Search</button>  
        </body>
        
    </div>
        <body>
            <?php if ($amount != 0){?>
                <div class = "homepage-table">
                    <table style="width: 100%; text-align: center; border: solid 2px black">
                        <tr class="tableHead">
                            <th>Business Name</th>
                            <th>Venue</th>
                            <th>Access Features</th>
                            <th>Location</th>
                        </tr>
                        <?php for($x = 0  ; $x < $amount; $x+=1){;?>
                                    <tr>
                                        <td><a href="https://www.cineworld.co.uk/cinemas/sheffield/031"><strong><?php echo $rows_array[$x][0]?></strong></a></td>
                                        <td><strong><?php echo $rows_array[$x][1];?></strong></td>
                                        <td><strong><?php echo $rows_array[$x][3];?></strong></td>
                                        <td><strong><?php echo $rows_array[$x][4];?></strong></td>
                                    </tr>
                                    <?php }?>
                        </table>
                                </div>
                                <?php }?>
        </body>
        <div class = "homepage-access-features">
            <header><b> Filter by Access Features </b></header>
                <input type="checkbox" id="vehicle1" name='features[]' value="Ramp" <?php if(!empty($features_string)){if(strpos($features_string, "Ramp") !== FALSE){?> checked <?php }}?> >
                <label for="vehicle1"> Ramp</label><br>
                <input type="checkbox" id="vehicle2" name='features[]' value="Accessible Toilets" <?php if(!empty($features_string)){if(strpos($features_string, "Accessible Toilets") !== FALSE) {?> checked <?php }}?>>
                <label for="vehicle2"> Accessible Toilets</label><br>
                <input type="checkbox" id="vehicle3" name='features[]' value="Disabled Parking" <?php if(!empty($features_string)){if(strpos($features_string, "Disabled Parking") !== FALSE) {?> checked <?php }}?>>
                <label for="vehicle3"> Disabled Parking</label><br>
        </div>
                                </form>
    </div>

                        </main>
                        <?php require("Footer.php");?>
                        </html>

