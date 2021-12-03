@extends('layouts.app')
@section('title', __('common/title.dashboard.index'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('common/title.dashboard.index') }}</div>
                <div class="card-body">
                    <div class="pt-4 bg-gray-100">
                        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                <div class="form" style="text-align: center">
                                    {{ Form::open(['url' => route('dashboard.search'), 'files' => true]) }}
                                    {{ Form::token() }}

                                    {{-- ユーザ --}}
                                    {{ Form::label('user', __('models/users.fields.name')) }}
                                    {{ Form::text('user', null) }}
                                    @if ($errors->has('okr'))
                                        <p>{{$errors->first('okr')}}</p>
                                    @endif

                                    {{-- 送信ボタン --}}
                                    {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 bg-green-400 text-white font-semibold rounded hover:bg-green-500;']) }}
                                    {{ Form::close() }}

                                    <p class="d-flex justify-content-center">
                                    {{ $users->links() }}
                                    </p>
                                </div>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('models/users.fields.name') }}</th>
                                            <th>{{ __('models/okrs.fields.okr') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ link_to_route('okr.show', __('common/action.detail'), $user->id); }}</td>
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
