<?php

$tree = new \Classes\Tree();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'add_cat':
            if (!$tree->add_cat($_POST['parent'])) {
                http_response_code(500);
                exit;
            }
            echo $tree->get_categories_output();
            break;
        case 'del_cat':
            if (!$tree->del_cat($_POST['id'])) {
                http_response_code(500);
                exit;
            }
            echo $tree->get_categories_output();
            break;
    }
    exit;
}
