<?php
// php loetakse ülevalt alla, seepärast kood lehel üles
//alustame sessiooni
 //   session_start();
    require_once("../../config.php");
    require_once("fnc_user.php");
$author_name = "Paula Videvik";

// AEG
$full_time_now = date("d.m.Y H:i:s");
$weekday_now = date("N"); // tõmbab sisse nädalapäeva numbri
$day_category = "lihtsalt päev";
$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$hour_now = date("H");
$hour_category;

if ($weekday_now <= 5 && $hour_now >= 8 && $hour_now <= 18) {
    $day_category = "tööpäev, tundide aeg";
} elseif ($weekday_now <= 5 && $hour_now < 8 && $hour_now >= 23) {
    $day_category = "tööpäev, uneaeg";
} elseif ($weekday_now <= 5 && $hour_now > 18 && $hour_now < 23) {
    $day_category = "tööpäev, vaba aeg";
} elseif ($weekday_now > 5 && $hour_now >= 8 && $hour_now <= 18) {
    $day_category = "puhkepäev, uneaeg";
} else {
    $day_category = "puhkepäev, vaba aeg";
}

// FOTOD

// juhusliku foto lisamine
$photo_dir = "../photos/";
// loen kataloogi sisu
$all_files = scandir($photo_dir);
// massiivi kaks esimest elementi (. ja ..) on käsud kataloogis liikumiseks, need tuleb välja jätta
$all_real_files = array_slice($all_files, 2);
// var_dump loeb nimekirja
// var_dump($all_real_files);

// sõelume välja päris pildid
$photo_files = [];
$allowed_photo_types = ["image/jpeg", "image/png"];

foreach ($all_real_files as $file_name) {
    $file_info = getimagesize($photo_dir . $file_name);
    // isset - kas sai väärtuse?
    if (isset($file_info["mime"])) {
        if (in_array($file_info["mime"], $allowed_photo_types)) {
            array_push($photo_files, $file_name);
        }
    }
}
// loen massiivi elemendid kokku
$file_count = count($photo_files);
// loosin juhusliku arvu (min 0 ja max $file_count - 1)
$photo_num = mt_rand(0, $file_count - 1);
$photo_html = '<img src="' . $photo_dir . $photo_files[$photo_num] . '" alt="ilus pilt">';

// if($hour now < 7 or $hour now > 23)
	
// SISSELOGIMINE
if(isset($_POST["login_submit"])){
	sign_in($_POST["email_input"], $_POST["password_input"]);
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
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="email" name="email_input" placeholder="email ehk kasutajatunnus">
        <input type="password" name="password_input" placeholder="salasõna">
        <input type="submit" name="login_submit" value="Logi sisse">
    </form>
	
	<p>Loo endale <a href="add_user.php">kasutajakonto</a></p>
	<hr>
	
    <p>Lehe avamise hetk:
        <?php echo $weekday_names_et[$weekday_now - 1] . " " . $full_time_now . ", " . $day_category; ?> </p>
    <?php echo $photo_html; ?>
</body>

</html>