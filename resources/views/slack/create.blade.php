@extends('layouts.app')
@section('title', __('common/title.slack.create'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common/title.slack.create') }}</div>
                    <div class="card-body">
                        <div class="pt-4 bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div
                                    class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    <div class="form">
                                        {{ Form::open(['url' => route('slack.store')]) }}
                                        {{ Form::token() }}

                                        {{-- Webhook --}}
                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('webhook', __('models/slacks.fields.webhook')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::text('webhook', null, ['class' => 'form-control', 'id' => 'webhook']) }}
                                            </div>
                                        </div>

                                        {{--フラッシュメッセージ--}}
                                        @include('flash::message')

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
