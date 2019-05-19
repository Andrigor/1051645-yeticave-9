<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $item): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $item['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form enctype="multipart/form-data" class="form form--add-lot container <?= $classname; ?>" action="/add.php"
          method="post">
        <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $classname = isset($errors['title']) ? "form__item--invalid" : "";
            $value = isset($lot['title']) ? $lot['title'] : ""; ?>
            <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота"
                       value="<?= $value; ?>">
                <span class="form__error">Введите наименование лота</span>
            </div>
            <?php $classname = isset($lot['category']) && $lot['category'] == 'Выберите категорию' ? "form__item--invalid" : ""; ?>
            <div class="form__item <?= $classname; ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $item): ?>
                        <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>
        <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
        $value = isset($lot['description']) ? $lot['description'] : ""; ?>
        <div class="form__item form__item--wide <?= $classname; ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $value; ?></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <div class="form__item form__item--file">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" name="lot_img" type="file" id="lot-img" value="">
                <label for="lot-img">
                    Добавить
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : "";
            $value = isset($lot['start_price']) ? $lot['start_price'] : ""; ?>
            <div class="form__item form__item--small <?= $classname; ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="start_price" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите начальную цену</span>
            </div>
            <?php $classname = isset($errors['step']) ? "form__item--invalid" : "";
            $value = isset($lot['step']) ? $lot['step'] : ""; ?>
            <div class="form__item form__item--small <?= $classname; ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="step" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>
            <?php $classname = isset($errors['closed_at']) ? "form__item--invalid" : "";
            $value = isset($lot['closed_at']) ? $lot['closed_at'] : ""; ?>
            <div class="form__item <?= $classname; ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="closed_at"
                       placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $value; ?>">
                <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
            <div class="form__error form__error--bottom">
                <ul>
                    <?php foreach ($errors as $err => $val): ?>
                        <li><strong><?= $dict[$err]; ?>:</strong> <?= $val; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>