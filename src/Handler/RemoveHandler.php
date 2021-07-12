<?php

namespace Mia\Blog\Handler;

use Mia\Blog\Model\MIAPost;

/**
 * Description of ListHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/remove/{id}",
 *     summary="Remove item",
 *     @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/MIAPost")
 *     )
 * )
 *
 * @author matiascamiletti
 */
class RemoveHandler extends \Mia\Core\Request\MiaRequestHandler
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Buscar si existe el item en la DB
        $item = MIAPost::find($itemId);
        // verificar si existe
        if($item === null){
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(1, 'This element is not exist.');
        }
        $item->deleted = 1;
        $item->save();
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse(true);
    }
}