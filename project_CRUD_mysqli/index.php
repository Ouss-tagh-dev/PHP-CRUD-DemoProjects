<?php
session_start();
require_once('./includes/header.php');
if (!$link) {
    echo "You are not connected";
}
$errors = array();
if (isset($_POST["submit"])) {
    $user_name = $_POST["user_name"];
    $user_email = $_POST["user_email"];
    $user_password = $_POST["user_password"];
    if (empty($user_name)) {
        $errors['user_name'] = true;
    }
    if (empty($user_email)) {
        $errors['user_email'] = true;
    }
    if (empty($user_password)) {
        $errors['user_password'] = true;
    }
    if (count($errors) === 0) {
        $sql = "INSERT INTO users(user_name, user_email, user_password) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die('Query Failed');
        } else {
            mysqli_stmt_bind_param($stmt, 'sss', $user_name, $user_email, $user_password);
            mysqli_stmt_execute($stmt);
        }
    }
}

if (isset($_POST["delete"])) {
    $user_id = $_POST["del"];
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt  = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die('Query Failed');
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $_SESSION['deleteSuccess'] = "User deleted successfully!";
    }
}

?>
<div class="container mt-5 content">
    <?php if (isset($_SESSION['updateSuccess'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✓ <?php echo $_SESSION['updateSuccess']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['updateSuccess']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['deleteSuccess'])) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>🗑 <?php echo $_SESSION['deleteSuccess']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['deleteSuccess']); ?>
    <?php endif; ?>
    <form action="index.php" method="post">
        <div class="form-floating mb-3">
            <input type="text" class="form-control <?php echo (isset($errors['user_name']) && $errors['user_name']) ? 'is-invalid' : ''; ?>" id="userName" placeholder="Username" name="user_name">
            <label for="userName">Username<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control <?php echo (isset($errors['user_email']) && $errors['user_email']) ? 'is-invalid' : ''; ?>" id="userEmail" placeholder="Email" name="user_email">
            <label for="userEmail">Email<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control <?php echo (isset($errors['user_password']) && $errors['user_password']) ? 'is-invalid' : ''; ?>" id="UserPassword" placeholder="Password" name="user_password">
            <label for="UserPassword">Password<span class="text-danger">*</span></label>
        </div>

        <div>
            <input type="submit" name="submit" class="btn btn-success btn-block" value="Submit" />
        </div>
    </form>
    <div class="mt-5">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($link, "SELECT * FROM users");
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['user_email']; ?></td>
                        <td class="d-flex justify-content-around">
                            <form action="edit-user.php" method="post">
                                <input type="hidden" name="edi" value="<?= $row['user_id'] ?>" />
                                <input type="submit" class="btn btn-info btn-sm" value="edit" name="edit" />
                            </form>
                            <form action="index.php" method="post">
                                <input type="hidden" name="del" value="<?= $row['user_id'] ?>" />
                                <input type="submit" class="btn btn-danger btn-sm" value="delete" name="delete" />
                            </form>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once('./includes/footer.php') ?>