<?php 
    require_once('../backend/dbConnection.php');
    require_once('../backend/utilities.php');
    require_once('../pagination.php');
    session_start();
    $search = isset($_GET['search']) ? trim($_GET['search']) : "";
    $pagination_info = [];

    if(!empty($search)){
        $query = "select count(*) as total from posts where lower(title) like lower(:search) or lower(content) like lower(:search)";
        $bindvalues= [':search' => "%".$search."%"];
        $total_posts = getTotalPosts($query, $conn,$bindvalues);
        $query = "select * from posts where lower(title) like lower(:search) or lower(content) like lower(:search) limit :start,:end";
        $posts = pagination_query($total_posts, $query, $conn, $pagination_info,$bindvalues);
    }else{
        
        $query = 'select count(*) as total from posts';
        $total_posts = getTotalPosts($query,$conn);
        $query = "select * from posts limit :start,:end";
        $posts = pagination_query($total_posts, $query, $conn, $pagination_info);
    }

    $page=$pagination_info['page'];
    $total_pages = $pagination_info["total_pages"];
    $start = $pagination_info['start'];
    $end = $pagination_info['end'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="flex-box main-wrapper">

    <?php
        require_once('admin_nav.php');
    ?>

    <div class="main-section flex-box flex-col">
        <div class="header flex-box">
            <div class="search-form flex-box content-space">
                <form action="" method="get" >
                    <input type="text" name="search" value="<?= $search; ?>" placeholder="search...">
                    <button type="submit" name="search_button" class="btn">search</button>
                </form>

                <div class="logo">
                    <span>My Blogs</span>
                </div>
            </div>
            <div class="Add_button">
                <a href="../createPost.php" class="btn">Add post</a>
            </div>
        </div>

        <div class="admin-content">
            <h2 style="text-align:center;">Posts Management</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Post ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created_At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo ($post['id']); ?></td>
                            <td><?php echo (substr($post['title'],0,20)."..."); ?></td>
                            <td><?php echo (substr($post['content'],0,30)."...");?></td>
                            <td><?php echo ($post['created_at']);?></td>
                            <td>
                                <a href="../view.php?id=<?= $post['id'] ?>" class="action-btn view-btn"><i class="ri-eye-line"></i></a>
                                <a href="../edit.php?id=<?= $post['id'] ?>" class="action-btn edit-btn">&#128393;</a>
                                <a href="../delete.php?delete=postmanagement&id=<?= $post['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure to delete this Post?');">&#10006;</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

                <!-- -----------pagination code------------->
            <div class="pagination">
                <a href="?page_no=1<?= !empty($search) ? "&search=".urlencode($search): ""?>" class="btn">first</a>
                <a href="?page_no=<?php echo  $page>1 ? $page-1 : 1; ?><?= !empty($search) ? "&search=".urlencode($search): ""?>" class="btn">&laquo; Previous</a>

                <div class="page_buttons">
                    <?php for($i = $start; $i<= $end; $i++) {
                        $activeClass = ($i == $page) ? 'active' : "";    
                    ?>
                    <a href="?page_no=<?php echo $i;?><?= !empty($search) ? "&search=".urlencode($search): ""?>" class="<?php echo $activeClass?>"> <span class="page_btn"><?php echo $i?></span></a>
                    <?php } ?>
                </div>

                <a href="?page_no=<?php echo  $page<$total_pages ? $page+1 : $total_pages; ?><?= !empty($search) ? "&search=".urlencode($search): ""?>" class="btn">Next &raquo;</a>
                <a href="?page_no=<?php echo $total_pages?><?= !empty($search) ? "&search=".urlencode($search): ""?>" class="btn">last</a>
                </div>
            </div>
       </div>
    </div>
</body>
</html>