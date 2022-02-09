@extends('layouts.app')
@section('title', __('common/title.dashboard.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.dashboard.index') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                {{-- 検索: 未実装 --}}
                                {{-- <div class="form" style="text-align: center">
                                    {{ Form::open(['url' => route('dashboard.search')]) }}
                                    {{ Form::token() }}
                                    {{ Form::label('name', __('models/users.fields.name')) }}
                                    {{ Form::text('name', null) }}
                                    @if ($errors->has('name'))
                                        <p>{{ $errors->first('name') }}</p>
                                    @endif
                                    {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 rounded btn btn-secondary']) }}
                                    {{ Form::close() }}
                                </div> --}}

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/users.fields.name') }}</th>
                                            <th>{{ __('models/users.fields.role') }}</th>
                                            <th>{{ __('models/companies.fields.name') }}</th>
                                            <th>{{ __('models/departments.fields.name') }}</th>
                                            <th>{{ __('models/objectives.fields.objective') }}</th>
                                            @can('admin-only')
                                                <th>{{ __('common/admin.proxy_login') }}</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->role == App\Enums\Role::COMPANY)
                                                        <i class="fa-solid fa-building fa-fw fa-lg"></i>
                                                    @elseif ($user->role == App\Enums\Role::DEPARTMENT)
                                                        <i class="fa-solid fa-briefcase fa-fw fa-lg"></i>
                                                    @elseif ($user->role == App\Enums\Role::MANAGER)
                                                        <i class="fa-solid fa-user-gear fa-fw fa-lg"></i>
                                                    @elseif ($user->role == App\Enums\Role::MEMBER)
                                                        <i class="fa-solid fa-user fa-fw fa-lg"></i>
                                                    @endif
                                                    {{ App\Enums\Role::getDescription($user->role) }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->role !== App\Enums\Role::COMPANY)
                                                        {{ $user->companies()->first()->name }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if (($user->role === App\Enums\Role::MANAGER) || ($user->role === App\Enums\Role::MEMBER))
                                                        {{ $user->departments()->first()->name }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($user->hasObjective)
                                                        {{ link_to_route('objective.index', __('common/action.detail'), ['user_id' => $user->id], ['class' => 'btn btn-primary']); }}
                                                    @endif
                                                </td>
                                                @can('admin-only')
                                                    <td class="align-middle">
                                                        {{ link_to_route('admin.proxy_login', __('common/admin.proxy_login'), ['user_id' => $user->id], ['class' => 'btn btn-primary']); }}
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <p class="d-flex justify-content-center"> {{ $users->links() }} </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
