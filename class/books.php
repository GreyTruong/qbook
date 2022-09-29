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

} ?>
