<?php
/**
 * Handle variables and methods related to the Movies
 */

class Movies {
    /**
     * Build the url for search the movies/series that the user wants to search
     * @param string $title Title written by the user
     * @param string $year Year that could be written or not by the user
     */
    function constructUrl($title, $year=''){
        #basic url of the API given, and with the 's' parameter, so we can search the titles of the desired movies
        $url = 'https://www.omdbapi.com/?s=';
        #basic url is concatenating with the title that was given us by the user
        $url = $url.$title;
        /*if the user gives us the year of the movie which he is looking for, we will concatenate
        the parameter '&y=' and the year that the user had given us and the API key will be contatenated*/
        if(!empty($year)) { 
            $url = $url.'&y='.$year.'&apiKey=fc59da33';
        } else {
            #otherwise we will use the previously url but with the rest of it's API key that was left to add on
            $url = $url.'&apiKey=fc59da33';
        }
        #returning the final url desired for the user
        return $url; 
    }
    /**
     * Get the info from the API to handle the gottens movie's information
     * @param string $url of the API from which it'll contain all the info of the movies related to it's title
     */
    function curlForApi($url) {
        $ch = curl_init($url);
        #the next 2 first curl_setopt lines were needed due to an error of SSL certificate with the curl metod
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        #next curl_setops were necessary to get the JSON from the APPI
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);        

        #convert the JSON into an associative array
        $Json = json_decode($data, true);
        #route necessary to have the access to the movies content in the JSON
        $Json = $Json['Search']; 

        return $Json;
    }

    /**
     * Organice the movies per ascendent or descendent form
     * @param array $array array of the movies
     * @param string $order order 
     */
    function orderMovies($array, $order) {
        switch($order) {
            #case1 is for organizing the movies by ascendent form
            case 1:
                if(isset($_POST['sortTitle'])){
                    usort($array, function($a, $b) { return strcmp($a['Title'], $b['Title']); });
                }else if(isset($_POST['sortYear'])){
                    usort($array, function($a, $b) { return $a['Year'] - $b['Year']; });
                }
                break;
            #case2 is for organizing the movies by descendent form
            case 2:     
                if(isset($_POST['sortTitle'])){
                    usort($array, function($a, $b) { return strcmp($a['Title'], $b['Title']); });
                    $array = array_reverse($array);
                }else if(isset($_POST['sortYear'])){
                    usort($array, function($a, $b) { return $a['Year'] - $b['Year']; });
                    $array = array_reverse($array);
                }
                break;
        }
        #the array is organized
        return $array; 
    }

    #this function is to store the API in the created movieList.txt
    function storeApi($name){
        #build the url for search the movies/series desired
        $url = $this->constructUrl($name);
        #getting the Json from the API
        $data = $this->curlForApi($url);
        #opening the file movieList.txt, and if it doesn't exist yet, it will be created by itself
        $storage = fopen("movieList.txt", "w");
        #writing the movieList.txt in JSON format; the info of the url that was gotten previously
        fwrite($storage, json_encode($data));
        #this message will be shown to the user, so they know that the download of the .txt is ready
        $success = ">> The file 'moviesList' was created with your recent research! please go check it out by yourself ;) <<";
        return $success;
    }

}

?>