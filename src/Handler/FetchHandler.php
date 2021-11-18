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
class FetchHandler extends \Mia\Core\Request\MiaRequestHandler
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
        // Verify has withs in query
        $withs = $this->getParam($request, 'withs', '');
        $countWiths = $this->getParam($request, 'count_withs', '');
        if($countWiths != ''){
            // Convert to array
            $with = explode(',', $countWiths);
            // Search item in DB
            $item = MIAPost::with($with)->where('id', $itemId)->first();
        } else if($withs != ''){
            $query = MIAPost::where('id', $itemId);
            // Convert to array
            $withs = explode(',', $withs);
            foreach($withs as $wc){ 
                $query->withCount($wc);
            }
            // Search item in DB
            $item = $query->first();
        } else {
            // Buscar si existe el tour en la DB
            $item = MIAPost::find($itemId);
        }
        // verificar si existe
        if($item === null){
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(1, 'This element not exist.');
        }
        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }
}