<?php
	
	include 'db.php';

	class student
	{
		private $table = 'student_table';
		private $name;
		private $dep;
		private $age;
		public function setName($name)
		{
			$this->name = $name;
		}
		public function setDep($dep)
		{
			$this->dep = $dep;
		}
		public function setAge($age)
		{
			$this->age = $age;
		}
		
		public function insert()
		{
		    $sql = "INSERT INTO $this->table (name, department, age) VALUES (:name, :dep, :age)";
		    $stmt = DB::prepare($sql);
		    $stmt->bindParam(':name', $this->name);
		    $stmt->bindParam(':dep', $this->dep);
		    $stmt->bindParam(':age', $this->age);
		    return $stmt->execute();
		}

		public function update($id)
		{
		    $sql = "UPDATE $this->table SET name=:name,department=:dep,age=:age WHERE id=:id";
		    $stmt = DB::prepare($sql);
		    $stmt->bindParam(':name', $this->name);
		    $stmt->bindParam(':dep', $this->dep);
		    $stmt->bindParam(':age', $this->age);
		    $stmt->bindParam(':id', $id);
		    return $stmt->execute();

		}

		public function delete($id)
		{
			$sql = "DELETE FROM $this->table WHERE id=:id";
			$stmt=DB::prepare($sql);
			$stmt->bindParam(':id', $id);
			return $stmt->execute();
		}

		public function editdata($id)
		{
			$sql = "SELECT * FROM $this->table WHERE id=:id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			return $stmt->fetch();
		}

		public function readAll()
		{
			$sql = "SELECT * FROM $this->table";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
	}
	
?>