
<?php
  header("Access-Control-Allow-Origin: http://localhost:3000");
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
    <p>From chapter:</p>
    <input type="number" name="fromChapter" value="0"  id="fromChapter" onchange="compareValue()" />
    <p>To chapter:</p>
    <input type="number" name="toChapter" value="0" id="toChapter" onchange="compareValue()" />
    <br/>
    <input type="submit" style="margin-top: 20px;" id="submit" />
  </form>
</body>
</html>
<?php 
 } 
?>
<script>
  function compareValue() {
    var fromChapterNo = parseInt(document.getElementById("fromChapter").value);
    var toChapterNo =  parseInt(document.getElementById("toChapter").value);
    if (fromChapterNo > 0 && toChapterNo > 0 && fromChapterNo > toChapterNo) {
      alert('Nhập sai rồi bạn ơi');
      document.getElementById("fromChapter").value = 0;
      document.getElementById("toChapter").value = 0;
    }
  }
</script>