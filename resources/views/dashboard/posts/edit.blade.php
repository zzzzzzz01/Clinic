<x-layouts.main.website>
    <x-slot:title>
        @lang('words.edit_post')
    </x-slot:title> 

    <link rel="stylesheet" href="{{ asset('temp2/css/posts.css') }}" />

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('posts.index') }}" class="text-decoration-none">
                        @lang('words.news')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                    {{ \Illuminate\Support\Str::limit($post->title, 20) }}
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <span style="color: #808080;">@lang('words.edit_post')</span>
                </li>
            </ol>
        </nav>

        <div class="search-card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">@lang('words.edit_post')</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-container"> 

                <!-- Title UZ -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.title_uz') <span class="required-star">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('title_uz') is-invalid @enderror" 
                           name="title_uz" 
                           value="{{ old('title_uz', $post->title_uz) }}">
                    @error('title_uz')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title RU -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.title_ru') <span class="required-star">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('title_ru') is-invalid @enderror" 
                           name="title_ru" 
                           value="{{ old('title_ru', $post->title_ru) }}"> 
                    @error('title_ru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title EN -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.title_en') <span class="required-star">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('title_en') is-invalid @enderror" 
                           name="title_en" 
                           value="{{ old('title_en', $post->title_en) }}">
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description UZ -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.description_uz') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('description_uz') is-invalid @enderror" 
                              name="description_uz"  
                              rows="3">{{ old('description_uz', $post->description_uz) }}</textarea>
                    @error('description_uz')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description RU -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.description_ru') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('description_ru') is-invalid @enderror" 
                              name="description_ru"  
                              rows="3">{{ old('description_ru', $post->description_ru) }}</textarea>
                    @error('description_ru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description EN -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.description_en') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror" 
                              name="description_en"  
                              rows="3">{{ old('description_en', $post->description_en) }}</textarea>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content UZ -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.content_uz') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('content_uz') is-invalid @enderror" 
                              name="content_uz"  
                              rows="6">{{ old('content_uz', $post->content_uz) }}</textarea>
                    @error('content_uz')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content RU -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.content_ru') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('content_ru') is-invalid @enderror" 
                              name="content_ru"  
                              rows="6">{{ old('content_ru', $post->content_ru) }}</textarea>
                    @error('content_ru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content EN -->
                <div class="form-group">
                    <label class="notification-label">
                        @lang('words.content_en') <span class="required-star">*</span>
                    </label>
                    <textarea class="form-control @error('content_en') is-invalid @enderror" 
                              name="content_en" 
                              rows="6">{{ old('content_en', $post->content_en) }}</textarea>
                    @error('content_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Rasm yuklash -->
                <div class="form-group">
                    <label class="notification-label">@lang('words.image')</label>
                    
                    <!-- Joriy rasmni ko'rsatish -->
                    @if($post->photo)
                        <div class="current-image mb-3">
                            <img src="{{ asset('storage/'.$post->photo) }}" alt="Current image">
                            <div class="mt-1">
                                <small class="text-muted">@lang('words.current_image')</small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="image-upload-minimal">
                        <div class="upload-btn" onclick="document.getElementById('photo').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>@lang('words.upload_image')</span>
                        </div>
                        
                        <span class="file-name" id="fileName">
                            @if($post->photo)
                                {{ basename($post->photo) }}
                            @else
                                @lang('words.no_file_selected')
                            @endif
                        </span>
                        
                        <div class="image-preview-minimal" id="imagePreview" style="display: none;">
                            <img id="previewImg" src="#" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeImage()">×</button>
                        </div>
                        
                        <input type="file" 
                               id="photo" 
                               name="photo" 
                               accept="image/*" 
                               style="display: none;"
                               onchange="previewImage(this)">
                    </div>
                    <div class="form-text text-muted">@lang('words.keep_current_image')</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategoriya va Holat -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="notification-label">
                            @lang('words.category') <span class="required-star">*</span>
                        </label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                            <option value="" disabled>@lang('words.select_category')</option>
                            @foreach($data['categories'] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="notification-label">@lang('words.status')</label>
                        <select class="form-control" name="status">
                            <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : '' }}>@lang('words.active')</option>
                            <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : '' }}>@lang('words.inactive')</option>
                        </select> 
                    </div>
                </div>

                <!-- Teglar -->
                <div class="form-group">
                    <label class="notification-label">@lang('words.tags')</label>
                    <div class="tags-select-container">
                        <input type="text" 
                                class="form-control tags-input" 
                                id="tagsInput" 
                                placeholder="@lang('words.click_to_select_tags')..."
                                readonly
                                onclick="toggleTagsDropdown()">
                        
                        <input type="hidden"
                               name="tags"
                               id="selectedTagsInput"
                               value="{{ old('tags', $post->tags->pluck('id')->implode(',')) }}">
                        
                        <div class="tags-dropdown" id="tagsDropdown">
                            <input type="text" 
                                    class="tag-search-input" 
                                    id="tagSearch" 
                                    placeholder="@lang('words.search_tags')..."
                                    oninput="filterTags(this.value)">
                            
                            <div id="tagOptions">
                                @foreach($data['tags'] as $tag)
                                    @php
                                        $selectedTags = old('tags', $post->tags->pluck('id')->implode(','));
                                        if (is_string($selectedTags)) {
                                            $selectedTags = array_map('trim', explode(',', $selectedTags));
                                        } else {
                                            $selectedTags = is_array($selectedTags) ? $selectedTags : [];
                                        }
                                    @endphp
                                    <div class="tag-option">
                                        <input type="checkbox"
                                            id="tag_{{ $tag->id }}"
                                            value="{{ $tag->id }}"
                                            data-name="{{ $tag->name }}"
                                            onchange="updateSelectedTags()"
                                            {{ in_array((string)$tag->id, $selectedTags) ? 'checked' : '' }}>
                                        <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                        <span class="tag-count">({{ $tag->posts_count ?? 0 }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="selected-tags" id="selectedTags"></div>
                    <div class="form-text">@lang('words.select_or_add_tags')</div>
                </div> 

            </div>

            <div class="submit-section">
                <div class="submit-actions">
                    <a href="{{ route('posts.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> @lang('words.cancel')
                    </a>
                    <button type="submit" class="btn-primary">
                        @lang('words.update')
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('temp2/js/posts.js') }}"></script>

</x-layouts.main.website>