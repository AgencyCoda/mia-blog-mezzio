<?php 

namespace Mia\Blog\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Description of Model
 * @property int $id Notification ID
 * @property int $post_id Post ID
 * @property int $post_related_id Category ID
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
 *  property="post_related_id",
 *  type="integer",
 *  description=""
 * )
 *
 * @author matiascamiletti
 */
class MIAPostRelated extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Name of table
     */
    protected $table = 'mia_post_related';
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
    public function post()
    {
        return $this->belongsTo(MIAPost::class, 'post_id');
    }
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function related()
    {
        return $this->belongsTo(MIAPost::class, 'post_related_id');
    }

}