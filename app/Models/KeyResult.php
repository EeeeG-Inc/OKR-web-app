<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TextReplace;
/**
 * App\Models\KeyResult.
 *
 * @property int $id
 * @property string $objective 成果指標
 * @property null|int $score スコア
 * @property null|string $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
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
 * @property null|int $okr_id okrID
 * @property-read null|\App\Models\Okr $okrs
 * @method static \Database\Factories\ObjectiveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereOkrId($value)
 * @property string $name 成果指標
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereName($value)
 * @property string $objective 成果指標
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereObjective($value)
 * @property string $detail 成果指標
 * @method static \Illuminate\Database\Eloquent\Builder|Objective whereDetail($value)
 * @property string $key_result 成果指標
 * @property null|int $objective_id objectiveID
 * @property-read null|\App\Models\Objective $objectives
 * @method static \Illuminate\Database\Eloquent\Builder|KeyResult whereKeyResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeyResult whereObjectiveId($value)
 * @method static \Illuminate\Database\Query\Builder|KeyResult onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|KeyResult withTrashed()
 * @method static \Illuminate\Database\Query\Builder|KeyResult withoutTrashed()
 * @property string|null $remarks 所感
 * @method static \Illuminate\Database\Eloquent\Builder|KeyResult whereRemarks($value)
 */
class KeyResult extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'key_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'key_result',
        'score',
        'objective_id',
        'remarks',
        'impression',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'key_result' => 'string',
        'score' => 'double',
        'objective_id' => 'int',
        'remarks' => 'string',
        'impression' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function objective(): BelongsTo
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }

    /**
     * remarksにURLが含まれていた場合、リンク化する。
     *
     * @return string|null
     */
    public function getLinkedRemarksAttribute(): ?string
    {
        return TextReplace::urlReplace($this->remarks);
    }

    /**
     * impressionにURLが含まれていた場合、リンク化する。
     *
     * @return string|null
     */
    public function getLinkedImpressionAttribute(): ?string
    {
        return TextReplace::urlReplace($this->impression);
    }
}
