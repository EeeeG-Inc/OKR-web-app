<?php

namespace App\Models;

use App\Repositories\ObjectiveRepository;
use App\Enums\CanEditOtherOkr;
use BenSampo\Enum\Traits\CastsEnums;
use Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $name ユーザ名
 * @property null|int $role 権限
 * @property null|int $companies_id 会社コード
 * @property null|int $departments_id 部署コード
 * @property string $email メールアドレス
 * @property null|\Illuminate\Support\Carbon $email_verified_at メールアドレス確認日時
 * @property string $password パスワード
 * @property null|string $two_factor_secret
 * @property null|string $two_factor_recovery_codes
 * @property null|string $deleted_at 削除フラグ
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection $notifications
 * @property-read null|int $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read null|int $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompaniesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property null|int $company_id 会社ID
 * @property null|int $department_id 部署ID
 * @property-read null|\App\Models\Company $companies
 * @property-read \App\Models\Okr[]|\Illuminate\Database\Eloquent\Collection $okrs
 * @property-read null|int $okrs_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentId($value)
 * @property-read null|\App\Models\Department $departments
 * @property-read bool $has_objective
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property string $profile_image
 * @property-read string $profile_image_path
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileImage($value)
 * @property string|null $remember_token
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Objective[] $objectives
 * @property-read int|null $objectives_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 */
class User extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;

    use HasProfilePhoto;

    use Notifiable;

    use SoftDeletes;

    use TwoFactorAuthenticatable;

    use CastsEnums;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'company_id',
        'department_id',
        'role',
        'email',
        'password',
        'email_verified_at',
        'profile_image',
        'can_edit_other_okr',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'role' => 'int',
        'company_id' => 'int',
        'department_id' => 'int',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'two_factor_secret' => 'string',
        'two_factor_recovery_codes' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'profile_image' => 'string',
        'can_edit_other_okr' => 'int',
    ];

    protected $enumCasts = [
        'can_edit_other_okr' => CanEditOtherOkr::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Relations.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class, 'user_id');
    }

    public function commentLikeUsers(): HasMany
    {
        return $this->hasMany(CommentLikeUser::class, 'user_id');
    }

    /**
     * Accessors.
     */

    /**
     * Objective を持っているユーザかどうか.
     */
    public function getHasObjectiveAttribute(): bool
    {
        $objectiveRepo = new ObjectiveRepository();
        return $objectiveRepo->getByUserId($this->id)->count() === 0 ? false : true;
    }

    /**
     * プロフィール画像のパスを取得
     */
    public function getProfileImagePathAttribute(): string
    {
        return asset(Config::get('profile.public_image_path') . $this->profile_image);
    }
}
