<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 */

namespace App\Models{
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
     */
    class Company extends \Eloquent
    {
    }
}

namespace App\Models{
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
     */
    class CompanyGroup extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Department.
     *
     * @property int $id
     * @property string $name 部署名
     * @property int $companies_id 会社コード
     * @property null|string $deleted_at 削除フラグ
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Department query()
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereCompaniesId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
     * @mixin \Eloquent
     * @property int $company_id 会社ID
     * @property-read \App\Models\Company $company
     * @method static \Database\Factories\DepartmentFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Department whereCompanyId($value)
     */
    class Department extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Membership.
     *
     * @property int $id
     * @property int $team_id
     * @property int $user_id
     * @property null|string $role
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Membership newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Membership newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Membership query()
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereRole($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereTeamId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUserId($value)
     * @mixin \Eloquent
     */
    class Membership extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Objective.
     *
     * @property int $id
     * @property string $result 成果詳細
     * @property null|int $score スコア
     * @property null|string $deleted_at 削除フラグ
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Objective newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Objective newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Objective query()
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereResult($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereScore($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereUpdatedAt($value)
     * @mixin \Eloquent
     * @property null|int $okr_id okrID
     * @property-read null|\App\Models\Okr $okrs
     * @method static \Database\Factories\ObjectiveFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereOkrId($value)
     * @property string $name 成果指標
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereName($value)
     * @property string $objective 成果指標
     * @method static \Illuminate\Database\Eloquent\Builder|Objective whereObjective($value)
     */
    class Objective extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Okr.
     *
     * @property int $id
     * @property string $name 登録名
     * @property null|int $score 総合スコア
     * @property int $users_id ユーザコード
     * @property int $year 年度
     * @property int $quarters_id 四半期コード
     * @property null|string $deleted_at 削除フラグ
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
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
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|Okr whereOkr($value)
     */
    class Okr extends \Eloquent
    {
    }
}

namespace App\Models{
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
     */
    class Quarter extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Team.
     *
     * @property int $id
     * @property int $user_id
     * @property string $name
     * @property bool $personal_team
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @property-read \App\Models\User $owner
     * @property-read \App\Models\TeamInvitation[]|\Illuminate\Database\Eloquent\Collection $teamInvitations
     * @property-read null|int $team_invitations_count
     * @property-read \App\Models\User[]|\Illuminate\Database\Eloquent\Collection $users
     * @property-read null|int $users_count
     * @method static \Database\Factories\TeamFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Team query()
     * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Team wherePersonalTeam($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId($value)
     * @mixin \Eloquent
     */
    class Team extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\TeamInvitation.
     *
     * @property int $id
     * @property int $team_id
     * @property string $email
     * @property null|string $role
     * @property null|\Illuminate\Support\Carbon $created_at
     * @property null|\Illuminate\Support\Carbon $updated_at
     * @property-read \App\Models\Team $team
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation query()
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereRole($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereTeamId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    class TeamInvitation extends \Eloquent
    {
    }
}

namespace App\Models{
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
     */
    class User extends \Eloquent
    {
    }
}
