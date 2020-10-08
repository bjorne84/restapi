<?php
abstract class PostModel extends Dbc {
    
    protected function setRecipe(&$arr) {
      
        /* */
        $User_ID = $arr['User_ID'];
        $title = $arr['headLine'];
        $short_description = $arr['short_description'];
        $step_by_step = $arr['step_by_step'];
        $port = $arr['port'];
        $imgPath = $arr['image_Name'];



        /* SQL-function now() have to be added direct in values and can not be binded with prepared statements*/
        $sql = "INSERT INTO recipes (User_ID, Title, Short_description, Step_by_step, create_date, Portions, imgPath) VALUES(?, ?, ?, ?, now(), ?, ?)";
        /* connecting to database with parent-class and prepare the sql-quary*/ 
        $stmt = $this->connect()->prepare($sql);
        /* exexute the sql query*/
        $stmt->execute([$User_ID, $title, $short_description, $step_by_step, $port, $imgPath]);
        return true;
    }

    /* Updates the recipe-post, sets the last_mod_date */
    protected function setUpdateRecipe(&$arr, $recipeToUpdate) {
    
        //$User_ID = $arr['User_ID'];
        $title = $arr['headLine'];
        $short_description = $arr['short_description'];
        $step_by_step = $arr['step_by_step'];
        $port = $arr['port'];
        $imgPath = $arr['image_Name'];
        /* SQL-function now() have to be added direct in values and can not be binded with prepared statements*/
        $sql = "UPDATE recipes
        SET Title = '?' , Short_description = '?', Step_by_step = '?', last_mod_date = now(), Portions = '?', imgPath = '?'
    WHERE Recipe_ID = $recipeToUpdate";
       // $this->connect()->query($sql);
        /* connecting to database with parent-class and prepare the sql-quary*/
        $stmt = $this->connect()->prepare($sql);
        /* exexute the sql query*/
        $stmt->execute([$title, $short_description, $step_by_step, $port, $imgPath]);
        $stmt = $this->connect()->prepare($sql);
        return true;
    }

    protected function updateSql(&$data) {

        $title = $data['Title'];
        $short_description = $data['Short_desc'];
        $step_by_step = $data['Step_by_step'];
        $recipe = $data['recipe_ID'];
        $port = $data['port'];

        /* SQL-function now() have to be added direct in values and can not be binded with prepared statements*/
        $sql = "UPDATE recipes
        SET Title = '$title', Short_description = '$short_description', Step_by_step = '$step_by_step', last_mod_date = now(), Portions = $port
    WHERE Recipe_ID = $recipe";
        $this->connect()->query($sql);
       // $this->connect()->query($sql);
        /* connecting to database with parent-class and prepare the sql-quary*/
       //$stmt = $this->connect()->prepare($sql);
        /* exexute the sql query*/
        //$stmt->execute([$title, $short_description, $step_by_step, $port]);
        //$stmt = $this->connect()->prepare($sql);


        /* 
          $sql = "UPDATE recipes
        SET Title= ?, Short_description = ?, Step_by_step= ?, last_mod_date = now(), Portions = ?
    WHERE Recipe_ID = $recipe";
        */
        return true;

        
    }



    /* Gets all recipes and its data from a specific user, return array*/
    protected function getRecipesFromUser($User_ID) {
        $sql = "SELECT recipes.Recipe_ID, recipes.Title, recipes.Short_description, recipes.Step_by_step, 
        recipes.create_date, recipes.last_mod_date, recipes.Portions, recipes.imgPath, users.Username
        FROM recipes 
        JOIN users
            ON recipes.User_ID = users.User_ID
        WHERE recipes.User_ID  = $User_ID;";

        $stmt = $this->connect()->query($sql);
        /* fetch all is already set to associative array*/
        $result = $stmt->fetchAll();
        return $result;
      
    }
    /* Get recipies by recipes id*/
    protected function getRecipeByIdDB($recipeID) {
        $sql = "SELECT recipes.Recipe_ID, recipes.Title, recipes.Short_description, recipes.Step_by_step, 
        recipes.create_date, recipes.last_mod_date, recipes.Portions, recipes.imgPath, users.Username, users.User_ID 
            FROM recipes 
            JOIN users 
                ON recipes.User_ID = users.User_ID 
            WHERE recipes.Recipe_ID = ?";
          $stmt = $this->connect()->prepare($sql);
          $stmt->execute([$recipeID]);
          /* Just on recipe = fetch and not fetch all*/
          $result = $stmt->fetch();
          return $result;
    }

    /* Delete recipies */
    protected function deletePostSql($recipe) {
        $sql = "DELETE FROM recipes WHERE recipes.Recipe_ID = $recipe";
        $this->connect()->query($sql);
        return true;

    }

    protected function getAllPostsDB() {
        $sql = "SELECT recipes.Recipe_ID, recipes.Title, recipes.Short_description, recipes.Step_by_step, 
        recipes.create_date, recipes.last_mod_date, recipes.Portions, recipes.imgPath, users.Username
        FROM recipes 
        JOIN users
            ON recipes.User_ID = users.User_ID
        ORDER BY recipes.create_date DESC";
        $stmt = $this->connect()->query($sql);
        /* fetch all is already set to associative array*/
        $result = $stmt->fetchAll();
        return $result;
    }

    /* Gets all post but max five from each user*/
    protected function maxFive() {
        $sql = "SELECT r.Recipe_ID, r.Title, r.Short_description, r.Step_by_step, r.create_date, 
        r.last_mod_date, r.Portions, r.imgPath, users.Username 
        FROM ( SELECT r.*, ROW_NUMBER() OVER(PARTITION BY User_ID ORDER BY create_date DESC) rn 
        FROM recipes r ) r 
        INNER JOIN users ON r.User_ID = users.User_ID 
        WHERE r.rn <= 5 ORDER BY r.create_date DESC"; 
        $stmt = $this->connect()->query($sql);
        /* fetch all is already set to associative array*/
        $result = $stmt->fetchAll();
        return $result;
    }

    protected function getAllUsersDB() {
        $sql ="SELECT Username, User_ID FROM users ORDER BY User_ID DESC";
        $stmt = $this->connect()->query($sql);
          /* fetch all is already set to associative array*/
          $result = $stmt->fetchAll();
          return $result;

    }

    protected function getUserById($id) {
        $sql = "SELECT Username FROM users WHERE user_id = $id";
        $stmt = $this->connect()->query($sql);
        /* fetch all is already set to associative array*/
        $result = $stmt->fetch();
        return $result;

    }

    


    
}