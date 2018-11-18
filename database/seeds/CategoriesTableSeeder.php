<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catIds = App\Models\Catalog::pluck('id')->toArray();
        $catalog = App\Models\Catalog::all();


        $catalog->each(function($catalog) use($catIds) {
            $catalog->categories()->saveMany(factory(App\Models\Category::class, 15)
                ->create(['parent_id' => $catalog->id])
                ->each(function($category) {
                    $category->products()->saveMany(factory(App\Models\Product::class, 15))
                        ->create(['cat_id' => $category->id]);
                })
              /*  ->each(function($category) use($catIds) {
                    $category->tags()->sync(array_random($catIds, mt_rand(2, 2)));
                })*/
            );
        });
    }
}

/*
 *
 * post eto category, a catalog eto user
 *
 * */
