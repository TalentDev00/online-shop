<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CatalogsTableSeeder::class,
            CategoriesTableSeeder::class,
            ImagesTableSeeder::class,
            PropertiesTableSeeder::class,
            VariantsTableSeeder::class,
            ValuesTableSeeder::class,
           // ProductsTableSeeder::class,
            ImagesProductsTableSeeder::class,
            ProductsPropertiesTableSeeder::class,
            ProductsVariantsTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            DeliveryMethodsTableSeeder::class,
            ShopInformationTableSeeder::class,
            DeliveryMethodsShopInformationTableSeeder::class,
            PaymentMethodsShopInformationTableSeeder::class,
            CatalogsShopInformationTableSeeder::class,
        ]);
    }
}
