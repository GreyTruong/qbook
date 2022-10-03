
  <?php

  include_once './config/database.php';
  include_once './class/chapters.php';

  $database = new Database();
  $db = $database->getConnection();

  $items = new Chapter($db);
  $bookName = $_POST["bookName"];
  $fromChapter = $_POST["fromChapter"];
  $toChapter = $_POST["toChapter"];
  
  if ($bookName !=''){
    $stmt = $items->getChaptersbyBookName($bookName, $fromChapter, $toChapter);
    $itemCount = $stmt->rowCount();
    
    if($itemCount > 0){    
      echo "<h1>".$bookName." - ".$itemCount."</h1>";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        echo "<h3>";
        echo $row['chapter_title'];
        echo "</h3>";
        echo "<div>";
        echo nl2br($row['chapter_content']);
        echo "</div>";
      }
    }
    else{
      http_response_code(404);
      echo json_encode(
          array("message" => "No record found.")
      );
    }
  }
?>





