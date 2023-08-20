<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: http://localhost/course/blog/index.php");
    exit();
}



require_once('./includes/header.php');
?>

<div class="fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <section id="main">
        <div class="post-single-information">

            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM posts WHERE post_id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $count = $stmt->rowCount();

                if ($count == 1) {
                    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $post_title = $post['post_title'];
                        $post_des = $post['post_des'];
                        $post_image = $post['post_image'];
                        $post_cat_id = $post['post_cat_id'];
                        $post_date = $post['post_date'];
                        $post_author = $post['post_author'];
            ?>

                        <div class="post-single-info">
                            <div class="post-single-80">
                                <h1 class="category-title">Category:
                                    <?php
                                    $sql_cat = "SELECT * FROM categories WHERE cat_id = :cat_id";
                                    $stmt_cat = $pdo->prepare($sql_cat);
                                    $stmt_cat->execute([':cat_id' => $post_cat_id]);
                                    while ($cat = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                                        $cat_title = $cat["cat_title"];
                                    }
                                    echo $cat_title;
                                    ?>
                                </h1>

                                <h2 class="post-single-title">Title: <?php echo $post_title ?></h2>

                                <div class="post-single-box">
                                    Posted by <?php echo $post_author ?> at <?php echo $post_date ?>
                                </div>
                            </div>
                        </div>

                        <div class="post-main">
                            <img class="d-block" style="width:100%;height:400px" src="img/<?php echo $post_image ?>" alt="photo" />
                            <p class="mt-4"><?php echo $post_des ?></p>
                        </div>

            <?php
                    }
                } else {
                    echo "<p class='container text-center mt-5 alert alert-danger'>Page not found!</p>";
                    exit();
                }
            }
            ?>

        </div>

        <div class="comments">

            <?php
            $sql_c = "SELECT * FROM comments WHERE comment_post_id = :post_id";
            $stmt_c = $pdo->prepare($sql_c);
            $stmt_c->execute(['post_id' => $id]);
            $comment_count = $stmt_c->rowCount();
            ?>

            <h2 class="comment-count"><?php echo  $comment_count ?> Comments</h2>

            <?php
            if ($comment_count == 0) {
                echo "No comment";
            } else {
                while ($comment = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
                    $comment_author = $comment['comment_author'];
                    $comment_des = $comment['comment_des'];
                    $comment_date = $comment['comment_date'];
            ?>

                    <div class="comment-box">
                        <img src="./img/unnamed.jpg" style="width:88px;height:88px;border-radius:50%" alt="Author photo" class="comment-photo">

                        <div class="comment-content">
                            <span class="comment-author"><b><?= $comment_author ?></b></span>
                            <span class="comment-date"><?= $comment_date ?></span>
                            <p class="comment-text"><?= $comment_des ?></p>
                        </div>
                    </div>

            <?php
                }
            }
            ?>

            <h3 class="leave-comment">Leave a comment</h3>

            <?php
            $errors = [];
            if (isset($_POST['submit-comment'])) {
                $name = trim($_POST['name']);
                $comment = trim($_POST['comment']);

                if (empty($name)) {
                    $errors['name'] = true;
                }

                if (empty($comment)) {
                    $errors['comment'] = true;
                }

                if (!$errors) {
                    $date = date('j F Y');
                    $sql_cm = "INSERT INTO comments(comment_des, comment_date, comment_author, comment_post_id) VALUES (:comment, :date, :author, :cp_id)";
                    $stmt_cm = $pdo->prepare($sql_cm);
                    $stmt_cm->execute([
                        ':comment' => $comment,
                        ':date' => $date,
                        ':author' => $name,
                        ':cp_id' => $id,
                    ]);

                    $commentAdded = false;

                    if ($stmt_cm) {
                        $sql_cm_p = "UPDATE posts SET post_comment = post_comment + 1 WHERE post_id = :id";
                        $stmt_cm_p = $pdo->prepare($sql_cm_p);
                        $stmt_cm_p->execute([':id' => $id]);
                        $commentAdded = true;
                    } else {
                        echo "<div class='alert alert-danger'>There was an error.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Please fill the form!</div>";
                }
            }
            ?>

            <?php
            if (isset($commentAdded) && $commentAdded) :
            ?>
                <script>
                    window.location.href = "single.php?id=<?php echo $id; ?>";
                </script>
            <?php
            endif;
            ?>


            <div class="comment-submit">
                <form action="http://localhost/course/blog/single.php?id=<?= $_GET['id'] ?>" method="POST" class="comment-form">
                    <input class="input <?php echo (isset($errors['name']) && $errors['name']) ? 'is-invalid' : ''; ?>" type="text" placeholder="Enter Full Name" name="name">
                    <textarea name="comment" class="<?php echo (isset($errors['comment']) && $errors['comment']) ? 'is-invalid' : ''; ?>" cols="20" rows="5" placeholder="Comment text"></textarea>
                    <input type="submit" name="submit-comment" value="Submit" class="comment-btn">
                </form>
            </div>
        </div>
    </section>

    <?php
    require_once('./includes/footer.php');
    ?>