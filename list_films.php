<?php
// php loetakse ülevalt alla, seepärast kood lehel üles

// ühendame config faili - kataloogis tagasi liikumine ../../
require_once("../../config.php");
require_once("fnc_films.php");
// echo $server_host;
$author_name = "Paula Videvik";
$film_html = null;
$film_html = read_all_films();
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
    <h2>Eesti filmid</h2>
    <?php echo $film_html ?>


</body>

</html>