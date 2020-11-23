CREATE TABLE items (
    id int (11) NOT NULL UNIQUE PRIMARY KEY,
    user_id int(11) NOT NULL,
    poi_id int(11) NOT NULL,
    item varchar(255) NOT NULL,
    item_amount int(11) NOT NULL,
    secondary_item varchar(255),
    secondary_item_amount int(11)
)