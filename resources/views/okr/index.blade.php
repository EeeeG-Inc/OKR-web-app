<x-app-layout>
    <!-- TODO:header と footer の表示 -->
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>OKR一覧</div>
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                <div class="form" style="text-align: center">
                    {{ Form::open(['url' => route('okr.search'), 'files' => true]) }}
                    {{-- CSRF トークン --}}
                    {{ Form::token() }}
                    {{-- OKR --}}
                    {{ Form::label('okr', __('models/okrs.fields.name')) }}
                    {{ Form::text('okr', null, ['placeholder' => __('models/okrs.fields.name')]) }}
                    @if ($errors->has('okr'))
                        <p>{{$errors->first('okr')}}</p>
                    @endif
                    {{-- 送信ボタン --}}
                    {{ Form::submit(__('common/action.search'), ['class'=>'px-2 py-1 bg-green-400 text-white font-semibold rounded hover:bg-green-500;']) }}
                    {{ Form::close() }}
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>YEAR</th>
                            <th>OKR</th>
                            <th>UserName</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach($okrs as $okr)
                            <tr>
                                <td>{{ $okr->year }}</td>
                                <td>{{ $okr->name }}</td>
                                <td>{{ $okr->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $okrs->links() }}
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
