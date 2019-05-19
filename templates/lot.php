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
                        <img src="<?= $item['path']; ?>" width="730" height="548" alt="Сноуборд">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $item['name']; ?></span>
                    </p>
                    <p class="lot-item__description"><?= $item['description']; ?></p>
                </div>
                <div class="lot-item__right">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="lot-item__state">
                            <div class="lot-item__timer timer <?php if (Show_time() <= 1): ?>timer--finishing <?php endif ?>">
                                <?= Show_time() ?>
                            </div>
                            <div class="lot-item__cost-state">
                                <div class="lot-item__rate">
                                    <span class="lot-item__amount">Текущая цена</span>
                                    <span class="lot-item__cost"><?= format_price($item['start_price']); ?></span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span><?= ($item['start_price'] + $item['step']); ?></span>
                                </div>
                            </div>
                            <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post"
                                  autocomplete="off">
                                <p class="lot-item__form-item form__item form__item--invalid">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="cost" placeholder="12 000">
                                    <span class="form__error">Введите наименование лота</span>
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>


