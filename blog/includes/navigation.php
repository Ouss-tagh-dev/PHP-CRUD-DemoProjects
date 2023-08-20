<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
    <a class="navbar-brand" href="http://localhost/course/blog/index.php" style="font-size: 22px">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php
            // Jointure entre categories et posts pour obtenir uniquement les catégories qui ont des posts
            $sql = "SELECT DISTINCT c.cat_id, c.cat_title 
                    FROM categories c
                    INNER JOIN posts p ON c.cat_id = p.post_cat_id
                    WHERE p.post_status = 'Publish'";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cat_id = $cat["cat_id"];
                $cat_title = $cat["cat_title"]; 
            ?>
            <li class="nav-item <?php echo $cat_id == $id ? 'active' : '' ?>">
                <a class="nav-link" href="http://localhost/course/blog/categories.php?id=<?php echo $cat_id; ?>">
                    <?php echo $cat_title; ?>
                </a>
            </li>
            <?php 
            } 
            ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="http://localhost/course/blog/search.php" method="POST">
            <input class="form-control mr-sm-2" name="val" style=" font-size: 14px" type="search" placeholder="Search"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>