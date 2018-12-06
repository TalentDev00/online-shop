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
            CategoriesTableSeeder::class,
            ImagesTableSeeder::class,
            ItemPropertiesTableSeeder::class,
            ItemVariantsTableSeeder::class,
            ItemVariantValuesTableSeeder::class,
            ImagesItemsTableSeeder::class,
            ItemsPropertiesTableSeeder::class,
            ItemsItemVariantsTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            DeliveryMethodsTableSeeder::class,
            ShopInformationTableSeeder::class,
            DeliveryMethodsShopInformationTableSeeder::class,
            PaymentMethodsShopInformationTableSeeder::class,
            CategoriesShopInformationTableSeeder::class,
            OrdersTableSeeder::class,
            CartItemsTableSeeder::class,
            CartItemsOrdersTableSeeder::class,
            CartItemsCartsTableSeeder::class,
            VouchersTableSeeder::class,
            ItemsVouchersTableSeeder::class,
            UsersVouchersTableSeeder::class,
            ShopInformationVouchersTableSeeder::class,
            //ItemsTableSeeder::class,
        ]);
    }
}
