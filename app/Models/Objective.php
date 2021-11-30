<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Objective
 *
 * @property int $id
 * @property string $result 成果詳細
 * @property int|null $score スコア
 * @property string|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Objective newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective query()
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $okr_id okrID
 * @property-read \App\Models\Okr|null $okrs
 * @method static \Database\Factories\ObjectiveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereOkrId($value)
 * @property string $name 成果指標
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereName($value)
 * @property string $detail 成果指標
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereDetail($value)
 */
class Objective extends Model
{
    use HasFactory;

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
        'detail',
        'score',
        'okr_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'detail' => 'string',
        'score' => 'float',
        'okr_id' => 'int',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function okrs(): BelongsTo
    {
        return $this->belongsTo(Okr::class, 'okr_id');
    }
}
