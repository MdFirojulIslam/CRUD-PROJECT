
<?php
    spl_autoload_register(function($class){
        include $class .'.php';
    });

    $user = new Person();

    if (isset($_POST['update'])) 
    {
        $id     = $_POST['id_no'];
        $name   = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email  = $_POST['email'];
        $f_name = $_POST['f_name'];
        $thana_name = $_POST['thana'];
        $zilla_name = $_POST['zilla'];
        
        $target_file    = basename($_FILES['image']['name']); 
        $target_dir     = "uploads/".$target_file; 
        $uploadOk       = 1;
        $imageFileType  = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);

        if ($check !== false) 
        {
            $uploadOk = 1;
        } 
        else 
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 5000000) 
        {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
        {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) 
        {
            echo "Sorry, your file was not uploaded.";
        } 

        else 
        {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)) 
            {
                $person = new Person();

                $person->push($id, $name, $mobile, $email, $f_name, $thana_name, $zilla_name, $target_file);

                if ($person->update()) 
                {
                    echo "<script> alert('Updated successfully');
                            window.location.href = 'index.php';
                       </script>";
                    exit();  
                } 
                else 
                {
                    echo "Sorry, there was an error inserting the record.";
                }
            } 
            else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }


    if (isset($_GET['action']) && $_GET['action']=='edit')
    {
        $id = (int)$_GET['id'];
        $result = $user->editdata($id);

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
            <form action="edit.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_no">ID</label>
                    <input type="text" name="id_no" value="<?php echo $result['id']?>" id="id_no">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?php echo $result['name']?>" id="name">
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" name="mobile" value="<?php echo $result['mobile']?>" id="mobile">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo $result['email']?>" id="email">
                </div>
                <div class="form-group">
                    <label for="father_name">Father Name</label>
                    <input type="text" name="f_name" value="<?php echo $result['father_name']?>" id="father_name">
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
                    <input type="file" name="image" value="<?php echo $result['image']?>" id="image">
                </div>
                <div class="form-group">
                    <input type="submit" name="update" value="UPDATE">
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CRUD Application</p>
    </footer>
</body>
</html>


<?php       }        ?>