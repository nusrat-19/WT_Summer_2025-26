<?php
  $conn=mysqli_connect("localhost","root","","employee_db");
  if(!$conn){
    die("Connection failed");
  }
?>
<?php
  if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employees(name, email, phone, department, position, salary) VALUES ('$name', '$email', '$phone', '$department', '$position', '$salary')";
    mysqli_query($conn, $sql);

    echo "Employee added successfully!";
  }


    if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM employees WHERE id=$id";

    mysqli_query($conn, $sql);

    echo "Employee deleted successfully!";
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $sql = "UPDATE employees SET name='$name',email='$email',phone='$phone', department='$department', position='$position', salary='$salary' WHERE id=$id";

    mysqli_query($conn, $sql);

    echo "Employee updated successfully!";
}

$edit = false;

if (isset($_GET['edit'])) {

    $edit = true;

    $id = $_GET['edit'];

    $sql = "SELECT * FROM employees WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
}



$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}



$department = "";

if (isset($_GET['department'])) {
    $department = $_GET['department'];
}


$sql = "SELECT * FROM employees WHERE 1=1";

if ($search != "") {
    $sql = $sql . " AND name LIKE '%$search%'";
}

if ($department != "") {
    $sql = $sql . " AND department='$department'";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Employee Management System </title>
        <style>

            body{
                font-family:Arial,sans-serif;
                background-color: white;
                margin:0;
                padding:30px;
            }

            h1 {
            text-align: center;
            color: #333;
            }

            h2 {
            color: #333;
            }

            .form-box {
            background-color: white;
            width: 500px;
            margin: 20px auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            }

            input,select {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            }

            input[type="submit"] {
            width: auto;
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            }

            input[type="submit"]:hover {
            background-color: darkgreen;
             }

            .search-box {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            }

            table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            margin-top: 20px;
            box-sizing: border-box;
            }

            th {
            background-color: #333;
            color: white;
            padding: 12px;
            }

            td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            }

            tr:hover {
            background-color: #f5f5f5;
            }

           a {
            color: red;
            text-decoration: none;
             }

            a:hover {
            text-decoration: underline;
             }
        </style>
    </head>

    <body>
        <h1>Employee Management System </h1>
    <div class="form-box">
        
    <?php if ($edit) { ?>
        <h2>Update Employee</h2>
    <?php } else { ?>
        <h2>Add Employee</h2>
    <?php } ?>

        
        <form method = "POST">

         <?php if ($edit) { ?>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
         <?php } ?>

        Name:
        <input type="text" name="name"  value="<?php echo $edit ? $row['name'] : ''; ?>" required>

        Email:
        <input type="email" name="email" value="<?php echo $edit ? $row['email'] : ''; ?>" required>

        Phone:
        <input type="text" name="phone" value="<?php echo $edit ? $row['phone'] : ''; ?>" required>

        Department:
        <select name="department">

            <option value="CSE"
                <?php if ($edit && $row['department'] == 'CSE') echo 'selected'; ?>> CSE
            </option>

            <option value="EEE"
                <?php if ($edit && $row['department'] == 'EEE') echo 'selected'; ?>> EEE
            </option>

            <option value="BBA"
                <?php if ($edit && $row['department'] == 'BBA') echo 'selected'; ?>> BBA
            </option>

        </select>

        Position:
        <input type="text" name="position" value="<?php echo $edit ? $row['position'] : ''; ?>" required>

        Salary:
        <input type="number" name="salary" value="<?php echo $edit ? $row['salary'] : ''; ?>" required>

        <?php if ($edit) { ?>

            <input type="submit" name="update" value="Update Employee">

        <?php } else { ?>

            <input type="submit" name="add" value="Add Employee">

        <?php } ?>


        </form>
    </div>

    <hr>

    <div class="search-box">
      <h2> Filter/ Search</h2>
      <form method="GET">
         Search Name:
         <input type="text" name="search">

         Department:
         <select name="department">
           <option value="">All</option>
           <option value="CSE">CSE</option>
           <option value="EEE">EEE</option>
           <option value="BBA">BBA</option>
         </select>

         <input type="submit" value="Search">
      </form>
     </div>
      <hr>
      <h2> Employee List </h2>
      <table border="1" cellpadding="10">

      <tr>
         
         <th>ID</th>
         <th>Name</th>
         <th>Email</th>
         <th>Phone</th>
         <th>Department</th>
         <th>Position</th>
         <th>Salary</th>
         <th>Action</th>

      </tr>
      
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>

       <tr>
           <td><?php echo $row['id']; ?></td>
           <td><?php echo $row['name']; ?></td>
           <td><?php echo $row['email']; ?></td>
           <td><?php echo $row['phone']; ?></td>
           <td><?php echo $row['department']; ?></td>
           <td><?php echo $row['position']; ?></td>
           <td><?php echo $row['salary']; ?></td>
            
           
           <td>
            <a class="edit"
               href="LabtaskDBconnection.php?edit=<?php echo $row['id']; ?>">Edit </a>

           <a href="LabtaskDBconnection.php?delete=<?php echo $row['id']; ?>">  Delete</a>
           </td>
        </tr>
      <?php
      }
      ?>
     </table>
    </body>
</html>