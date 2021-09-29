<?php
// php loetakse ülevalt alla, seepärast kood lehel üles

// ühendame config faili - kataloogis tagasi liikumine ../../
require_once("../../config.php");
require_once("fnc_films.php");
// echo $server_host;
$author_name = "Paula Videvik";

$title_input = null;
$genre_input = null;
$studio_input = null;
$director_input = null;
$year_input = null;
$duration_input = null;
$film_store_notice = null;
$film_store_notice_title = null;
$film_store_notice_genre = null;
$film_store_notice_studio = null;
$film_store_notice_dir = null;
$film_store_notice_year = null;
$film_store_notice_dur = null;

// kas püütakse salvestada
if(isset($_POST["film_submit"])) {
	//kontrollin, et andmed ikka sisestati
	if(!empty($_POST["title_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"])) {
		$film_store_notice = store_film(trim(htmlspecialchars($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"])));
	} if(empty($_POST["title_input"])) {
		$film_store_notice_title = "Filmi pealkiri puudub!";
	} if(empty($_POST["genre_input"])) {
		$film_store_notice_genre = "Filmi žanr puudub!";	
	} if(empty($_POST["studio_input"])) {
		$film_store_notice_studio = "Filmi tootja puudub!";
	} if(empty($_POST["director_input"])) {
		$film_store_notice_dir = "Filmi režissöör puudub!";
	} if(empty($_POST["year_input"])) {
		$film_store_notice_year = "Filmi valmimisaasta puudub!";
	} if(empty($_POST["duration_input"])) {
		$film_store_notice_dur = "Filmi kestus puudub!";
	} else {
		$title_input = $_POST["title_input"];
		$genre_input = $_POST["genre_input"];
		$studio_input = $_POST["studio_input"];
		$director_input = $_POST["director_input"];
		$year_input = $_POST["year_input"];
		$duration_input = $_POST["duration_input"];		
		}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
    <link rel="icon" type="image/png" href="https://www.google.com/s2/favicons?domain=paula.videvik.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
    <p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
    <p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a></p>
    <hr>
    <h2>Eesti filmide lisamine</h2>
        <form method="POST">
        <label for="title_input">Filmi pealkiri</label>
        <input type="text" name="title_input" id="title_input" placeholder="filmi pealkiri" value="<?php echo $title_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_title; ?></span>
        <br>
        <label for="year_input">Valmimisaasta</label>
        <input type="number" name="year_input" id="year_input" min="1912" placeholder = "2021" value="<?php echo $year_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_year; ?></span>
        <br>
        <label for="duration_input">Kestus</label>
        <input type="number" name="duration_input" id="duration_input" min="1" value="<?php echo $duration_input; ?>" max="600" placeholder="60">
		<span style="color:red;"><?php echo $film_store_notice_dur; ?></span>
        <br>
        <label for="genre_input">Filmi žanr</label>
        <input type="text" name="genre_input" id="genre_input" placeholder="žanr" value="<?php echo $genre_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_genre; ?></span>
        <br>
        <label for="studio_input">Filmi tootja</label>
        <input type="text" name="studio_input" id="studio_input" placeholder="filmi tootja" value="<?php echo $studio_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_studio; ?></span>
        <br>
        <label for="director_input">Filmi režissöör</label>
        <input type="text" name="director_input" id="director_input" placeholder="filmi režissöör" value="<?php echo $director_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_dir; ?></span>
        <br>
        <input type="submit" name="film_submit" value="Salvesta">
    </form>

</body>

</html>