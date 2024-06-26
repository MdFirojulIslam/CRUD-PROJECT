<?php

    spl_autoload_register(function($class){
        include $class .'.php';
    });

    $user = new Person();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Object Oriented PHP</h1>
        <h3>CRUD Application</h3>
    </header>

    <div class="container">
        <div class="form-section">
            <form action="create.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_no">ID</label>
                    <input type="text" name="id_no" id="id_no">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" name="mobile" id="mobile">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="father_name">Father Name</label>
                    <input type="text" name="f_name" id="father_name">
                </div>

                <div class="form-group">
                    <label for="thana">Thana : </label>
                    <div class="radio-group">
                        <input type="radio" id="thana1" name="thana" value="Jaldhaka">
                        <label for="thana1">Jaldhaka</label>
                    </div>   
                    <div class="radio-group">
                        <input type="radio" id="thana2" name="thana" value="Domar">
                        <label for="thana2">Domar</label>
                    </div>  
                    <div class="radio-group">
                        <input type="radio" id="thana2" name="thana" value="Domar">
                        <label for="thana2">Daliya</label>
                    </div>                    
                </div>                 

                <div class="form-group">
                    <label for="zilla">Zilla : </label>
                    <select name="zilla" id="zilla">
                        <option value=""></option>
                        <option value="Nilphamari">Nilphamari</option>
                        <option value="Nilphamari">thakurgao</option>
                        <option value="Nilphamari">panchagar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-group">
                    <input type="submit" name="create" value="SUBMIT">
                </div>
            </form>
        </div>
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>SERIAL NO</th>
                        <th>NID</th>
                        <th>NAME</th>
                        <th>MOBILE</th>
                        <th>EMAIL</th>
                        <th>FATHER NAME</th>
                        <th>THANA</th>
                        <th>ZILLA</th>
                        <th>IMAGE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

        <?php

            $i = 0;
            foreach ($user->readAll() as $key => $value) 
            {
                $i++;
          ?>
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['id']; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['mobile']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['father_name']; ?></td>
                        <td><?php echo $value['thana_name']; ?></td>
                        <td><?php echo $value['zilla_zilla_name']; ?></td>
                        <td><img src="uploads/<?php echo $value['image'];?>" alt=""></td>
                        <td><a href="edit.php?action=edit&id=<?php echo $value['id']; ?>">EDIT</a> || <a href="delete.php?action=delete&id=<?php echo $value['id']; ?>">DELETE</a></td>
                    </tr>
                </tbody>

        <?php
              }
        ?>

            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CRUD Application</p>
    </footer>
</body>
</html>
