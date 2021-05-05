<?php

namespace Mia\Blog\Handler;

use Mia\Blog\Model\MIAPost;

/**
 * Description of FetchHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/fetch-by-slug/{slug}",
 *     summary="Mia POst Fetch",
 *     tags={"MIA Blog"},
 *     @OA\Parameter(
 *         name="id",
 *         description="Id of Item",
 *         required=true,
 *         in="path"
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Campaign")
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 *
 * @author matiascamiletti
 */
class FetchBySlugHandler extends \Mia\Core\Request\MiaRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtenemos ID si fue enviado
        $slug = $this->getParam($request, 'slug', '');
        // Buscar si existe el tour en la DB
        $item = MIAPost::where('slug', $slug)->first();
        // verificar si existe
        if($item === null){
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(1, 'This element not exist.');
        }
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
}