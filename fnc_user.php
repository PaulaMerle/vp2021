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


function sign_in($email, $password) {
	$notice = null;
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("SELECT password FROM vprg_users WHERE email = ?");
	echo $conn->error; // ilmub veebilehe ülaserva, ei ole mõeldud kasutajale vaid arendajale
	$stmt->bind_param("s", $email);
	$stmt->bind_result($password_from_db);
	$stmt->execute();
	if($stmt->fetch()) {
		//kasutaja on olemas, parool tuli...
		if(password_verify($password, $password_from_db)) {
			// parool õige, oleme sees!
			$stmt->close();
			$conn->close();
			header("Location: home.php");
			exit();
		} else {
			$notice = " Kasutajatunnus või salasõna oli vale";
		}
	} else {
		$notice = " Kasutajatunnus või salasõna oli vale";
	}
	
	// sulgen ühendused
	$stmt->close();
	$conn->close();
	return $notice;
}
?>