@extends('dashboard.layouts.app')

@section('title', 'Edit Provider - ' . $provider->name)

@section('content')
    <div class="container-fluid py-4">
        {{-- Wizard Steps --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h4 class="mb-0 text-purple fw-bold">Edit Provider</h4>
                <small class="text-muted">Update provider information step by step</small>
            </div>
            <div class="card-body">
                <nav aria-label="Progress">
                    <ol class="prog-indicator">
                        <li class="prog-indicator-item active" id="step-basic">
                            <span class="prog-indicator-number">1</span>
                            <span class="prog-indicator-text">Basic Info</span>
                        </li>
                        <li class="prog-indicator-item" id="step-business">
                            <span class="prog-indicator-number">2</span>
                            <span class="prog-indicator-text">Business Details</span>
                        </li>
                        <li class="prog-indicator-item" id="step-category">
                            <span class="prog-indicator-number">3</span>
                            <span class="prog-indicator-text">Category & Badge</span>
                        </li>
                        <li class="prog-indicator-item" id="step-media">
                            <span class="prog-indicator-number">4</span>
                            <span class="prog-indicator-text">Media & Files</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Wizard Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.providers.update', $provider->slug) }}" method="POST" enctype="multipart/form-data" id="providerWizardForm">
                    @csrf
                    @method('PUT')

                    {{-- Step 1: Basic Information --}}
                    <div id="basic-step" class="wizard-step">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-user"></i> Basic Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name (English) <span class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                           value="{{ old('name.en', $provider->getTranslation('name', 'en')) }}" required>
                                    @error('name.en')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name (Arabic) <span class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                           value="{{ old('name.ar', $provider->getTranslation('name', 'ar')) }}" required>
                                    @error('name.ar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug', $provider->slug) }}" required>
                                    @error('slug')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">User Account</label>
                                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                        <option value="">Select User</option>
                                        @foreach(\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $provider->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description (English)</label>
                                    <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror" rows="3">{{ old('description.en', $provider->getTranslation('description', 'en')) }}</textarea>
                                    @error('description.en')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description (Arabic)</label>
                                    <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror" rows="3">{{ old('description.ar', $provider->getTranslation('description', 'ar')) }}</textarea>
                                    @error('description.ar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Business Details --}}
                    <div id="business-step" class="wizard-step" style="display: none;">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-building"></i> Business Details
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                           value="{{ old('address', $provider->address) }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Website</label>
                                    <input type="url" name="website_link" class="form-control @error('website_link') is-invalid @enderror"
                                           value="{{ old('website_link', $provider->website_link) }}">
                                    @error('website_link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Established Date</label>
                                    <input type="date" name="established_date" class="form-control @error('established_date') is-invalid @enderror"
                                           value="{{ old('established_date', $provider->established_date?->format('Y-m-d')) }}">
                                    @error('established_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Latitude</label>
                                    <input type="number" step="any" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                           value="{{ old('latitude', $provider->latitude) }}">
                                    @error('latitude')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Longitude</label>
                                    <input type="number" step="any" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
                                           value="{{ old('longitude', $provider->longitude) }}">
                                    @error('longitude')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Start Time</label>
                                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                                   value="{{ old('start_time', $provider->start_time ? \Carbon\Carbon::parse($provider->start_time)->format('H:i') : '') }}">
                                            @error('start_time')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">End Time</label>
                                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                                   value="{{ old('end_time', $provider->end_time ? \Carbon\Carbon::parse($provider->end_time)->format('H:i') : '') }}">
                                            @error('end_time')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Category & Badge --}}
                    <div id="category-step" class="wizard-step" style="display: none;">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-tags"></i> Category & Badge
                        </h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $provider->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Badge</label>
                                    <select name="badge_id" class="form-select @error('badge_id') is-invalid @enderror">
                                        <option value="">Select Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge->id }}" {{ old('badge_id', $provider->badge_id) == $badge->id ? 'selected' : '' }}>
                                                {{ $badge->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('badge_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 4: Media & Files --}}
                    <div id="media-step" class="wizard-step" style="display: none;">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-images"></i> Media & Files
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Provider Image</label>
                                <div class="upload-area border-dashed border-2 p-4 text-center position-relative"
                                     onclick="document.getElementById('imageInput').click()">

                                    {{-- Upload Placeholder --}}
                                    <div id="uploadPlaceholder" style="{{ $provider->image ? 'display: none;' : '' }}">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Click to upload image</p>
                                        <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
                                    </div>

                                    {{-- Current or New Image --}}
                                    <img id="imagePreview" src="{{ $provider->image_url }}" alt="Preview"
                                         class="img-fluid rounded {{ $provider->image ? '' : 'd-none' }}" style="max-height: 300px;">
                                </div>
                                <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Provider PDF</label>
                                <div class="upload-area border-dashed border-2 p-4 text-center position-relative"
                                     onclick="document.getElementById('pdfInput').click()">

                                    {{-- Upload Placeholder --}}
                                    <div id="pdfPlaceholder" style="{{ $provider->pdf ? 'display: none;' : '' }}">
                                        <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Click to upload PDF</p>
                                        <small class="text-muted">Max 10MB (PDF)</small>
                                    </div>

                                    {{-- Current PDF --}}
                                    @if($provider->pdf)
                                        <div id="pdfPreview">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <p class="text-muted mb-0">Current PDF</p>
                                            <a href="{{ $provider->pdf_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-eye"></i> View PDF
                                            </a>
                                        </div>
                                    @else
                                        <div id="pdfPreview" class="d-none">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <p class="text-muted mb-0" id="pdfFileName">PDF Selected</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="pdf" id="pdfInput" class="d-none" accept=".pdf">
                                @error('pdf')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                        <button type="button" class="btn btn-outline-secondary" onclick="previousStep()" id="prevBtn" style="display: none;">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-purple" onclick="nextStep()" id="nextBtn">
                                Next <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                                <i class="fas fa-save"></i> Update Provider
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentStep = 1;

        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < 4) {
                    document.querySelectorAll('.prog-indicator-item').forEach(i => i.classList.remove('active'));
                    currentStep++;

                    document.getElementById('step-basic').classList.toggle('active', currentStep == 1);
                    document.getElementById('step-business').classList.toggle('active', currentStep == 2);
                    document.getElementById('step-category').classList.toggle('active', currentStep == 3);
                    document.getElementById('step-media').classList.toggle('active', currentStep == 4);

                    document.querySelectorAll('.wizard-step').forEach(step => step.style.display = 'none');
                    const stepMap = {1: 'basic', 2: 'business', 3: 'category', 4: 'media'};
                    document.getElementById(`${stepMap[currentStep]}-step`).style.display = 'block';

                    updateNavigationButtons();
                }
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                document.querySelectorAll('.prog-indicator-item').forEach(i => i.classList.remove('active'));
                currentStep--;

                document.getElementById('step-basic').classList.toggle('active', currentStep == 1);
                document.getElementById('step-business').classList.toggle('active', currentStep == 2);
                document.getElementById('step-category').classList.toggle('active', currentStep == 3);
                document.getElementById('step-media').classList.toggle('active', currentStep == 4);

                document.querySelectorAll('.wizard-step').forEach(step => step.style.display = 'none');
                const stepMap = {1: 'basic', 2: 'business', 3: 'category', 4: 'media'};
                document.getElementById(`${stepMap[currentStep]}-step`).style.display = 'block';

                updateNavigationButtons();
            }
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-block';

            if (currentStep === 4) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
            }
        }

        function validateCurrentStep() {
            if (currentStep === 1) {
                const nameEn = document.querySelector('input[name="name[en]"]').value.trim();
                const nameAr = document.querySelector('input[name="name[ar]"]').value.trim();
                if (!nameEn || !nameAr) {
                    alert('Please enter both English and Arabic provider names');
                    return false;
                }
            }
            if (currentStep === 3) {
                const categoryId = document.querySelector('select[name="category_id"]').value;
                if (!categoryId) {
                    alert('Please select a category');
                    return false;
                }
            }
            return true;
        }

        // Image upload handler
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const placeholder = document.getElementById('uploadPlaceholder');
                    const imgTag = document.getElementById('imagePreview');

                    placeholder.style.display = "none";
                    imgTag.classList.remove("d-none");
                    imgTag.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // PDF upload handler
        document.getElementById('pdfInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const placeholder = document.getElementById('pdfPlaceholder');
                const preview = document.getElementById('pdfPreview');
                const fileName = document.getElementById('pdfFileName');

                placeholder.style.display = "none";
                preview.classList.remove("d-none");
                if (fileName) {
                    fileName.textContent = file.name;
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateNavigationButtons();
        });
    </script>
@endpush
