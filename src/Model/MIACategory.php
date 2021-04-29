<?php 

namespace Mia\Blog\Model;

/**
 * Description of Model
 * @property int $id Notification ID
 * @property string $title Title
 * @property string $slug Slug
 * @property int $status Status
 * @property int $is_featured Is Featured
 *
 * @OA\Schema()
 * @OA\Property(
 *  property="id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="title",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="slug",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="status",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="is_featured",
 *  type="integer",
 *  description=""
 * )
 *
 * @author matiascamiletti
 */
class MIACategory extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Name of table
     */
    protected $table = 'mia_blog_category';

    //protected $casts = ['data' => 'array'];
}