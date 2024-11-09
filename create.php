<?php
spl_autoload_register(function($class){
    include $class .'.php';
});

if (isset($_POST['submit'])) {
    // Initialize an array to store errors and valid data
    $errors = [];
    $data = [];

    // Form values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = trim($first_name . " " . $last_name);
    $email = $_POST['email'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $gender = $_POST['gender'];
    $skills = isset($_POST['skill']) ? $_POST['skill'] : [];
    $thana_name = $_POST['thana'];
    $zilla_name = $_POST['zilla'];


    if (empty($first_name) || !preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $errors['first_name'] = "Please enter a valid first name.";
    } else {
        $data['first_name'] = $first_name;
    }

    if (!empty($last_name) && !preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $errors['last_name'] = "Please enter a valid last name.";
    } else {
        $data['last_name'] = $last_name;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    } else {
        $data['email'] = $email;
    }

    if (empty($father_name) || !preg_match("/^[a-zA-Z\s]+$/", $father_name)) {
        $errors['father_name'] = "Please enter a valid father name.";
    } else {
        $data['father_name'] = $father_name;
    }

    if (empty($mother_name) || !preg_match("/^[a-zA-Z\s]+$/", $mother_name)) {
        $errors['mother_name'] = "Please enter a valid mother name.";
    } else {
        $data['mother_name'] = $mother_name;
    }

    if (empty($gender)) {
        $errors['gender'] = "Please select a gender.";
    } else {
        $data['gender'] = $gender;
    }

    if (empty($skills)) {
        $errors['skills'] = "Please select at least one skill.";
    } else {
        $data['skills'] = $skills;
    }

    if (empty($thana_name) || $thana_name == '--') {
	    $errors['thana'] = "Please select a valid Thana.";
	} else {
	    $data['thana'] = $thana_name;
	}

	if (empty($zilla_name) || $zilla_name == '--') {
	    $errors['zilla'] = "Please select a valid Zilla.";
	} else {
	    $data['zilla'] = $zilla_name;
	}


    $target_file = basename($_FILES['image']['name']);
    $target_dir = "uploads/" . $target_file;

    // If no errors, proceed with insertion
    if (empty($errors)) {
        // Process file upload (if necessary)
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)) 
        {
            // Insert data into database or other operations
            $person = new Person();
            $person->push($full_name, $email, $father_name, $mother_name, $gender, implode(', ', $skills), $thana_name, $zilla_name, $target_file);
            if ($person->insert()) {
                echo "<script>
                    alert('Inserted successfully');
                    window.location.href = 'show.php';
                </script>";
                exit();
            }
        } 
        else
        {
        	$target_file = 'default.jpg';
        	$person = new Person();
            $person->push($full_name, $email, $father_name, $mother_name, $gender, implode(', ', $skills), $thana_name, $zilla_name, $target_file);
            if ($person->insert()) {
                echo "<script>
                    alert('Inserted successfully');
                    window.location.href = 'show.php';
                </script>";
                exit();
            }
        }
    }

    // Redirect back with errors and data if validation fails
    if (!empty($errors)) {
        $error_string = urlencode(json_encode($errors));
        $data_string = urlencode(json_encode($data)); // Encode data for previous values
        header("Location: index.php?errors=$error_string&data=$data_string");
        exit();
    }
}
?>
