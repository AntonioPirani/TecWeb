<?php

namespace App\Models;

use App\Models\Resources\Category;
use App\Models\Resources\Product;

class Catalog {

    public function getTopCats() {
        return Category::where('parId', 0)->get();
    }

    public function getCatsByParId($topId) {
        return Category::whereIn('parId', $topId)->get();
    }


}
