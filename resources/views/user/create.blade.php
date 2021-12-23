@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ '新規ユーザ作成' }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{-- TODO:全体のタイトル変更と多言語管理 --}}
                                        {{ Form::open(['url' => route('user.store'), 'files' => true]) }}
                                        {{-- CSRFトークン --}}
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{-- 氏名 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('inputName', '氏名') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::text('inputName', null, ['class' => 'form-control', 'id' => 'inputName']) }}
                                            </div>
                                        </div>

                                        {{-- Role --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('selectRoles', '権限') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('roles', $roles, null, ['class' => 'form-control', 'id' => 'roles']) }}
                                            </div>
                                        </div>

                                        {{-- 部署 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('selectDepartments', '部署') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('departments', $departmentNames, null, ['class' => 'form-control', 'id' => 'departments']) }}
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('email', 'Eメール') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                                            </div>
                                        </div>

                                        {{-- パスワード --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('password', 'パスワード') }}
                                            </div>
                                            <div class="col-md-10 mb-3">
                                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                                                <small id="passwordHelpBlock"
                                                    class="form-text text-muted">パスワードは、文字と数字を含めて8～20文字で、空白、特殊文字、絵文字を含むことはできません。</small>
                                            </div>
                                        </div>

                                        {{-- フラッシュメッセージ --}}
                                        @include('flash::message')
                                        {{-- 内容確認ボタン --}}
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                {{ Form::submit(__('common/action.create'), ['class' => 'btn btn-primary btn-block']) }}
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
        </div>
    </div>
@endsection
