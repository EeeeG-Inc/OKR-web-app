@extends('layouts.app')
@section('title', __('common/title.slack.index'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.slack.index') }}</div>
                <div class="card-body">
                    <div class="bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                @include('flash::message')

                                {{-- 新規作成 --}}
                                @if ($canCreate)
                                    @can('company-higher')
                                        <div class="text-right">
                                            {{ link_to_route('slack.create', __('common/action.create'), null, ['class' => ' text-right my-2 btn btn-primary']) }}
                                        </div>
                                    @endcan
                                {{-- 編集 --}}
                                @else
                                    @can('company-higher')
                                        <div class="text-right">
                                            <div class="btn">
                                                @if ($isActive)
                                                    {{ link_to_route('slack.stop', __('common/action.stop'), null, ['class' => ' text-right my-2 btn btn-danger']) }}
                                                @else
                                                    {{ link_to_route('slack.restart', __('common/action.restart'), null, ['class' => ' text-right my-2 btn btn-danger']) }}
                                                @endif
                                            </div>
                                            <div class="btn">
                                                {{ link_to_route('slack.edit', __('common/action.edit'), $companyId, ['class' => ' text-right my-2 btn btn-primary']) }}
                                            </div>
                                        </div>
                                    @endcan

                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/slacks.fields.webhook') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle">{{ $slack->webhook }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
