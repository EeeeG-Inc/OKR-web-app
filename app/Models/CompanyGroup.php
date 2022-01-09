<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CompanyGroup.
 *
 * @property int $id
 * @property string $name 系列名
 * @property null|string $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Company[]|\Illuminate\Database\Eloquent\Collection $companies
 * @property-read null|int $companies_count
 * @method static \Database\Factories\CompanyGroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|CompanyGroup onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|CompanyGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CompanyGroup withoutTrashed()
 */
class CompanyGroup extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'company_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'company_id');
    }
}
