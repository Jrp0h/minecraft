CREATE TABLE IF NOT EXISTS trades (
    id int (11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    poi_id int(11) NOT NULL,
    item_id int(11) NOT NULL,
    item_amount int(11) NOT NULL,
    secondary_item_id int(11),
    secondary_item_amount int(11),
    return_item_id int(11) NOT NULL,
    return_item_amount int(11) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(item_id) REFERENCES items(id),
    FOREIGN KEY(secondary_item_id) REFERENCES items(id),
    FOREIGN KEY(return_item_id) REFERENCES items(id),
    FOREIGN KEY(poi_id) REFERENCES points_of_interest(id)
);
