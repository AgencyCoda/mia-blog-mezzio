<?php

namespace Mia\Blog\Handler;

use Mia\Blog\Model\MIAPost;
use Mia\Core\Helper\StringHelper;

/**
 * Description of FetchHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/save",
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
class SaveHandler extends \Mia\Core\Request\MiaRequestHandler
{
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtener item a procesar
        $item = $this->getForEdit($request);
        // Guardamos data
        $item->title = $this->getParam($request, 'title', '');
        $item->slug = StringHelper::createSlug($item->title);
        $item->content = $this->getParam($request, 'content', '');
        $item->summary = $this->getParam($request, 'summary', '');
        $item->photo_featured = $this->getParam($request, 'photo_featured', '');
        $item->photo_featured_mobile = $this->getParam($request, 'photo_featured_mobile', '');
        $item->is_featured = intval($this->getParam($request, 'is_featured', '0'));
        $item->status = intval($this->getParam($request, 'status', '0'));
                
        try {
            $item->save();
        } catch (\Exception $exc) {
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }

    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \App\Model\Team
     */
    protected function getForEdit(\Psr\Http\Message\ServerRequestInterface $request)
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Buscar si existe el item en la DB
        $item = MIAPost::find($itemId);
        // verificar si existe
        if($item === null){
            return new MIAPost();
        }
        // Devolvemos item para editar
        return $item;
    }
}