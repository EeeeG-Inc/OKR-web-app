@extends('layouts.app')
@section('title', __('common/title.company_group.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('common/title.company_group.index') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/companies.fields.name') }}</th>
                                            <th>{{ __('common/label.company_group.index.type') }}</th>
                                            <th>{{ __('common/label.company_group.index.is_master') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($companies as $company)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $company->name }}
                                                </td>
                                                <td class="align-middle">
                                                    {!! App\Enums\Role::getCompanyFontAwesome($company) !!}
                                                    @if ($company->is_master)
                                                        {{ __('common/label.company_group.index.parent') }}
                                                    @else
                                                        {{ __('common/label.company_group.index.child') }}
                                                    @endif

                                                </td>
                                                <td class="align-middle">
                                                    @if (!$company->is_master)
                                                        {{ Form::open(['route' => ['company_group.update', $company->id], 'method' => 'put']) }}
                                                        {{ Form::hidden('company_id', $company->id) }}
                                                        {{ Form::hidden('company_group_id', $company->company_group_id) }}
                                                        {{ Form::submit(__('common/action.is_master'), [
                                                            'class' => 'btn btn-danger',
                                                            'onclick' => "return confirm('" . __('common/message.company_group.update_confirm', ['name' => $company->name])  . "')"
                                                        ])}}
                                                        {{ Form::close() }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
