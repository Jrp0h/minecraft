CREATE TABLE IF NOT EXISTS items (
    id int (11) NOT NULL AUTO_INCREMENT UNIQUE,
    user_id int(11) NOT NULL,
    poi_id int(11) NOT NULL,
    item varchar(255) NOT NULL,
    item_amount int(11) NOT NULL,
    secondary_item varchar(255),
    secondary_item_amount int(11)
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(poi_id) REFERENCES points_of_interest(id)
);
