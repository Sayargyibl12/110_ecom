<?php
    require_once "dbconnect.php";
   if(!isset($_SESSION)){
    // session will be opened when it does not exist.
    session_start();
   }
?>

<?php 
if(isset($_POST['insertBtn']))
{
    $name = $_POST['pname'];
    $price = $_POST['price'];  
    $category = $_POST['category'];   
    $qty = $_POST['qty'];   
    $description = $_POST['description'];  
    $fileImage = $_FILES['productImage'];
    $filePath = "productImage/".$fileImage['name']; // uploading to a specified directory
    $status = move_uploaded_file($fileImage['tmp_name'], $filePath); // image, destion
    if($status)
    {
       try{
        $sql = "insert into product values (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $flag = $stmt -> execute([null, $name, $category, $price, $description, $qty, $filePath]);
        $id = $conn -> lastInsertId();

        if ($flag){
            $message = "new product with id $id has been inserted successfully!";
            $_SESSION["message"] = $message;
            header("Location:viewProduct.php");
        }
       }catch(PDOException $e){

       }
    }else{
        echo "file upload fail";
    }

    // echo $name."<br>";
    // echo $price."<br>";
    // echo $category."<br>";
    // echo $qty."<br>";
    // echo $description."<br>";
    // echo $fileImage['name']."<br>";
    //  echo "$fileImage[size].<br>";
    //   echo "$fileImage[type].<br>";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
     <style>
    body {
    background: linear-gradient(to right, #84dac0ff);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .form-container {
     background: rgba(255, 255, 255, 0.15); /* Soft white with transparency */
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 2rem 2.5rem;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin: 3rem auto;
  }

  h1 {
    font-size: 2.4rem;
    font-weight: 700;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
  }

  .form-label {
    font-weight: 600;
    color: #444;
  }

  .form-control,
  .form-select {
    border-radius: 12px;
    padding: 0.65rem 1rem;
    border: 1px solid #ccc;
    transition: all 0.2s ease-in-out;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
  }

  .btn-primary {
    background-color: #4a90e2;
    border-color: #4a90e2;
    padding: 0.75rem;
    font-size: 1.1rem;
    border-radius: 50px;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #357ABD;
  }

  textarea.form-control {
    resize: none;
    min-height: 100px;
  }
    </style>
</head>
<body>
    <div class="container-fluid px-0">
    <?php require_once("navbar.php"); ?>
    
    <div class="container">
      <div class="form-container">
        <h1>Insert Product</h1>
        <form action="insertProduct.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="pname" placeholder="Enter product name">
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" placeholder="Enter price">
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" class="form-select">
              <option value="">Choose Category</option>
              <?php
              if (isset($categories)) {
                foreach ($categories as $category) {
                  echo "<option value=$category[catId]> $category[catName]</option>";
                }
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="qty" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="qty" placeholder="Enter quantity">
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea name="description" class="form-control" placeholder="Enter product description"></textarea>
          </div>

          <div class="mb-3">
            <label for="productImage" class="form-label">Choose Product Image</label>
            <input type="file" class="form-control" name="productImage">
          </div>

          <button type="submit" name="insertBtn" class="btn btn-primary w-100">Insert Product</button>
        </form>
      </div>
    </div>
  </div>
    
</body>
</html>