<?php

    $tree = new \Classes\Tree();

    $depth_lelel = 2;
    $is_active = 0;

    if(isset($category['childs']) && count(array($category['childs'])) >= $depth_lelel) {
        foreach($category['childs'] as $child) {
            $is_active += count(array($child['childs'])) >= $depth_lelel ? 1 : -1;
        }
    }
?>

<li>
    <a href="#" class="js-category <?=$is_active >= $depth_lelel ? 'active' : ''; ?>" title="Delete"><?=$category['id']?></a>

    <?php if($category['childs']): ?>
        <ul>
            <?php $tree->categories_to_string($category['childs']); ?>
            <?php echo $tree->categories_to_string($category['childs']); ?>
            <?php if (count(array($category['childs'])) == 1) : ?>
            <li>
                <a href="#" data-parent="<?=$category['id']?>" class="js-add-category">
                    +
                </a>
            </li>
            <?php endif; ?>
        </ul>
    <?php else : ?>
        <ul>
            <?php for ($i=0; $i < 2 ; $i++) : ?>
            <li>
                <a href="#" data-parent="<?=$category['id']?>" class="js-add-category">
                    +
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
</li>