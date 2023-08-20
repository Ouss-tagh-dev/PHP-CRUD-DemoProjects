<?php require_once('./includes/header.php') ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}
?>
<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Comments</h2>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User name</th>
                    <th scope="col">Comment</th>
                    <th scope="col" class="d-none d-md-table-cell">In response to</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_cmnt = "SELECT * FROM comments";
                $stmt_cmnt = $pdo->prepare($sql_cmnt);
                $stmt_cmnt->execute();
                while ($cmt = $stmt_cmnt->fetch(PDO::FETCH_ASSOC)) {
                    $cmt_id = $cmt['comment_id'];
                    $cmt_author = $cmt['comment_author'];
                    $cmt_des = $cmt['comment_des'];
                    $cmt_post_id = $cmt['comment_post_id'];
                ?>
                <tr>
                    <td><?= $cmt_id ?></td>
                    <td><?= $cmt_author ?></td>
                    <td><?= $cmt_des ?></td>
                    <td class="d-none d-md-table-cell">
                        <?php
                            $sql_p_c = "SELECT * FROM posts WHERE post_id=:p_id";
                            $stmt_p_c = $pdo->prepare($sql_p_c);
                            $stmt_p_c->execute(['p_id' => $cmt_post_id]);
                            while ($post = $stmt_p_c->fetch(PDO::FETCH_ASSOC)) {
                                $post_title = $post['post_title'];

                            ?>
                        <a href="../single.php?id=<?= $cmt_post_id ?>"><?= $post_title ?></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                            if (isset($_POST['delete_cmnt'])) {
                                $cmnt_id = $_POST['val_delete'];
                                $sql_c_i = "SELECT * FROM comments WHERE comment_id = :cm_id";
                                $stmt_c_i = $pdo->prepare($sql_c_i);
                                $stmt_c_i->execute([':cm_id' => $cmnt_id]);
                                $cmt = $stmt_c_i->fetch(PDO::FETCH_ASSOC);
                                if ($cmt) {
                                    $comment_post_id = $cmt['comment_post_id'];
                                    $sql_cmt_del = "DELETE FROM comments WHERE comment_id=:cmnt_id";
                                    $stmt_cmt_d = $pdo->prepare($sql_cmt_del);
                                    $stmt_cmt_d->execute([':cmnt_id' => $cmnt_id]);
                                    $sql_upd_p = "UPDATE posts SET post_comment = post_comment - 1 WHERE post_id = :pid";
                                    $stmt_ipd_p = $pdo->prepare($sql_upd_p);
                                    $stmt_ipd_p->execute([':pid' => $comment_post_id]);
                                    header("Location: comments.php?id=" . $comment_post_id);
                                }
                            }
                            ?>

                        <form action="comments.php" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            <input type="hidden" value="<?= $cmt_id ?>" name="val_delete">
                            <input type="submit" class="btn btn-danger btn-sm" name="delete_cmnt" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php } ?>


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