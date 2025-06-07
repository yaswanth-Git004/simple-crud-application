<?php
    include_once "backend/dbConnection.php";
    $posts_per_page = 6;
    $sql = "SELECT COUNT(*) AS TOTAL FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $total_posts = $stmt->fetch(PDO::FETCH_ASSOC)['TOTAL'];
    $total_pages = ceil($total_posts / $posts_per_page);

    $page = isset($_GET["page_no"]) ? ((int) $_GET["page_no"]) : 1; //check this line if errors occurs
    $page = max(1, min($page, $total_pages));
    $starting_page = ($page-1) * $posts_per_page; 

    $sql = "SELECT * FROM posts LIMIT :start, :end ";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':start', $starting_page, PDO::PARAM_INT);
    $stmt->bindValue(':end', $posts_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

     if ($page == 1) {
        $start = 1;
        $end = min(3, $total_pages);
    } elseif ($page == $total_pages) {
        $start = max(1, $total_pages - 2);
        $end = $total_pages;
    } elseif($page == $total_pages-1){
        $start = $page-1;
        $end = $total_pages;
    }else {
        $start = $page-1;
        $end = $page + 1;
    }
?>