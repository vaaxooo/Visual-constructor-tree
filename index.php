<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$tree = new \Classes\Tree();

include 'handles.php';

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Visual tree constructor</title>
</head>
<body>

<div class="container">
    <h1>Visual tree constructor</h1>

    <div class="tree">
        <ul class="js-categories">
            <?php if ($categories_html = $tree->get_categories_output()): ?>
                <?php echo $categories_html ?>
            <?php else: ?>
                <li>
                    <a href="#" data-parent="0" class="js-add-category">
                        +
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
