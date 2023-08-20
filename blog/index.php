<?php require_once('./includes/header.php') ?>

<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <?php
    $post_per_page = 2; 
    $status = "Publish";
    
    $sql = "SELECT * FROM posts WHERE post_status = :status";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':status' => $status]);
    $post_count = $stmt->rowCount();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $page_id = ($page - 1) * $post_per_page;
    $total_pager = ceil($post_count / $post_per_page);
    ?>

    <section id="main" class="mx-5">
        <h2 class="my-3">All Posts</h2>

        <?php
        $sql = "SELECT * FROM posts LIMIT $page_id, $post_per_page";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post_id = $post["post_id"];
            $post_title = $post["post_title"];
            $post_des = $post["post_des"];
            $post_image = $post["post_image"];
            $post_date = $post["post_date"];
            $post_author = $post["post_author"];
            $post_cat_id = $post["post_cat_id"];
            $post_status = $post["post_status"];
            ?>

        <div class="row my-4 single-post">
            <img class="col col-lg-4 col-md-12" src="img/<?php echo $post_image  ?>" alt="Image">
            <div class="media-body col col-lg-8 col-md-12">
                <h5 class="mt-0">
                    <a href="single.php?id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h5>
                <span class="posted">
                    <a href="categories.php?id=<?php echo $post_cat_id ?>" class="category">
                        <?php
                            $sql_cat = "SELECT * FROM categories WHERE cat_id = :id";
                            $stmt_cat = $pdo->prepare($sql_cat);
                            $stmt_cat->execute([':id' => $post_cat_id]);
                            while ($cat = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                                $cat_title = $cat["cat_title"];
                            }
                            echo $cat_title;
                            ?>
                    </a>
                    Posted by <?php echo $post_author ?> at <?php echo $post_date ?>
                </span>
                <p>
                    <?php echo substr($post_des, 0, 250) . "..."; ?></p>

                <span>
                    <a href="single.php?id=<?php echo $post_id ?>" class="d-block">See more &rarr;</a>
                </span>
            </div>
        </div>

        <?php
        }
        ?>
    </section>

    <?php
    $prev = max($page - 1, 1);
    $next = min($page + 1, $total_pager);
    if ($post_count > $post_per_page) {
    ?>

    <ul class="pagination px-5">
        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?page=<?php echo $prev ?>" tabindex="-1">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pager; $i++): ?>
        <li class="page-item <?php echo ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
        <?php endfor; ?>

        <li class="page-item <?php echo ($page >= $total_pager) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?page=<?php echo $next ?>">Next</a>
        </li>
    </ul>

    <?php } ?>

    <?php require_once('./includes/footer.php') ?>
</div>