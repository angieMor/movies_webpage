<?php
#it is included the class Movies to this file
include('ClassMovies.php');
session_start();
/*its necesary to validate if the user isn't loggedin and for some reason tries to reach the principal website,
if this is the case, it'll be return to the Login area*/
if(!isset($_SESSION['USERDATA']['USERNAME'])) {
    header("location:Login.php");
    exit;
}
#the object $movies is created with the class Movies
$movies = new Movies();
#this validates if theres info in the field Title of the website and if the user had clicked the Search button
if($_POST['Title'] && $_POST['Search']) {
    /*in this line we call the object created with a fuction named constructUrl,
    to build the link of the desired movie the user want to see */
    $link = $movies->constructUrl($_POST['Title'], $_POST['Year']); 
    /*in this line, we pass to the fuction $curlForApi the link that we've built before,
    thanks to the specific search of the user, obtaining the movies with the similar word that the user use, from the API*/
    $Api = $movies->curlForApi($link);
    /*we pass to the function $orderMovies the result of the previous API and we organize the
    movie elements thanks to the values of the div.order that have the ascendent and descendent fields*/
    $Api = $movies->orderMovies($Api, $_POST['order']); 
}
if($_POST['save'] && $_POST['Title']){ 
    $stored = $movies->storeApi($_POST['Title']);
}

#with this variable we'll be showing in the page the movies we will obtain
$moviesHTML = '';
#this is a cycle, the info gained of the API will be inserted in the varibale $movies
foreach ($Api as $movie) {
    /*we will be concatenating to the webpage the info of the API, the title, year, type and the poster with each movie
    or serie found*/
    $moviesHTML = $moviesHTML . '<h4>' . $movie["Title"] . '</h4>' .
    '<p>' . $movie["Year"] . '</p>' .
    '<p>' . $movie["Type"] . '</p>' .
    "<img src = {$movie["Poster"]} >" . '<br>' . '</br>' . '</br>';
}



?>
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link rel='stylesheet' href='FrontEnd.css' type='text/css'>

<body>
<div class='backgroundColor'>
    <h1> Cuevana ++ </h1>   
</div>
<form class="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post"> <!-- The form pass the info stored in POST to itself -->  
<div class='row'>
    <div class='col col-image'>
        <img class='image' src='Talent.png'></img>
    </div>
    <div class='col'>    
            <div class='fields'>
                <!-- This is the field in which the user have to type the desired movie/serie that wants to download the API or want to see the content of the page about the movies we have sotred in -->
                <input type= "text" class = 'input' placeholder='Title' name='Title' value="<?= $_POST['Title']?>"> 
                <!-- This is the field in which the user will indicates from what specific year is the movie he wants-->
                <input type= "text" class = 'input' placeholder='Year' name='Year' value="<?= $_POST['Year']?>">
            </div>
    </div> 
    <div class='col col-image'>
        <img class='image2' src='Movies.png'>
    </div>   
</div>
<div>
    <div class='filters'>
        <select name="order">
            <!-- These 2 values are to designate the fields of the Ascendent or Descendent order -->
            <option value="1">Asc</option>
            <option value="2">Desc</option>
        </select>
        <label><input type="checkbox" name="sortTitle">Sort by Title</label> <!-- These 2 are checkbox, so the user can click on them depending on the organization he wants for the page to show the desired results of the movie(s) picked -->
        <label><input type="checkbox" name="sortYear">Sort by Year</label>
    </div>
    <div class='notification'> <?= $stored ?></div> <!-- this message will show to the user if he had clicked on the 'Save the API' button -->
    <div class='filters'>
        
        <input type= 'submit' value="Search" name='Search'> <!-- the search button, the user will use it to search the titles and/or years of the movies --> 
        <input type="submit" name="save" value='Save the info'> <!-- This button will download the Api desired in the text file movieList.txt -->
    </div>
    <div class = 'logout'>
        <input type= "button" value= 'Log out' onclick= 'location.href="LogOut.php"'> <!-- this is the logout button, needed to close the session/account-->
    </div>

</div>
</form>
<div class='movies'>
    <?= $moviesHTML ?> <!-- thanks to this PHP variable, the cycle previously build, will be shown-->
</div>
</body>