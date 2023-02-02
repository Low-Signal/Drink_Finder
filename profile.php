<?php
require 'dbconn.php';
session_start();

// Check if user is logged in, if not shows error message.
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile.";
  header("location: error.php");    
}
else {

  // Sets session variables to regular variables
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  $email = $_SESSION['email'];
  $active = $_SESSION['active'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  // Includes file based on user selection.
  if(isset($_POST['name_search']))
  {
    $name_value = $_POST['name_value'];
    $sql = "SELECT * FROM drink_recipes WHERE drink_name LIKE '%$name_value%'";
  }
  elseif(isset($_POST['ingredient_search']))
  {
    $ingredient_value = $_POST['ingredient_value'];
    $sql = "SELECT DISTINCT * FROM drink_recipes WHERE(
      base_alcohol1 LIKE '%$ingredient_value%' OR
      base_alcohol2 LIKE '%$ingredient_value%' OR
      base_alcohol3 LIKE '%$ingredient_value%' OR
      base_alcohol4 LIKE '%$ingredient_value%' OR 
      base_mixer1 LIKE '%$ingredient_value%' OR 
      base_mixer2 LIKE '%$ingredient_value%' OR 
      base_mixer3 LIKE '%$ingredient_value%' OR
      base_mixer4 LIKE '%$ingredient_value%' OR 
      base_mixer5 LIKE '%$ingredient_value%')";
  }
  elseif(isset($_POST['addtofavorites']))   // Adds drink to current users favorites.
  {
    $fav_drink_name = $_POST['custID'];
    $sql = "INSERT INTO user_favorites (drink_name, email, base_alcohol1, base_alcohol2, base_alcohol3, base_alcohol4, base_mixer1, base_mixer2, base_mixer3, base_mixer4, base_mixer5, garnish1, garnish2, garnish3)
            SELECT drink_recipes.drink_name, '$email', drink_recipes.base_alcohol1, drink_recipes.base_alcohol2, drink_recipes.base_alcohol3, drink_recipes.base_alcohol4, drink_recipes.base_mixer1, drink_recipes.base_mixer2, drink_recipes.base_mixer3, drink_recipes.base_mixer4, drink_recipes.base_mixer5, drink_recipes.garnish1, drink_recipes.garnish2, drink_recipes.garnish3
            FROM drink_recipes
            WHERE drink_recipes.drink_name = '$fav_drink_name';";
    $mysqli->query($sql);
    $sql = "SELECT * FROM drink_recipes";
    
  }
  elseif(isset($_POST['remove']))
  {
    $remove_drink = $_POST['custID2'];
    $sql = "DELETE FROM user_favorites
          WHERE user_favorites.drink_name = '$remove_drink' AND
          user_favorites.email = '$email'";
    $mysqli->query($sql);
    $sql = "SELECT * FROM user_favorites WHERE '$email' = email";
  }       

}
else{
  $sql = "SELECT * FROM drink_recipes";
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <!-- Sets tab title -->
    <title>Welcome <?= $first_name.' '.$last_name ?></title>
    <!-- includes scripts and css code -->
    <?php include 'css/css.html'; ?>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  </head>

  <body>

    <div class="form2">
      <p>
      <?php 
      
      // Informs user about account verification
      // if ( isset($_SESSION['message']) )
      // {
      //   echo $_SESSION['message'];
      //   unset($_SESSION['message']);
      // }

      ?>
      </p>
      <?php
            
      // Keep reminding the user this account is not active, until they activate
        // if ( !$active ){
        //   echo
        //   '<div class="info">
        //   Account is unverified, please confirm your email by clicking
        //   the link that was sent to your email address.
        //   </div>';
        // }
      ?>
        <ul class="tab-group">
            
            <li class="tab active"><a href="#drink_recipes">Drink Recipes</a></li>
            <li class="tab"><a href="#myFavorites">My Favorites</a></li>
            <!-- logout button -->
            <a href="logout.php"><button class="button1 button-block1" name="logout">Logout</button></a><li>

        </ul>
     
      <div class="tab-content">

        <!-- For Drink Recipe tab -->
        <div id="drink_recipes">
          <h1>Drink Recipes</h1>

          <!-- Drink name search -->
          <form action="profile.php" method="post" autocomplete="off">
            <input type="text" name="name_value" placeholder="Enter Drink Name"><br></br>
            <input type="submit" name="name_search" value="Search Drink Name"><br></br>
          </form>

          <!-- Ingredient name search -->
          <form action="profile.php" method="post" autocomplete="off">
            <input type="text" name="ingredient_value" placeholder="Enter Ingredient Name"><br></br>
            <input type="submit" name="ingredient_search" value="Search Ingredient Name"><br></br>
          </form>

            <script>
              $(document).ready( function () {
                $('#drinks').DataTable(
                {
                  "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 2 ] } // So Ingredients is not sortable
                  ],
                  searching: false
                  
                }
                )});
            </script>
            

            <table id="drinks" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Select</th>
                  <th>Drink Name</th>
                  <th>Ingredients</th>
                </tr>
              </thead>
              <tbody>  
                <?php
                  $result = $mysqli->query($sql);

                  if($result->num_rows == 0)
                  {
                    $_SESSION['message'] = "There are no drinks in the table.";
                    header("location: profile_error.php");
                  }
                  if($result-> num_rows > 0)
                  {
                    while($row = $result-> fetch_assoc())
                    {
                      $value_to_add = $row["drink_name"];
                      echo "<tr>";
                      echo "<td><form action='profile.php' method='post' autocomplete='off'>";
                      echo "<input type='hidden' name='custID' value='$value_to_add'>";
                      echo "<input type='submit' name='addtofavorites' value='Add to Favorites'>
                      </form>
                      </td>";
                      echo "<td>".$row["drink_name"]. "</td><td>" .$row["base_alcohol1"]."<br>".$row["base_alcohol2"]."<br>".$row["base_alcohol3"]."<br>".$row["base_alcohol4"]."<br>"
                        .$row["base_mixer1"]."<br>".$row["base_mixer2"]."<br>".$row["base_mixer3"]."<br>".$row["base_mixer4"]."<br>".$row["base_mixer5"]."<br>".$row["garnish1"]."<br>".$row["garnish2"]."<br>".$row["garnish3"]."</td></tr>";
                    }
                    echo "</table>";
                  }
                ?>
              </tbody>
            </table>
        </div>
        
        <!-- For My Favorites tab -->
        <div id="myFavorites">

          <!-- script to convert to datatable -->
          <script>
              $(document).ready( function () {
                $('#favorite_drinks').DataTable(
                {
                  "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ -1,2 ] } // So Ingredients is not sortable
                  ],

                  "oLanguage": {
                    "sSearch": "Search Drinks"
                    }
                  
                }
                )});
            </script>
          <table id="favorite_drinks" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Remove</th>
                <th>Drink Name</th>
                <th>Ingredients</th>
              </tr>
            </thead>

            <tbody>
              <?php
                  $sql = "SELECT * FROM user_favorites WHERE '$email' = email";
                  $result = $mysqli->query($sql);

                  if($result-> num_rows > 0)
                  {
                    while($row = $result-> fetch_assoc())
                    {
                      $value_to_add = $row["drink_name"];

                      echo "<tr>";
                      echo "<td><form action='profile.php' method='post' autocomplete='off'>";
                      echo "<input type='hidden' name='custID2' value='$value_to_add'>";
                      echo "<input type='submit' name='remove' value='Remove from Favorites'>
                      </form>
                      </td>";
                      echo "<td>" .$row["drink_name"]. "</td><td>" .$row["base_alcohol1"]."<br>".$row["base_alcohol2"]."<br>".$row["base_alcohol3"]."<br>".$row["base_alcohol4"]."<br>"
                        .$row["base_mixer1"]."<br>".$row["base_mixer2"]."<br>".$row["base_mixer3"]."<br>".$row["base_mixer4"]."<br>".$row["base_mixer5"]."<br>".$row["garnish1"]."<br>".$row["garnish2"]."<br>".$row["garnish3"]."</td></tr>";
                    }
                    echo "</table>";
                  }
              ?>
            </tbody>
          </table>
        </div> 
      </div>
    </div>

    <script src="js/index.js"></script>

  </body>
</html>
