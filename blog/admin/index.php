<?php require_once('./includes/header.php') ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}
?>
<?php 
if (isset($_POST['delete-post'])) {
    $p_id = $_POST['val'];
    
    $sql_image = "SELECT post_image FROM posts WHERE post_id = :id";
    $stmt_image = $pdo->prepare($sql_image);
    $stmt_image->execute([':id' => $p_id]);
    $post_image = $stmt_image->fetchColumn();
    
    $sql_delete = "DELETE FROM posts WHERE post_id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([':id' => $p_id]);
    
    if ($post_image && file_exists("../img/" . $post_image)) {
        unlink("../img/" . $post_image);
    }
}
?>

<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>


    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Posts</h2>
            <a class="btn btn-secondary align-self-center d-block" href="new-post.php">Add New Post</a>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Post Title</th>
                    <th scope="col">Post Category</th>
                    <th scope="col">Post Status</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM posts";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count == 0) {
                    echo "<tr ><td class='text-center' colspan='7'>No post found!</td></tr>";
                } else {
                    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $post_id = $post['post_id'];
                        $post_title = $post['post_title'];
                        $post_cat_id = $post['post_cat_id'];
                        $post_status = $post['post_status'];
                        $post_comment = $post['post_comment'];

                ?>
                <tr>
                    <th><?= $post_id ?></th>
                    <td><?= $post_title ?></td>
                    <td>
                        <?php
                                $sql_cat = "SELECT * FROM categories WHERE cat_id = :post_cat_id";
                                $stmt_cat = $pdo->prepare($sql_cat);
                                $stmt_cat->execute(['post_cat_id' => $post_cat_id]);
                                while ($cat = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                                    $cat_title =  $cat['cat_title'];
                                }
                                echo $cat_title;
                                ?>
                    </td>

                    <td><?= $post_status ?></td>
                    <td class="d-none d-md-table-cell">
                        <a href="comments.php?id= <?= $post_id ?>">
                            <?= $post_comment ?>
                        </a>
                    </td>
                    <td>
                        <form action="edit-post.php" method="POST">
                            <input type="hidden" value="<?= $post_id ?>" name="val">
                            <input type="submit" class="btn btn-success btn-sm" name="update-post" value="Edit">
                        </form>
                    </td>
                    <td>
                        <form action="index.php" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?')">
                            <input type="hidden" value="<?= $post_id ?>" name="val">
                            <input type="submit" class="btn btn-danger btn-sm" name="delete-post" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php }
                }
                ?>

            </tbody>
        </table>

    </section>

    <!-- <ul class="pagination px-lg-5">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
            <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul> -->

</div>
<?php require_once('./includes/footer.php') ?>