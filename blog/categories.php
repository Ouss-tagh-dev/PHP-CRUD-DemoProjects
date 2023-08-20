<?php 
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: http://localhost/course/blog/index.php");
    exit();
}
require_once('./includes/header.php') ?>

<div class="c fluid-container">
    <?php require_once('./includes/navigation.php'); ?>

    <?php
    $post_per_page = 2;
    $status = "Publish";

    $sql_p = "SELECT * FROM posts WHERE post_cat_id = :id AND post_status = :status";
    $stmt_p = $pdo->prepare($sql_p);
    $stmt_p->execute([
        ':id' => $_GET['id'],
        ':status' => $status
    ]);
    $post_count = $stmt_p->rowCount();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $page_id = ($page - 1) * $post_per_page;
    $total_pager = ceil($post_count / $post_per_page);
    ?>

    <section id="main" class="mx-5">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM categories WHERE cat_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                echo "<div class='text-center mt-5 alert alert-danger'>Page not found!</div>";
                exit();
            } else {
                $cat = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<h2 class='my-3'>Category: {$cat['cat_title']}</h2>";
            }
        }

        $sql_p = "SELECT * FROM posts WHERE post_cat_id = :post_cat_id LIMIT $page_id, $post_per_page";
        $stmt_p = $pdo->prepare($sql_p);
        $stmt_p->execute([':post_cat_id' => $id]);
        while ($post = $stmt_p->fetch(PDO::FETCH_ASSOC)) {
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
            <img class="col col-lg-4 col-md-12" src="./img/<?php echo $post_image ?>" alt="Image">
            <div class="media-body col col-lg-8 col-md-12">
                <h5 class="mt-0"><a href="http://localhost/course/blog/single.php?id=<?php echo  $post_id ?>"">
                        <?php echo $post_title ?>
                    </a></h5>
                <span class=" posted"><a
                            href="http://localhost/course/blog/categories.php?id=<?php echo $post_cat_id ?>"
                            class="category">
                            <?php echo $cat['cat_title']; ?>
                        </a> Posted by <?php echo $post_author ?> at <?php echo $post_date ?> </span>
                        <p>
                            <p><?php echo substr($post_des, 0, 250) . "..."; ?></p>

                        </p>
                        <span><a href="http://localhost/course/blog/single.php?id=<?php echo $post_id ?>"
                                class="d-block">See
                                more &rarr;</a></span>
            </div>
        </div>
        <?php
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
            echo "<li class='page-item'><a class='page-link' href='categories.php?id={$id}&page={$prev}'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><a class='page-link'>Previous</a></li>";
        }

        for ($i = 1; $i <= $total_pager; $i++) {
            $activeClass = $i === $page ? 'active' : '';
            echo "<li class='page-item {$activeClass}'><a class='page-link' href='categories.php?id={$id}&page={$i}'>{$i}</a></li>";
        }

        if ($page < $total_pager) {
            echo "<li class='page-item'><a class='page-link' href='categories.php?id={$id}&page={$next}'>Next</a></li>";
        } else {
            echo "<li class='page-item disabled'><a class='page-link'>Next</a></li>";
        }
        ?>
    </ul>
    <?php
    }
    ?>

    <?php require_once('./includes/footer.php'); ?>
</div>