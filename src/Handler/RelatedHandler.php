<?php

namespace Mia\Blog\Handler;

use Mia\Blog\Model\MIAPost;

/**
 * Description of FetchHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/fetch/{id}",
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
class RelatedHandler extends \Mia\Core\Request\MiaRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Generate query
        $item = MIAPost::where('id', $itemId)->first();
        // verificar si existe
        if($item === null){
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(1, 'This element not exist.');
        }
        // get Relateds
        $relateds = $item->relateds;
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($relateds->toArray());
    }
}