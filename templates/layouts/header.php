<?php use App\Config\Helpers; ?>
<?php $user = $_SESSION['user'] ?? null; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>La Fruiterie Global Inventory</title>
    <link rel="stylesheet" href="<?= Helpers::url('/assets/css/style.css') ?>">
</head>
<body>
