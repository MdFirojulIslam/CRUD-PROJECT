<?php

	spl_autoload_register(function($class){
		include $class . '.php';
	});

	$person = new Person();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Data Table</title>
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

		/* Table Container */
		.table-container {
			width: 90%;
			max-width: 1000px;
			margin: 20px;
			overflow-x: auto;
			background: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}

		/* Table Styling */
		table {
			width: 100%;
			border-collapse: collapse;
		}

		th, td {
			padding: 12px 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		thead th {
			background-color: #4a90e2;
			color: #fff;
			font-weight: bold;
		}

		tbody tr:nth-child(even) {
			background-color: #f9fafb;
		}

		tbody tr:hover {
			background-color: #f1f1f1;
		}

		/* Image Styling */
		td img {
			height: 30px;
			width: 30px;
			border-radius: 50%;
			object-fit: cover;
			border: 1px solid #ddd;
		}

		/* Action Links Styling */
		.action-links a {
			text-decoration: none;
			color: #4a90e2;
			font-weight: bold;
			margin-right: 10px;
			border-radius: 5px;
			padding: 5px 10px;
			transition: background 0.3s, color 0.3s;
		}

		.action-links a:hover {
			background-color: #4a90e2;
			color: #fff;
		}
	</style>
</head>
<body>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Father Name</th>
					<th>Mother Name</th>
					<th>Gender</th>
					<th>Skills</th>
					<th>Thana</th>
					<th>Zilla</th>
					<th>Image</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($person->readall() as $key => $value) {
				?>
					<tr>
						<td><?php echo $value['id'];?></td>
						<td><?php echo $value['name'];?></td>
						<td><?php echo $value['father_name'];?></td>
						<td><?php echo $value['mother_name'];?></td>
						<td><?php echo $value['gender'];?></td>
						<td><?php echo $value['skills'];?></td>
						<td><?php echo $value['thana_name'];?></td>
						<td><?php echo $value['zilla_name'];?></td>
						<td><img src="uploads/<?php echo $value['image']; ?>" alt="Profile Image"></td>
						<td class="action-links">
						    <a href="setSession.php?id=<?php echo $value['id']; ?>">Edit</a>
						    <a href="delete.php?action=delete&id=<?php echo $value['id']; ?>">Delete</a>
						</td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>
