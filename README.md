# AgencyCoda Blog Mezzio

1. Incluir libreria:
```bash
composer require mobileia/mia-core-mezzio
composer require mobileia/mia-auth-mezzio
composer require mobileia/mia-blog-mezzio
```
5. Agregando las rutas:
```php
    /** MIA BLOG **/
    $app->route('/mia-blog/list', [Mia\Blog\Handler\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.list');
    $app->route('/mia-blog/category/list', [Mia\Blog\Handler\Category\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.category.list');
```