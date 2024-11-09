<?php
session_start();
spl_autoload_register(function($class) {
    include $class . '.php';
});

$id = $_POST['hidden_id'] ?? $_SESSION['edit_id'] ?? null;

if (isset($_POST['update'])) {
    $errors = [];
    $data = [];

    // Collect input data
    $update_name = $_POST['update_name'] ?? '';
    $update_email = $_POST['update_email'] ?? '';
    $update_father_name = $_POST['update_father_name'] ?? '';
    $update_mother_name = $_POST['update_mother_name'] ?? '';
    $update_gender = $_POST['update_gender'] ?? '';
    $update_skills = isset($_POST['update_skill']) ? implode(', ', $_POST['update_skill']) : '';
    $update_thana = $_POST['update_thana'] ?? '';
    $update_zilla = $_POST['update_zilla'] ?? '';

    // Validation for required fields
    if (empty($update_name) || !preg_match("/^[a-zA-Z]+$/", $update_name)) {
        $errors['update_name'] = "Please enter a valid name.";
    } else {
        $data['update_name'] = $update_name;
    }

    if (empty($update_email) || !filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
        $errors['update_email'] = "Please enter a valid email address.";
    } else {
        $data['update_email'] = $update_email;
    }

    if (empty($update_father_name) || !preg_match("/^[a-zA-Z\s]+$/", $update_father_name)) {
        $errors['update_father_name'] = "Please enter a valid father name.";
    } else {
        $data['update_father_name'] = $update_father_name;
    }

    if (empty($update_mother_name) || !preg_match("/^[a-zA-Z\s]+$/", $update_mother_name)) {
        $errors['update_mother_name'] = "Please enter a valid mother name.";
    } else {
        $data['update_mother_name'] = $update_mother_name;
    }

    if (empty($update_gender)) {
        $errors['update_gender'] = "Please select a gender.";
    } else {
        $data['update_gender'] = $update_gender;
    }

    if (empty($update_skills)) {
	    $errors['update_skills'] = "In previous you haven't selected any skills.";
	} else {
	    $data['update_skills'] = $update_skills;
	}

    // If there are no validation errors, process the update
    if (empty($errors) && $id !== null) {
        $target_file = '';
        if (!empty($_FILES['update_image']['name'])) {
            $target_file = basename($_FILES['update_image']['name']);
            $target_dir = "uploads/" . $target_file;

            if (!move_uploaded_file($_FILES['update_image']['tmp_name'], $target_dir)) {
                $errors['update_image'] = "Image upload failed.";
            }
        }

        if (empty($errors)) {
            $person = new Person();
            $person->push($update_name, $update_email, $update_father_name, $update_mother_name, $update_gender, $update_skills, $update_thana, $update_zilla, $target_file);

            // Clear session data on successful update
            if ($person->update($id)) {
                unset($_SESSION['errors'], $_SESSION['form_data'], $_SESSION['edit_id']);
                echo "<script>alert('Data updated successfully'); window.location.href = 'show.php';</script>";
                exit();
            } else {
                $errors['update'] = "Failed to update data. Please try again.";
            }
        }
    }

    // If there are errors, store them in the session
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $data;
        $_SESSION['edit_id'] = $id;
        header("Location: edit.php");
        exit();
    }
}
