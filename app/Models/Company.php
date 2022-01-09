<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Company.
 *
 * @property int $id
 * @property string $name 会社名
 * @property int $company_group_id 系列コード
 * @property int $is_master マスターフラグ
 * @property null|string $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCompanyGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CompanyGroup $companyGroups
 * @property-read \App\Models\Department[]|\Illuminate\Database\Eloquent\Collection $departments
 * @property-read null|int $departments_count
 * @property-read \App\Models\Quarter[]|\Illuminate\Database\Eloquent\Collection $quarters
 * @property-read null|int $quarters_count
 * @property-read \App\Models\User[]|\Illuminate\Database\Eloquent\Collection $users
 * @property-read null|int $users_count
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 */
class Company extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'company_group_id',
        'is_master',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'company_group_id' => 'int',
        'is_master' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function companyGroups(): BelongsTo
    {
        return $this->belongsTo(CompanyGroup::class, 'company_group_id');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'department_id');
    }

    public function quarters(): HasMany
    {
        return $this->hasMany(Quarter::class, 'quarter_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
