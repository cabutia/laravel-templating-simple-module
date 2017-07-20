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
