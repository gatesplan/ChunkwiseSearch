# LogarithmSearchCollection
With this, I can find an Item without search through head to toe of array.


# Whats it for?
Let an array $entry = [a, b, c, d, e, ..., ax, ay, az, ba, ..., ts, tt, 1, 2, 3, ...];
`entry` has an item that we want to find as a starting point of some condition. In this example, `some condition` might be a integer value item.
Your machine probably fast enough to through all items but.. what if the array has 150k items or even more?


# Usable environment
Your haystack must be a Laravel Collection because the class extend `Illuminate\Support\Collection` of Laravel.. which is fine because I always using Laravel.
When I possible I would update this limitation with minimal or if possible without signiture change.


# Features
1. You can search through collection with your custom test function.
2. ..what else do I need..? hm...
