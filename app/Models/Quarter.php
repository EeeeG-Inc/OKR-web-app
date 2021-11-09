<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Quarter
 *
 * @property int $id
 * @property string $from 開始月
 * @property string $to 終了月
 * @property int $companies_id 会社コード
 * @property string|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 */
class Quarter extends Model
{
    use HasFactory;
}
