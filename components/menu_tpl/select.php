<option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>

<?php if ( isset($category['childs']) ): ?>
    <ul>
        <?= $this->getMenuHtml($category['childs']) ?>
    </ul>
<?php endif; ?>


