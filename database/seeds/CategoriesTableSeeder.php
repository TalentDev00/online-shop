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
        factory(App\Models\Category::class, 12)->create();

        $catIds = App\Models\Category::pluck('id')->toArray();
        $categories = App\Models\Category::all();


       /* $categories->each(function($category) use($catIds) {
            $category->saveMany(factory(App\Models\Category::class, 15)
                ->create(['parent_id' => $category->id])
                ->each(function($category) {
                    $category->items()->saveMany(factory(App\Models\Item::class, 15))
                        ->create(['cat_id' => $category->id]);
                })
            );
        });*/


       /* $categories->each(function($category) use ($catIds) {
            $category->items()->saveMany(factory(App\Models\Item::class, 15))->create(['cat_id' => $category->id]);
        });*/

       //;

        $categories->each(function($category){
            $category->children()->saveMany(factory(App\Models\Category::class, 5)->states('children')->make());
        });

        //factory(App\Models\Category::class, 15)->states('children')->make();

        $allCats = App\Models\Category::all();

        $allCats->each(function($cat){
            $cat->items()->saveMany(factory(App\Models\Item::class, 15))
                ->create(['cat_id' => $cat->id]);
        });


    }
}

/*
 *
 * post eto category, a catalog eto user
 *
 * */
