<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/chapters.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Chapter($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleChapter();

    if($item->id != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "chapter_title" => $item->chapter_title,
            "chapter_content" => $item->chapter_content,
            "chapter_no" => $item->chapter_no,
            "book_name" => $item->book_name,
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Chapter not found.");
    }
?>