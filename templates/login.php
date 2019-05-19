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
    <form class="form container <?= $classname; ?>" action="" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $form['email'] ?? ""; ?>">
            <span class="form__error">Введите e-mail</span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--last <?= $classname; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль"
                   value="<?= $form['password'] ?? ""; ?>">
            <span class="form__error">Введите пароль</span>
        </div>
        <div class="form__error form__error--bottom">
            <ul>
                <?php foreach ($errors as $err => $val): ?>
                    <li><strong><?= $dict[$err]; ?>:</strong> <?= $val; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>