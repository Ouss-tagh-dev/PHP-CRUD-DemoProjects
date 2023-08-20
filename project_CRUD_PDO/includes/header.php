<!DOCTYPE html>
<html lang="en">
<?php require_once('./includes/db.php') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User CRUD App</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        flex: 1 0 auto;
    }

    .footer {
        flex-shrink: 0;
    }
    </style>
</head>

<body>