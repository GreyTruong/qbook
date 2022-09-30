<?php
class Book
{
  // Connection
  private $conn;

  // Table
  private $db_table = "book";

  // Columns
  public $id;
  public $book_name;
  public $book_author;
  // Db connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // GET ALL
  public function getBooks()
  {
    $sqlQuery = "SELECT id, book_name, book_author FROM " . $this->db_table . "";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
  }
  public function getBooksbyBookName($bookName)
  {
    $sqlQuery = "SELECT id, book_name, book_author FROM " . $this->db_table . " WHERE book_name = '". $bookName . "'";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->execute();
    return $stmt;
  }

  public function createBook()
  {
    $sqlQuery = "INSERT INTO ".$this->db_table." SET book_name = :book_name, book_author = :book_author";
    $stmt = $this->conn->prepare($sqlQuery);
    // echo $sqlQuery;
    // sanitize
    $this->book_name = htmlspecialchars(strip_tags($this->book_name));
    $this->book_author = htmlspecialchars(strip_tags($this->book_author));
    // bind data
    $stmt->bindParam(":book_name", $this->book_name);
    $stmt->bindParam(":book_author", $this->book_author);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
} ?>
