CREATE TABLE points_of_interest (
    id int (11) NOT NULL AUTO_INCREMENT UNIQUE,
    user_id int (11) NOT NULL,
    name varchar(255) NOT NULL,
    x int (11) NOT NULL,
    y int (11),
    z int (11) NOT NULL,
    looted boolean,
    description text NOT NULL,
    world ENUM("Overworld", "Nether", "End") NOT NULL,
    category ENUM("Home", "Spawner","Farm", "Village", "Stronghold", "Desert Temple", "Jungle Temple", "Guardian Tempel", "Ocean Ruins", "Mineshaft", "Pillager Outpost", "Shipwreck", "Biome", "End Portal", "Nether Portal", "Bastion",  "Nether Fortress", "Mansion", "Mushroom Island", "Misc") NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);
