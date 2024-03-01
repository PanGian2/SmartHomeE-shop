<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Προϊόντα</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <ul id="productNav">
                <?php
                $p = new Product();
                $products = $p->getProductCategories();
                foreach ($products as $product) : ?>
                    <li><a href="<?php echo $viewsPath ?>products/product_category.php?category=<?php echo $product["_id"] ?>"><?php echo $product["_id"] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>