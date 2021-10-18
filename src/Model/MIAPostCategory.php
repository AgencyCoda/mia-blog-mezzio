<?php 

namespace Mia\Blog\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Description of Model
 * @property int $id Notification ID
 * @property int $post_id Post ID
 * @property int $category_id Category ID
 *
 * @OA\Schema()
 * @OA\Property(
 *  property="id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="post_id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="category_id",
 *  type="integer",
 *  description=""
 * )
 *
 * @author matiascamiletti
 */
class MIAPostCategory extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Name of table
     */
    protected $table = 'mia_post_category';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(MIACategory::class, 'category_id');
    }
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(MIAPost::class, 'post_id');
    }
}