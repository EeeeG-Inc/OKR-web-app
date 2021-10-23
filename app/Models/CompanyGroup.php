<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class CompanyGroup extends Model
{
    use HasFactory;
}