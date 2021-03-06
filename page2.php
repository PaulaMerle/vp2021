<?php
// php loetakse ülevalt alla, seepärast kood lehel üles

$author_name = "Paula Videvik";

// kontrollin, kas POST meetod jõuab kuhugi
// var_dump($_POST);

// Kontrollin, kas vajutati submit nuppu
$todays_adjective_html = "";
$todays_adjective_error = "";
$todays_adjective = null;
if (isset($_POST["adjective_submit"])) {
    //kontrollin, kas midagi kirjutati
    if (!empty($_POST["todays_adjective_input"])) {
        $todays_adjective_html = "<p>Tänane päev on " . $_POST["todays_adjective_input"] . ".</p>";
        $todays_adjective = $_POST["todays_adjective_input"];
    } else {
        $todays_adjective_error = " Palun sisesta tänase kohta sobiv omadussõna";
    }
}

// FOTOD
$photo_html = null;
$photo_file_html = null;
$photo_list_html = null;
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
// $photo_html = '<img src="' . $photo_dir . $photo_files[$photo_num] . '" alt="ilus pilt">';


// rippmenüü submit nupu kontroll ja foto näitamine
// $selected = null;
if (isset($_POST["photo_select_submit"])) {
    if (!empty($_POST["photo_select"])) {
        $photo_num = $_POST["photo_select"];
    }
	$photo_html = '<img src="' . $photo_dir . $photo_files[$photo_num] . '" alt="valitud pilt">';
	$photo_file_html = "\n <p>".$photo_files[$photo_num] ."</p> \n";
	// tsükkel
	$photo_list_html = "<ul>";
	for ($i = 0; $i < $file_count; $i++) {
		$photo_list_html .= "<li>" . $photo_files[$i] . "</li>"; // .= lisab juurde
	}
	$photo_list_html .= "</ul>";
	}

//rippmenüü fotodest
$photo_select_html = "\n" .'<select name="photo_select">' ."\n";
	for($i = 0;$i < $file_count;$i ++){
		$photo_select_html .= '<option value="' .$i .'"';
		if($i == $photo_num){
			$photo_select_html .= " selected";
		}
        $photo_select_html .= ">" .$photo_files[$i] ."</option> \n";
	}
	$photo_select_html .= "</select> \n";


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
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<form method="POST">
		<input type="text" placeholder="omadussõna tänase kohta" name="todays_adjective_input" value="<?php echo $todays_adjective; ?>">
		<input type="submit" name="adjective_submit" value="Saada">
		<span><?php echo $todays_adjective_error; ?></span>
	</form>
	<?php echo $todays_adjective_html; ?>
	<hr>
	<form method="POST">
		<?php echo $photo_select_html; ?>
        <input type="submit" name="photo_select_submit" value="Näita valitud fotot">
	</form>
	<hr>
	<?php
		echo $photo_html;
        echo $photo_file_html;
		echo "<hr> \n";
		echo $photo_list_html;
	?>
</body>

</html>