<?php

namespace Classes;

use PDO;

class Tree extends DataBase {
    private $database;

    public function __construct()
    {
        $this->database = DataBase::connect();
    }

    /**
     * Get categories
     * @return array
     */
    public function get_cat(): array{
        $query = "SELECT * FROM categories ORDER BY id";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $arr_cat = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $arr_cat[$row['id']] = $row;
        }
        return $arr_cat;
    }

    /**
     * Generate TREE
     * @param $dataset
     * @return array
     */
    public function map_tree(array $dataset): array {
        $tree = [];
        foreach ($dataset as $id=>&$node) {
            if (!$node['parent']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['parent']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    /**
     * Generate tree line
     * @param $data
     * @return string
     */
    public function categories_to_string(array $data): string{
        $string = "";
        foreach($data as $item){
            $string .= $this->categories_to_template($item);
        }
        return $string;
    }

    /**
     * Render template
     * @param $category
     * @return false|string
     */
    public function categories_to_template(array $category): string{
        ob_start();
        include('tpl/category_template.php');
        return ob_get_clean();
    }

    /**
     * Get categories list
     * @return string
     */
    public function get_categories_output(): string{
        $categories = $this->get_cat();
        $categories_tree = $this->map_tree($categories);
        return $this->categories_to_string($categories_tree);
    }

    /**
     * Add category in database
     * @param $parent
     * @return bool
     */
    public function add_cat(int $parent): int {
        $parent = intval($parent);
        $query = "SELECT COUNT(*) as count FROM categories WHERE parent = $parent";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        if ($stmt->fetchAll(PDO::FETCH_ASSOC)['count'] >= 2) {
            return false;
        }
        $query = "INSERT INTO categories (parent) VALUES (?)";
        $this->database->prepare($query)->execute([$parent]);
        return $this->database->lastInsertId();
    }

    /**
     * Delete category from database
     * @param $category_id
     * @return bool
     */
    public function del_cat(int $category_id): bool{
        $category_id = intval($category_id);
        if(!$category_id) {
            return false;
        }
        $query = "SELECT id FROM categories WHERE parent = ?";
        $stmt = $this->database->prepare($query);
        $stmt->execute([$category_id]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->del_cat($row['id']);
        }
        $query = "DELETE FROM categories WHERE id = ? ";
        $this->database->prepare($query)->execute([$category_id]);
        return true;
    }


}