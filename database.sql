DROP DATABASE IF EXISTS culinary_book;
CREATE DATABASE culinary_book DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE culinary_book

CREATE TABLE recipes
(
	recipe_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    metadata_id INT NOT NULL,
    title VARCHAR(30),
    meal_id INT NULL,
    difficulty_id INT NOT NULL,
    portions INT,
    prepare_time TIME,
    ingredients_list_id INT,
    description_id INT NOT NULL, 
	accepted BOOLEAN
);
	 
CREATE TABLE recipes_metadatas
(
	metadata_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    add_date DATETIME,
    update_date DATETIME
);

CREATE TABLE ingredients_lists
(
	ingredients_list_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    ingredient VARCHAR(30) NOT NULL,
    how_many FLOAT NOT NULL,
    unit_id INT
);
CREATE INDEX ingredients_list_idIdx ON ingredients_lists(ingredients_list_id);

CREATE TABLE meals
(
	meal_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    meal VARCHAR(18)
);

CREATE TABLE recipes_categories
(
	recipe_id INT NOT NULL,
    category_id INT NOT NULL
);

CREATE TABLE categories
(
	category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(20)
);

CREATE TABLE difficulties
(
	difficulty_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    difficulty VARCHAR(12)
);

CREATE TABLE descriptions
(
	description_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	recipe_id INT NOT NULL,
    description VARCHAR(1000)
);
 
CREATE TABLE units
(
	unit_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    singular VARCHAR(15),
    plural_2pcs VARCHAR(15),
    plural_5pcs VARCHAR(15),
	shortcut VARCHAR(10),
	si_converse FLOAT
);

CREATE TABLE users
(
	user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(20),
	e_mail VARCHAR(30),
	password VARCHAR(30)
);

CREATE TABLE admins
(
	admin_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL
);

CREATE TABLE marks
(
	mark_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	recipe_id INT NOT NULL,
	mark INT
);
	 
CREATE TABLE users_stats
(
	stats_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	account_created DATETIME
);
	 
CREATE TABLE favourites
(
	favourite_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	recipe_id INT NOT NULL
);

ALTER TABLE recipes
	ADD FOREIGN KEY (metadata_id) REFERENCES recipes_metadatas(metadata_id)
     ON UPDATE CASCADE ON DELETE CASCADE,
    ADD FOREIGN KEY (meal_id) REFERENCES meals(meal_id)
     ON UPDATE CASCADE ON DELETE NO ACTION,
    ADD FOREIGN KEY (difficulty_id) REFERENCES difficulties(difficulty_id)
     ON UPDATE CASCADE ON DELETE NO ACTION,
    ADD FOREIGN KEY (ingredients_list_id) REFERENCES ingredients_lists(ingredients_list_id)
     ON UPDATE CASCADE ON DELETE CASCADE,
    ADD FOREIGN KEY (description_id) REFERENCES descriptions(description_id)
     ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE recipes_metadatas
    ADD FOREIGN KEY (user_id) REFERENCES users(user_id)
     ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ingredients_lists
    ADD FOREIGN KEY (unit_id) REFERENCES units(unit_id)
     ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE recipes_categories
	ADD FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id)
	 ON UPDATE CASCADE ON DELETE NO ACTION,
	ADD FOREIGN KEY (category_id) REFERENCES categories(category_id)
	 ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE admins
	ADD FOREIGN KEY (user_id) REFERENCES users(user_id)
     ON UPDATE CASCADE ON DELETE CASCADE;
	 
ALTER TABLE marks 
	ADD FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id)
     ON UPDATE CASCADE ON DELETE CASCADE,
	ADD FOREIGN KEY (user_id) REFERENCES users(user_id)
     ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE users_stats 
	ADD FOREIGN KEY (user_id) REFERENCES users(user_id)
     ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE favourites 
	ADD FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id)
     ON UPDATE CASCADE ON DELETE CASCADE,
	ADD FOREIGN KEY (user_id) REFERENCES users(user_id)
     ON UPDATE CASCADE ON DELETE NO ACTION;
	 
CREATE VIEW recipes_last_added AS 
	SELECT r.recipe_id, r.title, d.description FROM recipes r INNER JOIN descriptions d USING (description_id) 
	WHERE accepted ORDER BY recipe_id DESC;
CREATE VIEW average_for_recipe AS 
	SELECT recipe_id, IFNULL(AVG(mark), 0.00) AS average_mark FROM marks GROUP BY recipe_id;
CREATE VIEW recipes_highest_rated AS 
	SELECT r.recipe_id, r.title, d.description, afr.average_mark FROM recipes r, descriptions d, average_for_recipe afr 
	WHERE r.description_id = d.description_id AND afr.recipe_id = r.recipe_id AND accepted ORDER BY average_mark DESC;
CREATE VIEW ingredients_lists_units AS
	SELECT il.*, u.singular, u.plural_2pcs, plural_5pcs, shortcut, si_converse FROM ingredients_lists il, units u 
	WHERE il.unit_id = u.unit_id;
CREATE VIEW recipes_metadatas_users AS
	SELECT rm.metadata_id, rm.recipe_id, rm.add_date, rm.update_date, u.user_name, u.user_id FROM recipes_metadatas rm, users u 
	WHERE rm.user_id = u.user_id;
CREATE VIEW recipes_categories_with_name AS
	SELECT rc.recipe_id, rc.category_id, c.category FROM recipes_categories rc, categories c 
	WHERE rc.category_id = c.category_id;
CREATE VIEW recipe_page AS
	SELECT r.recipe_id, r.title, r.portions, r.prepare_time, rcwn.category, rmu.add_date, rmu.update_date, rmu.user_name, rmu.user_id, m.meal, d.difficulty, afr.average_mark, de.description FROM recipes r, recipes_categories_with_name rcwn, recipes_metadatas_users rmu, meals m, difficulties d, average_for_recipe afr, descriptions de 
	WHERE r.recipe_id = rcwn.recipe_id AND r.recipe_id = rmu.recipe_id AND r.meal_id = m.meal_id AND r.difficulty_id = d.difficulty_id AND r.recipe_id = afr.recipe_id AND r.description_id = de.description_id;
CREATE VIEW recipes_favourites AS
	SELECT f.user_id, r.recipe_id, r.title FROM favourites f, recipes r 
	WHERE f.recipe_id = r.recipe_id;
CREATE VIEW recipes_for_category AS
	SELECT r.recipe_id, r.title, rcwn.category_id, rcwn.category, d.description FROM recipes r, recipes_categories_with_name rcwn, descriptions d 
	WHERE r.recipe_id = rcwn.recipe_id AND r.description_id = d.description_id;
CREATE VIEW recipes_for_meal AS
	SELECT r.recipe_id, r.title, m.meal_id, m.meal, d.description FROM recipes r, meals m, descriptions d 
	WHERE r.meal_id = m.meal_id AND r.description_id = d.description_id;
CREATE VIEW recipes_for_user AS
	SELECT r.recipe_id, r.title, u.user_id, u.user_name, d.description FROM recipes r, recipes_metadatas rm, users u, descriptions d 
	WHERE r.recipe_id = rm.recipe_id AND rm.user_id = u.user_id AND r.description_id = d.description_id;
	
INSERT INTO users (user_id, user_name, e_mail, password) VALUES
(1, "Boczek", "Boczek@gmail.com", "okm"),
(2, "Puchaty", "Puchaty@gmail.com", "mle"),
(3, "Kleks", "kleks@wp.pl", "qwe"),
(4, "urwany", "panpolicjant@onet.pl", "zxc");

INSERT INTO users_stats (stats_id, user_id, account_created) VALUES
(1, 1, "2021-05-29 13:31:24"),
(2, 2, "2021-05-29 13:38:29"),
(3, 3, "2021-06-15 13:19:05"),
(4, 4, "2021-06-15 13:21:42");

INSERT INTO admins(user_id) VALUES (2);

INSERT INTO units(singular, plural_2pcs, plural_5pcs, shortcut, si_converse) VALUES
("gram","gramy","gram","g", 1),
("dekagram","dekagramy","dekagramów","dag", 1),
("kilogram","kilogramy","kilogramów","kg", 1),
("litr","litry","litrów","l", 1),
("mililitr","mililitry","mililitrów","ml", 1),
("łyżka","łyżki","łyżek","łyż.", 0.005),
("łyżka stołowa","łyżki stołowe","łyżek stołowych","łyż. stoł.", 0.015),
("chochla","chochle","chochli","choch.", 0.225),
("szklanka","szklanki","szklanki","szkl.", 0.25),
("sztuka","sztuki","sztuk","szt.", 1),
("opakowanie","opakowania","opakowań","opak.", 1),
("szczypta","szczypty","szczypt","szczypt.", 1),
("kromka","kromki","kromek","krom.", 1),
("plaster","plastry","plastrów","plast.", 1);

INSERT INTO difficulties(difficulty) VALUES 
("Łatwy"),
("Średni"),
("Trudny"),
("Dla mistrzów");

INSERT INTO categories(category) VALUES
("Mączne"),
("Jednogarnkowe"),
("Kanapki"),
("Makarony"),
("Naleśniki"),
("Sałatki"),
("Sosy"),
("Surówki"),
("Zapiekanki"),
("Uliczne"),
("Ryby"),
("Mięsne"),
("Pizze"),
("Ciasta"),
("Ciastka"),
("Pączki"),
("Pierniki"),
("Torty"),
("Lody"),
("Napoje ciepłe"),
("Napoje zimne"),
("Wegańskie"),
("Wegetariańskie"),
("Dla kamieniożerców"),
("Bez laktozy"),
("Dla alergików"),
("Grill"),
("Wielkanoc"),
("Boże Narodzenie"),
("Post");

INSERT INTO meals(meal) VALUES
("Śniadanie"),
("Drugie śniadanie"),
("Pierwsze danie"),
("Drugie danie"),
("Deser"),
("Podwieczorek"),
("Kolacja");

INSERT INTO ingredients_lists(recipe_id, ingredient, how_many, unit_id) VALUES
(1, "Boczek", 1, 10),
(1, "Czekolada", 50, 1),
(2, "Pyry", 500, 1),
(2, "Śmietana", 100, 5),
(3, "Woda", 1, 4),
(3, "Mąka", 200, 1),
(3, "Biały ser", 20, 2),
(3, "Ziemniaki", 20, 2),
(4, "Czerwona papryka", 100, 1),
(4, "Zielona papryka", 100, 1),
(4, "Żółta papryka", 100, 1),
(4, "Biała kiełbasa", 4, 10),
(4, "Woda", 2, 4),
(5, "Chleb", 2, 13),
(5, "Mięso", 1, 14),
(5, "Żólty ser", 1, 14),
(5, "Masło", 10, 1),
(6, "Spaghetti", 1, 11),
(6, "Mięso mielone", 1, 3),
(6, "Sos pomidorowy", 500, 5),
(6, "Woda", 1, 4),
(7, "Woda", 1, 4),
(7, "Mąka", 300, 1),
(7, "Soczewica", 250, 1),
(7, "Boczek", 100, 1),
(8, "Pomidory", 2, 10),
(8, "Sałata", 1, 10),
(8, "Oliwa", 50, 5),
(9, "Kostka rosołowa", 1, 10),
(9, "Marchewka", 100, 1),
(9, "Papryka", 100, 1),
(9, "Woda", 500, 5);

INSERT INTO recipes_metadatas(recipe_id, user_id, add_date, update_date) VALUES
(1, 2, "2021-05-29 14:04:00", NULL),
(2, 2, "2021-06-15 12:54:22", NULL),
(3, 1, "2021-06-15 12:48:52", NULL),
(4, 1, "2021-06-15 12:52:50", NULL),
(5, 3, "2021-06-15 12:59:58", NULL),
(6, 3, "2021-06-15 13:03:50", NULL),
(7, 1, "2021-06-15 13:07:38", NULL),
(8, 2, "2021-06-15 13:11:07", NULL),
(9, 4, "2021-06-15 13:15:06", NULL);

INSERT INTO descriptions(recipe_id, description) VALUES
(1, "Wsadzamy boczek do rozpuszczonej czekolady."),
(2, "Lejemy śmietanę na ziemniaki."),
(3, "Zagniatamy ciasto i wkładamy do niego twaróg z ziemniakami."),
(4, "Umieszczamy wszystko w garze i gotujemy godzinę."),
(5, "Bierzemy dwie kromki chleba, smarujemy masłem, kładziemy mięso i ser."),
(6, "Wrzucamy mięso i sos do gara, makaron do oddzielnego. Potem mieszamy."),
(7, "Mieszamy wodę z mąką. Smażymy placki. Soczewicę gotujemy i mielimy z boczkiem. Zawijamy placki z nadzieniem"),
(8, "Kładziemy pomidorki na sałatę, którą polewamy oliwą."),
(9, "Trzemy marchewkę i paprykę, następnie gotujemy w wodzie z kostką rosołową. Podawać z ziemniakami, makaronem lub ryżem.");

INSERT INTO recipes(metadata_id, title, meal_id, difficulty_id, portions, prepare_time, ingredients_list_id, description_id, accepted) VALUES
(1, "Boczek z czekoladą", 4, 1, 4, "0:30", 1, 1, TRUE),
(2, "Kartofle ze śmietaną", 4, 1, 4, "0:45", 2, 2, TRUE),
(3, "Pierogi ruskie", 4, 2, 6, "2:00", 3, 3, TRUE),
(4, "Chłopski garnek", 4, 1, 4, "1:25", 4, 4, TRUE),
(5, "Kanapka", 1, 1, 1, "0:05", 5, 5, TRUE),
(6, "Spaghetti", 4, 1, 4, "1:30", 6, 6, TRUE),
(7, "Naleśniki z soczewicą", 4, 1, 5, "1:45", 7, 7, TRUE),
(8, "Pomidory z sałatą", 2, 1, 2, "0:25", 8, 8, TRUE),
(9, "Sos marchewko-pomidorowy", 4, 1, 4, "1:10", 9, 9, TRUE);

INSERT INTO recipes_categories(recipe_id, category_id) VALUES
(1, 12),
(2, 23),
(3, 1),
(4, 2),
(5, 3),
(6, 4),
(7, 5),
(8, 6),
(9, 7);
 
INSERT INTO marks(user_id, recipe_id, mark) VALUES
(2, 1, 2),
(1, 8, 4),
(1, 9, 5),
(1, 4, 2),
(2, 5, 3),
(2, 2, 1),
(2, 1, 2),
(3, 6, 3),
(3, 5, 4),
(4, 4, 5),
(4, 3, 3),
(4, 2, 4),
(2, 7, NULL);

INSERT INTO favourites(user_id, recipe_id) VALUES
(1, 8),
(1, 9),
(2, 5),
(2, 2),
(2, 6),
(2, 5),
(2, 3),
(3, 5),
(4, 6),
(4, 8);