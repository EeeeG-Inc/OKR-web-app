@extends('layouts.app')
@section('title', __('common/title.objective.create'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.objective.create') }}</div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    <p>{{ link_to_route('objective.index', __('common/action.back'), ['user_id' => $user->id], ['class' => 'text-decoration-none']) }}</p>

                                    @include('flash::message')

                                    <div class="form">
                                        {{ Form::open(['url' => route('objective.store')]) }}
                                        {{ Form::token() }}
                                        {{ Form::hidden('user_id', $user->id) }}

                                        {{--年度--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('year', __('models/objectives.fields.year'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::select('year', $years, 'ordinarily', ['class' => 'form-control', 'id' => 'year']) }}
                                            </div>
                                        </div>

                                        {{--四半期区分--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('quarter', __('models/quarters.fields.quarter'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', App\Enums\Quarter::FULL_YEAR_ID, true, ['id' => 'radioQuarter0']) }}
                                                    {{ Form::label('radioQuarter0', $quarterLabels[0]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[0]->id, false, ['id' => 'radioQuarter1']) }}
                                                    {{ Form::label('radioQuarter1', $quarterLabels[1]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[1]->id, false, ['id' => 'radioQuarter2']) }}
                                                    {{ Form::label('radioQuarter2', $quarterLabels[2]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[2]->id, false, ['id' => 'radioQuarter3']) }}
                                                    {{ Form::label('radioQuarter3', $quarterLabels[3]) }}
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    {{ Form::radio('quarter_id', $quarters[3]->id, false, ['id' => 'radioQuarter4']) }}
                                                    {{ Form::label('radioQuarter4', $quarterLabels[4]) }}
                                                </div>
                                            </div>
                                        </div>

                                        {{--OKR--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('objective', __('models/objectives.fields.objective'), ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('objective', null, ['class' => 'form-control', 'id' => 'objective', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        {{-- 優先度 --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('priority', __('models/objectives.fields.priority')) }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::select('priority', $prioritys, 'ordinarily', ['class' => 'form-control', 'id' => 'priority']) }}
                                            </div>
                                        </div>

                                        {{--KeyResult--}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result1', __('models/key-results.fields.key_result') . '1', ['class' => 'required']) }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::textarea('key_result1', null, ['class' => 'form-control', 'id' => 'key_result1', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result2', __('models/key-results.fields.key_result') . '2') }}
                                            </div>
                                            <div class="col-md-10 mb-5">
                                                {{ Form::textarea('key_result2', null, ['class' => 'form-control', 'id' => 'key_result2', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('key_result3', __('models/key-results.fields.key_result') . '3') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('key_result3', null, ['class' => 'form-control', 'id' => 'key_result3', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        {{--内容確認ボタン--}}
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.create'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
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
