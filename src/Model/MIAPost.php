<?php 

namespace Mia\Blog\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Mia\Auth\Model\MIAUser;

/**
 * Description of Model
 * @property int $id Notification ID
 * @property string $title Title
 * @property string $slug Slug
 * @property string $content Content
 * @property string $summary Summary
 * @property string $photo_featured Photo featured data
 * @property string $photo_featured_mobile Photo featured data
 * @property int $status Status
 * @property int $type Type
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
 *  property="content",
 *  type="string",
 *  description=""
 * )
 * @OA\Property(
 *  property="summary",
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
class MIAPost extends \Illuminate\Database\Eloquent\Model
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_CANCELLED = 2;

    /**
     * Name of table
     */
    protected $table = 'mia_post';

    protected $casts = ['photo_featured' => 'array', 'photo_featured_mobile' => 'array'];

    /**
     * 
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(MIAComment::class, 'post_id')->orderBy('created_at', 'desc');
    }
    /**
     * 
     *
     * @return HasMany
     */
    public function categories()
    {
        return $this->hasMany(MIAPostCategory::class, 'post_id');
    }
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(MIAUser::class, 'creator_id');
    }
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function relateds()
    {
        return $this->hasManyThrough(MIAPost::class, MIAPostRelated::class, 'post_id', 'id', 'id', 'post_related_id');
    }

    /**
     * 
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        
        static::addGlobalScope('exclude', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('mia_post.deleted', 0);
        });
    }
}