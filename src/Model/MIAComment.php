<?php 

namespace Mia\Blog\Model;

use Mia\Auth\Model\MIAUser;

/**
 * Description of Model
 * @property int $id Comment ID
 * @property string $content Content
 * @property int $post_id Post
 * @property int $user_id User
 * @property int $status Status
 *
 * @OA\Schema()
 * @OA\Property(
 *  property="id",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="content",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="post_id",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="status",
 *  type="integer",
 *  description=""
 * )
 * @OA\Property(
 *  property="user_id",
 *  type="integer",
 *  description=""
 * )
 *
 * @author matiascamiletti
 */
class MIAComment extends \Illuminate\Database\Eloquent\Model
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_CANCELLED = 2;

    /**
     * Name of table
     */
    protected $table = 'mia_post_comment';

    //protected $casts = ['photo_featured' => 'array', 'photo_featured_mobile' => 'array'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(MIAUser::class, 'user_id');
    }

    /**
     * 
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        
        static::addGlobalScope('exclude', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('mia_post_comment.deleted', 0);
        });
    }
}