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
    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container <?= $classname; ?>" action="" method="post" autocomplete="off"
          enctype="multipart/form-data">
        <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $form['email'] ?? ""; ?>">
            <span class="form__error">Введите e-mail</span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль"
                   value="<?= $form['password'] ?? ""; ?>">
            <span class="form__error">Введите пароль</span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $form['name'] ?? ""; ?>">
            <span class="form__error">Введите имя</span>
        </div>
        <?php $classname = isset($errors['message']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?= $classname; ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message"
                      placeholder="Напишите как с вами связаться"><?= $form['message'] ?? ""; ?></textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <div class="form__error form__error--bottom">
            <ul>
                <?php foreach ($errors as $err => $val): ?>
                    <li><strong><?= $dict[$err]; ?>:</strong> <?= $val; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="/pages/login.html">Уже есть аккаунт</a>
    </form>
</main>