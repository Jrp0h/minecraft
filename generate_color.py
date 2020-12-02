#!/usr/bin/python3

import sys


def convert(r, g, b):
    OP = 0.75
    B = 255

    print("r: ", (r - ((1 - OP) * B))/OP)
    print("g: ", (g - ((1 - OP) * B))/OP)
    print("b: ", (b - ((1 - OP) * B))/OP)


if __name__ == "__main__":
    r = 0
    g = 0
    b = 0

    if(len(sys.argv) == 2):
        print("hex")
        r = int(sys.argv[1][0:2], 16)
        g = int(sys.argv[1][2:4], 16)
        b = int(sys.argv[1][4:6], 16)
    elif (len(sys.argv) == 4):
        print("rgb")
        r = sys.argv[1]
        g = sys.argv[2]
        b = sys.argv[3]

    convert(r, g, b)
