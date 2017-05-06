<?

	$css_paths = [
		"/" => "home.css",
		"/music" => "music.css",
		"/contact" => "contact.css"
	];
	$titles = [
		"/" => "Nelation",
		"/music" => "Music",
		"/contact" => "Contact"
	];

	// GET THINGS
	function get_slug() {
		$slug = $_SERVER["REQUEST_URI"];
		$slug = explode("?", $slug, 2);
		$slug = $slug[0];
		$slug = strtolower($slug);
		if (preg_match("[/$]", $slug) && $slug != "/") {
			$slug = rtrim($slug, "/");
		}
		return $slug;
	}

	function get_css($slug, $type = "normal") {
		global $css_paths;
		$css = "";
		// Find out if slug is one from $css_paths
		foreach ($css_paths as $possible_slug => $css_path) {
			if ($possible_slug == $slug) {
				$css = "/css/$css_path?r=" . rand(0,999);
				if ($type == "normal") {
					$css = '<link class="page-css" rel="stylesheet" type="text/css" href="'.$css.'"/>';
				}
			}
		}
		return $css;
	}

	function get_title($slug, $type = "normal") {
		global $titles;
		$title = "";
		// Find out if slug is one from $titles
		foreach ($titles as $possible_slug => $current_title) {
			if ($possible_slug == "/") {
				$title = $current_title;
			} elseif ($possible_slug == $slug) {
				$title = $current_title." - Nelation";
			}
		}
		return $title;
	}

// DATABASE

	function db_connect() {
		global $db_connection;
		$host = "localhost";
		$username = "web";
		$password = "BdW2XyeWaSVmFNcn";
		$db_name = "nelation";
		$db_connection = mysqli_connect($host, $username, $password, $db_name);
	}
	function db_disconnect() {
		// 5. Disconnect from db
		global $db_connection;
		mysqli_close($db_connection);
	}
	function db_query($query) {
		global $db_connection;
		$query = mysqli_real_escape_string($db_connection, $query);
		$result = mysqli_query($db_connection, $query);
		if (!$result) {
			echo "Bad, bad, bad error that we don't like: ".mysqli_error($db_connection);
			die();
		}
		return $result;
	}

	// MISC

	function urlify($string) {
		$string = strtolower($string);
		$string = str_replace([" "], "-", $string);
		$string = preg_replace("/[^\w+-]/", "", $string);
		$string = preg_replace("[-+]", "-", $string);
		return $string;
	}

?>
