<?php require_once('./includes/header.php') ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}
?>

<div class="fluid-container">
    <?php require_once('./includes/navigation.php') ?>

    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
        <h2 class="pb-3">Add New Post</h2>
        <?php
        if (isset($_POST['submit'])) {
            $errors = [];

            $post_title = trim($_POST['post_title']);
            $post_cat_id = trim($_POST['cat_id']);
            $post_status = trim($_POST['post_status']);
            $post_des = trim($_POST['post_des']);

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
            if (empty($_FILES['post_image'])) {
                $errors['post_image'] = true;
            }

            // Check if the file is an image by verifying its MIME type
            $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];
            if (!in_array($_FILES['post_image']['type'], $allowed_image_types)) {
                $errors['post_image_type'] = 'Invalid image type!';
            }

            if (empty($errors)) {
                $post_date = date('j F Y');
                $post_author = "Oussama";
                $post_image = $_FILES['post_image']['name'];
                $post_temp_image = $_FILES['post_image']['tmp_name'];
                move_uploaded_file($post_temp_image, "../img/" . $post_image);
                $sql = "INSERT INTO posts(post_title, post_des, post_image, post_date, post_author, post_cat_id, post_status) 
        VALUES(:title, :des, :image, :date, :author, :cat_id, :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(
                    [
                        ':title' => $post_title,
                        ':des' => $post_des,
                        ':image' => $post_image,
                        ':date' => $post_date,
                        ':author' => $post_author,
                        ':cat_id' => $post_cat_id,
                        ':status' => $post_status
                    ]
                );
                echo '<div class="alert alert-success" role="alert">
        <strong>✓</strong> Post created successfully! <a href="index.php">go back</a></div>';
            }
        }
        ?>


        <form method="POST" action="new-post.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="post-title">Post
                    Title</label>
                <input type="text" name="post_title"
                    class="form-control <?php echo (isset($errors['post_title']) && $errors['post_title']) ? 'is-invalid' : ''; ?>"
                    id="post-title" placeholder="Enter post title">
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
                        echo "<option value=" . $cat_id . ">" . $cat_title . "</option>";
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
                    <option value="Publish">Publish</option>
                    <option value="Draft">Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label for="post-image">Upload post image</label>
                <input name="post_image"
                    class="form-control <?php echo (isset($errors['post_image']) && $errors['post_image']) ? 'is-invalid' : ''; ?>"
                    type="file" id="formFile">
                <span
                    class="text-danger"><?php echo isset($errors['post_image_type']) ? $errors['post_image_type'] : ''; ?>
                </span>


            </div>
            <div class="form-group">
                <label for="post-content">Post Content</label>
                <textarea
                    class="form-control <?php echo (isset($errors['post_des']) && $errors['post_des']) ? 'is-invalid' : ''; ?>"
                    id="post-content" name="post_des" rows="6" placeholder="Your post content"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>

</div>
<?php require_once('./includes/footer.php') ?>