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
    $app->route('/mia-blog/fetch/{id}', [Mia\Blog\Handler\FetchHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.fetch-by-id');
    $app->route('/mia-blog/fetch-by-slug/{slug}', [Mia\Blog\Handler\FetchBySlugHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.fetch-by-slug');
    $app->route('/mia-blog/list', [Mia\Blog\Handler\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.list');
    $app->route('/mia-blog/category/list', [Mia\Blog\Handler\Category\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-blog.category.list');
    $app->route('/mia-blog/save', [\Mia\Auth\Handler\AuthHandler::class, new \Mia\Auth\Middleware\MiaRoleAuthMiddleware([MIAUser::ROLE_ADMIN]), Mia\Blog\Handler\SaveHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia-blog.save');
    $app->route('/mia-blog/remove/{id}', [\Mia\Auth\Handler\AuthHandler::class, new \Mia\Auth\Middleware\MiaRoleAuthMiddleware([MIAUser::ROLE_ADMIN]), Mia\Blog\Handler\RemoveHandler::class], ['GET', 'DELETE', 'OPTIONS', 'HEAD'], 'mia-blog.remove');
```