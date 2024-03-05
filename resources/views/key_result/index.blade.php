@extends('layouts.app')
@section('title', __('common/title.key_result.index'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card mb-4">
                    @if ($isArchive)
                        <div class="card-header card-header-archive">{{ __('common/title.key_result.archive') }}</div>
                    @else
                        <div class="card-header">{{ __('common/title.key_result.index') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">

                                    @if ($isArchive)
                                        <p>{{ link_to_route('objective.archived_list', __('common/action.back'), ['user_id' => $objective->user->id], ['class' => 'text-decoration-none']) }}</p>
                                    @else
                                        <p>{{ link_to_route('objective.index', __('common/action.back'), ['user_id' => $objective->user->id], ['class' => 'text-decoration-none']) }}</p>
                                    @endif

                                    @include('flash::message')

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/users.fields.name') }}</th>
                                                <th>{{ __('models/objectives.fields.objective') }}</th>
                                                <th>{{ __('models/objectives.fields.year') }}</th>
                                                <th>{{ __('models/quarters.fields.quarter') }}</th>
                                                <th>{{ __('models/objectives.fields.priority') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td width="20%" class="align-middle">
                                                        <img class="border border-secondary rounded-circle mx-2" src="{{ $objective->user->profile_image_path }}" alt="プロフィール画像">
                                                        {{ $objective->user->name }}
                                                    </td>
                                                    <td width="50%" class="align-middle">{!! nl2br($objective->linked_objective) !!}</td>
                                                    <td width="10%" class="align-middle">{{ $objective->year }}</td>
                                                    <td width="10%" class="align-middle">
                                                        {{ App\Enums\Quarter::getDescription($objective->quarter) }}
                                                    </td>
                                                    <td width="10%" class="align-middle">
                                                        {!! App\Enums\Priority::getFontAwesome($objective->priority) !!}
                                                        {{ App\Enums\Priority::getDescription($objective->priority) }}
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/objectives.fields.score') }}</th>
                                                <th>{{ __('models/objectives.fields.remarks') }}</th>
                                                <th>{{ __('models/objectives.fields.impression') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if ($objective->score == 0)
                                                    <td width="10%" class="align-middle text-center score">{{ $objective->score }}</td>
                                                @elseif ($objective->score <= 0.6)
                                                    <td width="10%" class="align-middle bg-danger text-white text-center score">{{ $objective->score }}</td>
                                                @else
                                                    <td width="10%" class="align-middle bg-success text-white text-center score">{{ $objective->score }}</td>
                                                @endif

                                                <td width="45%" class="align-middle">{!! nl2br($objective->linked_remarks) !!}</td>
                                                <td width="45%" class="align-middle">{!! nl2br($objective->linked_impression) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('models/key-results.fields.key_result') }}</th>
                                                <th>{{ __('models/key-results.fields.remarks') }}</th>
                                                <th>{{ __('models/key-results.fields.impression') }}</th>
                                                <th>{{ __('models/key-results.fields.score') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($keyResults as $keyResult)
                                                <tr>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_keyResult) !!}</td>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_remarks) !!}</td>
                                                    <td width="30%" class="align-middle">{!! nl2br($keyResult->linked_impression) !!}</td>
                                                    <td width="10%" class="align-middle">{{ $keyResult->score }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- コメント欄 --}}
                <div class="card">
                    <div class="card-header">
                        {{ __('common/title.key_result.comment') }}
                    </div>
                    <div class="card-body">
                        <div class="bg-gray-100">
                            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                                    @if(count($comments) > 0)
                                        @foreach($comments as $comment)
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="20%" class="align-middle">
                                                        <img class="border border-secondary rounded-circle mx-2" src="{{ $comment->user->profile_image_path }}" alt="プロフィール画像">
                                                        {{ $comment->user->name }}
                                                    </td>
                                                    <td width="50%" class="align-middle">{!! nl2br($comment->linked_comment) !!}</td>
                                                    <td width="10%" class="align-middle"><span class="align-righet comment-error-message"></span></td>
                                                    <td width="5%" class="align-middle">
                                                        @if (!$commentLikeUserInfo[$comment->id]['isLiked'])
                                                            <i class="fas fa-music like-toggle" data-comment-id="{{ $comment->id }}"></i>
                                                        @else
                                                            <i class="fas fa-music heart like-toggle liked" data-comment-id="{{ $comment->id }}"></i>
                                                        @endif
                                                        <span class="like-counter">{{$commentLikeUserInfo[$comment->id]['likeCount']}}</span>
                                                    </td>
                                                    <td width="10%" class="align-middle">{{ $comment->created_at }}</td>
                                                    <td width="5%" class="align-middle">
                                                        @if($comment->user_id === Auth::id())
                                                            {{ Form::open(['route' => ['key_result.destroy_comment', [$comment->id, $objective->id]], 'method' => 'delete', 'class' => 'd-inline-block']) }}
                                                            {{ Form::submit(__('common/action.delete'), [
                                                                'class' => 'btn btn-danger',
                                                                'onclick' => "return confirm('" . __('common/message.key_result.delete_comment_confirm')  . "')"
                                                            ])}}
                                                            {{ Form::close() }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    @else
                                        <p>まだコメントがありません</p>
                                    @endif

                                    <div class="form">
                                        {{ Form::open(['route' => ['key_result.comment'], 'method' => 'post']) }}
                                        {{ Form::hidden('objective_id', $objective->id) }}

                                        <div class="form-group row">
                                            <div class="col-md-2 mb-3">
                                                {{ Form::label('comment', __('models/comments.fields.comment')) }}
                                            </div>
                                            <div class="col-md-10">
                                                {{ Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'objective', 'rows' => '10']) }}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                {{ Form::submit(__('common/action.comment'), ['class' => 'align-self-center px-2 py-1 rounded btn btn-primary']) }}
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
    @include('parts.cdn-jquery')
    @push('scripts')
    <script>
        $(() => {
            $('.like-toggle').on('click', function () {

                // いいね追加
                const addLike = () => {
                    postAjaxRequest('{{ route('like') }}', 1);
                };

                // いいね取り消し
                const removeLike = () => {
                    postAjaxRequest('{{ route('remove') }}', -1);
                };

                // DB更新
                const postAjaxRequest = (route, count) => {
                    let likeCommentId = $likeToggle.data('comment-id');
                    let userId = "{{Auth::user()->id}}";

                    let jqXHR = $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: route,
                        method: 'POST',
                        data: {
                            'comment_id': likeCommentId,
                            'user_id': userId
                        },
                    })
                    .done((data) => {
                        $likeToggle.toggleClass('liked');
                        let likeCounter = $likeToggle.siblings('.like-counter');
                        let currentCount = parseInt(likeCounter.text());
                        likeCounter.text(currentCount + count); // いいねのカウントを追加または減らす。
                    })
                    .fail(() => {
                        $likeToggle.closest('tr').find('.comment-error-message').text('DB更新失敗').css('color', 'red');
                    });
                };

                let $likeToggle = $(event.currentTarget);
                if ($likeToggle.hasClass('liked')) {
                    removeLike();
                    return;
                }
                addLike();
                return;
            });
        });
    </script>
    @endpush
@endsection
