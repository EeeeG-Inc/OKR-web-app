<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ApiToken
 *
 * @property int $id
 * @property int $personal_access_token_id パーソナルアクセストークンID
 * @property int $user_id ユーザID
 * @property int $company_id 会社ID
 * @property string $plain_text_token API Token
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\PersonalAccessToken $personalAccessToken
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newQuery()
 * @method static \Illuminate\Database\Query\Builder|ApiToken onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken wherePersonalAccessTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken wherePlainTextToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ApiToken withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ApiToken withoutTrashed()
 * @mixin \Eloquent
 */
class ApiToken extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'api_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'personal_access_token_id',
        'user_id',
        'company_id',
        'plain_text_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_access_token_id' => 'int',
        'user_id' => 'int',
        'company_id' => 'int',
        'plain_text_token' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function personalAccessToken(): BelongsTo
    {
        return $this->belongsTo(PersonalAccessToken::class, 'personal_access_token_id');
    }
}
