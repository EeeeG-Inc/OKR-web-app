<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Okr
 *
 * @property int $id
 * @property string $name 登録名
 * @property int $objectives_id オブジェクトコード
 * @property int|null $score 総合スコア
 * @property int $users_id ユーザコード
 * @property int $year 年度
 * @property int $quarters_id 四半期コード
 * @property string|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Okr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Okr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Okr query()
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereObjectivesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereQuartersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereYear($value)
 * @mixin \Eloquent
 * @property int $user_id ユーザID
 * @property int $quarter_id 四半期ID
 * @property-read \App\Models\Quarter $quarters
 * @property-read \App\Models\User $users
 * @method static \Database\Factories\OkrFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereQuarterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Okr whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Objective[] $objectives
 * @property-read int|null $objectives_count
 */
class Okr extends Model
{
    use HasFactory;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'okrs';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'score',
        'user_id',
        'year',
        'quater_id',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'score' => 'float',
        'user_id' => 'int',
        'year' => 'int',
        'quarter_id' => 'int',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quarters(): BelongsTo
    {
        return $this->belongsTo(Quarter::class, 'quarter_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class, 'object_id');
    }
}
