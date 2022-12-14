<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/chapters.php';
    include_once '../class/books.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Chapter($db);
    $items = new Chapter($db);
    $book = new Book($db);
    $books = new Book($db);

    $data = json_decode(file_get_contents("php://input"));
    if ($data->chapter_title != '' &&  $data->chapter_content != '' && $data->book_name != '') {
        $item->chapter_title = $data->chapter_title;
        $item->chapter_content = $data->chapter_content;
        $item->chapter_no = $data->chapter_no;
        $item->book_name = $data->book_name;
        
        // CHeck book & insert book
        $bookresult = $books->getBooksbyBookName($data->book_name);
        $bookCount = $bookresult->rowCount();
        if ($bookCount == 0){
            $book->book_name =  $data->book_name;
            $book->book_author =$data->book_author;
            $book->createBook();
        }

        // Check chapter is existed
        $stmt = $items->getChaptersbyBookNameandChapter($data->book_name, $data->chapter_no);
        $itemCount = $stmt->rowCount();
        // If chpater is not existed, insert to db
        if ($itemCount == 0) {
            if($item->createChapter()){
                $result = '{"status": 200, "text":  "Chapter created successfully."}';
                echo $result;
                // echo json_encode($result);
            } else{
                $result = '{"status": 400, "text":  "Chapter created fail."}';
                echo $result;
            }
        } 
        // Return 400 if chapter existed
        else {
            $result = '{"status": 400, "text":  "Chapter existed."}';
                echo $result;
        }
    }
?>