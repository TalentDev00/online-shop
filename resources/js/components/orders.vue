<template>
    <section class="orders">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <router-link tag="li" :to="'/menu/orders/' + '3414244'" class="list__item">
                        <a href="" class="list__item__name">
                            <div class="order">
                                <div class="order__details">
                                    <p class="order__details__number">#3414244</p>
                                    <p class="order__details__price">5 612 ₽ (25 октября 2018)</p>
                                </div>
                                <div class="order__status order__status-inprocess">в обработке</div>
                            </div>
                        </a>
                    </router-link>
                    <router-link tag="li" :to="'/menu/orders/' + '3411988'" class="list__item">
                        <a href="" class="list__item__name">
                            <div class="order">
                                <div class="order__details">
                                    <p class="order__details__number">#3411988</p>
                                    <p class="order__details__price">2 559 ₽ (10 августа 2018)</p>
                                </div>
                                <div class="order__status order__status-complete">выполнен</div>
                            </div>
                        </a>
                    </router-link>
                </ul>
            </div>
        </div>
    </section>
</template>
