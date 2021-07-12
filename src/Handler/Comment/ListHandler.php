<?php

namespace Mia\Blog\Handler\Comment;

use Mia\Blog\Repository\MIACommentRepository;

/**
 * Description of ListHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/comment/list",
 *     summary="Get all posts",
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MIAComment")
 *     )
 * )
 *
 * @author matiascamiletti
 */
class ListHandler extends \Mia\Core\Request\MiaRequestHandler
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Configurar query
        $configure = new \Mia\Database\Query\Configure($this, $request);
        // Obtenemos información
        $rows = MIACommentRepository::fetchByConfigure($configure);
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($rows->toArray());
    }
}