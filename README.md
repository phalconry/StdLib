# StdLib

###Class: `String`
The `String` class provides an object-oriented wrapper for a string. Most of the methods are chainable except for those that return a value.

####Example
Given:
```php
$original_string = "Someone ate my cheese and that makes me <b>mad</b>.";
```
Without `String`:
```php
$string = filter_var($original_string, FILTER_SANITIZE_STRING);
$string = str_replace('mad', 'outraged', $string);
$string = rtrim($string, '.');
$string .= '!';
print $string; // prints "Someone ate my cheese and that makes me outraged!"

echo strlen($string); // prints "49"
echo mb_detect_encoding($string); // prints "ASCII"
echo $string[0]; // prints "S"
echo substr($string, -1); // prints "!"

$string = '<p>'.$string.'</p>';
print_r($string); // outputs "<p>Someone ate my cheese and that makes me outraged!</p>"

print_r(ctype_alnum($string)); // outputs "false"
```
With `String`:
```php
$str = new Phalconry\StdLib\String($original_string);
$str->sanitize()
	->replace('mad', 'outraged')
	->rtrim('.')
	->append('!')
	->print(); // prints "Someone ate my cheese and that makes me outraged!"

echo $str->length; // prints "49"
echo $str->encoding; // prints "ASCII"
echo $str->firstChar; // prints "S"
echo $str->lastChar; // prints "!"

$str->wrap('<p>', '</p>'); 
print_r($str->get()); // outputs "<p>Someone ate my cheese and that makes me outraged!</p>"

print_r($str->isAlnum()); // outputs "false"
```
