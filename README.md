# Laraplus/String
This package provides a fluid easy-to-use interface for string manipulation. It integrates with Illuminate\Support 
to enable a fluid syntax even when dealing with multiple results. All methods are UTF-8 friendly.

## Installation
To install this package, simply require it using composer:

```
composer require laraplus/string
```

## Example usage

With this package you can avoid ugly nested str_* functions and never ending needle-haystack problems:
```php
str(' some text ')->trim()->substring(0, 4);

// instead of

substr(trim(' some text '), 0, 4);
```

If you have a slug "my-blog-title-4" and you need to find the index "4", you can simply write:
```php
$lastIndex = str($lastSlug)->explode('-')->last();

// instead of

$parts = $explode('-');
$lastIndex = array_pop($parts);
```

Lets say you have some custom "colon separated" multi line string that you need to parse:
```php
str($content)->lines()->each(function ($row) {
    $data = str($row)->explode(':');
    // do something with $data here
});

// instead of

$lines = preg_split('/\r\n|\n|\r/', $content);
foreach($lines as $line) {
    $data = explode(':', $line);
    // do something with $data here
}
```

## Full reference

### Initialization

You can initialize the ``StringBuffer`` object directly or by using the ``str`` helper function:
```php
$string = new Laraplus\String\StringBuffer('Hello world!');

// or

$string = str('Hello world!');
```

### Chaining

When the result of a method call is a string, it is automatically wrapped in a new StringBuffer instance, so that the
method calls can be chained.
```php
// result: "HELLO"
str('hello world')->toUpper()->wordAt(1);
```

If you need to unwrap the object, you can do that by calling the ``get()`` method or simply cast it to string.
```php
// a string "Hello world" is produced in all examples below
str('hello world')->ucfirst()->get();
(string)str('hello world')->ucfirst();
str('hello')->ucfirst() . ' world!';
```

When a method returns an array it is automatically wrapped in a Collection object, which enables further chaining:
```php
str('hello world')->words()->each(function($word){
 // Be careful, $word is just a plain string here.
 // To convert it to StringBuffer again, call: str($word)
});
```

For a full reference of available collection methods, see the Laravel documentation: http://laravel.com/docs/5.1/collections#available-methods

### Available methods

#### ucfirst()

Capitalize the first letter of the string.
```php
// result: "Hello world"
str('hello world')->ucfirst();
```

#### lcfirst()

Lowercase the first letter of the string.
```php
// result: "hello world"
str('Hello world')->lcfirst();
```

#### startsWith($needles)

Determine if the string starts with a given substring.
```php
// returns true
str('Hello world')->startsWith('Hello');

// returns false
str('Hello world')->startsWith('world');

// returns true
str('Hello world')->startsWith(['H', 'W']);
```

#### endsWith($needles)

Determine if the string ends with a given substring.
```php
// returns true
str('Hello world')->endsWith('world');

// returns false
str('Hello world')->endsWith('Hello');

// returns true
str('Hello world')->endsWith(['o', 'd']);
```


#### contains($needles)
Determine if the string contains a given substring.
```php
// returns true
str('Hello world')->contains('world');

// returns false
str('Hello world')->contains('universe');

// returns true
str('Hello world')->endsWith(['w', 'u']);
```

#### equals($needles)
Determine if the string equals the given input in a constant time comparison.
```php
// returns true
str('Hello world')->equals('Hello world');

// returns false
str('Hello world')->equals('Hello universe');
```

#### matches($pattern)
Determine if the string matches a given pattern.
```php
// returns true
str('Hello/World')->matches('*/*');

// returns true
str('Hello world')->equals('Hello*');
```

#### explode($delimiters)
Split the string with given delimiter(s).
```php
// result: ['Hello', ' World']
str('Hello, World')->explode(',');

// result: ['one', 'two', 'three', 'four']
str('one:two,three:four')->explode([':', ',']);
```

#### indexOf($needle, $offset = 0)
Find the first occurrence of a given needle in the string, starting at the provided offset.
```php
// returns 0
str('one, two')->indexOf('o');

// returns 7
str('one, two')->indexOf('o', 1);
```

#### lastIndexOf($needle, $offset = 0)
Find the last occurrence of a given needle in the string, starting at the provided offset.
```php
// returns 7
str('one, two')->lastIndexOf('o');

// returns 0
str('one, two')->lastIndexOf('o', 1);
```

#### replace($search, $replace, &$count = 0)
Replace all occurrences of the search string with the replacement string.
```php
// result: 'one; two; three'
str('one, two, three')->replace(',', ';');

// result: 'one; two; three' and $count in incremented by 2
str('one, two, three')->replace(',', ';', $count);

// result: 'one; two; three'
str('one, two. three')->replace([',', '.'], ';');

// result: 'one; two, three'
str('one, two. three')->replace([',', '.'], [';', ',']);
```

#### substring($start, $length = null)
Returns the portion of string specified by the start and length parameters
```php
// result: 'world'
str('Hello world')->substring(6);

// result: 'll'
str('Hello world')->substring(2, 2);
```

#### toAscii()
Transliterate a UTF-8 value to ASCII.
```php
// result: 'CcZzSs'
str('ČčŽžŠš')->toAscii();
```

#### toCamel()
Convert a value to camel case.
```php
// result: 'helloWorld'
str('hello_world')->toCamel();
```

#### toSnake()
Convert a value to snake case.
```php
// result: 'hello_world'
str('HelloWorld')->toSnake();
```

#### toStudly()
Convert a value to studly case.
```php
// result: 'HelloWorld'
str('hello_world')->toStudly();
```

#### toTitle()
Convert a value to title case.
```php
// result: 'Hello World'
str('hello world')->toTitle();
```

#### toSlug()
Convert a value to title case.
```php
// result: 'hello-world'
str('Hello world')->toSlug();
```

#### toUpper()
Convert the given string to upper-case.
```php
// result: 'HELLO WORLD'
str('hello world')->toUpper();
```

#### toLower()
Convert the given string to lower-case.
```php
// result: 'hello world'
str('HELLO WORLD')->toLower();
```

#### toSingular()
Get the singular form of an English word.
```php
// result: 'person'
str('people')->toSingular();
```

#### toPlural()
Get the plural form of an English word.
```php
// result: 'people'
str('person')->toPlural();
```

#### length()
Return the length of the given string.
```php
// returns 11
str('Hello world')->length();
```

#### words($ignore = '?!;:,.')
Return a Collection of individual words in the string ignoring the given characters.
```php
// result: ['one', 'two', 'three']
str('one, two, three')->words();

// result: ['one', 'two', 'three']
str('(one) : (two) : (three)')->words('(:)');
```

#### lines()
Return a collection of individual lines in the string.
```php
// result: ['one', 'two', 'three']
str("one\ntwo\r\nthree")->lines();
```

#### prepend($string)
Prepend a given input to the string.
```php
// result: 'hello world'
str('world')->prepend(' ')->prepend('hello');
```

#### append($string)
Append a given input to the string.
```php
// result: 'hello world'
str('hello')->append(' ')->append('hello');
```

#### trim($chars = null)
Trim given characters from both ends of the string. If no characters are provided, all white space is trimmed.
```php
// result: 'hello world'
str('  hello world  ')->trim();

// result: 'hello world'
str('--hello world--')->trim('-');
```

#### ltrim($chars = null)
Similar to ``trim()``, but only trims characters from the left side.
```php
// result: 'hello world  '
str('  hello world  ')->trim();

// result: 'hello world--'
str('--hello world--')->trim('-');
```

#### rtrim($chars = null)
Similar to ``trim()``, but only trims characters from the right side.
```php
// result: '  hello world'
str('  hello world  ')->trim();

// result: '--hello world'
str('--hello world--')->trim('-');
```

#### limit($limit = 100, $end = '...')
Limit the number of characters in the string.
```php
// result: 'hello...'
str('hello world')->limit(5);

// result: 'hello etc.'
str('hello world')->limit(5, 'etc.');

// result: 'hello world'
str('hello world')->limit();
```

#### limitWords($limit = 100, $end = '...')
Limit the number of words in the string.
```php
// result: 'hello the world...'
str('Hello the world of PHP!')->limitWords(3);

// result: 'hello the world etc.'
str('Hello the world of PHP!')->limit(5, 'etc.');

// result: 'Hello the world of PHP!'
str('Hello the world of PHP!')->limit();
```

#### wordAt($index)
Return the word at the given index.
```php
// result: 'world'
str('Hello the world of PHP!')->wordAt(2);
```

### Using offsets
Since the StringBuffer class implements the ArrayAccess interface, you can also use all of the usual offset goodies:
```php
$string = str('hello world');
$string[0]; // returns 'h'
isset($string[10]) // returns true
unset($string[0]); // $string becomes 'ello world'
$string[0] = 'He'; // $string becomes 'Hello world'
```

