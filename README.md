## Read me
### Description
The main goal of this project is to show database structure and some code solutions for fast and productive search of products without using full-text search, caching and search engines. Search by keywords works only for full word. It means that product "Lorem ipsum" can't be found by "lor" or "psum", only by "lorem" and "ipsum". Also you can use only words that are longer than 3 characters. Such words as "on", "at" will be ignored

In theory, the project can be expanded through the use of full-text search, the morphology of Russian language, adding caching of results. The data can be returned without HTML to make the rendering on the client faster. The perfect solution for such tasks is to use search engines like Elasticsearch, Sphinx, Solr, etc

### Initial setup of project
Please follow the steps:
1. Create a new database and import "test_2016-10-12.sql". This dump will create only a database structure and fill Types and Sizes
2. Modify config/congif.php with your credentials
3. Run a script commands/generate.php to add test Brands and Products. Please be patient, it will take some time. Brands and Products will be created in 4 languages - English, Danish, Russian and French. Product name contains just a part of random text, sorry for this )) If you don't want to wait I can provide you with a full database dump.
```sh
$ php commands/generate.php
```
4. And now we need to index added Products. Run a script commands/updateIndex.php and make some coffe
```sh
$ php commands/updateIndex.php
```

That's all! Finally you can play with your new catalogue.