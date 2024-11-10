<?php
session_start();
spl_autoload_register(function($class){
    include $class . '.php';
});

// Retrieve errors and form data from the session if available
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

// Clear session data after use
unset($_SESSION['errors'], $_SESSION['form_data']);

if (isset($_SESSION['edit_id'])) {
    $id = $_SESSION['edit_id'];
    unset($_SESSION['edit_id']); // Clear the session variable after using it

    $person = new Person();
    $result = $person->editData($id);
} else {
    echo "No ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f6f9;
            color: #333;
        }

        .form-container {
            background: #ffffff;
            padding: 30px;
            max-width: 500px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            background-color: #f9fafb;
            font-size: 14px;
        }

        .options-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .option-item {
            display: flex;
            align-items: center;
        }

        .option-item input {
            margin-right: 8px;
        }

        .image-preview img {
            margin-top: 10px;
            height: 50px;
            border-radius: 4px;
            border: 1px solid #d1d5db;
        }

        .submit-btn {
            background-color: #4a90e2;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #357ab8;
        }

        .error-message {
            color: red;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <form action="update.php" method="POST" enctype="multipart/form-data" class="form-container">

    	<?php echo '<h1>PHP CRUD OPERATION USING PDO</h1></br>'; ?>

        <input type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($id); ?>">

        <!-- Name Field -->
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="update_name" value="<?php echo htmlspecialchars($form_data['update_name'] ?? $result['name'] ?? ''); ?> " required>
            <?php if (isset($errors['update_name'])): ?>
                <p class="error-message"><?php echo $errors['update_name']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="update_email" value="<?php echo htmlspecialchars($form_data['update_email'] ?? $result['email'] ?? ''); ?>" required>
            <?php if (isset($errors['update_email'])): ?>
                <p class="error-message"><?php echo $errors['update_email']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Father's Name Field -->
        <div class="form-group">
            <label>Father's Name:</label>
            <input type="text" name="update_father_name" value="<?php echo htmlspecialchars($form_data['update_father_name'] ?? $result['father_name'] ?? ''); ?>" required>
            <?php if (isset($errors['update_father_name'])): ?>
                <p class="error-message"><?php echo $errors['update_father_name']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Mother's Name Field -->
        <div class="form-group">
            <label>Mother's Name:</label>
            <input type="text" name="update_mother_name" value="<?php echo htmlspecialchars($form_data['update_mother_name'] ?? $result['mother_name'] ?? ''); ?>" required>
            <?php if (isset($errors['update_mother_name'])): ?>
                <p class="error-message"><?php echo $errors['update_mother_name']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Gender Options -->
        <div class="form-group">
            <label>Gender:</label>
            <div class="options-group">
                <?php 
                    $genders = ['Male', 'Female', 'Others'];
                    $selectedGender = $form_data['update_gender'] ?? $result['gender'] ?? '';
                    foreach ($genders as $gender) {
                        $checked = ($selectedGender === $gender) ? 'checked' : ''; 
                        echo "<div class='option-item'><input type='radio' name='update_gender' value='$gender' $checked><label>$gender</label></div>";
                    }
                ?>
            </div>
            <?php if (isset($errors['update_gender'])): ?>
                <p class="error-message"><?php echo $errors['update_gender']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Skills Options -->
		<div class="form-group">
		    <label>Skills:</label>
		    <div class="options-group">
		        <?php 
		            $skills = ['OOP', 'Git-Github', 'Problem Solving'];
		            $userSkills = explode(', ', $form_data['update_skill'] ?? $result['skills'] ?? '');
		            foreach ($skills as $skill) {
		                $checked = in_array($skill, $userSkills) ? 'checked' : ''; 
		                echo "<div class='option-item'><input type='checkbox' name='update_skill[]' value='$skill' $checked><label>$skill</label></div>";
		            }
		        ?>
		    </div>
		    <?php if (isset($errors['update_skills'])): ?>
		        <p class="error-message"><?php echo $errors['update_skills']; ?></p>
		    <?php endif; ?>
		</div>


        <!-- Zilla Dropdown -->
        <div class="form-group">
            <label for="zilla">Zilla:</label>
            <select name="update_zilla" id="zilla">
                <?php 
                    $zillas = ['Nilphamari', 'Thakurgaon', 'Panchagar'];
                    $selectedZilla = $form_data['update_zilla'] ?? $result['zilla_name'] ?? '';
                    foreach ($zillas as $zilla) {
                        $selected = ($selectedZilla === $zilla) ? 'selected' : ''; 
                        echo "<option value='$zilla' $selected>$zilla</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Thana Dropdown -->
        <div class="form-group">
            <label for="thana">Thana:</label>
            <select name="update_thana" id="thana">
                <?php 
                    $thanas = ['Jaldhaka', 'Domar', 'Dimla'];
                    $selectedThana = $form_data['update_thana'] ?? $result['thana_name'] ?? '';
                    foreach ($thanas as $thana) {
                        $selected = ($selectedThana === $thana) ? 'selected' : ''; 
                        echo "<option value='$thana' $selected>$thana</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Image:</label>
            <div class="image-preview">
                <?php 
                    // Use the hidden image field value for preview if no new file is uploaded
                    $imagePath = $form_data['update_image'] ?? $result['image'] ?? '';
                    if (!empty($imagePath)): ?>
                    <img src="uploads/<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Image">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>

            <!-- File input for a new image upload -->
            <input type="file" name="update_image" id="image">
            <?php if (isset($errors['update_image'])): ?>
                <p class="error-message"><?php echo $errors['update_image']; ?></p>
            <?php endif; ?>

            <!-- Hidden input to store the existing image path -->
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($imagePath); ?>">
        </div>


        <!-- Submit Button -->
        <div class="form-group">
            <input type="submit" name="update" value="Update" class="submit-btn">
        </div>
    </form>
</body>
</html>
