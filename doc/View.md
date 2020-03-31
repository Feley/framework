
If you log in using blade then you could use the tags @auth/@endauth/@guest/@endguest


```html
@auth
    // The user is authenticated...
@endauth

@guest
    // The user is not authenticated...
@endguest
```

or

```html
@auth('admin')
    // The user is authenticated...
@endauth

@guest('admin')
    // The user is not authenticated...
@endguest
```



## Business Logic/Controller methods

### constructor
```php
$blade=new bladeone\BladeOne($views,$compile,$mode);
```
- `BladeOne(templatefolder,compiledfolder,$mode)` Creates the instance of BladeOne.
-   **$views** indicates the folder or folders (it could be an array of folders) (without ending backslash) of where the template files (*.blade.php) are located.
-   **$compile** indicates the folder where the result of files will be saved. This folder should have write permission. Also, this folder could be located outside of the Web Root.
-   **$mode** (optional).  It sets the mode of the compile. See [setMode(mode)](#setmode) .  By default it's automatic

Example:  

```php
$blade=new bladeone\BladeOne(__DIR__.'/views',__DIR__.'/compiles');
// or multiple views:
$blade=new bladeone\BladeOne([__DIR__.'/views',__DIR__.'/viewsextras'],__DIR__.'/compiles');
```


### run
```php
echo $blade->run("hello",array("variable1"=>"value1"));
```
- run([template],[array])  Runs the template and generates a compiled version (if its required), then it shows the result.
-   **template** is the template to open. The dots are used for to separate folders.  If the template is called "folder.example" then the engine tries to open the file "folder/example.blade.php"
- - If the template has a slash (/), then it uses the full literal path, ignoring the default extension.  
-   **array (optional)**. Indicates the values to use for the template.  For example ['v1'=>10'], indicates the variable $v1 is equals to 10

Examples:

```php
echo $blade->run("path.hello",array("variable1"=>"value1")); // calls the template in /(view folders)/path/hello.blade.php
echo $blade->run("path/hello.blade.php",array("variable1"=>"value1")); // calls the template in /(view folders)/path/hello.blade.php
```

### share

It adds a global variable

```php
echo $blade->share("global","valueglobal"));
echo $blade->run("hello",array("variable1"=>"value1"));
```

### setOptimize(bool=false)

If true then it optimizes the result (it removes tab and extra spaces).  
By default BladeOne will optimize the result.

```php
$blade->setOptimize(false); 
```

### setIsCompiled(bool=false)

If false then the file is not compiled and it is executed directly from the memory.
This behaviour is slow because the compiled file is used as a cache and without 
this file, then the file is compiled each time.     
By default the value is true   
It also sets the mode to MODE_SLOW   

```php
$blade->setIsCompiled(false); 
```

### setMode

It sets the mode of compilation.

> If the constant BLADEONE_MODE is defined, then it has priority over setMode()

|mode|behaviour|
|---|---|
|BladeOne::MODE_AUTO|Automatic, BladeOne checks the compiled version, if it is obsolete, then a new version is compiled and it replaces the old one|
|BladeOne::MODE_SLOW|Slow, BladeOne always compile and replace with a new version.  It is useful for development|
|BladeOne::MODE_FAST|Fast, Bladeone never compile or replace the compiled version, even if it doesn't exist|
|BladeOne::MODE_DEBUG| It's similar to MODE_SLOW but also generates a compiled file with the same name than the template.


### setFileExtension($ext), getFileExtension

It sets or gets the extension of the template file. By default, it's .blade.php

> The extension includes the leading dot.

### setCompiledExtension($ext), getCompiledExtension

It sets or gets the extension of the template file. By default, it's .bladec

> The extension includes the leading dot.




### runString
```php
echo $blade->runString('<p>{{$direccion}}</p>', array('direccion'=>'cra 20 #33-58'));
```
- runString([expression],[array])  Evaluates the expression and returns the result.
-   expression = is the expression to evaluate
-   array (optional). Indicates the values to use for the template.  For example ['v1'=>10'], indicates the variable $v1 is equals to 10

### directive
It sets a new directive (command) that runs on compile time.
```php
$blade->directive('datetime', function ($expression) {
    return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
});
```
```html
@datetime($now)
```

### directiveRT
It sets a new directive (command) that runs on runtime time.
```php
$blade->directiveRT('datetimert', function ($expression) {
    echo $expression->format('m/d/Y H:i');
});
```

```html
@datetimert($now)
```


### BLADEONE_MODE (global constant) (optional)

It defines the mode of compilation (via global constant) See [setMode(mode)](#setmode) for more information.

```php
define("BLADEONE_MODE",BladeOne::MODE_AUTO);
```

- `BLADEONE_MODE` Is a global constant that defines the behaviour of the engine.
- Optionally, you could use `$blade->setMode(BladeOne::MODE_AUTO);`

### setErrorFunction
In order to use `@error()`, you must first add a callback function so that BladeOne knows where to get your errors from.

The callback will be passed the `$key` to find errors for, and must return `false` if no error is found, and `true` if it is.

If you want to use `$message` as per the Laravel implementation, just before sure your error callback returns an error `string` or `false` if not found:
```php
$errorCallback = function($key = null) use ($errorArray) {
    if (array_key_exists($key, $errorArray)) {
        return $errorArray[$key];
    }

    return false;
};

$blade->setErrorFunction($errorCallback);
```

```php
<input id="title" type="text" class="@error('title') is-invalid @enderror">

@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```

### setCanFunction and setAnyFunction
The `setCanFunction`  must be set in order to use `@can`/`@cannot`/`@elsecan`/`@Eesecannot`, and likewise `setAnyFunction` is used to allow `@canany` to work.

Very similar to `setErrorFunction`, just pass a `callable` in which will return a `bool` value indicating is the current user can perform a given action:

```php
$blade->setCanFunction(function($action, $subject = null) {
    // Perform your permissions checks here
    
    return true;
});
```

#### Quick permission validation
You can also provide the current user's permissions via the `setAuth` method for a quick solution:

```php
$permissions = ['read', 'write'];
$blade->setAuth($username, $role, $permissions);
```

This method will perform a simple check to see if the action requested by `@can`/`@cannot` etc is in the provided array of permissions.

Although this works fine for simple solutions, adding a full-featured check via `setCanFunction` and `setAnyFunction` is advisable.

## Template tags

### Template Inheritance

### In the master page (layout)
|Tag|Note|
|---|---|
|@section('sidebar')|Start a new section|
|@show|Indicates where the content of section will be displayed|
|@yield('title')|Show here the content of a section|

### Using the master page (using the layout)
|Tag|Note|
|---|---|
|@extends('layouts.master')|Indicates the layout to use|
|@section('title', 'Page Title')|Sends a single text to a section|
|@section('sidebar')|Start a block of code to send to a section|
|@endsection|End a block of code|


Note :(*) This feature is in the original documentation but it's not implemented either is it required. Maybe it's an obsolete feature.

### variables
|Tag|Note|
|---|---|
|{{$variable1}}|show the value of the variable using htmlentities (avoid xss attacks)|
|@{{$variable1}}|show the value of the content directly (not evaluated, useful for js)|
|{!!$variable1!!}|show the value of the variable without htmlentities (no escaped)|
|{{ $name or 'Default' }}|value or default|
|{{Class::StaticFunction($variable)}}|call and show a function (the function should return a value)|

### logic
|Tag|Note|
|---|---|
|@if (boolean)|if logic-conditional|
|@elseif (boolean)|else if logic-conditional|
|@else|else logic|
|@endif|end if logic|
|@unless(boolean)|execute block of code is boolean is false|

### loop

#### @for($variable;$condition;$increment) / @endfor
_Generates a loop until the condition is meet and the variable is incremented for each loop_   

|Tag|Note|Example|
|---|---|---|
|$variable|is a variable that should be initialized.|$i=0|  
|$condition|is the condition that must be true, otherwise the cycle will end.|$i<10|
|$increment|is how the variable is incremented in each loop.|$i++|

Example:   
```html
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}<br>
@endfor
```
Returns:   
```html
The current value is 0
The current value is 1
The current value is 2
The current value is 3
The current value is 4
The current value is 5
The current value is 6
The current value is 7
The current value is 8
The current value is 9
```

#### @inject('variable name', 'namespace')

```html
@inject('metric', 'App\Services\MetricsService')
<div>
    Monthly Revenue: {{ $metric->monthlyRevenue() }}.
</div>
```

By default, BladeOne creates a new instance of the class `'variable name'` inside `'namespace'` with the parameterless constructor.

To override the logic used to resolve injected classes, pass a function to `setInjectResolver`.


Example with Symphony Dependency Injection.
```php
$containerBuilder = new ContainerBuilder();
$loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('services.xml');

$blade->setInjectResolver(function ($namespace, $variableName) use ($loader) {
    return $loader->get($namespace);
});
```



#### @foreach($array as $alias) / @endforeach
Generates a loop for each values of the variable.    

|Tag|Note|Example|
|---|---|---|
|$array|Is an array with values.|$countries|  
|$alias|is a new variable that it stores each interaction of the cycle.|$country|

Example: ($users is an array of objects)
```html
@foreach($users as $user)
    This is user {{ $user->id }}
@endforeach
```
Returns:
```html
This is user 1
This is user 2
```

#### @forelse($array as $alias) / @empty / @endforelse
Its the same as foreach but jumps to the `@empty` tag if the array is null or empty   

|Tag|Note|Example|
|---|---|---|
|$array|Is an array with values.|$countries|  
|$alias|is a new variable that it stores each interaction of the cycle.|$country|


Example: ($users is an array of objects)
```html
@forelse($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse
```
Returns:
```html
John Doe
Anna Smith
```

#### @while($condition) / @endwhile
Loops until the condition is not meet.

|Tag|Note|Example|
|---|---|---|
|$condition|The cycle loops until the condition is false.|$counter<10|  


Example: ($users is an array of objects)
```html
@set($whilecounter=0)
@while($whilecounter<3)
    @set($whilecounter)
    I'm looping forever.<br>
@endwhile
```
Returns:
```html
I'm looping forever.
I'm looping forever.
I'm looping forever.
```

#### @splitforeach($nElem,$textbetween,$textend="")  inside @foreach
This functions show a text inside a `@foreach` cycle every "n" of elements.  This function could be used when you want to add columns to a list of elements.   
NOTE: The `$textbetween` is not displayed if its the last element of the last.  With the last element, it shows the variable `$textend`

|Tag|Note|Example|
|---|---|---|
|$nElem|Number of elements|2, for every 2 element the text is displayed|  
|$textbetween|Text to show|`</tr><tr>`| 
|$textend|Text to show|`</tr>`| 

Example: ($users is an array of objects)
```html
<table border="1">
<tr>
@foreach($drinks7 as $drink)
    <td>{{$drink}}</td>
    @splitforeach(2,'</tr><tr>','</tr>')
    @endforeach
</table>
```
Returns a table with 2 columns.

#### @continue / @break
Continue jump to the next iteration of a cycle.  `@break` jump out of a cycle.

|Tag|Note|Example|
|---|---|---|

Example: ($users is an array of objects)
```html
@foreach($users as $user)
    @if($user->type == 1) // ignores the first user John Smith
    @continue
    @endif
    <li>{{ $user->type }} - {{ $user->name }}</li>

    @if($user->number == 5) // ends the cycle.
        @break
    @endif
@endforeach
```
Returns:
```html
2 - Anna Smith
```
### switch / case

_Example:(the indentation is not required)_
```html
@switch($countrySelected)
    @case(1)
        first country selected<br>
    @break
    @case(2)
        second country selected<br>
    @break
    @defaultcase()
        other country selected<br>
@endswitch()
```

- `@switch` The first value is the variable to evaluate.
- `@case` Indicates the value to compare.  It should be run inside a @switch/@endswitch
- `@default` (optional) If not case is the correct then the block of @defaultcase is evaluated.
- `@break` Break the case
- `@endswitch` End the switch.

## Template

### @compilestamp($format='')
It shows the current date of the compiled template

```html
@compileStamp() // returns the current date and time as "Y-m-d H:i:s"
@compileStamp('d') // returns the current date AND TIME AS "d" (day)
```

### @viewname($type='') 

It shows the name of the template

```html
@viewname('compiled') // the full filename of the compiled file
@viewname('template') // the full filename of the template
@viewname('') // the name of the filename
```

## Sub Views
|Tag|Note|
|---|---|
|@include('folder.template')|Include a template|
|@include('folder.template',['some' => 'data'])|Include a template with new variables|
|@each('view.name', $array, 'variable')|Includes a template for each element of the array|
Note: Templates called folder.template is equals to folder/template

### @include
It includes a template

You could include a template as follow:
```html
<div>
    @include('shared.errors')
    <form>
        <!-- Form Contents -->
    </form>
</div>
```

You could also pass parameters to the template
```html
@include('view.name', ['some' => 'data'])
```
### @includeif

Additionally, if the template doesn't exist then it will fail. You could avoid it by using includeif
```html
@includeIf('view.name', ['some' => 'data'])
```
### @includefast

`@Includefast` is similar to `@include`. However, it doesn't allow parameters because it merges the template in a big file (instead of relying on different files), so it must be fast at runtime by using more space on the hard disk versus less call to read a file.


```html
@includefast('view.name')
```

>This template runs at compile time, so it doesn't work with runtime features such as @if() @includefast() @endif()

### aliasing include

Laravel's blade allows to create aliasing include. Laravel calls this method "include()". However, PHP 5.x doesn't allow to use
the name "include()" so in this library is called "**addInclude()**". 

How it work?

If your BladeOne includes are stored in a sub-directory, you may wish to alias them for easier access. For example, imagine a BladeOne include that is stored at views/includes/input.blade.php with the following content:

📁 views/includes/input.blade.php

    <input type="{{ $type ?? 'text' }}">

You may use the include method to alias the include from includes.input to input. 

    Blade->addInclude('includes.input', 'input');

Once the include has been aliased, you may render it using the alias name as the Blade directive:

    @input(['type' => 'email'])



## Comments
|Tag|Note|
|---|---|
|{{-- text --}}|Include a comment|

### Stacks
|Tag|Note|
|---|---|
|@push('elem')|Add the next block to the push stack|
|@pushonce('elem')|Add the next block to the push stack. It is only pushed once.|
|@endpush|End the push block|
|@stack('elem')|Show the stack|

```html
@push('scripts')
script1
@endpush
@push('scripts')
script2
@endpush
@push('scripts')
script3
@endpush
<hr>
@stack('scripts')
<hr>
```

It returns 

```html
<hr>
script1 script2 script3
<hr>
```

```html
@pushonce('scripts')
script1
@endpushonce
@pushonce('scripts')
script2
@endpushonce
@pushonce('scripts')
script3
@endpushonce
<hr>
@stack('scripts')
<hr>
```

It returns 

```html
<hr>
script1
<hr>
```




## @set
```
@set($variable=[value])
```
`@set($variable)` is equals to `@set($variable=$variable+1)`
- `$variable` defines the variable to add. If not value is defined and it adds +1 to a variable.
- value (option) define the value to use.

### Service Inject
|Tag|Note|
|---|---|
|@inject('metrics', 'App\Services\MetricsService')|Used for insert a Laravel Service|NOT SUPPORTED|

## Asset Management

The next libraries are designed to work with assets (CSS, JavaScript, images and so on). While it's possible to show an asset without a special library but it's a challenge if you want to work with relative path using an MVC route.

For example, let's say the next example:
http://localhost/img/resource.jpg

you could use the full path.
```html
<img src='http://localhost/img/resource.jpg' />
```
However, it will fail if the server changes.
So, you could use a relative path.
```html
<img src='img/resource.jpg' />
```
However, it fails if you are calling the web
http://localhost/controller/action/

because the browser will try to find the image at
http://localhost/controller/action/img/resource.jpg
instead of
http://localhost/img/resource.jpg

So, the solution is to set a base URL and to use an absolute or relative path

Absolute using `@asset`
```html
<img src='@asset("img/resource.jpg")' />
```
is converted to
```html
<img src='http://localhost/img/resource.jpg' />
```

Relative using @relative
```html
<img src='@relative("img/resource.jpg")' />
```
is converted to (it depends on the current url)
```html
<img src='../../img/resource.jpg' />
```

It is even possible to add an alias to resources. It is useful for switching from local to CDN.

```php
$blade->addAssetDict('js/jquery.min.js','https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
```
so then
```html
@asset('js/jquery.min.js')
```

returns
```html
https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js
```

:file_folder: Example: [BladeOne/examples/relative1/relative2/callrelative.php](https://github.com/EFTEC/BladeOne/blob/master/examples/examplerelative.php)


### @asset
It returns an absolute path of the resource. 

```html
@asset('js/jquery.js')
```
Note: it requires to set the base address as 
```php
$obj=new BladeOne();
$obj->setBaseUrl("https://www.example.com/urlbase/"); // with or without trail slash
```
> Security: Don't use the variables $SERVER['HTTP_HOST'] or $SERVER['SERVER_NAME'] unless the url is protected or the address is sanitized.

### @use(namespace)
It works exactly like the command "use" of PHP.  

```
@use(\namespace1\namespace2)
```

### @resource

It's similar to `@asset`. However, it uses a relative path.
```
@resource('js/jquery.js')
```


Note: it requires to set the base address as 
```php
$obj=new BladeOne();
$obj->setBaseUrl("https://www.example.com/urlbase/"); // with or without trail slash
```

### setBaseUrl($url)
It sets the base url.

```php
$obj=new BladeOne();
$obj->setBaseUrl("https://www.example.com/urlbase/"); // with or without trail slash
```



### getBaseUrl()
It gets the current base url.

```php
$obj=new BladeOne();
$url=$obj->getBaseUrl(); 
```

### addAssetDict($name,$url)
It adds an alias to an asset. It is used for `@asset` and `@relative`. If the name exists then `$url` is used.

```php
$obj=new BladeOne();
$url=$obj->addAssetDict('css/style.css','http://....'); 
```


## Extensions Libraries (optional)
[BladeOneHtml Documentation](BladeOneHtml.md)

[BladeOneCache Documentation](BladeOneCache.md)

[BladeOneLang Documentation](BladeOneLang.md)

## Calling a static methods inside the template.

Since **3.34**, BladeOne allows to call a static method inside a class.

Let's say we have a class with namespace \namespace1\namespace2

```php
namespace namespace1\namespace2 {
    class SomeClass {
        public static function Method($arg='') {
            return "hi world";
        }
    }
}
```

### Method 1 PHP Style

We could add a "use" in the template.  Example:

Add the next line to the template
```html
@use(\namespace1\namespace2)
```

and the next lines to the template (different methods)

```html
{{SomeClass::Method()}}
{!! SomeClass::Method() !!}
@SomeClass::Method()
```

> All those methods are executed at runtime


### Method 2 Alias
Or we could define alias for each classes.

php code:
```php
    $blade = new BladeOne();
    // with the method addAliasClasses
    $blade->addAliasClasses('SomeClass', '\namespace1\namespace2\SomeClass');
    // with the setter setAliasClasses
    $blade->setAliasClasses(['SomeClass'=>'\namespace1\namespace2\SomeClass']);
    // or directly in the field
    $blade->aliasClasses=['SomeClass'=>'\namespace1\namespace2\SomeClass'];
```

Template:
```html
{{SomeClass::Method()}}
{!! SomeClass::Method() !!}
@SomeClass::Method()
```

> We won't need alias or use for global classes.

## Definition of Blade Template
https://laravel.com/docs/7/blade

## Differences between Blade and BladeOne

- Laravel's extension removed.
- Dependencies to other class removed (around 30 classes).
- The engine is self-contained.
- Setter and Getters removed. Instead, we are using the PHP style (public members).
- BladeOne doesn't support static calls.

## Differences between Blade+Laravel and BladeOne+BladeOneHTML

Instead of use the Laravel functions, for example Form::select
```html
{{Form::select('countryID', $arrayCountries,$countrySelected)}}
```

> Note: Since 3.34 this method is also allowed.

We have native tags as @select,@item,@items and @endselect
```html
@select('countryID')
    @item('0','--Select a country--',$countrySelected)
    @items($arrayCountries,'id','name',$countrySelected)
@endselect()
```

bad example:
```html
@extends("_shared.htmltemplate")
@section("content")
@endsection
this is a bug
```

result:
```html
this is a bug
<!DOCTYPE html>
<html>
   <head>....</head>
   <body>....</body>
</html>
```

bad too: (check the empty line at the bottom).  This is not as bad but a small annoyance.
```html
@endsection(line carriage)
(empty line)
```

good:
```html
@endsection
```
## SourceGuardian

This library is compatible with [SourceGuardian](https://www.sourceguardian.com).   
 
>SourceGuardian provides full PHP 4, PHP 5 and PHP 7 support including the latest PHP 7.2 along with many other protection and encryption features.
 
However:  
 
* You must avoid encoding the template folder (copy unencoded the views folder).
* Optionally, you must avoid encoding the compiled folder because the files could be replaced by Bladeone. Also, you could run BladeOne in mode `BladeOne::MODE_FAST` and encode the compile folder)      

So,   
* **\view** folder = copy unencoded.
* **\compiled** folder (BladeOne::MODE_FAST)= php/html script (encode)
* **\compiled folder** (anything but BladeOne::MODE_FAST)= skip files (because it will be replaced)
* **(everything else)** = php/html script (encode)

I don't know about the compatibility of [Ioncube](http://www.ioncube.com/) or [Zend Guard](http://www.zend.com/en/products/zend-guard) I don't own a license of it.  


## Collaboration

You are welcome to use it, share it, ask for changes and whatever you want to. Just keeps the copyright notice in the file.

## Future
* Blade locator/container

## Missing

Some features are missing because they are new, or they lack documentation or they are specific to Laravel (then, they are useless without it)

- Laravel's own commands. Reason: This library is free of Laravel
- ~~Custom if. Reason: It is dangerous and odds.~~ DONE
- blade extension Reason: Extensions (that is part of the code, not in the template) is managed differently on BladeOne.
- ~~@php. Pending. I'm not so sure to implement this one. If you are using this one, then you are doing it wrong.~~ DONE
- ~~@canany. Pending. :baby_chick:~~ DONE
- ~~@can ( https://laravel.com/docs/5.6/authorization ). Pending~~ DONE
- ~~@cannot. Pending~~ DONE
- ~~@elseauth. Pending~~ DONE
- ~~@elseguest. Pending~~ DONE
- ~~@dump. Done. Ugly but it is done~~ DONE
- ~~@elsecan. Pending~~ DONE
- ~~@elsecanany. Pending :baby_chick:~~ DONE
- ~~@elsecannot. Pending~~ DONE
- ~~@endcanany. Pending :baby_chick:~~ DONE
- ~~@endcannot. Pending~~ DONE
- ~~@endunless. Pending~~ DONE
- ~~@csrf. Pending~~ DONE
- ~~@dd. Done. Ugly but it is done too.~~ DONE
- ~~@method. Pending~~ DONE
- Comment with the name of the template folder. It is not done because it could break functionality.
 BladeOne allows to write and work even with non-html templates.
 