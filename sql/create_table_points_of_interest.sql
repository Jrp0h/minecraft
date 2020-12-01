CREATE TABLE points_of_interest (
    id int (11) NOT NULL AUTO_INCREMENT UNIQUE,
    user_id int (11) NOT NULL,
    name varchar(255) NOT NULL,
    x int (11) NOT NULL,
    y int (11),
    z int (11) NOT NULL,
    looted boolean,
    description text NOT NULL,
    location ENUM("Overworld", "Nether", "End") NOT NULL,
    category ENUM("Home", "Biom", "Spawner", "Temple", "Misc") NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);
