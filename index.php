<?php
	spl_autoload_register(function($class){
		include $class .'.php';
	});

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create New Entry</title>
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

		/* Form Container */
		.form-container {
			background: #ffffff;
			padding: 30px;
			width: 100%;
			max-width: 500px;
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
			color: #333;
		}

		.form-group input[type="text"]:focus,
		.form-group select:focus {
			border-color: #4a90e2;
			background-color: #fff;
			outline: none;
		}

		/* Radio and Checkbox styling */
		.options-group {
			display: flex;
			gap: 10px;
			flex-wrap: wrap;
		}

		.option-item {
			display: flex;
			align-items: center;
		}

		.option-item input[type="radio"],
		.option-item input[type="checkbox"] {
			margin-right: 8px;
		}

		/* Submit Button Styling */
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
	</style>
</head>
<body>

	<?php
    $errors = isset($_GET['errors']) ? json_decode($_GET['errors'], true) : [];
    $data = isset($_GET['data']) ? json_decode($_GET['data'], true) : [];
?>

<form action="create.php" method="POST" enctype="multipart/form-data" class="form-container">
    <!-- First Name -->
    
		<?php echo '<h1>PHP CRUD OPERATION USING PDO</h1></br>'; ?>

    <div class="form-group">
        <label for="first_name">*First Name: </label>
        <input type="text" name="first_name" id="first_name" value="<?php echo isset($data['first_name']) ? htmlspecialchars($data['first_name']) : ''; ?>" required>
        <?php if (isset($errors['first_name'])): ?>
            <p style="color: red;"><?php echo $errors['first_name']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Last Name -->
    <div class="form-group">
        <label for="last_name">Last Name (optional):</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo isset($data['last_name']) ? htmlspecialchars($data['last_name']) : ''; ?>">
        <?php if (isset($errors['last_name'])): ?>
            <p style="color: red;"><?php echo $errors['last_name']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Email or Phone -->
    <div class="form-group">
        <label for="contact">*Email or Phone:</label>
        <input type="text" name="email" id="contact" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>" required>
        <?php if (isset($errors['email'])): ?>
            <p style="color: red;"><?php echo $errors['email']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Father Name -->
    <div class="form-group">
        <label for="father_name">*Father Name:</label>
        <input type="text" name="father_name" id="father_name" value="<?php echo isset($data['father_name']) ? htmlspecialchars($data['father_name']) : ''; ?>" required>
        <?php if (isset($errors['father_name'])): ?>
            <p style="color: red;"><?php echo $errors['father_name']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Mother Name -->
    <div class="form-group">
        <label for="mother_name">*Mother Name:</label>
        <input type="text" name="mother_name" id="mother_name" value="<?php echo isset($data['mother_name']) ? htmlspecialchars($data['mother_name']) : ''; ?>" required>
        <?php if (isset($errors['mother_name'])): ?>
            <p style="color: red;"><?php echo $errors['mother_name']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Gender Options -->
    <div class="form-group">
        <label>*Gender:</label>
        <div class="options-group">
            <?php 
                $genders = ['Male', 'Female', 'Others'];
                foreach ($genders as $key => $gender) {
                    $id = 'gender_' . ($key + 1);
                    echo '<div class="option-item">';
                    echo '<input type="radio" name="gender" id="' . $id . '" value="' . htmlspecialchars($gender) . '" ' . 
                         ((isset($data['gender']) && $data['gender'] == $gender) ? 'checked' : '') . '>';
                    echo '<label for="' . $id . '">' . htmlspecialchars($gender) . '</label>';
                    echo '</div>';
                }
            ?>

            <?php if (isset($errors['gender'])): ?>
                <p style="color: red;"><?php echo $errors['gender']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Skills Options -->
    <div class="form-group">
        <label>*Skills:</label>
        <div class="options-group">
            <?php 
                $skills = ['OOP', 'Git-Github', 'Problem Solving'];
                foreach ($skills as $key => $skill) {
                    $id = 'skill_' . ($key + 1);
                    echo '<div class="option-item">';
                    echo '<input type="checkbox" name="skill[]" id="' . $id . '" value="' . htmlspecialchars($skill) . '" ' . 
                         (isset($data['skills']) && in_array($skill, $data['skills']) ? 'checked' : '') . '>';
                    echo '<label for="' . $id . '">' . htmlspecialchars($skill) . '</label>';
                    echo '</div>';
                }
            ?>

            <?php if (isset($errors['skills'])): ?>
                <p style="color: red;"><?php echo $errors['skills']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Zilla Dropdown -->
    <div class="form-group">
	    <label for="zilla">*Zilla:</label>
	    <select name="zilla" id="zilla">
	        <option value="--">--</option> <!-- Default value shown as -- -->
	        <?php 
	            $zillas = ['nilphamari', 'thakurgaon', 'panchagar'];
	            foreach ($zillas as $zilla) {
	                echo '<option value="' . htmlspecialchars($zilla) . '" ' . 
	                     (isset($data['zilla']) && $data['zilla'] == $zilla ? 'selected' : '') . '>' . 
	                     htmlspecialchars($zilla) . '</option>';
	            }
	        ?>
	    </select>
	    <?php if (isset($errors['zilla'])): ?>
	        <p style="color: red;"><?php echo $errors['zilla']; ?></p>
	    <?php endif; ?>
	</div>


    <!-- Thana Dropdown -->
    <div class="form-group">
	    <label for="thana">*Thana:</label>
	    <select name="thana" id="thana">
	        <option value="--">--</option> <!-- Default value shown as -- -->
	        <?php 
	            $thanas = ['jaldhaka', 'domar', 'dimla'];
	            foreach ($thanas as $thana) {
	                echo '<option value="' . htmlspecialchars($thana) . '" ' . 
	                     (isset($data['thana']) && $data['thana'] == $thana ? 'selected' : '') . '>' . 
	                     htmlspecialchars($thana) . '</option>';
	            }
	        ?>
	    </select>
	    <?php if (isset($errors['thana'])): ?>
	        <p style="color: red;"><?php echo $errors['thana']; ?></p>
	    <?php endif; ?>
	</div>

    <!-- Image Upload -->
    <div class="form-group">
        <label for="image">Image (optional):</label>
        <input type="file" name="image" id="image">
    </div>

    <button type="submit" name="submit">Submit</button>
</form>


</body>
</html>
