@extends('layouts.app')
@section('title', __('common/title.user.edit'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.user.edit') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    @include('flash::message')

                                    <div class="form">
                                        {{ Form::open(['id' => 'update_user_form', 'method' => 'put']) }}
                                        {{-- CSRFトークン --}}
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{-- アカウント種別 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('role', __('common/label.user.edit.role'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('role', $roles, $user->role, ['class' => 'form-control', 'id' => 'roles']) }}
                                            </div>
                                        </div>

                                        {{-- 氏名 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('name', __('models/users.fields.name'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'name']) }}
                                            </div>
                                        </div>

                                        {{-- 会社 --}}
                                        <div class="form-group row" id="company_form">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('company_id', __('common/label.user.edit.name_my_company'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('company_id', $companyNames, $user->company_id, ['class' => 'form-control', 'id' => 'companies']) }}
                                            </div>
                                        </div>

                                        {{-- 部署 --}}
                                        <div class="form-group row" id="department_form">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('department_id', __('common/label.user.edit.name_department'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('department_id', [], null, ['class' => 'form-control', 'id' => 'departments', 'disabled' => true]) }}
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('email', __('models/users.fields.email')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'email']) }}
                                            </div>
                                        </div>

                                        {{-- パスワード --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('password', __('models/users.fields.password')) }}
                                            </div>
                                            <div class="col-md-10 mb-3">
                                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                                                <small id="passwordHelpBlock" class="form-text text-muted">
                                                    {{ __('common/message.user.password') }}
                                                </small>
                                            </div>
                                        </div>

                                        {{-- パスワード (確認用) --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('password_confirmation', __('common/label.user.edit.password_confirmation')) }}
                                            </div>
                                            <div class="col-md-10 mb-3">
                                                {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) }}
                                            </div>
                                        </div>

                                        {{-- 内容確認ボタン --}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.update'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
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

    @push('scripts')
        <script>
            $(function() {
                const COMPANY = 2;
                const DEPARTMENT = 3;
                const MANAGER = 4;
                const MEMBER = 5;
                actions = {
                    COMPANY: '{{ route('company.update') }}',
                    DEPARTMENT: '{{ route('department.update') }}',
                    MANAGER: '{{ route('manager.update') }}',
                    MEMBER: '{{ route('member.update') }}',
                };
                roleId = 0;

                var controlFields = function (roleId) {
                    switch (roleId) {
                        case COMPANY:
                            $('#name').text('{!! __('common/label.user.edit.name_company')!!}');
                            $('#update_user_form').attr('action', actions.COMPANY);
                            $('#company_form').hide();
                            $('#department_form').hide();
                            break;
                        case DEPARTMENT:
                            $('#name').text('{!! __('common/label.user.edit.name_department')!!}');
                            $('#update_user_form').attr('action', actions.DEPARTMENT);
                            $('#company_form').show();
                            $('#department_form').hide();
                            break;
                        case MANAGER:
                            $('#name').text('{!! __('common/label.user.edit.name_manager')!!}');
                            $('#update_user_form').attr('action', actions.MANAGER);
                            $('#company_form').show();
                            $('#department_form').show();
                            break;
                        case MEMBER:
                            $('#name').text('{!! __('common/label.user.edit.name_member')!!}');
                            $('#update_user_form').attr('action', actions.MEMBER);
                            $('#company_form').show();
                            $('#department_form').show();
                            break;
                    }
                }

                var postData = function (url = '', data = {}) {
                    return fetch(url, {
                        method: "POST",
                        mode: 'same-origin',
                        credentials: 'include',
                        headers: {
                            "Content-Type": "application/json; charset=utf-8",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json());
                }

                var fetchDepartments = function (companyId, departmentId = 0) {
                    postData("{{ route('fetch.departments', $companyId) }}", {company_id: companyId})
                    .then(data => {
                        $('#departments').children().remove();
                        if (data.departments.length === 0) {
                            $('#departments').append($('<option>').attr({ value: '' }).text('部署ユーザを作成してください'));
                            $('#departments').prop('disabled', true);
                        } else {
                            $('#departments').append($('<option>').attr({ value: '' }).text('部署名を選択してください'));
                            $.each(data.departments, function(index, value) {
                                $('#departments').append($('<option>').attr({ value: value.id }).text(value.name));
                                $('#departments').prop('disabled', false);
                            });
                            // 初期値をセット
                            if (departmentId !== 0) {
                                $(`#departments option[value='${departmentId}']`).prop('selected', true);
                            }
                        }
                    })
                    .catch(error => {
                        // console.error(error.message)
                        $('#departments').children().remove();
                        $('#departments').append($('<option>').attr({ value: '' }).text('部署データを取得できませんでした'));
                        $('#departments').prop('disabled', true);
                    });
                }

                $('#roles').change(function() {
                    roleId = Number($('#roles').val())
                    controlFields(roleId)
                    if ((roleId === MANAGER) || (roleId === MEMBER)) {
                        fetchDepartments(Number($('#companies').val()))
                    }
                });

                $('#companies').change(function() {
                    roleId = Number($('#roles').val())
                    if ((roleId === MANAGER) || (roleId === MEMBER)) {
                        fetchDepartments(Number($('#companies').val()))
                    }
                });

                // 初期化
                departmentId = {{ $user->department_id }}
                controlFields(Number($('#roles').val()));
                fetchDepartments(Number($('#companies').val()), departmentId)
            })
        </script>
    @endpush
@endsection
