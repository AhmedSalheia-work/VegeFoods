<?php


namespace MVC\Controllers;


use MVC\Lib\Database\DatabaseHandler;

class DbController extends AbstractController
{
    public function defaultAction()
    {
        // DatabaseHandler::factory()->exec(
        //     'CREATE TABLE imgs(
        //         id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        //         imgPath VARCHAR(150) NOT NULL,
        //         description VARCHAR(150) NOT NULL
        //     );'
        // );

        // DatabaseHandler::factory()->exec(
        //     'CREATE TABLE users(
        //         id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        //         name VARCHAR(50) NOT NULL,
        //         user VARCHAR(150) NOT NULL unique ,
        //         birthday DATE NOT NULL,
        //         password VARCHAR(255) NOT NULL,
        //         role ENUM("admin","user") NOT NULL DEFAULT "user",
        //         img VARCHAR(30) NOT NULL DEFAULT "default.img.jpg",
        //         verified ENUM("n","y") NOT NULL DEFAULT "n",
        //         token VARCHAR(20) NOT NULL UNIQUE
        //     );'
        // );

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE data(
        //         id VARCHAR(30) NOT NULL PRIMARY KEY,
        //         data VARCHAR(150) NOT NULL
        //     );
        // ');
        // DatabaseHandler::factory()->exec('
        //     INSERT INTO data VALUES ("address","Palestine - Gaza - Khanyounis"),("user","ahmedsalheia.as@gmail.com"),("phone","+ 9705 9784 7916"),("facebook",""),("twitter",""),("instagram","")
        // ');

        // DatabaseHandler::factory()->exec('ALTER TABLE users ADD bio TEXT NOT NULL AFTER birthday;');
        // DatabaseHandler::factory()->exec('ALTER TABLE `users` CHANGE `token` `token` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;');
        // DatabaseHandler::factory()->exec('
        //     create table tokens(
        //         userId INT NOT NULL,
        //         token VARCHAR(30) NOT NULL UNIQUE ,
        //         FOREIGN KEY (userId) REFERENCES users(id),
        //         PRIMARY KEY (userId,token)
        //     );
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE messages(
        //         messageId INT PRIMARY KEY AUTO_INCREMENT,
        //         name VARCHAR(30) NOT NULL,
        //         email VARCHAR(30) NOT NULL,
        //         subject VARCHAR(100) NOT NULL,
        //         message TEXT NOT NULL
        // )');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE feedbacks(
        //         id INT PRIMARY KEY AUTO_INCREMENT,
        //         userId INT NOT NULL,
        //         feedback TEXT NOT NULL,
        //         FOREIGN KEY (userId) REFERENCES users(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     ALTER TABLE `users` ADD `job` VARCHAR(30) NOT NULL AFTER `bio`;
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE langTableNames(
        //         table_for VARCHAR(2) NOT NULL PRIMARY KEY,
        //         en VARCHAR(20) NOT NULL UNIQUE,
        //         ar VARCHAR(20) NOT NULL UNIQUE
        //     )');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE Categories(
        //         id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        //         en_catagory VARCHAR(20) NOT NULL UNIQUE,
        //         ar_catagory VARCHAR(20) NOT NULL UNIQUE
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO langTableNAmes VALUES ("product_names","enproducts","arproducts")
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO Categories VALUES (NULL,"Vegetables","خضراوات"),(NULL,"Fruits","فواكه"),(NULL,"Juice","عصائر"),(NULL,"Dried","مجفف")
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE products(
        //         id INT PRIMARY KEY AUTO_INCREMENT,
        //         img VARCHAR(30) UNIQUE NOT NULL,
        //         price FLOAT NOT NULL
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE enproducts(
        //         prodId INT PRIMARY KEY NOT NULL,
        //         name VARCHAR(30) NOT NULL UNIQUE,
        //         description TEXT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE arproducts(
        //         prodId INT PRIMARY KEY NOT NULL,
        //         name VARCHAR(30) NOT NULL UNIQUE,
        //         description TEXT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE prod_cat(
        //         prodId INT NOT NULL,
        //         cateId INT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id),
        //         FOREIGN KEY (cateId) REFERENCES Categories(id),
        //         PRIMARY KEY (prodId,cateId)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE sizes(
        //         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        //         en_size VARCHAR(30) NOT NULL UNIQUE ,
        //         ar_size VARCHAR(30) NOT NULL UNIQUE
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE prod_size(
        //         prodId INT NOT NULL,
        //         sizeId INT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id),
        //         FOREIGN KEY (sizeId) REFERENCES sizes(id),
        //         PRIMARY KEY (prodId,sizeId)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE discount(
        //         id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        //         discount INT NOT NULL,
        //         discount_type ENUM("%","$") NOT NULL,
        //         end_time DATETIME DEFAULT NOW()
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE prod_disc(
        //         prodId INT NOT NULL PRIMARY KEY,
        //         discId INT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id),
        //         FOREIGN KEY (discId) REFERENCES discount(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO products VALUES (NULL,"product-1.jpg",120.00),(NULL,"product-2.jpg",120.00),(NULL,"product-3.jpg",120.00),(NULL,"product-4.jpg",120.00),(NULL,"product-5.jpg",120.00),(NULL,"product-6.jpg",120.00),(NULL,"product-7.jpg",120.00),(NULL,"product-8.jpg",120.00),(NULL,"product-9.jpg",120.00),(NULL,"product-10.jpg",120.00),(NULL,"product-11.jpg",120.00),(NULL,"product-12.jpg",120.00);
        // ');

        DatabaseHandler::factory()->exec('
            INSERT INTO discount VALUES (1,30,"%",""),(2,30,"$","");
        ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO sizes VALUES (NULL,"small","صغير"),(NULL,"meduim","متوسط"),(NULL,"large","كبير"),(NULL,"extra large","كبير جدا");
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO enproducts(prodId, name, description) VALUES
        //     ("1","Bell Pepper","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("2","Strawberry","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("3","Green Beans","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("4","Purple Cabbage","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("5","Tomatoe","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("6","Brocolli","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("7","Carrots","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("8","Fruit Juice","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("9","Bell Onion","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("10","Apple","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("11","Garlic","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until."),
        //     ("12","Chilli","A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until.");
        // ');


        // DatabaseHandler::factory()->exec('
        //     INSERT INTO arproducts(prodId, name, description) VALUES
        //     ("1","فلفل حلو","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("2","فراولة","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("3","فاصوليا خضراء","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("4","الملفوف الأرجواني","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("5","طماطم","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("6","بروكلي","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("7","جزر","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("8","عصير فواكه","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("9","جرس البصل","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("10","تفاح","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("11","ثوم","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى."),
        //     ("12","الفلفل","يتدفق نهر صغير يدعى Duden من مكانه ويزوده بال Regelialia الضروري. إنها دولة جنة ، حيث تطير أجزاء من الجمل المحمصة في فمك. يجب أن يستدير النص ويعود إلى بلده الآمن. لكن لا شيء تقوله النسخة لا يمكن أن يقنعها ولم تستغرق وقتًا طويلاً حتى.");
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO sizes VALUES (1,1),(1,2),(1,3),(1,4);
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO prod_cat(prodId, cateId) VALUES
        //         (1,1),(2,1),(3,1),
        //         (4,2),(5,2),(6,2),
        //         (7,3),(8,3),(9,3),
        //         (10,4),(11,4),(12,4),
        //         (1,3),(2,4),(3,2),
        //         (4,4),(5,3),(6,1),
        //         (7,2),(8,4),(9,1),
        //         (10,2),(11,1),(12,3);
        // ');

        // DatabaseHandler::factory()->exec('
        //     INSERT INTO prod_disc(prodId, discId) VALUES (1,1),(4,1),(7,1),(10,1),(5,2);
        // ');
        // DatabaseHandler::factory()->exec('
        //     ALTER TABLE prod_disc ADD end_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER discId;
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE cart(
        //         id INT PRIMARY KEY AUTO_INCREMENT,
        //         userId INT NOT NULL,
        //         FOREIGN KEY (userId) REFERENCES users(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE cart_prod(
        //         id INT NOT NULL AUTO_INCREMENT,
        //         cartId INT NOT NULL,
        //         prodId INT NOT NULL,
        //         sizeId INT NOT NULL DEFAULT 1,
        //         quantity INT NOT NULL DEFAULT 1,
        //         FOREIGN KEY (cartId) REFERENCES cart(id),
        //         FOREIGN KEY (prodId) REFERENCES products(id),
        //         FOREIGN KEY (sizeId) REFERENCES sizes(id),
        //         PRIMARY KEY (id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE wishlist(
        //         id INT PRIMARY KEY AUTO_INCREMENT,
        //         userId INT NOT NULL,
        //         FOREIGN KEY (userId) REFERENCES users(id)
        //     )
        // ');

        // DatabaseHandler::factory()->exec('
        //     CREATE TABLE wish_prod(
        //         wishId INT NOT NULL,
        //         prodId INT NOT NULL,
        //         FOREIGN KEY (prodId) REFERENCES products(id),
        //         FOREIGN KEY (wishId) REFERENCES wishlist(id),
        //         PRIMARY KEY (wishId,prodId)
        //     )
        // ');
    }


}