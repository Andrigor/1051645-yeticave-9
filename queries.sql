
-- Добавление записей в таблицу "categories"

INSERT INTO categories (name, symbol)
VALUES
    ('Доски и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Ботинки', 'boots'),
    ('Одежда', 'clothing'),
    ('Инструменты', 'tools'),
    ('Разное', 'other');

-- Добавление записей в таблицу "users"

INSERT INTO users (email, name, password, avatar_path, contact)
VALUES
    ('vasyarogov@yandex.ru', 'Vasya Rogov', '3627909A29C31381A071EC27F7C9CA97726182AED29A7DDD2E54353322CFB30ABB9E3A6DF2AC2C20FE23436311D678564D0C8D305930575F60E2D3D048184D79', 'C:/Users/Vasya/Pictures/123.jpg', 'Moscow, Tverskaya str.'),
    ('ivanfrolov@google.com', 'Ivan Frolov', 'D3F7EDF14BF629708A2C58EC9ECD5EDE2B57372BB78852C60DE59E4631598F3BB8401B56771D306636B64AC0E62319405809FC89C31358F8FB26BDBB54E8CE72', 'C:/Users/Ivan/Pictures/rrr.jpg', 'Tver, Leninskiy pr.'),
    ('kolyapetrov@gmail.ru', 'Kolya Petrov', '0DCA9D45AFA2020153D7AA2EA09D6D98BE169677D876A96476993AC0A32B77F9E14A7A54CCF4A11D8CFBE48C5AD243BD172568E40588256E165ABB06CBB42A90', 'C:/Users/Kolya/Pictures/Me.jpg', 'Kolomna, Kozlova str.');

-- Добавление записей в таблицу "lot"

INSERT INTO lot (category_id, user_id, user_id_win, title, description, path, start_price, closed_at, step)
VALUES
    (1, 1, null, '2014 Rossignol District Snowboard', 'Good Snowboard', 'img/lot-1.jpg', 10999, null, 500),
    (1, 1, null, 'DC Ply Mens 2016/2017 Snowboard', 'Very expensive Snowboard', 'img/lot-2.jpg', 159999, null, 10000),
    (2, 2, null, 'Крепления Union Contact Pro 2015 года размер L/XL', 'Useful attachment', 'img/lot-3.jpg', 8000, null, 300),
    (3, 2, null, 'Ботинки для сноуборда DC Mutiny Charocal', 'Cool boots', 'img/lot-4.jpg', 10999, null, 500),
    (4, 2, null, 'Куртка для сноуборда DC Mutiny Charocal', 'Sports jacket', 'img/lot-5.jpg', 7500, null, 200),
    (6, 1, null, 'Маска Oakley Canopy', 'Super mask', 'img/lot-6.jpg', 5400, null, 100);

-- Добавление записей в таблицу "bet"

INSERT INTO bet (user_id, lot_id, bet_price)
VALUES
    (2, 1, 11499),
    (3, 1, 11999);

-- Получить все категории

SELECT * FROM categories;

-- Получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории

SELECT category_id, title, path, start_price, name, bet_price FROM lot l
JOIN categories c on l.category_id = c.id
LEFT JOIN bet b on l.id = b.lot_id
WHERE user_id_win IS NULL AND l.created_at BETWEEN SUBDATE(NOW(),1) AND NOW();

-- Показать лот по его id. Получите также название категории, к которой принадлежит лот

SELECT user_id, user_id_win, created_at, title, description, path, start_price, closed_at, step, name FROM lot l
JOIN categories c on l.category_id = c.id
WHERE l.id = 2;

-- Обновить название лота по его идентификатору

UPDATE lot SET title = '2014 Rossignol District Snowboard Updated'
WHERE id = 1;

-- Получить список самых свежих ставок для лота по его идентификатору

SELECT bet_price FROM bet b
JOIN lot l on b.lot_id = l.id
WHERE l.id = 1 AND b.created_at BETWEEN SUBDATE(NOW(),1) AND NOW();