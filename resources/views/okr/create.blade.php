@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.okr.create') }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['url' => route('store'), 'files' => true]) }}
                                        <!--CSRFトークン-->
                                        {{ Form::token() }}

                                        <!--年度-->
                                        <div class="form-group pb-2">
                                            {{ Form::label('selectYear', __('models/okrs.fields.year')) }}
                                            {{ Form::select(
                                                'selectYear',
                                                [
                                                    'thisYear' => \Carbon\Carbon::now()->format('Y'),
                                                    'yearAfterNext' => \Carbon\Carbon::now()->addYear()->format('Y'),
                                                    'threeYearsLater' => \Carbon\Carbon::now()->addYear(2)->format('Y'),
                                                ],
                                                'ordinarily',
                                                ['class' => 'form-control', 'id' => 'selectYear'],
                                            ) }}
                                        </div>

                                        <!--四半期区分-->
                                        <div class="form-group row">
                                            <legend class="col-form-label col-md-2 mb-3">
                                                {{ __('models/quarters.fields.quater') }}</legend>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('raidoQuater', __('models/quarters.quarter.firstQuarter'), true, ['class' => 'custom-control-input', 'id' => 'radioQuarter1']) }}
                                                    {{ Form::label('raidoQuater1', __('models/quarters.quarter.firstQuarter'), ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('raidoQuater', __('models/quarters.quarter.secondQuarter'), false, ['class' => 'custom-control-input', 'id' => 'raidoQuater2']) }}
                                                    {{ Form::label('raidoQuater2', __('models/quarters.quarter.secondQuarter'), ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('raidoQuater', __('models/quarters.quarter.thirdQuarter'), false, ['class' => 'custom-control-input', 'id' => 'raidoQuater3']) }}
                                                    {{ Form::label('raidoQuater3', __('models/quarters.quarter.thirdQuarter'), ['class' => 'custom-control-label']) }}
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    {{ Form::radio('raidoQuater', __('models/quarters.quarter.fourthQuarter'), false, ['class' => 'custom-control-input', 'id' => 'raidoQuater4']) }}
                                                    {{ Form::label('raidoQuater4', __('models/quarters.quarter.fourthQuarter'), ['class' => 'custom-control-label']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <!--OKR-->
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('inputOkr', __('models/okrs.fields.okr')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('inputOkr', null, ['class' => 'form-control', 'id' => 'inputOkr', 'placeholder' => __('models/okrs.fields.okr'), 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <!--Objective-->
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('inputObjective1', __('models/objectives.fields.detail') . '1') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('inputObjective1', null, ['class' => 'form-control', 'id' => 'inputObjective1', 'placeholder' => __('models/objectives.fields.detail') . '1', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('inputObjective2', __('models/objectives.fields.detail') . '2') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('inputObjective2', null, ['class' => 'form-control', 'id' => 'inputObjective2', 'placeholder' => __('models/objectives.fields.detail') . '2', 'rows' => '2']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('inputObjective3', __('models/objectives.fields.detail') . '3') }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('inputObjective3', null, ['class' => 'form-control', 'id' => 'inputObjective3', 'placeholder' => __('models/objectives.fields.detail') . '3', 'rows' => '2']) }}
                                            </div>
                                        </div>
                                        @if (count($errors) > 0)
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <!--内容確認ボタン-->
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                {{ Form::submit(__('common/action.confirm'), ['class' => 'btn btn-primary btn-block']) }}
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
