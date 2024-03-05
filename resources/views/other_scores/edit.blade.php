@extends('layouts.app')
@section('title', __('common/title.other_scores.edit'))

@include('parts.cdn-jquery')
@push('scripts')
    <script>
        // ツールチップ表示
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                {{ Form::open(['route' => ['other_scores.edit', $user->id], 'method' => 'get']) }}

                <div class="card">
                    <div class="card-header">{{ __('common/title.other_scores.search') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    <p>{{ link_to_route('dashboard.index', __('common/action.back'), null, ['class' => 'text-decoration-none']) }}</p>

                                    @include('flash::message')

                                    <div class="form">
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('year', __('models/objectives.fields.year')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('year', $years, $year, ['class' => 'form-control', 'id' => 'year']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('quarter', __('models/objectives.fields.quarter_id')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('quarter_id', $quarters, $quarter_id, ['class' => 'form-control', 'id' => 'quarter']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-12 text-right">
                                                        {{ Form::submit(__('common/action.search'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                                    </div>
                                                </div>
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


            <div class="col-md-8">
                {{ Form::open(['route' => ['other_scores.update', $user->id], 'method' => 'put']) }}

                <div class="card">
                    <div class="card-header">{{ $year_and_quarter . ' ' . __('common/title.other_scores.edit')}}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    @include('flash::message')

                                    <div class="form">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                @foreach($datum as $data)
                                                    <div class="card mb-4">
                                                        <div class="card-header card-header-score">
                                                            {{ $data['user']->name }}
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="bg-gray-100">
                                                                <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                                                    @foreach($data['objectives'] as $objective)
                                                                        <div class="form-group row">
                                                                            <div class="col mb-3">
                                                                                <p class="font-weight-bold" style="font-size: 16px">{{ $objective->objective }}</p>
                                                                            </div>
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr class="table-secondary">
                                                                                        <th style="font-size: 0.7rem; width: 33%">
                                                                                            <p class="mb-0" data-toggle="tooltip" data-placement="top" title="{{ $objective->keyResults[0]->key_result }}">
                                                                                                {{ $objective->keyResults[0]->short_key_result }}
                                                                                            </p>
                                                                                        </th>
                                                                                        <th style="font-size: 0.7rem; width: 33%">
                                                                                            <p class="mb-0" data-toggle="tooltip" data-placement="top" title="{{ $objective->keyResults->count() >= 2 ? $objective->keyResults[1]->key_result : '' }}">
                                                                                                {{ ($objective->keyResults->count() >= 2 && !empty($objective->keyResults[1]->key_result)) ? $objective->keyResults[1]->short_key_result : '' }}
                                                                                            </p>
                                                                                        </th>
                                                                                        <th style="font-size: 0.7rem; width: 33%">
                                                                                            <p class="mb-0" data-toggle="tooltip" data-placement="top" title="{{ $objective->keyResults->count() >= 3 ? $objective->keyResults[2]->key_result : '' }}">
                                                                                                {{ ($objective->keyResults->count() >= 3 && !empty($objective->keyResults[2]->key_result)) ? $objective->keyResults[2]->short_key_result : '' }}
                                                                                            </p>
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr class="table-striped-columns">
                                                                                        <td class="align-middle">
                                                                                            {{ Form::select(
                                                                                                'key_result1_score[' . $objective->id . '][' . $objective->keyResults[0]->id . ']',
                                                                                                $scores,
                                                                                                $objective->keyResults[0]->score,
                                                                                                ['class' => 'form-control  w-25']
                                                                                            ) }}
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            @if ($objective->keyResults->count() >= 2 && !empty($objective->keyResults[1]->key_result))
                                                                                                {{ Form::select(
                                                                                                    'key_result2_score[' . $objective->id . '][' . $objective->keyResults[1]->id . ']',
                                                                                                    $scores,
                                                                                                    $objective->keyResults[1]->score,
                                                                                                    ['class' => 'form-control w-25']
                                                                                                ) }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            @if ($objective->keyResults->count() >= 3 && !empty($objective->keyResults[2]->key_result))
                                                                                                {{ Form::select(
                                                                                                    'key_result3_score[' . $objective->id . '][' . $objective->keyResults[2]->id . ']',
                                                                                                    $scores,
                                                                                                    $objective->keyResults[2]->score,
                                                                                                    ['class' => 'form-control w-25']
                                                                                                ) }}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>

                                                                            <div class="col-md-2 mb-3">
                                                                                {{ Form::label('comment[' . $objective->id . ']', __('models/comments.fields.comment')) }}
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                                {{ Form::textarea('comment[' . $objective->id . ']', null, ['class' => 'form-control', 'rows' => '1']) }}
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="form-group row">
                                                    @if(empty($datum))
                                                        <div class="col-sm-12">
                                                            <p>編集可能な OKR が存在しません</p>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-12 text-right">
                                                            {{ Form::submit(__('common/action.update'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
                                                        </div>
                                                    @endif
                                                </div>
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
