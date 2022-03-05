@extends('layouts.app')
@section('title', __('common/title.objective.archived_list'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- 検索 --}}
            <div class="card mb-4">
                <div class="card-header toggle-mark">
                    <a data-toggle="collapse" href="#search-item" class="collapsed text-decoration-none">{{ __('common/title.objective.archive_search') }}</a>
                </div>
                <div class="collapse" id="search-item">
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['url' => route('objective.archive_search')]) }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{--年度--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('year', __('models/objectives.fields.year')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('year', $years, 'ordinarily', ['class' => 'form-control']) }}
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

            <div class="card">
                <div class="card-header">{{ __('common/title.objective.archived_list') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">

                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                <div class="text-right">
                                    {{-- 目標一覧 --}}
                                    {{ link_to_route('objective.index', __('common/title.objective.index'), ['user_id' => $user->id], ['class' => 'text-right my-2 btn btn-primary']); }}
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/users.fields.name') }}</th>
                                            <th>{{ __('models/users.fields.role') }}</th>
                                            @if (App\Enums\Role::COMPANY !== $user->role)
                                                <th>{{ __('models/companies.fields.name') }}</th>
                                            @endif
                                            @if (($user->role === App\Enums\Role::MANAGER) || ($user->role === App\Enums\Role::MEMBER))
                                                <th>{{ __('models/departments.fields.name') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">
                                                {{ $user->name }}
                                            </td>
                                            <td class="align-middle">
                                                {!! App\Enums\Role::getFontAwesome($user->role, $user->companies) !!}
                                                @if ($user->role === App\Enums\Role::COMPANY)
                                                    @if ($user->companies->is_master)
                                                        {{ __('common/label.company_group.index.parent') }}
                                                    @else
                                                        {{ __('common/label.company_group.index.child') }}
                                                    @endif
                                                @else
                                                    {{ App\Enums\Role::getDescription($user->role) }}
                                                @endif
                                            </td>
                                            @if (App\Enums\Role::COMPANY !== $user->role)
                                                <td class="align-middle">
                                                    {{ $user->companies()->first()->name }}
                                                </td>
                                            @endif
                                            @if (($user->role === App\Enums\Role::MANAGER) || ($user->role === App\Enums\Role::MEMBER))
                                                <td class="align-middle">
                                                    {{ $user->departments()->first()->name }}
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/objectives.fields.year') }}</th>
                                            <th>{{ __('models/quarters.fields.quarter') }}</th>
                                            <th>{{ __('models/objectives.fields.priority') }}</th>
                                            <th>{{ __('models/objectives.fields.objective') }}</th>
                                            <th>{{ __('models/objectives.fields.score') }}</th>
                                            <th>{{ __('common/action.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objectives as $objective)
                                            <tr>
                                                <td class="align-middle">{{ $objective->year }}</td>
                                                <td class="align-middle">
                                                    {{ App\Enums\Quarter::getDescription($objective->quarter) }}
                                                </td>
                                                <td class="align-middle">
                                                    {!! App\Enums\Priority::getFontAwesome($objective->priority) !!}
                                                    {{ App\Enums\Priority::getDescription($objective->priority) }}
                                                </td>
                                                <td class="align-middle">{!! nl2br($objective->objective) !!}</td>
                                                <td class="align-middle">{{ $objective->score }}</td>
                                                <td class="align-middle">
                                                    {{-- 詳細 --}}
                                                    {{ link_to_route('key_result.index', __('common/action.detail'), ['objective_id' => $objective->id], ['class' => 'btn btn-primary']) }}
                                                    @if ($isLoginUser)
                                                        {{-- アーカイブ解除 --}}
                                                        {{ Form::open(['route' => ['objective.unarchive', $objective->id], 'method' => 'put', 'class' => 'd-inline-block']) }}
                                                        {{ Form::submit(__('common/action.unarchive'), ['class' => 'btn btn-secondary'])}}
                                                        {{ Form::close() }}
                                                    @endif
                                                    @can('member-higher')
                                                        {{-- 削除 --}}
                                                        {{ Form::open(['route' => ['objective.destroy', $objective->id], 'method' => 'delete', 'class' => 'd-inline-block']) }}
                                                        {{ Form::submit(__('common/action.delete'), [
                                                            'class' => 'btn btn-danger',
                                                            'onclick' => "return confirm('" . __('common/message.objective.delete_confirm', ['objective' => $objective->objective])  . "')"
                                                        ])}}
                                                        {{ Form::close() }}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <p class="d-flex justify-content-center">
                                    {{-- 検索用 GET パラメータをページネーションリンクに付与 --}}
                                    {{ $objectives->appends(request()->input())->links()}}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 紐付いている会社・部署を表示する --}}
            @if ($companyUser || $departmentUser)
                <div class="card mt-4">
                    <div class="card-header">{{ __('common/title.objective.index_relational', ['name' => $user->name]) }}</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('models/users.fields.name') }}</th>
                                    <th>{{ __('models/objectives.fields.objective') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($companyUser)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $companyUser->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ link_to_route('objective.index', __('common/action.detail'), ['user_id' => $companyUser->id], ['class' => 'btn btn-primary']); }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($departmentUser)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $departmentUser->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ link_to_route('objective.index', __('common/action.detail'), ['user_id' => $departmentUser->id], ['class' => 'btn btn-primary']); }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
