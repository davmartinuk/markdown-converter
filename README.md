# Markdown Converter

> A PHP CLi App


## Running the App

Here is a simple App to convert markdown files into HTML counterparts. 

I have spent approximately 2 hours as requested. I have managed to get most parts working correctly – but I would expect thorough testing would show a few improvements needed. I have focused on the basics to demonstrate my methodology and coding style. That said: I would expect parts of the code could to refactored.

## Things I didn’t complete

PHP error logging. How would I go about this if I had time? (this probably wouldn’t take that long). Install an error logging library like monolog. Then from within parts of the apps code particularly i.e. line 87 write an error message to be logged. 

I have a feeling the configuration options are not as specified (S3, FTP). I am simply asking the user to define a upload location (e.g. ./uploads). I suspect you where perhaps after a programmatic configuration. That wouldn’t be a problem, I would just setup the object to accept certain parameters i.e 

``` bash
$convertMarkdown = new ConvertMarkdown();
$convertMarkdown->config(username, password, connectionType, uploadPath);
$convertMarkdown->mainMenu();

```
 

## Running the App

``` bash
# Command line
php -f markdown-converter.php
```



