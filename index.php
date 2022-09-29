
<?php
  include_once './config/database.php';
  include_once './class/books.php';
  $database = new Database();
  $db = $database->getConnection();
  $items = new Book($db);
  $stmt = $items->getBooks();
  $itemCount = $stmt->rowCount();
  if($itemCount > 0){    
?>
<html>
<body>
  <form action="viewbook.php" method="post">
    <p>Please select book:</p>
    <?php 
      echo "<select name=bookName>";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        if ($row['book_name'] != '') {
          echo "<option value='".$row['book_name']."'>".$row['book_name']."</option>";
        }
      }
      echo "</select>"
    ?>
    <br/>
    <input type="submit" style="margin-top: 20px;" />
  </form>
</body>
</html>
<?php 
 } 
?>