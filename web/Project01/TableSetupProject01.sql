/* Michael Graver */
CREATE TABLE users (
	ID				SERIAL	PRIMARY KEY NOT NULL,
	Username 		VARCHAR(15) 		NOT NULL,
	Password		VARCHAR(15) 		NOT NULL,
	UNIQUE (Username)
);

CREATE TABLE rating (
	Score			INT  CHECK(Score < 6) PRIMARY KEY 	NOT NULL
);

CREATE TABLE unit (
	ID  			SERIAL PRIMARY KEY NOT NULL,
	Unit 			VARCHAR(10) 	   NOT NULL,
	UNIQUE(Unit)
);

CREATE TABLE recipes (
	ID				SERIAL 	PRIMARY KEY 				NOT NULL,
	Name            VARCHAR(50)                         NOT NULL,
	Rating			INT	   	REFERENCES rating(Score)	NOT NULL,
	Description		TEXT		 						        ,
	ImgPath			VARCHAR(250) 						
);

CREATE TABLE ingredients (
	ID 				SERIAL PRIMARY KEY  NOT NULL,
	Name			VARCHAR(30) 		NOT NULL,
	UNIQUE(Name)
);

CREATE TABLE favorite (
	ID 				SERIAL PRIMARY KEY 					NOT NULL,
	Recipe_ID		INT	   REFERENCES recipes(ID)		NOT NULL,
	Comment			TEXT
);

CREATE TABLE recipe_ingrident (
	Recipe_ID      	INT     REFERENCES recipes(ID)		NOT NULL,
	Ingredient_ID	INT  	REFERENCES ingredients(ID)  NOT NULL,
	Amount			REAL 								NOT NULL,
	Unit			INT     REFERENCES unit(ID) 		
);

CREATE TABLE user_favorite (
	User_ID			INT 	REFERENCES users(ID)		 NOT NULL,
	Favorite_ID		INT 	REFERENCES favorite(ID)	 	 NOT NULL
);

CREATE TABLE steps (
ID 					SERIAL PRIMARY KEY					NOT NULL,
Recipe_ID 			INT    REFERENCES recipes(ID)		NOT NULL,
recipe_steps		TEXT								NOT NULL,
UNIQUE(Recipe_ID)
);

INSERT INTO users (Username, Password) VALUES ('John.S', 'Password');

INSERT INTO rating VALUES (1), (2), (3), (4), (5);

INSERT INTO unit (Unit) VALUES ('tsp'), ('tbsp'), ('fl.oz'), ('cup'), ('oz'), ('lb'), ('ml'), ('stick');

INSERT INTO recipes (Name, Rating, Description) VALUES ('Spaghetti Bolognese', 4, 
	'A bowl of steaming hot pasta tangled with a beautifully rich and 
	smooth bolognese sauce exploding with so much flavour you''ll be 
	dipping and licking the sauce directly from the wooden spoon before 
	it hits the pasta.');

INSERT INTO ingredients (Name) VALUES ('olive oil'), ('ground beef'), ('tomato sauce'), ('tomato paste'), ('oregano'), ('angel hair pasta');

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'), (SELECT ID FROM ingredients WHERE Name = 'angel hair pasta'), 14.25,
 (SELECT ID FROM unit WHERE Unit = 'oz'));

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'), (SELECT ID FROM ingredients WHERE Name = 'ground beef'), 1,
 (SELECT ID FROM unit WHERE Unit = 'lb'));

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'), (SELECT ID FROM ingredients WHERE Name = 'olive oil'), 2,
 (SELECT ID FROM unit WHERE Unit = 'tbsp'));

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'), (SELECT ID FROM ingredients WHERE Name = 'tomato sauce'), 4,
 (SELECT ID FROM unit WHERE Unit = 'cup'));

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'), (SELECT ID FROM ingredients WHERE Name = 'tomato paste'), 3,
 (SELECT ID FROM unit WHERE Unit = 'oz'));

INSERT INTO steps (Recipe_ID, recipe_steps) VALUES ((SELECT ID FROM recipes WHERE Name = 'Spaghetti Bolognese'),
'
1.Cook pasta in a large stock pot, according to package instructions.
2.Reserve 1 cup starchy cooking water, drain, and keep pasta warm.
3.Heat olive oil in a large skillet over medium high heat.
4.Once oil is hot, brown ground beef.
5.Add tomato sauce and paste, stir to combine and cook until sauce has thickened slightly, approximately 3-4 minutes.
6.Add meat sauce and reserved starchy cooking water to the cooked pasta and stir to combine.
7.Serve hot and garnish with crushed red pepper flakes and/or parmesan cheese, if desired.');

INSERT INTO recipes (Name, Rating, Description) VALUES ('Grilled Cheese', 3, 
	'A delicious classic that is easy to make and satifies those tummy grumbels');

INSERT INTO ingredients (Name) VALUES ('bread slice'), ('cheese slice'), ('butter');

INSERT INTO recipe_ingrident (Recipe_ID, Ingredient_ID, Amount, Unit) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Grilled Cheese'), (SELECT ID FROM ingredients WHERE Name = 'bread slice'), 12, NULL),
((SELECT ID FROM recipes WHERE Name = 'Grilled Cheese'), (SELECT ID FROM ingredients WHERE Name = 'cheese slice'), 12, NULL);

INSERT INTO steps (Recipe_ID, recipe_steps) VALUES ((SELECT ID FROM recipes WHERE Name = 'Grilled Cheese'),
'
1.Preheat skillet over medium heat. Generously butter one side of a slice of bread. Place bread butter-side-down 
onto skillet bottom and add 1 slice of cheese. Butter a second slice of bread on one side and place butter-side-up 
on top of sandwich. Grill until lightly browned and flip over; continue grilling until cheese is melted. Repeat 
with remaining 2 slices of bread, butter and slice of cheese.');

INSERT INTO favorite (Recipe_ID, Comment) VALUES 
((SELECT ID FROM recipes WHERE Name = 'Grilled Cheese'), NULL);

INSERT INTO user_favorite (User_ID, Favorite_ID) VALUES (1, 1);

SELECT Name, Description FROM recipes r JOIN favorite f ON r.ID = f.Recipe_ID JOIN user_favorite uf ON f.ID = uf.Favorite_ID
JOIN users u ON uf.User_ID = 1;

SELECT r.Name, r.Description FROM users u JOIN user_favorite uf ON u.ID = uf.User_ID JOIN favorite f ON uf.Favorite_ID = f.ID 
JOIN recipes r ON f.Recipe_ID = r.ID;