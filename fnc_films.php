<?php
// php loetakse ülevalt alla, seepärast kood lehel üles

// ühendame config faili - kataloogis tagasi liikumine ../../
require_once("../../config.php");
// echo $server_host;
$author_name = "Paula Videvik";

// kuna andmebaase võib olla mitu, siis parem nimetada siin, aga võib ka config faili
$database = "if21_inga_pe_T1";

function read_all_films() {
// kasutatavad muutujad teen globaalseks, et saaks skoobist väljas kasutada
// loon andmebaasiühenduse: server, kasutaja, parool, andmebaas
$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
// määrame korrektse kooditabeli
$conn->set_charset("utf8");
// valmistan ette sql käsu
// SELECT * FROM film
$stmt = $conn->prepare("SELECT * FROM film");
echo $conn->error;
// seome tulemused muutujaga
$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
// anname käsu täitmiseks
$film_html = null;
$stmt->execute();
// võtan andmed
while ($stmt->fetch()) {
    // paneme andmed meile sobivasse vormi
    $film_html .= "<h3>" . $title_from_db . "</h3> <ul>";
    $film_html .= "<li>Valmimisaasta: " . $year_from_db . "</li>";
    $film_html .= "<li>Kestus: " . $duration_from_db . "</li>";
    $film_html .= "<li>Žanr: " . $genre_from_db . "</li>";
    $film_html .= "<li>Tootja: " . $studio_from_db . "</li>";
    $film_html .= "<li>Lavastaja: " . $director_from_db . "</li> </ul>";
}
// sulgeme käsu
$stmt->close();
// sulgeme andmebaasi ühenduse
$conn->close();
return $film_html;
}

function store_film($title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input) {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
	// loon andmebaasiühenduse: server, kasutaja, parool, andmebaas
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	// määrame korrektse kooditabeli
	$conn->set_charset("utf8");
	
	$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	echo $conn->error;
	// seome sql käsu päris andmetega
	// andmetüübid (bind_param): i - integer, d - decimal, s - string
	$stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input);
	$success = "";
	
	if($stmt->execute()) {
		$success = "Salvestamine õnnestus";
	} else {
		$success = "Salvestamisel tekkis viga: " .$stmt->error;
	}
	// sulgeme käsu
	$stmt->close();
	// sulgeme andmebaasi ühenduse
	$conn->close();
	return $success;
	} else {
		exit("Invalid Request");
	}
}

?>