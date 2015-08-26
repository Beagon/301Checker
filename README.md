301 Redirect Checker
==============

Simple page/script which makes it faster to check if your 301 rules work.

**This has been a quick built just for use as a development tool.**

![screenshot of the mainpage](http://i.imgur.com/CknpYuy.png)

Authors
-------

* Robin Rijkeboer <rmrijkeboer@gmail.com>

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [GitHub issue tracker](https://github.com/Thunderofnl/301Checker/issues).

How it works
---------------------------------------
Insert a the base url in the Base url field like so: http://www.example.com/

Make a txt file filled with suffixes e.g.:
```
index
about-us
testing
...
````
Put that into the field Text file with the suffixes.

After that's done, you can click check 301's, you will get back a list with all the the results e.g.:

```
Url: http://www.example.com/index redirects to http://www.example.com/newindex
Url: http://www.example.com/about-us redirects to http://www.example.com/about/us
Url: http://www.example.com/testing doesn't 301 but instead gives status code: 404
```
