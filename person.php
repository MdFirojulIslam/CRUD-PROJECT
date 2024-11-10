<?php
	
	include 'db.php';

	class Person
	{
		private $table1 = 'user_information';
		private $table2 = 'thana_name';
		private $table3 = 'zilla_name';
		private $table4 = 'skills';
		private $id;
		private $name;
		private $email;
		private $father_name;
		private $mother_name;
		private $gender;
		private $skill;
		private $thana_name;
		private $zilla_name;
		private $image;

		public function push($full_name, $email, $father_name, $mother_name, $gender, $skill, $thana_name, $zilla_name, $img)
		{
			$this->name = $full_name;
			$this->email = $email;
			$this->father_name = $father_name;
			$this->mother_name = $mother_name;
			$this->gender = $gender;
			$this->skill = $skill;
			$this->thana_name = $thana_name;
			$this->zilla_name = $zilla_name;
			$this->image = $img;
		}

		public function insert()
		{
		    // Insert into user_information
		    $sql_1 = "INSERT INTO $this->table1(name, email, father_name, mother_name, gender, image) 
		              VALUES(:name, :email, :father_name, :mother_name, :gender, :image)";
		    $stmt1 = DB::prepare($sql_1);
		    $stmt1->bindParam(':name', $this->name);
		    $stmt1->bindParam(':email', $this->email);
		    $stmt1->bindParam(':father_name', $this->father_name);
		    $stmt1->bindParam(':mother_name', $this->mother_name);
		    $stmt1->bindParam(':gender', $this->gender);
		    $stmt1->bindParam(':image', $this->image);
		    $stmt1->execute();

		    // Get the last inserted ID using MySQL's lastInsertId method
		    $user_id = DB::lastInsertId();

		    // Insert into thana_name with the foreign key
		    $sql_2 = "INSERT INTO $this->table2(user_id, thana_name) VALUES(:user_id, :thana)";
		    $stmt2 = DB::prepare($sql_2);
		    $stmt2->bindParam(':user_id', $user_id);
		    $stmt2->bindParam(':thana', $this->thana_name);
		    $stmt2->execute();

		    // Insert into zilla_name with the foreign key
		    $sql_3 = "INSERT INTO $this->table3(user_id, zilla_name) VALUES(:user_id, :zilla)";
		    $stmt3 = DB::prepare($sql_3);
		    $stmt3->bindParam(':user_id', $user_id);
		    $stmt3->bindParam(':zilla', $this->zilla_name);
		    $stmt3->execute();

		    $sql_4 = "INSERT INTO $this->table4(user_id, skills) VALUES(:user_id, :skills)";
		    $stmt4 = DB::prepare($sql_4);
		    $stmt4->bindParam(':user_id', $user_id);
		    $stmt4->bindParam(':skills', $this->skill);
		    $stmt4->execute();

		    return true;
		}

		public function readall()
		{
			$sql = "SELECT t1.id, t1.name, t1.email, t1.father_name, t1.mother_name, t1.gender, 
					t1.image, t2.thana_name, t3.zilla_name, t4.skills
					FROM $this->table1 AS t1
					LEFT JOIN $this->table2 AS t2 ON t1.id = t2.user_id
					LEFT JOIN $this->table3 AS t3 ON t1.id = t3.user_id
					LEFT JOIN $this->table4 AS t4 ON t1.id = t4.user_id";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function delete($id)
		{
		    // Step 1: Fetch the image file name
		    $sql_image = "SELECT image FROM $this->table1 WHERE id = :id";
		    $stmt_image = DB::prepare($sql_image);
		    $stmt_image->bindParam(':id', $id);
		    $stmt_image->execute();
		    $image = $stmt_image->fetchColumn();
		    
		    // Step 2: Delete the image file from the 'uploads' directory if it exists
		    if ($image && file_exists("uploads/$image")) {
		        unlink("uploads/$image");
		    }

		    // Step 3: Perform the database deletion
		    $sql = "DELETE t1, t2, t3, t4
		            FROM $this->table1 AS t1 
		            LEFT JOIN $this->table2 AS t2 ON t1.id = t2.user_id 
		            LEFT JOIN $this->table3 AS t3 ON t1.id = t3.user_id 
		            LEFT JOIN $this->table4 AS t4 ON t1.id = t4.user_id
		            WHERE t1.id = :id";
		    $stmt = DB::prepare($sql);
		    $stmt->bindParam(':id', $id);
		    return $stmt->execute();
		}


		public function editData($id)
		{
			$sql = "SELECT t1.id, t1.name, t1.email, t1.father_name, t1.mother_name, t1.gender, t1.image, t2.thana_name, t3.zilla_name, t4.skills
					FROM $this->table1 AS t1 
					LEFT JOIN $this->table2 AS t2 ON t1.id = t2.user_id
					LEFT JOIN $this->table3 AS t3 ON t1.id = t3.user_id
					LEFT JOIN $this->table4 AS t4 ON t1.id = t4.user_id
					WHERE t1.id = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function update($id)
		{
			$sql1 = "UPDATE $this->table1 SET name = :name, email = :email, father_name = :father_name,
					mother_name = :mother_name, gender = :gender, image = :image
					WHERE id = :id";
			$stmt1 = DB::prepare($sql1);
			$stmt1->bindParam(':name', $this->name);
			$stmt1->bindParam(':email', $this->email);
			$stmt1->bindParam(':father_name', $this->father_name);
			$stmt1->bindParam(':mother_name', $this->mother_name);
			$stmt1->bindParam(':gender', $this->gender);
			$stmt1->bindParam(':image', $this->image);
			$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
			$result1 = $stmt1->execute();

			$sql2 = "UPDATE $this->table2 SET thana_name = :thana_name WHERE user_id = :id";
			$stmt2 = DB::prepare($sql2);
			$stmt2->bindParam(':thana_name', $this->thana_name);
			$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
			$result2 = $stmt2->execute();

			$sql3 = "UPDATE $this->table3 SET zilla_name = :zilla_name WHERE user_id = :id";
			$stmt3 = DB::prepare($sql3);
			$stmt3->bindParam(':zilla_name', $this->zilla_name);
			$stmt3->bindParam(':id', $id, PDO::PARAM_INT);
			$result3 = $stmt3->execute();

			$sql4 = "UPDATE $this->table4 SET skills=:skills_name WHERE user_id = :id";
			$stmt4 = DB::prepare($sql4);
			$stmt4->bindParam(':skills_name', $this->skill);
			$stmt4->bindParam(':id', $id, PDO::PARAM_INT);
			$result4 = $stmt4->execute();

			return true;
		}
	}
?>
