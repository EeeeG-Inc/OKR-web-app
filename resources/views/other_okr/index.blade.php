@extends('layouts.app')
@section('title', __('common/title.other_okr.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    {{ __('common/title.other_okr.index') }}
                </div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/users.fields.name') }}</th>
                                            <th>{{ __('models/users.fields.role') }}</th>
                                            <th>{{ __('models/users.fields.can_edit_other_okr') }}</th>
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
                                                    {{ $user->can_edit_other_okr->description }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ link_to_route('other_okr.edit', __('common/action.edit'), $user->id, ['class' => 'btn btn-primary']) }}
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
