@extends('layouts.app')
@section('title', __('common/title.other_okr.edit', ['name' => $user->name]))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{ Form::open(['route' => ['other_okr.update', $user->id], 'method' => 'put']) }}
                {{ Form::hidden('user_id', $user->id) }}

                <div class="card">
                    <div class="card-header">{{ __('common/title.other_okr.edit', ['name' => $user->name]) }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    <p>{{ link_to_route('other_okr.index', __('common/action.back'), null, ['class' => 'text-decoration-none']) }}</p>

                                    @include('flash::message')

                                    <div class="form">
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('can_edit_other_okr', '他人の OKR 編集権限') }}
                                            </div>

                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio(
                                                        'can_edit_other_okr',
                                                        false,
                                                        (bool) $user->can_edit_other_okr->value === false,
                                                        ['id' => 'disable']
                                                    ) }}
                                                    {{ Form::label('disable', 'なし') }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio(
                                                        'can_edit_other_okr',
                                                        true,
                                                        (bool) $user->can_edit_other_okr->value === true,
                                                        ['id' => 'enable']
                                                    ) }}
                                                    {{ Form::label('enable', 'あり') }}
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        @foreach($users as $user)
                                            <div class="form-group row">
                                                <div class="col-md-2 mb-3">
                                                    {{ Form::label('user_name', $user->name) }}
                                                </div>

                                                <div class="col-md-10">
                                                    <div class="custom-control custom-radio">
                                                        {{ Form::radio(
                                                            'target[' . $user->id . ']',
                                                            false,
                                                            empty(old('target[' . $user->id . ']', $target_values[$user->id])),
                                                            ['id' => 'ng[' . $user->id . ']']
                                                        ) }}
                                                        {{ Form::label('ng[' . $user->id . ']', App\Enums\CanEdit::getDescription(App\Enums\CanEdit::CAN_NOT_EDIT)) }}
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        {{ Form::radio(
                                                            'target[' . $user->id . ']',
                                                            true,
                                                            !empty(old('target[' . $user->id . ']', $target_values[$user->id])),
                                                            ['id' => 'ok[' . $user->id . ']']
                                                        ) }}
                                                        {{ Form::label('ok[' . $user->id . ']', App\Enums\CanEdit::getDescription(App\Enums\CanEdit::CAN_EDIT)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.update'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
