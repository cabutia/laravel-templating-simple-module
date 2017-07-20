# TemplateCreationModule

I'm gonna end with this:

Put the **CreateTemplate.php** file, in your `App\Console\Commands\` directory.
Then, open your `Kernel.php` file, and add these lines into `protected $commands` array:
```(php)
Commands\CreateTemplate::class,
```

# How to use it?

Simple, open a `Terminal` cd into your `project` folder.
This is the command syntax:
```(bash)
php artisan template:make {name} {--dev}
```

This will create the necessary directories. The `--dev` option, is pruposed for testing, it will delete any directory created with the command. Basically, you'll see the output. Just that!


## Inside templates

Your templates will be **.blade.php** files.

**<a>** tags:
```blade
<a href="{{ TR::route($template, 'contact') }}">Go to contact page!</a>
```
Passing 'contact' as 2nd arg, will return the 'contact.blade.php'
view inside the same folder than 'index.blade.php'

**sources** like `<link>` and `<script>` tags, will be like this:
```blade
<script src="{{ TR::src($template, 'your/path/to/file/in/public/folder') }}" type="text/javascript"></script>
```

# Requirements

Create a `TemplateController` file inside your `Project\app\Http\Controllers\` folder, with the next code:
```php
<?php

namespace App\Http\Controllers;

use \App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
      $templates = Template::all();
      return view('webtemplating.index')->with('templates', $templates);
    }

    public function viewurl($slug, $uri = '')
    {
      $template = Template::view($slug);
      $path = $template->path;
      $path.= ($uri == '') ? '/index' : '/'.$uri;
      return view('webtemplating.demo')->with(['route' => $path, 'template' => $template->slug]);
    }
}
```

Create a `TemplateRouteHelper.php` with this content:
```php
<?php
namespace App\Helpers\Functions;

class TemplateRouteHelper
{

  static function route($slug, $uri = '')
  {
    return route('template.view.url', ['slug' => $slug, 'uri' => $uri]);
  }

  static function src($slug, $path)
  {
    $fullpath = 'templates/'.$slug.'/'.$path;
    return asset($fullpath);
  }

}

```


And add it to your aliases in your `Project\config\app.php` file:
```php
'TR' => App\Helpers\Functions\TemplateRouteHelper::class,
```
