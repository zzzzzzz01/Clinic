<div class="comments-section">
                <h4 class="comments-title">
                    @lang('words.comments')
                    <span>{{ $commentCount }}</span>
                </h4>

                <!-- Comment Form -->
                <div class="comment-form">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <textarea placeholder="@lang('words.write_comment_placeholder')" name="message" required></textarea>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                @lang('words.submit')
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                <div class="comments-list">
                    @foreach($comments as $comment)
                    <div class="comment-item">
                        <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                        <div class="comment-body">
                            <div class="comment-user">
                                {{ $comment->user->name }} 
                                @if($comment->user->isAdmin())
                                    <span class="badge">@lang('words.admin')</span>
                                @endif
                                <span class="comment-date">
                                    <i class="fas fa-calendar-alt"></i> {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="comment-text">{{ $comment->message }}</p>
                            <div class="comment-actions">
                                <button><i class="fas fa-thumbs-up"></i> {{ $comment->likes_count ?? 0 }}</button>
                                <button onclick="replyComment(this)"><i class="fas fa-reply"></i> @lang('words.reply')</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>