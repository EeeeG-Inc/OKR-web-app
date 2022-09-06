@extends('layouts.app')
@section('title', __('common/title.api_token.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.api_token.index') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                @can('company-higher')
                                    <div class="text-right">
                                        {{ link_to_route('api_token.store', $isNoToken ? __('common/action.create') : __('common/action.change'), null, ['class' => ' text-right my-2 btn btn-primary']) }}
                                    </div>
                                @endcan

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/api_tokens.token') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">{{ $token }}</td>
                                        </tr>
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
