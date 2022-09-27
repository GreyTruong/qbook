<pre><?php
  echo "start page\n";
  $title = $_POST["title"];
  $content = $_POST["content"];
  $book = "Quang Âm Chi Ngoại";
  if (!isset($_POST["submit"])) {
    echo "submission";
    die;
  }
  // if (!$title || !$content) {
  //   echo "empty fields";
  //   die;
  // }
  // $bridge = mysqli_connect('localhost', 'root','root','quanbook');
  // $query = "INSERT INTO chapter (chapter_title, chapter_content, book_name) VALUES ('$title', '$content', '$book')";
  // if (!$bridge->query($query)) {
  //   echo "cool";
  // }
  // else{
  //   echo "issue";
  // }
  echo "working";
?>
</pre>