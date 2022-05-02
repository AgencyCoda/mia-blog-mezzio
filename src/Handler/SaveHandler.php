<?php

namespace Mia\Blog\Handler;

use Mia\Blog\Model\MIAPost;
use Mia\Blog\Model\MIAPostCategory;
use Mia\Blog\Model\MIAPostRelated;
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
     * @var boolean
     */
    protected $isNew = false;
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
        $item->photo_featured = $this->getParam($request, 'photo_featured', []);
        $item->photo_featured_mobile = $this->getParam($request, 'photo_featured_mobile', []);
        $item->is_featured = intval($this->getParam($request, 'is_featured', '0'));
        $item->status = intval($this->getParam($request, 'status', '0'));
        $item->seo_title = $this->getParam($request, 'seo_title', '');
        $item->seo_description = $this->getParam($request, 'seo_description', '');
        $item->seo_keywords = $this->getParam($request, 'seo_keywords', '');
        $item->visibility = intval($this->getParam($request, 'visibility', '0'));

        try {
            $item->save();

            $this->saveCategories($item, $this->getParam($request, 'categories', []));
            $this->saveRelated($item, $this->getParam($request, 'relateds', []));
        } catch (\Exception $exc) {
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-2, $exc->getMessage());
        }

        // Devolvemos respuesta
        return new \Mia\Core\Diactoros\MiaJsonResponse($item->toArray());
    }

    protected function saveCategories(MIAPost $post, $categories)
    {
        // Remove all Items
        if(!$this->isNew){
            MIAPostCategory::where('post_id', $post->id)->delete();
        }
        // For each objects
        foreach($categories as $obj){
            $row = new MIAPostCategory();
            $row->category_id = $obj['id'];
            $row->post_id = $post->id;
            $row->save();
        }
    }

    protected function saveRelated(MIAPost $post, $posts)
    {
        // Remove all Items
        if(!$this->isNew){
            MIAPostRelated::where('post_id', $post->id)->delete();
        }
        // For each objects
        foreach($posts as $obj){
            $row = new MIAPostRelated();
            $row->post_related_id = $obj['id'];
            $row->post_id = $post->id;
            $row->save();
        }
    }

    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return MIAPost
     */
    protected function getForEdit(\Psr\Http\Message\ServerRequestInterface $request)
    {
        // Obtenemos ID si fue enviado
        $itemId = $this->getParam($request, 'id', '');
        // Buscar si existe el item en la DB
        $item = MIAPost::find($itemId);
        // verificar si existe
        if($item === null){
            $this->isNew = true;
            return new MIAPost();
        }
        // Devolvemos item para editar
        return $item;
    }
}