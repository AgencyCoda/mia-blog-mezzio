<?php

namespace Mia\Blog\Handler\Comment;

use Mia\Blog\Model\MIAComment;
use Mia\Blog\Model\MIAPost;
use Mia\Core\Exception\MiaException;

/**
 * Description of FetchHandler
 * 
 * @OA\Get(
 *     path="/mia-blog/comment/save",
 *     summary="Mia Comment Save",
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
class SaveHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
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
        $item->content = $this->getParam($request, 'content', '');
        $item->status = MIAComment::STATUS_APPROVED;
                
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
        // Get Current user
        $user = $this->getUser($request);
        // Obtenemos ID si fue enviado
        $postId = $this->getParam($request, 'post_id', '');
        // Buscar si existe el tour en la DB
        $post = MIAPost::find($postId);
        // verificar si existe
        if($post === null){
            throw new MiaException('This element not exist.');
        }
        // Create entity
        $item = new MIAComment();
        $item->post_id = $postId;
        $item->user_id = $user->id;

        return $item;
    }
}