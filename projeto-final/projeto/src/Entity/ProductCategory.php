<?php

namespace Code\Entity;

use Code\DB\Entity;

class ProductCategory extends Entity
{
    protected $table = 'categories_products';
    protected $timestamps = false;

    public function sync(int $productId, array $data)
    {
        $this->delete(['products_id' => $productId]);

        foreach ($data as $d) {
            $saveManyToMany = [
                'products_id' => $productId,
                'categories_id' => $d
            ];
            $this->insert($saveManyToMany);
        }
    }
}
