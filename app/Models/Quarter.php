<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Quarter.
 *
 * @property int $id
 * @property string $from 開始月
 * @property string $to 終了月
 * @property int $companies_id 会社コード
 * @property null|string $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereCompaniesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $company_id 会社ID
 * @property-read \App\Models\Company $companies
 * @property-read \App\Models\Okr[]|\Illuminate\Database\Eloquent\Collection $okrs
 * @property-read null|int $okrs_count
 * @method static \Database\Factories\QuarterFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereCompanyId($value)
 * @property int $quarter 四半期区分
 * @method static \Illuminate\Database\Eloquent\Builder|Quarter whereQuarter($value)
 * @property-read \App\Models\Objective[]|\Illuminate\Database\Eloquent\Collection $objectives
 * @property-read null|int $objectives_count
 * @method static \Illuminate\Database\Query\Builder|Quarter onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Quarter withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Quarter withoutTrashed()
 * @property-read \App\Models\Company|null $company
 */
class Quarter extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'quarters';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quarter',
        'from',
        'to',
        'company_id',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quarter' => 'int',
        'from' => 'int',
        'to' => 'int',
        'company_id' => 'int',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class, 'quarter_id');
    }
}
