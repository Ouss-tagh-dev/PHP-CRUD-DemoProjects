<?php require_once('./includes/header.php') ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}
?>


<div class="c fluid-container">
    <?php require_once('./includes/navigation.php') ?>
    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <form action="categories.php" method="POST" class="py-4">
            <button type="submit" class="btn btn-secondary btn-block mt-3 
                <?= isset($_POST['add_cat']) ? 'd-none' : ''  ?>" name="add_cat">Add Category</button>
        </form>
        <?php
        if (isset($_POST['add_new_cat'])) {
            $errors = [];
            $cat_title =  $_POST['cat_title'];
            if (empty($cat_title)) {
                echo "<div class='mt-3 alert alert-danger'>Field can't be blank!</div>";
                $errors['cat_title'] = true;
            } else {
                $sql = "INSERT INTO categories(cat_title) VALUES(:title)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':title' => $cat_title]);
                header("Location: categories.php");
            }
        }
        ?>
        <?php if (isset($_POST['add_cat'])) { ?>
        <form action="categories.php" method="POST" class="py-4">
            <div class=" row">
                <div class="col">
                    <input type="text" name="cat_title"
                        class="form-control <?= (isset($errors['cat_title']) && $errors['cat_title']) ? 'is-invalid' : ''; ?>"
                        placeholder="Enter category name">
                </div>
                <div class="col">
                    <input type="submit" name="add_new_cat" class="form-control btn btn-secondary"
                        value="Add New Category">
                </div>
            </div>
        </form>
        <?php } ?>
        <?php
        if (isset($_POST['delete_cat'])) {
            $id = $_POST['val_delete'];
            $sql_delete = "DELETE FROM categories WHERE cat_id=:c_id";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->execute([':c_id' => $id]);
            header("Location: categories.php");
        }
        ?>
        <?php
        if (isset($_POST['update_cat'])) {
            $errors = [];
            $id = $_POST['val_update'];
            $c_title =  $_POST['cat_title'];
            if (empty($c_title)) {
                echo "<div class='mt-3 alert alert-danger'>Field can't be blank!</div>";
                $errors['cat_title'] = true;
            } else {
                $sql_update = "UPDATE categories SET cat_title=:title WHERE cat_id=:c_id";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->execute([':title' => $c_title, ':c_id' => $id]);
                header("Location: categories.php");
            }
        } ?>
        <?php
        if (isset($_POST['edit_cat'])) {
            $id = $_POST['val_edit'];
            $sql_edit = "SELECT * FROM categories WHERE cat_id = :id";
            $stmt_edit = $pdo->prepare($sql_edit);
            $stmt_edit->execute([':id' => $id]);
            while ($cat = $stmt_edit->fetch(PDO::FETCH_ASSOC)) {
                $cat_title = $cat['cat_title'];
            }
        ?> <form action="categories.php" method="POST" class="py-4">
            <div class=" row">
                <input type="hidden" value="<?= $id ?>" name="val_update">
                <div class="col">
                    <input type="text" name="cat_title" value="<?= $cat_title ?>"
                        class="form-control <?= (isset($errors['cat_title']) && $errors['cat_title']) ? 'is-invalid' : ''; ?>"
                        placeholder="Enter category name">
                </div>
                <div class="col">
                    <input type="submit" name="update_cat" class="form-control btn btn-primary" value="Update Category">
                </div>
            </div>
        </form>
        <?php } ?>
        <h2>All Categories</h2>
        <table class="table text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category name</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM categories";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cat_id = $cat['cat_id'];
                    $cat_title = $cat['cat_title']; ?>
                <tr>
                    <th>
                        <?= $cat_id ?>
                    </th>
                    <td><?= $cat_title ?></td>
                    <td>
                        <form action="categories.php" method="POST">
                            <input type="hidden" value="<?= $cat_id ?>" name="val_edit">
                            <input type="submit" class="btn btn-success btn-sm" name="edit_cat" value="Edit">
                        </form>
                    </td>
                    <td>
                        <form action="categories.php" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                            <input type="hidden" value="<?= $cat_id ?>" name="val_delete">
                            <input type="submit" class="btn btn-danger btn-sm" name="delete_cat" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>

</div>
<?php require_once('./includes/footer.php') ?>