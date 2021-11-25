<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CompanyGroup
 *
 * @property int $id
 * @property string $name 系列名
 * @property string|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @method static \Database\Factories\CompanyGroupFactory factory(...$parameters)
 */
class CompanyGroup extends Model
{
    use HasFactory;

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
        'name'              => 'string',
        'deleted_at'        => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'company_id');
    }
}
