<?php

$database = "if21_paula";

function sign_up($firstname, $surname, $email, $gender, $birth_date, $password) {
	$notice = null;
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("INSERT INTO vprg_users (firstname, lastname, birthdate, gender, email, password) values (?,?,?,?,?,?)");
	echo $conn->error; // ilmub veebilehe ülaserva, ei ole mõeldud kasutajale vaid arendajale
	// krüpteerime parooli
	$option = ["cost"=>12];
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
	// andmete sidumine, PS! Oluline on järjekord!
	$stmt->bind_param("sssiss", $firstname, $surname, $birth_date, $gender, $email, $pwd_hash);
	// saadan minema
	if($stmt->execute()) {
		$notice = " UUS KASUTAJA EDUKALT LOODUD!";
	} else {
		$notice = " Uue kasutaja loomisel tekkis viga: " .$stmt->error;
	}
	// sulgen ühendused
	$stmt->close();
	$conn->close();
	return $notice;
}