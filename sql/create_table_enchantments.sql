CREATE TABLE enchantments (
    id int (11) NOT NULL AUTO_INCREMENT UNIQUE,
    user_id int(11) NOT NULL,
    poi_id int(11) NOT NULL,
    price int(11) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(poi_id) REFERENCES points_of_interest(id)
);
