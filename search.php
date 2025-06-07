<?php
require_once("backend/dbConnection.php");
$total_posts = 0;
if(isset($_GET['search_button']))
{
    if(!empty($_GET["search"]))
    {   $posts_per_page = 6;
        $search=$_GET['search'];
        $sql="select count(*) as total from posts where lower(title) like lower(:searcH) or lower(content) like lower(:searcH)";
        $stmt=$conn->prepare($sql);
        $stmt->bindValue(':searcH','%' . $search . '%');
        $stmt->execute();
        $total_posts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_posts / $posts_per_page);
        
        $page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
        $page = max(1, min($page, $total_pages));
        $starting_page = ($page-1) * $posts_per_page; 

        $sql = "select * from posts where lower(title) like lower(:searcH) or lower(content) like lower(:searcH) limit :start, :end";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':searcH','%' . $search . '%');
        $stmt->bindValue(':start', $starting_page, PDO::PARAM_INT);
        $stmt->bindValue(':end', $posts_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        }else{
            header("Location: index.php");
        }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blog</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php
include_once "nav.php";
if($total_posts > 0){?>
    <div class="container">
       <div class="wrapper">
         <?php
            foreach($results as $result){
         ?>
            <div class="post-container flex-box flex-col">
                <div class="post-img">
                    <img src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=" alt="post-image">
                </div>
                <div class="post-content flex-box flex-col">
                    <h3 class="post-title"><?php echo $result['title']?></h3>
                    <p class="post-description"><?php echo substr($result['content'],0, 150).'...'?></p>
                </div>
                <div class="post-btns flex-box">
                        <!-- <button class="btn">view</button> -->
                    <a href="edit.php?id=<?php echo $result['id'];?>"><button class="btn">Edit</button></a>
                    <a href="delete.php?id=<?php echo $result['id'];?>"><button class="btn">Delete</button></a>
                </div>
            </div>
         <?php } ?>
        </div>
    </div>

    <div class="pagination">
            <a class="btn" href="?search=<?php echo urlencode($search); ?>&search_button=Search&page=1">first</a>

            <a class="btn" href="?search=<?php echo urlencode($search); ?>&search_button=Search&page=<?php echo $page > 1 ? $page - 1 : 1; ?>">&laquo; Previous</a>

            <div class="page_buttons">
                <?php for($i = $start; $i<= $end; $i++) {
                $activeClass = ($i == $page) ? 'active' : "";    
                ?>
                    <a href="?search=<?php echo urlencode($search);?>&search_button=Search&page=<?php echo $i;?>" class="<?php echo $activeClass?>"><span class="page_btn"><?php echo $i?></span></a>
                <?php } ?>
            </div>

            <a class="btn" href="?search=<?php echo urlencode($search); ?>&search_button=Search&page=<?php echo $page < $total_pages ? $page + 1 : $total_pages; ?>">Next &raquo;</a>

            <a class="btn" href="?search=<?php echo urlencode($search); ?>&search_button=Search&page=<?php echo $total_pages; ?>">last</a>
        </div>

        <?php
    }else{  ?>
            <div class="flex-box content-center">
                <h1>not found</h1>
            </div>
        <?php
        }?>
</body>
</html>