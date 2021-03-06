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
			// Deletes the publication in the database
			$stmt = $conn->prepare("DELETE FROM LIKES WHERE ID_QUOTE = :id");
			$stmt->bindParam(":id", $id);
			$result = $stmt->execute();

			if ($result) {
				$stmt = $conn->prepare("DELETE FROM QUOTES WHERE ID_QUOTE = :id");
				$stmt->bindParam(":id", $id);
				$result = $stmt->execute();
			}

			if ($result === false) {
				$_SESSION["message"] = "Your post cannot be deleted at this time. Please try again later.";
			}

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} catch (PDOException $e) {
			$_SESSION["message"] = "<strong>DataBase Error</strong>: The post could not be deleted.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: The post could not be deleted.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} finally {
			// Destroy the database connection
			$conn = null;
		}
	}

?>
