<x-layouts.main.website>
    <x-slot:title>@lang('words.new_department')</x-slot:title>

    <div class="main-content">
        <div class="container pt-4"> 

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home.page') }}" class="text-decoration-none">
                            <i class="fas fa-home"></i> @lang('words.main_page')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('department.index') }}">@lang('words.department_management')</a> 
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" style="color: #808080;">@lang('words.new_department')</a> 
                    </li>
                </ol>
            </nav>
            
            <div class="search-wrapper" style="margin-bottom: 0;">
                <div class="search-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-md-0">@lang('words.new_department')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">  
            <form action="{{ route('department.store') }}" method="POST" id="createDepartmentForm" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="form-grid">
                        <div class="form-row"> 
                            <div class="form-group">
                                <label for="name_uz" class="notification-label">@lang('words.department_name') (UZ)</label>
                                <input type="text" 
                                        class="form-control @error('name_uz') is-invalid @enderror" 
                                        id="name_uz" 
                                        name="name_uz" 
                                        value="{{ old('name_uz') }}" 
                                        required 
                                        placeholder="@lang('words.enter_department_name')">
                                @error('name_uz')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div> 

                            <div class="form-group">
                                <label for="name_ru" class="notification-label">@lang('words.department_name') (RU)</label>
                                <input type="text" 
                                        class="form-control @error('name_ru') is-invalid @enderror" 
                                        id="name_ru" 
                                        name="name_ru" 
                                        value="{{ old('name_ru') }}" 
                                        required 
                                        placeholder="@lang('words.enter_department_name')">
                                @error('name_ru')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name_en" class="notification-label">@lang('words.department_name') (EN)</label>
                                <input type="text" 
                                        class="form-control @error('name_en') is-invalid @enderror" 
                                        id="name_en" 
                                        name="name_en" 
                                        value="{{ old('name_en') }}" 
                                        required 
                                        placeholder="@lang('words.enter_department_name')">
                                @error('name_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                            <div class="form-group">
                                <label for="floor" class="notification-label">@lang('words.floor')</label>
                                <select class="form-control @error('floor') is-invalid @enderror" 
                                        id="floor" 
                                        name="floor" 
                                        required>
                                    <option value="">@lang('words.select_floor')</option>
                                    <option value="1" {{ old('floor') == 1 ? 'selected' : '' }}>@lang('words.floor_1')</option>
                                    <option value="2" {{ old('floor') == 2 ? 'selected' : '' }}>@lang('words.floor_2')</option>
                                    <option value="3" {{ old('floor') == 3 ? 'selected' : '' }}>@lang('words.floor_3')</option>
                                    <option value="4" {{ old('floor') == 4 ? 'selected' : '' }}>@lang('words.floor_4')</option>
                                </select>
                                @error('floor')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-row"> 
                            <div class="form-group">
                                <label for="head_doctor_id" class="notification-label">@lang('words.head_doctor')</label>
                                <select class="form-control @error('head_doctor_id') is-invalid @enderror" 
                                        id="head_doctor_id" 
                                        name="head_doctor_id">
                                    <option value="">@lang('words.unassigned')</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('head_doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->last_name }} {{ $doctor->user->name }} - {{ $doctor->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('head_doctor_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                            <div class="form-group">
                                <label for="status" class="notification-label">@lang('words.status')</label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status">
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>@lang('words.active')</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>@lang('words.inactive')</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div class="form-group">
                            <label class="notification-label">@lang('words.image')</label>
                            <div class="image-upload-minimal">
                                <div class="upload-btn" onclick="document.getElementById('photo').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>@lang('words.upload_image')</span>
                                </div>
                                <span class="file-name" id="fileName">@lang('words.no_file_selected')</span>
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
                            @error('photo')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description_uz" class="notification-label">@lang('words.description') (UZ)</label>
                            <textarea class="form-control @error('description_uz') is-invalid @enderror" 
                                        id="description_uz" 
                                        name="description_uz" 
                                        rows="4" 
                                        placeholder="@lang('words.enter_description')">{{ old('description_uz') }}</textarea>
                            @error('description_uz')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description_ru" class="notification-label">@lang('words.description') (RU)</label>
                            <textarea class="form-control @error('description_ru') is-invalid @enderror" 
                                        id="description_ru" 
                                        name="description_ru" 
                                        rows="4" 
                                        placeholder="@lang('words.enter_description')">{{ old('description_ru') }}</textarea>
                            @error('description_ru')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description_en" class="notification-label">@lang('words.description') (EN)</label>
                            <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                        id="description_en" 
                                        name="description_en" 
                                        rows="4" 
                                        placeholder="@lang('words.enter_description')">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div> 
                    </div>

                </div>
                <div class="submit-section">
                    <div class="submit-actions">
                        <a href="{{ route('department.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> @lang('words.cancel')
                        </a>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> @lang('words.save')
                        </button>
                    </div>  
                </div>
            </form> 
        </div>
    </div>    

    <style>
        /* Image Upload Styles */
        .image-upload-minimal {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #fff;
            border: 2px dashed #00BFFF;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #00BFFF;
            font-weight: 500;
        }

        .upload-btn:hover {
            background: #00BFFF;
            color: #fff;
            border-color: #00BFFF;
        }

        .upload-btn i {
            font-size: 18px;
        }

        .file-name {
            color: #495057;
            font-size: 14px;
            font-weight: 500;
            padding: 5px 10px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .image-preview-minimal {
            position: relative;
            display: inline-block;
        }

        .image-preview-minimal img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 6px;
            border: 2px solid #dee2e6;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            border: 2px solid #fff;
            cursor: pointer;
            font-size: 14px;
            line-height: 18px;
            text-align: center;
            transition: all 0.3s ease;
            padding: 0;
        }

        .remove-image:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        @media (max-width: 576px) {
            .upload-btn {
                padding: 8px 12px;    
                font-size: 11px;
            }

            .upload-btn i {
                font-size: 15px;
            }

            .file-name {
                font-size: 12px;
            }
        }
    </style>

    <script>
        // Rasm preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const fileName = document.getElementById('fileName');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'inline-block';
                    fileName.textContent = input.files[0].name;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Rasmni olib tashlash
        function removeImage() {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('photo').value = '';
            document.getElementById('fileName').textContent = '@lang('words.no_file_selected')';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createDepartmentForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> @lang('words.saving')...';
            });
        });
    </script>

</x-layouts.main.website>