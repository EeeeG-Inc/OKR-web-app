<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Objective.
 *
 * @property int $id
 * @property string $objective 目標
 * @property null|float $score 総合スコア
 * @property int $user_id ユーザID
 * @property int $year 年度
 * @property int $quarter_id 四半期ID
 * @property null|\Illuminate\Support\Carbon $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\KeyResult[]|\Illuminate\Database\Eloquent\Collection $keyResults
 * @property-read null|int $key_results_count
 * @property-read \App\Models\Quarter $quarters
 * @property-read \App\Models\User $users
 * @method static \Database\Factories\ObjectiveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective query()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereObjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereQuarterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereYear($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|Objective onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Objective withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Objective withoutTrashed()
 */
class Objective extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'objectives';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'objective',
        'score',
        'user_id',
        'year',
        'quarter_id',
        'remarks',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'objective' => 'string',
        'score' => 'double',
        'user_id' => 'int',
        'year' => 'int',
        'quarter_id' => 'int',
        'remarks' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quarters(): BelongsTo
    {
        return $this->belongsTo(Quarter::class, 'quarter_id');
    }

    public function keyResults(): HasMany
    {
        return $this->hasMany(KeyResult::class, 'object_id');
    }
}
