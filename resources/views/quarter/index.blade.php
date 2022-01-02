@extends('layouts.app')
@section('title', __('common/title.quarter.index'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.quarter.index') }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">

                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                {{-- フラッシュメッセージ --}}
                                @include('flash::message')

                                {{-- 新規作成 --}}
                                @if ($canCreate)
                                    @can('company-higher')
                                        <div class="text-right">
                                            {{ link_to_route('quarter.create', __('common/action.create'), null, ['class' => ' text-right my-2 btn btn-primary']) }}
                                        </div>
                                    @endcan
                                {{-- 編集 --}}
                                @else
                                    @can('company-higher')
                                        <div class="text-right">
                                            {{ link_to_route('quarter.edit', __('common/action.edit'), $companyId, ['class' => ' text-right my-2 btn btn-primary']) }}
                                        </div>
                                    @endcan

                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/quarters.fields.quarter') }}</th>
                                                <th>{{ __('models/quarters.fields.from') }}</th>
                                                <th>{{ __('models/quarters.fields.to') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quarters as $quarter)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{ App\Enums\Quarter::getDescription($quarter->quarter) }}
                                                    </td>
                                                    <td class="align-middle">{{ $quarter->from }}</td>
                                                    <td class="align-middle">{{ $quarter->to }}</td>
                                                </tr>
                                            @endforeach
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
