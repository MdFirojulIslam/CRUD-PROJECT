<?php

include 'db.php';

class Person 
    {
        private $table_1 = 'person_information';
        private $table_2 = 'up_table';
        private $table_3 = 'zilla_table';
        private $id;
        private $name;
        private $mobile;
        private $email;
        private $f_name;
        private $thana;
        private $zilla;
        private $img;
        

        public function push($id, $name, $mobile, $email, $f_name, $thana, $zilla, $img)
        {
            $this->id = $id;
            $this->name = $name;
            $this->mobile = $mobile;
            $this->email = $email;
            $this->f_name = $f_name;            
            $this->thana = $thana;
            $this->zilla = $zilla;
            $this->img = $img;
        }

        public function insert() 
        {
            // Prepare the first statement
            $sql_1 = "INSERT INTO $this->table_1 (id, name, mobile, email, father_name, image) 
                    VALUES (:id, :name, :mobile, :email, :father_name, :img)";
            $stmt_1 = DB::prepare($sql_1);
            $stmt_1->bindParam(':id', $this->id);
            $stmt_1->bindParam(':name', $this->name);
            $stmt_1->bindParam(':mobile', $this->mobile);
            $stmt_1->bindParam(':email', $this->email);
            $stmt_1->bindParam(':father_name', $this->f_name);
            $stmt_1->bindParam(':img', $this->img);
            $result_1 = $stmt_1->execute();

            // Prepare the second statement
            $sql_2 = "INSERT INTO $this->table_2 (id, thana_name, zilla_name) 
                    VALUES (:id, :thana_name, :zilla_name)";
            $stmt_2 = DB::prepare($sql_2);
            $stmt_2->bindParam(':id', $this->id);
            $stmt_2->bindParam(':thana_name', $this->thana);
            $stmt_2->bindParam(':zilla_name', $this->zilla);
            $result_2 = $stmt_2->execute();

            // Prepare the third statement
            $sql_3 = "INSERT INTO $this->table_3 (id, zilla_name) 
                    VALUES (:id, :zilla_name)";
            $stmt_3 = DB::prepare($sql_3);
            $stmt_3->bindParam(':id', $this->id);
            $stmt_3->bindParam(':zilla_name', $this->zilla);
            $result_3 = $stmt_3->execute();

            // Return the result of all executions
            return $result_1 && $result_2 && $result_3;
        }

        public function readAll()
        {
             $sql = "SELECT 
                    t1.id, t1.name, t1.mobile, t1.email, t1.father_name, t1.image, 
                    t2.thana_name, t2.zilla_name AS up_zilla_name, 
                    t3.zilla_name AS zilla_zilla_name
                FROM $this->table_1 AS t1
                INNER JOIN 
                    $this->table_2 AS t2 ON t1.id = t2.id
                INNER JOIN 
                    $this->table_3 AS t3 ON t1.id = t3.id";

            $stmt = DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

         public function editdata($id)
        {
            $sql = "SELECT 
                        t1.id, t1.name, t1.mobile, t1.email, t1.father_name, t1.image, 
                        t2.thana_name, t2.zilla_name AS up_zilla_name, 
                        t3.zilla_name AS zilla_zilla_name
                    FROM $this->table_1 AS t1
                    INNER JOIN $this->table_2 AS t2 ON t1.id = t2.id
                    INNER JOIN $this->table_3 AS t3 ON t1.id = t3.id
                    WHERE t1.id = :id";

            $stmt = DB::prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id)
        {
            $sql = "DELETE t1, t2, t3 
                    FROM $this->table_1 t1
                    LEFT JOIN $this->table_2 t2 ON t1.id = t2.id
                    LEFT JOIN $this->table_3 t3 ON t1.id = t3.id
                    WHERE t1.id = :id";

            $stmt = DB::prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function update()
        {
            $sql_1 = "UPDATE $this->table_1 
                      SET name = :name, mobile = :mobile, email = :email, father_name = :father_name, image = :img 
                      WHERE id = :id";
            $stmt_1 = DB::prepare($sql_1);
            $stmt_1->bindParam(':name', $this->name);
            $stmt_1->bindParam(':mobile', $this->mobile);
            $stmt_1->bindParam(':email', $this->email);
            $stmt_1->bindParam(':father_name', $this->f_name);
            $stmt_1->bindParam(':img', $this->img);
            $stmt_1->bindParam(':id', $this->id);
            $result_1 = $stmt_1->execute();

            // Update the second table
            $sql_2 = "UPDATE $this->table_2 
                      SET thana_name = :thana_name, zilla_name = :zilla_name 
                      WHERE id = :id";
            $stmt_2 = DB::prepare($sql_2);
            $stmt_2->bindParam(':thana_name', $this->thana);
            $stmt_2->bindParam(':zilla_name', $this->zilla);
            $stmt_2->bindParam(':id', $this->id);
            $result_2 = $stmt_2->execute();

            // Update the third table
            $sql_3 = "UPDATE $this->table_3 
                      SET zilla_name = :zilla_name 
                      WHERE id = :id";
            $stmt_3 = DB::prepare($sql_3);
            $stmt_3->bindParam(':zilla_name', $this->zilla);
            $stmt_3->bindParam(':id', $this->id);
            $result_3 = $stmt_3->execute();

            return $result_1 && $result_2 && $result_3;
        }
    }
?>
