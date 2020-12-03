# Minecraft web app

## Starta

Efter clone kör:

```bash
composer install
```

För att starta en server:

```bash
php -S localhost:5000
```

Servern kommer lyssna på port 5000 och inte 8080 som vanligtvis.
Om ni har gjort en ändring så behöver ni ibland starta om servern.

PHPMyAdmin är fortfarande på localhost:8080/phpmyadmin

## CRUD Koordinater

* Lägga till    (INSERT)
* Vissa         (SELECT)
* Uppdatera     (UPDATE)
* Ta bort       (DELETE)

X och Z behövs läggas in, eventuellt Y om man vill.

Kategorier som tex:

* Overworld
  * Home (Där folk bor)
  * Biome
  * Tempel
  * Misc
* Nether
  * Biome
  * Tempel
  * Misc
* End
  * Tempel
  * Misc

## Places of Interest

Skriva in sina koordinater och om man är i overworld eller nether
och få ut olika sparade koordinater
i ordningen som är närmst med distansen som en kolumn också,
Y värdet behöver inte vara med i uträkningen för den kommer inte alltid att finnas

## Koordinat Kalkylator

Skriva in overworld koordinater och få ut nether coords
och skriva in nether coords och får ut overworld coords

## Enchantment system

Välja vilka enchantments man vill ha, det visar hur många emeralds man behöver
och visar var alla de olika enchantments villagerna står

## Notes to self(Marcus)

PHP fil som tar emot en post request för att lägga till i Shopping Cart.
Skickar med Id. Ska retunera hur många föremål man har i sin Shopping Cart.

Använd fetch med credentials same-origin.

Send:

```javascript
fetch("/addtocart.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  credentials:"same-origin",
  body: JSON.stringify({id: "hidden val id"})
});
```

Response:

```json
{
  "amount": 3
}
```
