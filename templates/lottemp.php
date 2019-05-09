<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $item): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= htmlspecialchars($item['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <?php foreach ($advert as $key => $item): ?>
            <h2><?= $item['title']; ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?= htmlspecialchars($item['path']); ?>" width="730" height="548" alt="Сноуборд">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= htmlspecialchars($item['name']); ?></span>
                    </p>
                    <p class="lot-item__description"><?= htmlspecialchars($item['description']); ?></p>
                </div>
                <div class="lot-item__right">
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer <?php if (Show_time() <= 1): ?>timer--finishing <?php endif ?>">
                            <?= Show_time() ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= format_price(htmlspecialchars($item['start_price'])); ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span>12 000 р</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>


