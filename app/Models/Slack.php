<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Slack
 *
 * @property int $id
 * @property string $webhook Webhook URL
 * @property int $company_id 会社ID
 * @property bool $is_active 有効フラグ
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $companies
 * @method static \Illuminate\Database\Eloquent\Builder|Slack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slack newQuery()
 * @method static \Illuminate\Database\Query\Builder|Slack onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slack query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slack whereWebhook($value)
 * @method static \Illuminate\Database\Query\Builder|Slack withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Slack withoutTrashed()
 * @mixin \Eloquent
 */
class Slack extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'slacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'webhook',
        'company_id',
        'is_active',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'webhook'    => 'string',
        'company_id' => 'int',
        'is_active'  => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
