<?php
class Chapter
{
  // Connection
  private $conn;

  // Table
  private $db_table = "chapter";

  // Columns
  public $id;
  public $chapter_title;
  public $chapter_content;
  public $chapter_no;
  public $book_name;

  // Db connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET ALL
  public function getChapters()
  {
    $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . "";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
  }
  public function getChaptersbyBookName($bookName, $fromChapter, $toChapter)
  {
    $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . " WHERE book_name = '". $bookName . "' ORDER by chapter_no ASC";
    if ($fromChapter > 0 && $toChapter == 0) {
      $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . " WHERE book_name = '". $bookName . "' AND chapter_no >= ". $fromChapter ." ORDER by chapter_no ASC";
    }
    if ($fromChapter > 0 && $toChapter > 0) {
      $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . " WHERE book_name = '". $bookName . "' AND chapter_no >= ". $fromChapter ." AND chapter_no <= ". $toChapter ." ORDER by chapter_no ASC";
    }
    if ($fromChapter == 0 && $toChapter > 0) {
      $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . " WHERE book_name = '". $bookName . "' AND chapter_no <= ". $toChapter ." ORDER by chapter_no ASC";
    }
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
  }
  public function getChaptersbyBookNameandChapter($bookName,$chapterNo)
  {
    $sqlQuery = "SELECT id, chapter_title, chapter_content, book_name, chapter_no FROM " . $this->db_table . " WHERE book_name = '". $bookName . "' AND chapter_no =".$chapterNo." ORDER by chapter_no ASC";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
  }

  // CREATE
  public function createChapter()
  {
    $sqlQuery = "INSERT INTO ".$this->db_table." SET chapter_title = :chapter_title, chapter_content = :chapter_content,  chapter_no = :chapter_no, book_name = :book_name";
    $stmt = $this->conn->prepare($sqlQuery);
    // echo $sqlQuery;
    // sanitize
    $this->chapter_title = htmlspecialchars(strip_tags($this->chapter_title));
    $this->chapter_content = htmlspecialchars(strip_tags($this->chapter_content));
    $this->chapter_no = htmlspecialchars(strip_tags($this->chapter_no));
    $this->book_name = htmlspecialchars(strip_tags($this->book_name));
    // bind data
    $stmt->bindParam(":chapter_title", $this->chapter_title);
    $stmt->bindParam(":chapter_content", $this->chapter_content);
    $stmt->bindParam(":chapter_no", $this->chapter_no);
    $stmt->bindParam(":book_name", $this->book_name);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // UPDATE
  public function getSingleChapter()
  {
    $sqlQuery ="SELECT chapter_title, chapter_content, chapter_no, book_name FROM ".$this->db_table." WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($sqlQuery);

    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->chapter_title = $dataRow["chapter_title"];
    $this->chapter_content = $dataRow["chapter_content"];
    $this->chapter_no = $dataRow["chapter_no"];
    $this->book_name = $dataRow["book_name"];
  }

  // UPDATE
  public function updateChapter()
  {
    $sqlQuery = "UPDATE ".$this->db_table." SET chapter_title = :chapter_title, chapter_content = :chapter_content, chapter_no = :chapter_no, book_name = :book_name WHERE id = :id";

    $stmt = $this->conn->prepare($sqlQuery);

    $this->chapter_title = htmlspecialchars(strip_tags($this->chapter_title));
    $this->chapter_content = htmlspecialchars(strip_tags($this->chapter_content));
    $this->book_name = htmlspecialchars(strip_tags($this->book_name));
    // echo $sqlQuery;
    // bind data
    $stmt->bindParam(":chapter_title", $this->chapter_title);
    $stmt->bindParam(":chapter_content", $this->chapter_content);
    $stmt->bindParam(":chapter_no", $this->chapter_no);
    $stmt->bindParam(":book_name", $this->book_name);
  
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // DELETE
  function deleteChapter()
  {
    $sqlQuery = "DELETE FROM ".$this->db_table." WHERE id = ?";
    $stmt = $this->conn->prepare($sqlQuery);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
} ?>
