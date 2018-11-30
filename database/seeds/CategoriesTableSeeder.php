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
       /* factory(App\Models\Category::class, 5)->create([
        ])->each(function($cat){
            $cat->save([
                'path' => $cat->generatePath()
            ]);
        });


        $catIds = App\Models\Category::pluck('id')->toArray();
        $categories = App\Models\Category::all();

        $categories->each(function($category){
            $category->children()->saveMany(factory(App\Models\Category::class, 3)->create([
                'parent_id' => $category->id,

            ])->each(function($category){
                $category->save([
                    'path' => $category->generatePath()
                ]);
            })
                ->each(function($cat) {
                $cat->children()->saveMany(factory(App\Models\Category::class, 2)->create([
                    'parent_id' => $cat->id,

                ])->each(function($cat){
                    $cat->save([
                        'path' => $cat->generatePath()
                    ]);
                })
                    ->each(function($c){
                    $c->children()->saveMany(factory(App\Models\Category::class, 1)->create([
                        'parent_id' => $c->id,

                    ])->each(function($c){
                        $c->save([
                            'path' => $c->generatePath()
                        ]);
                    })
                    );
                }));
            }));
        });


        $allCats = App\Models\Category::all();

        $allCats->each(function($cat){
            $cat->items()->saveMany(factory(App\Models\Item::class, 8))
                ->create(['cat_id' => $cat->id]);
        });*/

        factory(App\Models\Category::class, 5)->create();
        $categories = App\Models\Category::all();

        $categories->each(function($category){
            $category->children()->saveMany(factory(App\Models\Category::class, 3)->create([
                'parent_id' => $category->id,
            ])
                ->each(function($cat) {
                    $cat->children()->saveMany(factory(App\Models\Category::class, 2)->create([
                        'parent_id' => $cat->id,
                    ])
                        ->each(function($c){
                            $c->children()->saveMany(factory(App\Models\Category::class, 1)->create([
                                'parent_id' => $c->id,
                                ])
                            );
                        }));
                }));
        });


        $allCats = App\Models\Category::all();

        $allCats->each(function($cat){
            $cat->items()->saveMany(factory(App\Models\Item::class, 8))
                ->create(['cat_id' => $cat->id]);
        });





    }
}

/*
 *
 * post eto category, a catalog eto user
 *
 * */
