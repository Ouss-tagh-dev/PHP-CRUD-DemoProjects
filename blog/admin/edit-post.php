<?php require_once('./includes/header.php') ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
}

if (isset($_POST['val'])) {
    $p_id = $_POST['val'];
    $sql = "SELECT * FROM posts WHERE post_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $p_id]);
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $post_id = $post['post_id'];
        $post_title = $post['post_title'];
        $post_cat_id = $post['post_cat_id'];
        $post_status = $post['post_status'];
        $post_comment = $post['post_comment'];
        $post_image = $post['post_image'];
        $post_des = $post['post_des'];
    }
}
?>



<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
        <h2 class="pb-3">Edit Post</h2>
        <?php
        if (isset($_POST['submit-update'])) {
            $errors = [];
            $post_title = trim($_POST['post_title']);
            $post_cat_id = trim($_POST['cat_id']);
            $post_status = trim($_POST['post_status']);
            $post_des = trim($_POST['post_des']);
            
            $post_id = $_POST['edit_post_id'];
            $edit_post_id = $_POST['edit_post_id'];

            if (empty($post_title)) {
                $errors['post_title'] = true;
            }
            if (empty($post_cat_id)) {
                $errors['cat_id'] = true;
            }
            if (empty($post_status)) {
                $errors['post_status'] = true;
            }
            if (empty($post_des)) {
                $errors['post_des'] = true;
            }

            if (empty($errors)) {
                $post_date = date('j F Y');
                $post_author = "Oussama";
                $sql_old_image = "SELECT post_image FROM posts WHERE post_id = :id";
                $stmt_old_image = $pdo->prepare($sql_old_image);
                $stmt_old_image->execute([':id' => $edit_post_id]);
                $old_image = $stmt_old_image->fetchColumn();
                $post_image = $old_image;
                if (!empty($_FILES['post_image']['name'])) {
                    if (file_exists("../img/" . $old_image)) {
                        unlink("../img/" . $old_image);
                    }
                    $post_image = $_FILES['post_image']['name'];
                    $post_temp_image = $_FILES['post_image']['tmp_name'];
                    move_uploaded_file($post_temp_image, "../img/" . $post_image);
                }
                $sql = "UPDATE posts SET post_title=:title, post_des=:des, post_image=:image, post_date=:date, post_author=:author, post_cat_id=:cat_id, post_status=:status WHERE post_id=:edit_post_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(
                    [
                        ':title' => $post_title,
                        ':des' => $post_des,
                        ':image' => $post_image,
                        ':date' => $post_date,
                        ':author' => $post_author,
                        ':cat_id' => $post_cat_id,
                        ':status' => $post_status,
                        ':edit_post_id' => $edit_post_id
                    ]
                );

                echo
                '<div class="alert alert-success" role="alert">
        <strong>✓</strong>Post updated successfully!<a href="index.php">go back</a></div>';
            }
        }
        ?>
        <form action="edit-post.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_post_id" value="<?= $post_id ?>">
            <div class="form-group">
                <label for="post-title">Post Title</label>
                <input type="text" name="post_title"
                    class="form-control <?php echo (isset($errors['post_title']) && $errors['post_title']) ? 'is-invalid' : ''; ?>"
                    id="post-title" placeholder="Enter post title" value="<?= $post_title ?>">
            </div>
            <div class="form-group">
                <label for="category">Select Category</label>
                <select name="cat_id"
                    class="form-control <?php echo (isset($errors['cat_id']) && $errors['cat_id']) ? 'is-invalid' : ''; ?>"
                    id="category">
                    <option value="" hidden>Select Category</option>
                    <?php
                    $sql_c = "SELECT * FROM categories";
                    $stmt_c = $pdo->prepare($sql_c);
                    $stmt_c->execute();
                    while ($cat = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
                        $cat_id =  $cat['cat_id'];
                        $cat_title =  $cat['cat_title'];

                        $selected = ($cat_id == $post_cat_id) ? 'selected' : '';
                        echo "<option value=" . $cat_id . " " . $selected . ">" . $cat_title . "</option>";
                    }
                    ?>

                </select>
            </div>
            <div class="form-group">
                <label for="status">Post Status</label>
                <select name="post_status"
                    class="form-control <?php echo (isset($errors['post_status']) && $errors['post_status']) ? 'is-invalid' : ''; ?>"
                    id="status">
                    <option value="" hidden>Select Status</option>
                    <option value="Publish"
                        <?php echo (isset($post_status) && $post_status == 'Publish') ? 'selected' : ''; ?>>Published
                    </option>
                    <option value="Draft"
                        <?php echo (isset($post_status) && $post_status == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>
            <div class="form-group">
                <div class="align-items-center" style="width: 100px;height:100px">
                    <img class="img-fluid" src="../img/<?= $post_image ?>" alt=""> <br>

                </div>
                <label for="post-image">Upload post image</label>
                <input name="post_image"
                    class="form-control <?php echo (isset($errors['post_image']) && $errors['post_image']) ? 'is-invalid' : ''; ?>"
                    type="file" id="formFile">
            </div>
            <div class="form-group">
                <label for="post-content">Post Content</label>
                <textarea
                    class="form-control <?php echo (isset($errors['post_des']) && $errors['post_des']) ? 'is-invalid' : ''; ?>"
                    id="post-content" name="post_des" rows="6"
                    placeholder="Your post content"><?= $post_des ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit-update">Submit</button>
        </form>
    </section>

</div>
<?php require_once('./includes/footer.php') ?>