<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/chapters.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Chapter($db);

    $stmt = $items->getChapters();
    $itemCount = $stmt->rowCount();


    // echo json_encode($itemCount);

    if($itemCount > 0){
        
        $chapterArr = array();
        $chapterArr["body"] = array();
        $chapterArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "chapter_title" => $chapter_title,
                "chapter_content" => $chapter_content,
                "chapter_no" => $chapter_no,
                "book_name" => $book_name
            );

            array_push($chapterArr["body"], $e);
        }
        echo json_encode($chapterArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>