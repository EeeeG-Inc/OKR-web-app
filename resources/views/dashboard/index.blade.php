@extends('layouts.app')
@section('title', __('common/title.dashboard.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- 検索 --}}
            <div class="card mb-4">
                <div class="card-header toggle-mark">
                    <a data-toggle="collapse" href="#search-item" class="collapsed text-decoration-none">{{ __('common/title.dashboard.search') }}</a>
                </div>
                <div class="collapse" id="search-item">
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['url' => route('dashboard.search')]) }}

                                        {{-- 会社名 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('$company_id',  __('models/companies.fields.name')) }}
                                            </div>
                                            <div class="col-md-10">
                                                @foreach($companies as $company)
                                                    {{ Form::checkbox('company_ids[]', $company['id'], $companyIdsChecks[$company['id']], ['id' => '$company_ids[' . $company['id'] . ']']) }}
                                                    {{ Form::label('$company_ids[' . $company['id'] . ']', $company['name']) }}
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- 検索ボタン --}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 rounded btn btn-secondary']) }}
                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 検索結果 --}}
            <div class="card">
                <div class="card-header">{{ __('common/title.dashboard.index') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/users.fields.name') }}</th>
                                            <th>{{ __('models/users.fields.role') }}</th>
                                            <th>{{ __('models/companies.fields.name') }}</th>
                                            <th>{{ __('models/departments.fields.name') }}</th>
                                            <th>{{ __('common/action.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="align-middle">
                                                    <img class="border border-secondary rounded-circle mx-2" src="{{ $user->profile_image_path }}" alt="プロフィール画像">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="align-middle">
                                                    {!! App\Enums\Role::getFontAwesome($user->role, $user->company) !!}
                                                    @if ($user->role === App\Enums\Role::COMPANY)
                                                        @if ($user->company->is_master)
                                                            {{ __('common/label.company_group.index.parent') }}
                                                        @else
                                                            {{ __('common/label.company_group.index.child') }}
                                                        @endif
                                                    @else
                                                        {{ App\Enums\Role::getDescription($user->role) }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->role !== App\Enums\Role::COMPANY)
                                                        {{ $user->company()->first()->name }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if (($user->role === App\Enums\Role::MANAGER) || ($user->role === App\Enums\Role::MEMBER))
                                                        {{ $user->department()->first()->name }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->hasObjective)
                                                        {{ link_to_route('objective.index', __('common/action.detail'), ['user_id' => $user->id], ['class' => 'btn btn-primary']); }}
                                                    @endif
                                                    @can('admin-only')
                                                        {{ link_to_route('admin.proxy_login', __('common/admin.proxy_login'), ['user_id' => $user->id], ['class' => 'btn btn-success']); }}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <p class="d-flex justify-content-center">
                                    {{-- 検索用 GET パラメータをページネーションリンクに付与 --}}
                                    {{ $users->appends(request()->input())->links()}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
