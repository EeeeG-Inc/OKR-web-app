@extends('layouts.app')
@section('title', __('models/objectives.fields.index', ['name' => $user->name]))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('models/objectives.fields.index', ['name' => $user->name]) }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                <div class="form" style="text-align: center">
                                    {{-- フラッシュメッセージ --}}
                                    @include('flash::message')
                                    {{ Form::open(['url' => route('objective.search'), 'files' => true]) }}
                                    {{-- CSRF トークン --}}
                                    {{ Form::token() }}
                                    {{-- OKR --}}
                                    {{ Form::label('objective', __('models/objectives.fields.objective')) }}
                                    {{ Form::text('objective', null) }}
                                    @if ($errors->has('objective'))
                                        <p>{{$errors->first('objective')}}</p>
                                    @endif
                                    {{-- 送信ボタン --}}
                                    {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 rounded btn btn-secondary']) }}
                                    {{ Form::close() }}
                                    <p class="d-flex justify-content-center">
                                    {{ $objectives->links() }}
                                    </p>
                                </div>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/objectives.fields.year') }}</th>
                                            <th>{{ __('models/quarters.fields.quarter') }}</th>
                                            <th>{{ __('models/objectives.fields.objective') }}</th>
                                            <th>{{ __('models/objectives.fields.score') }}</th>
                                            <th>{{ __('models/key-results.fields.key_result') }}</th>
                                            @can('manager-higher')
                                                <th>{{ __('common/action.delete') }}</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objectives as $objective)
                                            <tr>
                                                <td class="align-middle">{{ $objective->year }}</td>
                                                <td class="align-middle">{{ $objective->quarters->quarter }}</td>
                                                <td class="align-middle">{{ $objective->objective }}</td>
                                                <td class="align-middle">{{ $objective->score }}</td>
                                                <td class="align-middle">{{ link_to_route('key_result.index', __('common/action.detail'), ['objective_id' => $objective->id]) }}</td>
                                                @can('manager-higher')
                                                    <td class="align-middle">
                                                        {{ Form::open(['url' => route('objective.search'), 'method' => 'delete']) }}
                                                        {{ Form::token() }}
                                                        {{ Form::hidden('objective_id', $objective->id) }}
                                                        {{ Form::submit(__('common/action.delete'), [
                                                            'class' => 'btn btn-danger btn-block',
                                                            'onclick' => "return confirm('" . __('common/message.objective.delete_confirm', ['objective' => $objective->objective])  . "')"
                                                        ])}}
                                                        {{ Form::close() }}
                                                    </td>
                                                @endcan
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
