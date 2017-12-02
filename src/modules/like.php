<?php

	// Load user session
	session_start();

	// Load application files
	require_once "../autoload.php";

	if (isset($_GET['id'])) {
		// Gets the publication id
    $id = (int) $_GET['id'];

		// Gets the database connection
		$conn = getConnection();

		try {
			// Increments the 'likes' in the publication
			$stmt = $conn->prepare("UPDATE QUOTES SET LIKES=LIKES+1 WHERE ID_QUOTE=:id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			// Adds the publication id into the voted publications
			array_push($_SESSION["voted"], $id);

			// Redirect to homepage
			header('location: ../../public/index.php?page=home.php');
		} catch (PDOException $e) {
			header('location: ../../public/index.php?page=home.php&error=' . $e->getMessage());
    } finally {
			// Destroy the database connection
      $conn = null;
    }
	}

?>
