#!/usr/bin/python3
from os import listdir
from os.path import isfile, join

images = [f for f in listdir("./images/items")
          if isfile(join("./images/items", f))]

query = "INSERT INTO items (name, image_url) VALUES"

for image in images:
    img_no_ext = image[:-4]

    name = ""

    next_upper_case = True

    for c in img_no_ext:
        if(next_upper_case):
            next_upper_case = False
            name = name + c.upper()
        elif(c == "_"):
            name = name + " "
            next_upper_case = True
        else:
            name = name + c

    query = query + " ('" + name + "', '" + "/images/items/" + image + "'),"

query = query[:-1] + ";"

print(query)
