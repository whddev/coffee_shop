-- =============================================
-- SETUP DATABASE - Toko Kopi Kawan
-- Jalankan file ini di phpMyAdmin atau MySQL CLI
-- mysql -u root -p < setup.sql
-- =============================================

CREATE DATABASE IF NOT EXISTS `kopi_kawan_db`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `kopi_kawan_db`;

-- ----------------------------
-- TABEL CATEGORIES
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug`       VARCHAR(50)  NOT NULL UNIQUE,
  `name`       VARCHAR(100) NOT NULL,
  `emoji`      VARCHAR(10)  NOT NULL DEFAULT '',
  `sort_order` TINYINT      NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`slug`, `name`, `emoji`, `sort_order`) VALUES
('white-milk', 'White-Milk Coffee', '☕', 1),
('black',      'Black Coffee',      '🖤', 2),
('non-coffee', 'Non Coffee',        '🍵', 3),
('tukudapan',  'Tukudapan',         '🍩', 4);

-- ----------------------------
-- TABEL MENUS
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id`  INT UNSIGNED NOT NULL,
  `name`         VARCHAR(150) NOT NULL,
  `description`  TEXT,
  `ingredients`  TEXT,
  `price`        INT UNSIGNED NOT NULL DEFAULT 0,
  `image`        VARCHAR(255) DEFAULT 'images/tuku_iced_coffee.png',
  `is_popular`   TINYINT(1)   NOT NULL DEFAULT 0,
  `is_available` TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `menus` (`category_id`,`name`,`description`,`ingredients`,`price`,`image`,`is_popular`,`is_available`) VALUES
-- White-Milk (category_id=1)
(1,'MINI KST','Kopi susu tetangga ukuran mini, pas untuk teman ngobrol singkat.','ESPRESSO + MILK + CREAMER + ARENGA SUGAR',18000,'images/tuku_iced_coffee.png',1,1),
(1,'KOPI SUSU TETANGGA','Kopi susu andalan Tuku yang legendaris, manis pas dengan aroma arenga.','ESPRESSO + MILK + CREAMER + ARENGA SUGAR',25000,'images/tuku_iced_coffee.png',1,1),
(1,'MOCHA','Perpaduan espresso dan coklat yang kaya rasa, sempurna di pagi hari.','ESPRESSO + CHOCOLATE + SUGAR + MILK',28000,'images/mocha_coffee.png',0,1),
(1,'CARAMEL','Sensasi karamel lembut berpadu espresso segar.','ESPRESSO + MILK + CARAMEL SAUCE',28000,'images/caramel_coffee.png',0,1),
(1,'LATTE','Espresso klasik dengan susu steamed yang creamy dan lembut.','ESPRESSO + COFFEE SHOT + MILK',30000,'images/latte_coffee.png',1,1),
(1,'CAPPUCINO','Espresso dengan milk foam yang tebal dan aroma khas.','ESPRESSO + MILK FOAM',28000,'images/tuku_hot_coffee.png',0,1),
(1,'KST NABATI','Kopi susu tetangga versi nabati, cocok untuk teman yang vegan.','ESPRESSO + OAT MILK + ARENGA SUGAR',30000,'images/kst_nabati.png',0,1),
-- Black (category_id=2)
(2,'KOPI HITAM TETANGGA','Kopi hitam khas Tuku dengan sentuhan gula aren yang memanjakan.','ESPRESSO + WATER + SUGAR',20000,'images/tuku_black_coffee.png',1,1),
(2,'LONG BLACK','Espresso double shot dengan air panas, kuat dan bold.','ESPRESSO + WATER',22000,'images/tuku_black_coffee.png',0,1),
(2,'ESPRESSO','Shot espresso murni, intens dan penuh karakter.','ESPRESSO',18000,'images/espresso.png',0,1),
(2,'KOPI FILTER PAGI','Single origin pour-over untuk memulai pagi dengan sempurna.','SINGLE ORIGIN BEANS',35000,'images/tuku_black_coffee.png',0,1),
(2,'KOPI FILTER SORE','Pour-over istimewa untuk menemani sore yang tenang.','SINGLE ORIGIN BEANS',35000,'images/tuku_black_coffee.png',0,1),
(2,'COLD DRIP SANTAI KELAPA JERUK','Cold drip segar dengan twist kelapa dan jeruk yang unik.','COLD DRIP + COCONUT + ORANGE',40000,'images/cold_drip.png',1,1),
-- Non-Coffee (category_id=3)
(3,'CHOCOLATE','Minuman coklat premium yang hangat dan menenangkan.','CHOCOLATE + MILK',25000,'images/chocolate.png',1,1),
(3,'EARL GREY MILK TEA','Teh earl grey dengan susu creamy dan aroma bunga bergamot.','EARL GREY TEA + MILK + MILK TEA POWDER + CREAMER',25000,'images/earlgrey.png',0,1),
(3,'REMON','Teh lemon segar yang menyegarkan di hari panas.','LEMON + TEA',22000,'images/remon.png',0,1),
(3,'S.K.M.J','Santan kelapa, madu, jahe — minuman tradisional penuh kehangatan.','COCONUT MILK + GINGER + HONEY + ANDALIMAN + ARENGA SUGAR',28000,'images/skmj.png',1,1),
(3,'GO-ES','Air kelapa segar dengan madu dan perasan jeruk nipis.','COCONUT WATER + HONEY + LIME',22000,'images/goes.png',0,1),
(3,'TEH JAVA','Teh Java asli dengan gula pandan yang menenangkan jiwa.','JAVA TEA + PANDAN SUGAR',20000,'images/java.png',0,1),
-- Tukudapan (category_id=4)
(4,'DONAT KAMPOENG','Donat kampung yang dibaluri gula putih, gurih dan manis.','TEPUNG + GULA + MINYAK',12000,'images/donat.png',1,1),
(4,'LUMPIA AYAM','Lumpia renyah dengan isian ayam dan sayuran segar.','AYAM + SAYURAN',15000,'images/lumpia.png',0,1),
(4,'TAHU SCHOTEL','Tahu schotel panggang dengan paduan telur dan keju.','TAHU + TELUR + KEJU',18000,'images/tahu.png',0,1),
(4,'DONAT COKELAT','Donat lembut berlapis cokelat premium yang bikin nagih.','TEPUNG + COKELAT',13000,'images/donat_cklt.png',1,1),
(4,'BOLU COKELAT','Bolu lembut dengan cokelat yang meleleh di mulut.','KUE + COKELAT',15000,'images/bolu_cklt.png',0,1),
(4,'BOLU WORTEL','Bolu wortel sehat yang lembut dan natural.','KUE + WORTEL',15000,'images/bolu_wortel.png',0,1),
(4,'MARTABAK COKELAT KACANG','Martabak manis dengan isian cokelat dan kacang berlimpah.','TEPUNG + COKELAT + KACANG',22000,'images/martabak_cklt.png',1,1),
(4,'MARTABAK KEJU GULA JAWA','Martabak dengan keju melted dan manisnya gula jawa.','TEPUNG + KEJU + GULA JAWA',25000,'images/martabak_keju.png',0,1),
(4,'KUKIS OATMEAL','Kukis renyah dengan oats dan kismis, camilan sehat.','OATS + KISMIS',10000,'images/kukis.png',0,1),
(4,'BOLU GULA AREN','Bolu dengan aroma khas gula aren yang harum dan manis alami.','KUE + GULA AREN',15000,'images/bolu_aren.png',0,1);

-- ----------------------------
-- TABEL ORDERS
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `session_id`   VARCHAR(128) NOT NULL,
  `customer_name` VARCHAR(100) DEFAULT NULL,
  `notes`        TEXT,
  `total_price`  INT UNSIGNED NOT NULL DEFAULT 0,
  `status`       ENUM('pending','confirmed','preparing','done','cancelled') NOT NULL DEFAULT 'pending',
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- TABEL ORDER ITEMS
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id`        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id`  INT UNSIGNED NOT NULL,
  `menu_id`   INT UNSIGNED NOT NULL,
  `menu_name` VARCHAR(150) NOT NULL,
  `price`     INT UNSIGNED NOT NULL,
  `qty`       TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `subtotal`  INT UNSIGNED NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`menu_id`)  REFERENCES `menus`(`id`)  ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
