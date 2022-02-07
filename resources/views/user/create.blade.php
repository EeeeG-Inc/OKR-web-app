@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('common/title.user.create') }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    @include('flash::message')

                                    <div class="form">
                                        {{ Form::open(['id' => 'create_user_form']) }}
                                        {{-- CSRFトークン --}}
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{-- Role(作成アカウント種別) --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('role', __('common/label.user.create.role')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('role', $roles, null, ['class' => 'form-control', 'id' => 'roles']) }}
                                            </div>
                                        </div>

                                        {{-- 氏名 --}}
                                        <div class="form-group row">
                                            <div id="name" class="col-md-2 mb-3">
                                                {{ Form::label('name', __('models/users.fields.name')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                                            </div>
                                        </div>

                                        {{-- 部署 --}}
                                        <div class="form-group row" id="department_form">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('department_id', __('common/label.user.create.department')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('department_id', $departmentNames, null, ['class' => 'form-control', 'id' => 'departments']) }}
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('email', __('models/users.fields.email')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                                            </div>
                                        </div>

                                        {{-- パスワード --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('password', __('models/users.fields.password')) }}
                                            </div>
                                            <div class="col-md-10 mb-3">
                                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                                                <small id="passwordHelpBlock"
                                                    class="form-text text-muted">パスワードは、文字と数字を含めて8～20文字で、空白、特殊文字、絵文字を含むことはできません。</small>
                                            </div>
                                        </div>

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
    <script>
        $(function() {
            const COMPANY = 2;
            const DEPARTMENT = 3;
            const MANAGER = 4;
            const MEMBER = 5;
            actions = {
                COMPANY: '{{ route('company.store') }}',
                DEPARTMENT: '{{ route('department.store') }}',
                MANAGER: '{{ route('manager.store') }}',
                MEMBER: '{{ route('member.store') }}',
            };
            roleId = 0;

            var controlFields = function(roleId) {
                switch (roleId) {
                    case COMPANY:
                        $('#name').text('{!! __('common/label.user.create.name_company')!!}');
                        $('#create_user_form').attr('action', actions.COMPANY);
                        $('#department_form').hide();
                        break;
                    case DEPARTMENT:
                        $('#name').text('{!! __('common/label.user.create.name_department')!!}');
                        $('#create_user_form').attr('action', actions.DEPARTMENT);
                        $('#department_form').hide();
                        break;
                    case MANAGER:
                        $('#name').text('{!! __('common/label.user.create.name_manager')!!}');
                        $('#create_user_form').attr('action', actions.MANAGER);
                        $('#department_form').show();
                        break;
                    case MEMBER:
                        $('#name').text('{!! __('common/label.user.create.name_member')!!}');
                        $('#create_user_form').attr('action', actions.MEMBER);
                        $('#department_form').show();
                        break;
                }
            }

            $('#roles').change(function() {
                controlFields(Number($('#roles').val()))
            });

            // 初期化
            controlFields(Number($('#roles').val()));

        })
    </script>
@endsection
