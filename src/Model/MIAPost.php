<?php 

namespace Mia\Blog\Model;

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