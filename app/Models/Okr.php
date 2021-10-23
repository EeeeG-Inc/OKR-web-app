<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Okr extends Model
{
    use HasFactory;
}