<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>


<?php
	spl_autoload_register(function($class){
		include $class .'.php';
	});

	$user = new student();
	if (isset($_POST['create'])) 
	{
		$name 	= $_POST['name'];
		$dep	= $_POST['department'];
		$age 	= $_POST['age'];

		$user->setName($name);
		$user->setDep($dep);
		$user->setAge($age);

		if ($user->insert()) 
		{
			 echo "<script> alert('Inserted successfully');
			            window.location.href = 'index.php';
			       </script>";
			    exit();
		}
	}

    if (isset($_POST['update'])) 
    {
        $id     = $_POST['id'];
        $name   = $_POST['name'];
        $dep    = $_POST['department'];
        $age    = $_POST['age'];

        $user->setName($name);
        $user->setDep($dep);
        $user->setAge($age);

        if ($user->update($id)) 
        {
             echo "<script> alert('Updated successfully');
                        window.location.href = 'index.php';
                   </script>";
                exit();
        }
    }

    if (isset($_GET['action']) && $_GET['action']=='delete')
    {
        $id = (int)$_GET['id'];
        if ($user->delete($id)) 
        {
            echo "<script> alert('Deleted successfully');
                        window.location.href = 'index.php';
                   </script>";
                exit();
        }
    }

    if (isset($_GET['action']) && $_GET['action']=='update')
    {
        $id = (int)$_GET['id'];
        $result = $user->editdata($id);
?>

    <header>
        <h1>Object Oriented PHP</h1>
        <h3>CRUD Application</h3>
    </header>

    <div class="container">
        <div class="form-section">
            <form action="index.php" method="POST">

                <input type="hidden" name="id"  value="<?php echo $result['id'];?>">

                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $result['name'];?>">
                </div>

                <div>
                    <label for="department">Department</label>
                    <input type="text" name="department" id="department" value="<?php echo $result['department'];?>">
                </div>

                <div>
                    <label for="age">Age</label>
                    <input type="text" name="age" id="age" value="<?php echo $result['age'];?>">
                </div>
                <div>
                    <input type="submit" name="update" value="UPDATE">
                </div>
            </form>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>SERIAL NO</th>          
                        <th>NAME</th>          
                        <th>DEPARTMENT</th>          
                        <th>AGE</th>          
                        <th>ACTION</th>          
                    </tr>
                </thead>
    <?php
        $i = 0;
        foreach($user->readAll() as $key => $value) 
        {
            $i++;

    ?>
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['department']; ?></td>
                        <td><?php echo $value['age']; ?></td>
                        <td><a href="index.php?action=update&id=<?php echo $value['id']; ?>">EDIT</a> || <a href="index.php?action=delete&id=<?php echo $value['id']; ?>">DELETE</a></td>
                    </tr>
                    <!-- More rows as needed -->
                </tbody>
            

    <?php       }      ?>

            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CRUD Application</p>
    </footer>
</body>
</html>


    <?php   }    else       {       ?>


    <header>
        <h1>CRUD Application</h1>
    </header>

    <div class="container">
        <div class="form-section">
            <form action="index.php" method="POST">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name">
                </div>

                <div>
                    <label for="department">Department</label>
                    <input type="text" name="department" id="department" placeholder="Enter your department name">
                </div>

                <div>
                    <label for="age">Age</label>
                    <input type="text" name="age" id="age" placeholder="Enter your age">
                </div>
                <div>
                    <input type="submit" name="create" value="INSERT">
                </div>
            </form>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>SERIAL NO</th>          
                        <th>NAME</th>          
                        <th>DEPARTMENT</th>          
                        <th>AGE</th>          
                        <th>ACTION</th>          
                    </tr>
                </thead>
		<?php
			$i = 0;
			foreach($user->readAll() as $key => $value) 
			{
				$i++;

		?>
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['department']; ?></td>
                        <td><?php echo $value['age']; ?></td>
                        <td><a href="index.php?action=update&id=<?php echo $value['id']; ?>">EDIT</a> || <a href="index.php?action=delete&id=<?php echo $value['id']; ?>">DELETE</a></td>
                    </tr>
                    <!-- More rows as needed -->
                </tbody>
            
        <?php      	}		?>

			</table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CRUD Application</p>
    </footer>
</body>
</html>

<?php   }   ?>