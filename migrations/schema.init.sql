create table if not exists products
(
    id int auto_increment primary key,
    uuid  varchar(255) not null unique comment 'UUID товара',
    category  varchar(255) not null comment 'Категория товара',
    is_active tinyint default 1  not null comment 'Флаг активности (1 - активно, 0 - не активно)',
    name varchar(255) default '' not null comment 'Наименование товара',
    description text null comment 'Описание товара',
    thumbnail  varchar(255) null comment 'Ссылка на картинку',
    price float not null comment 'Цена'
)
    comment 'Товары';

create index category_idx on products (category);

-- Пример таблицы категории

-- create table if not exists categories
-- (
--     id int auto_increment primary key,
--     name varchar(255) default '' not null comment 'Наименование категории'
-- )
--     comment 'Категории';


-- ALTER TABLE products ADD category_id INT NOT NULL commnet 'категория товара';
-- ALTER TABLE products ADD CONSTRAINT products_categories_FK FOREIGN KEY (category_id) REFERENCES categories(id);
