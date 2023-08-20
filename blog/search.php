<?php 
require_once('./includes/header.php');
?>
<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <?php
    if (isset($_POST['val'])) {
        $key = $_POST['val'];
        header("Location: search.php?key={$key}");
        exit;
    }
    

    $post_per_page = 2;
    $status = "Publish";
    $key = isset($_GET['key']) ? $_GET['key'] : '';

    $sql_p = "SELECT * FROM posts WHERE post_title LIKE :p_title AND post_status = :status";
    $stmt_p = $pdo->prepare($sql_p);
    $stmt_p->execute([
        ':p_title' => '%' . $key . '%',
        ':status' => $status
    ]);
    $post_count = $stmt_p->rowCount();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $page_id = ($page - 1) * $post_per_page;

    $total_pager = ceil($post_count / $post_per_page);
    ?>

    <section id="main" class="mx-5">
        <h2 class="my-3">Search Result: <?= $key ?></h2>

        <?php
        $sql = "SELECT * FROM posts WHERE post_status = :status AND post_title LIKE :title LIMIT $page_id, $post_per_page";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':title' => '%' . $key . '%'
        ]);

        if ($stmt->rowCount() === 0) {
            echo "<div class='alert alert-danger'> No post found!</div>";
        } else {
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

        <!-- Display each post details here -->
        <div class="row my-4 single-post">
            <img class="col col-lg-4 col-md-12" src="img/<?php echo $post_image; ?>" alt="Image">
            <div class="media-body col col-lg-8 col-md-12">
                <h5 class="mt-0">
                    <a href="single.php?id=<?php echo $post_id; ?>">
                        <?php echo $post_title; ?>
                    </a>
                </h5>
                <span class="posted">
                    <a href="categories.php?id=<?php echo $post_cat_id; ?>" class="category">
                        <?php 
                                $sql_cat = "SELECT * FROM categories WHERE cat_id = :id";
                                $stmt_cat = $pdo->prepare($sql_cat);
                                $stmt_cat->execute([':id' => $post_cat_id]);
                                $cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                                echo $cat["cat_title"]; 
                                ?>
                    </a>
                    Posted by <?php echo $post_author; ?> on <?php echo $post_date; ?>
                </span>
                <p><?php echo substr($post_des, 0, 250) . "..."; ?></p>
                <span><a href="single.php?id=<?php echo $post_id; ?>" class="d-block">Read more &rarr;</a></span>
            </div>
        </div>

        <?php
            }
        }
        ?>
    </section>

    <?php
    if ($post_count > $post_per_page) {
    ?>
    <ul class="pagination px-5">
        <?php
            $prev = max(1, $page - 1);
            $next = min($total_pager, $page + 1);

            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='search.php?key={$key}&page={$prev}'>Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><a class='page-link'>Previous</a></li>";
            }

            for ($i = 1; $i <= $total_pager; $i++) {
                $activeClass = $i === $page ? 'active' : '';
                echo "<li class='page-item {$activeClass}'><a class='page-link' href='search.php?key={$key}&page={$i}'>{$i}</a></li>";
            }

            if ($page < $total_pager) {
                echo "<li class='page-item'><a class='page-link' href='search.php?key={$key}&page={$next}'>Next</a></li>";
            } else {
                echo "<li class='page-item disabled'><a class='page-link'>Next</a></li>";
            }
        ?>
    </ul>
    <?php } ?>

    <?php require_once('./includes/footer.php'); ?>
</div>