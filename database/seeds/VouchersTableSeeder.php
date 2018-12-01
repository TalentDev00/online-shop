<?php

use Illuminate\Database\Seeder;

class VouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        App\Models\Voucher::create([
            'name' => 'Акция 20%',
            'image' => $faker->image(resource_path('images'), 400, 400, null, false),
            'description' =>
                '
                    <h2>Скида&nbsp;20% на&nbsp;первый заказ при установке приложения</h2>
                    <p>
                        Скидка&nbsp;20% на&nbsp;первый заказ для тех, кто впервые скачивает приложение! А&nbsp;что дальше? Дальше еще интереснее) Продолжайте делать заказы и&nbsp;удерживайте скидку 20%. Угощайте всех: тех, кто ждет дома, кто приглашает в&nbsp;гости, и&nbsp;тех, кто приходит к&nbsp;вам! Друзей, любимых и&nbsp;даже тех, кто случайно забежал на&nbsp;огонек!
                    </p>
                    <h2>Условия акции</h2>
                    <p>1. Срок действия: до&nbsp;30&nbsp;сентября 2018 года включительно.</p>
                    <p>2. Территория действия: Москва&nbsp;и Московская область.</p>
                    <p>3. В&nbsp;акции принимают участие заказы, сделанные с&nbsp;помощью мобильного приложения &laquo;Якитория&raquo;, доступного в&nbsp;App Store и&nbsp;Google Play.</p>
                    <p>4. Если вы&nbsp;новый пользователь*, сделайте первый заказ через приложение и&nbsp;получите скидку&nbsp;20%, автоматически став участником акции &laquo;-20% на&nbsp;доставку&raquo;.</p>
                    <p>5. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>6. Если вы&nbsp;не&nbsp;удержали скидку, совершите новый заказ и&nbsp;получите скидку&nbsp;20% уже&nbsp;на следующий заказ. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>7. Минимальная сумма заказа должна соответствовать условиям доставки: 990 рублей с&nbsp;учетом всех скидок. Подробности смотрите в&nbsp;разделе &laquo;Условия доставки&raquo;.</p>
                    <p>8. Действие акции распространяется в&nbsp;том числе на&nbsp;услугу &laquo;Самовывоз&raquo;, оформленную через мобильное приложение.</p>
                    <p>9. Скидки и&nbsp;подарки по&nbsp;акциям&nbsp;не суммируются. Действие других акций, проходящих в&nbsp;этот&nbsp;же период,&nbsp;не распространяются на&nbsp;заказы,&nbsp;участвующие&nbsp;в акции &laquo;-20% на&nbsp;доставку&raquo;.</p> 
                ',
            'type' => 1,
            'discount_amount' => 20,
            'is_fixed' => false,
        ]);

        App\Models\Voucher::create([
            'name' => 'На ВСЁ 30%!!!',
            'image' => $faker->image(resource_path('images'), 400, 400, null, false),
            'description' =>
                '
                    <h2>Скида&nbsp;20% на&nbsp;первый заказ при установке приложения</h2>
                    <p>
                        Скидка&nbsp;20% на&nbsp;первый заказ для тех, кто впервые скачивает приложение! А&nbsp;что дальше? Дальше еще интереснее) Продолжайте делать заказы и&nbsp;удерживайте скидку 20%. Угощайте всех: тех, кто ждет дома, кто приглашает в&nbsp;гости, и&nbsp;тех, кто приходит к&nbsp;вам! Друзей, любимых и&nbsp;даже тех, кто случайно забежал на&nbsp;огонек!
                    </p>
                    <h2>Условия акции</h2>
                    <p>1. Срок действия: до&nbsp;30&nbsp;сентября 2018 года включительно.</p>
                    <p>2. Территория действия: Москва&nbsp;и Московская область.</p>
                    <p>3. В&nbsp;акции принимают участие заказы, сделанные с&nbsp;помощью мобильного приложения &laquo;Якитория&raquo;, доступного в&nbsp;App Store и&nbsp;Google Play.</p>
                    <p>4. Если вы&nbsp;новый пользователь*, сделайте первый заказ через приложение и&nbsp;получите скидку&nbsp;20%, автоматически став участником акции &laquo;-20% на&nbsp;доставку&raquo;.</p>
                    <p>5. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>6. Если вы&nbsp;не&nbsp;удержали скидку, совершите новый заказ и&nbsp;получите скидку&nbsp;20% уже&nbsp;на следующий заказ. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>7. Минимальная сумма заказа должна соответствовать условиям доставки: 990 рублей с&nbsp;учетом всех скидок. Подробности смотрите в&nbsp;разделе &laquo;Условия доставки&raquo;.</p>
                    <p>8. Действие акции распространяется в&nbsp;том числе на&nbsp;услугу &laquo;Самовывоз&raquo;, оформленную через мобильное приложение.</p>
                    <p>9. Скидки и&nbsp;подарки по&nbsp;акциям&nbsp;не суммируются. Действие других акций, проходящих в&nbsp;этот&nbsp;же период,&nbsp;не распространяются на&nbsp;заказы,&nbsp;участвующие&nbsp;в акции &laquo;-20% на&nbsp;доставку&raquo;.</p> 
                ',
            'type' => 1,
            'discount_amount' => 30,
            'is_fixed' => false,
        ]);

        App\Models\Voucher::create([
            'name' => '10% на сундуки!',
            'image' => $faker->image(resource_path('images'), 400, 400, null, false),
            'description' =>
                '
                    <h2>Скида&nbsp;20% на&nbsp;первый заказ при установке приложения</h2>
                    <p>
                        Скидка&nbsp;20% на&nbsp;первый заказ для тех, кто впервые скачивает приложение! А&nbsp;что дальше? Дальше еще интереснее) Продолжайте делать заказы и&nbsp;удерживайте скидку 20%. Угощайте всех: тех, кто ждет дома, кто приглашает в&nbsp;гости, и&nbsp;тех, кто приходит к&nbsp;вам! Друзей, любимых и&nbsp;даже тех, кто случайно забежал на&nbsp;огонек!
                    </p>
                    <h2>Условия акции</h2>
                    <p>1. Срок действия: до&nbsp;30&nbsp;сентября 2018 года включительно.</p>
                    <p>2. Территория действия: Москва&nbsp;и Московская область.</p>
                    <p>3. В&nbsp;акции принимают участие заказы, сделанные с&nbsp;помощью мобильного приложения &laquo;Якитория&raquo;, доступного в&nbsp;App Store и&nbsp;Google Play.</p>
                    <p>4. Если вы&nbsp;новый пользователь*, сделайте первый заказ через приложение и&nbsp;получите скидку&nbsp;20%, автоматически став участником акции &laquo;-20% на&nbsp;доставку&raquo;.</p>
                    <p>5. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>6. Если вы&nbsp;не&nbsp;удержали скидку, совершите новый заказ и&nbsp;получите скидку&nbsp;20% уже&nbsp;на следующий заказ. Удерживайте скидку&nbsp;20%, делая повторные заказы не&nbsp;позднее 10&nbsp;дней от&nbsp;каждого предыдущего. Отсчет начинается со&nbsp;дня оформления заказа.**</p>
                    <p>7. Минимальная сумма заказа должна соответствовать условиям доставки: 990 рублей с&nbsp;учетом всех скидок. Подробности смотрите в&nbsp;разделе &laquo;Условия доставки&raquo;.</p>
                    <p>8. Действие акции распространяется в&nbsp;том числе на&nbsp;услугу &laquo;Самовывоз&raquo;, оформленную через мобильное приложение.</p>
                    <p>9. Скидки и&nbsp;подарки по&nbsp;акциям&nbsp;не суммируются. Действие других акций, проходящих в&nbsp;этот&nbsp;же период,&nbsp;не распространяются на&nbsp;заказы,&nbsp;участвующие&nbsp;в акции &laquo;-20% на&nbsp;доставку&raquo;.</p> 
                ',
            'type' => 1,
            'discount_amount' => 10,
            'is_fixed' => false,
        ]);

        App\Models\Voucher::create([
            'code' => 'test',
            'name' => '500 рублей',
            'description' => '500 рублей на всё',
            'max_uses_user' => 1,
            'type' => 2,
            'discount_amount' => 500,
            'is_fixed' => true,
        ]);


        App\Models\Voucher::create([
            'code' => 'percent',
            'name' => '10% скидка ',
            'description' => '10% на всё',
            'max_uses_user' => 1,
            'type' => 2,
            'discount_amount' => 10,
            'is_fixed' => false,
        ]);
    }
}