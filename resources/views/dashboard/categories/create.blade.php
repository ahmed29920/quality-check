@extends('dashboard.layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="container-fluid py-4">
        {{-- Wizard Steps --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h4 class="mb-0 text-purple fw-bold">Create New Category</h4>
                <small class="text-muted">Add category details and associated MCQ questions</small>
            </div>
            <div class="card-body">
                <nav aria-label="Progress">
                    <ol class="prog-indicator">
                        <li class="prog-indicator-item active" id="step-category">
                            <span class="prog-indicator-number">1</span>
                            <span class="prog-indicator-text">Category Info</span>
                        </li>
                        <li class="prog-indicator-item" id="step-questions">
                            <span class="prog-indicator-number">2</span>
                            <span class="prog-indicator-text">Questions</span>
                        </li>
                        <li class="prog-indicator-item" id="step-review">
                            <span class="prog-indicator-number">3</span>
                            <span class="prog-indicator-text">Review</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Wizard Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                    id="categoryWizardForm">
                    @csrf

                    {{-- Step 1: Category Information --}}
                    <div id="category-step" class="wizard-step">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-info-circle"></i> Category Information
                        </h5>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Category Name (EN)<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control" value="{{ old('name[en]') }}"
                                        required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Category Name (AR)<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" class="form-control" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                {{-- Pricing Fields (Hidden by default) --}}
                                <div id="pricing-fields" class="row" style="display: none;">
                                    <div class="col-md-6">
                                        <label class="form-label">Monthly Price ($)</label>
                                        <input type="number" name="monthly_subscription_price" class="form-control"
                                            value="{{ old('monthly_subscription_price') }}" min="0" step="0.01">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Weekly Price ($)</label>
                                        <input type="number" name="yearly_subscription_price" class="form-control"
                                            value="{{ old('yearly_subscription_price') }}" min="0" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Category Image</label>
                                <div class="upload-area border-dashed border-2 p-4 text-center position-relative"
                                    onclick="document.getElementById('imageInput').click()">

                                    <!-- محتوى الديف (بيختفي بعد الرفع) -->
                                    <div id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Click to upload image</p>
                                        <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
                                    </div>

                                    <!-- الصورة -->
                                    <img id="imagePreview" src="" alt="Preview"
                                        class="img-fluid rounded d-none w-100 h-100"
                                        style="object-fit: contain; max-height: 200px;">

                                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                </div>

                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description (EN)</label>
                                    <textarea name="description[en]" class="form-control" rows="4" placeholder="Describe this category...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description (AR)</label>
                                    <textarea name="description[ar]" class="form-control" rows="4" placeholder="Describe this category...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" name="is_active" id="is_active"
                                                class="form-check-input" value="1"
                                                @if (old('is_active', true)) checked @endif>
                                            <label class="form-check-label fw-bold" for="is_active">
                                                Category is Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" name="has_pricable_services"
                                                id="has_pricable_services" checked class="form-check-input" value="1"
                                                @if (old('has_pricable_services')) checked @endif>
                                            <label class="form-check-label fw-bold" for="has_pricable_services">
                                                Has Paid Services
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form- mb-3">
                                            <label class="form-control-label fw-bold" for="monthly_subscription_price">
                                                Monthly Subscription Price
                                            </label>
                                            <input type="number" name="monthly_subscription_price"
                                                id="monthly_subscription_price"  class="form-control" value="{{ old('monthly_subscription_price') }}">
                                                @error('monthly_subscription_price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form- mb-3">
                                            <label class="form-control-label fw-bold" for="yearly_subscription_price">
                                                Yearly Subscription Price
                                            </label>
                                            <input type="number" name="yearly_subscription_price" id="yearly_subscription_price"  class="form-control" value="{{ old('yearly_subscription_price') }}">
                                                @error('yearly_subscription_price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-purple" onclick="nextStep()">
                                Next: Questions <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 2: Questions --}}
                    <div id="questions-step" class="wizard-step" style="display: none;">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-question-circle"></i> MCQ Questions
                        </h5>

                        <div id="questionsContainer">
                            {{-- No questions by default --}}
                            <div class="text-center py-4" id="noQuestionsText">
                                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No questions added yet</h6>
                                <p class="text-muted">Click "Add Question" to start building your question set.</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" class="btn btn-outline-info" onclick="addQuestion()">
                                <i class="fas fa-plus"></i> Add Question
                            </button>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousStep()">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-purple" onclick="nextStep()">
                                Next: Review <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 3: Review --}}
                    <div id="review-step" class="wizard-step" style="display: none;">
                        <h5 class="fw-bold mb-4 text-purple">
                            <i class="fas fa-check-circle"></i> Review & Submit
                        </h5>

                        <div id="reviewContent">
                            {{-- Content will be populated by JavaScript --}}
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="previousStep()">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Create Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Question Template (Hidden) --}}
    <template id="questionTemplate">
        <div class="question-item border rounded p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-purple fw-bold">Question <span class="question-number"></span></h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeQuestion(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Question Title <span class="text-danger">*</span></label>
                        <textarea class="form-control question-title" rows="2" name="questions[INDEX][title]" required></textarea>
                    </div>

                    <div class="options-container mb-3">
                        <label class="form-label">Answer Options <span class="text-danger">*</span></label>
                        <div class="options-list">
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <span class="badge bg-info rounded-circle">A</span>
                                </span>
                                <input type="text" class="form-control" name="questions[INDEX][options][]" required>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="removeOption(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <span class="badge bg-info rounded-circle">B</span>
                                </span>
                                <input type="text" class="form-control" name="questions[INDEX][options][]" required>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="removeOption(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="addOption(this)">
                            <i class="fas fa-plus"></i> Add Option
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Score <span class="text-danger">*</span></label>
                            <input type="number" class="form-control question-score" name="questions[INDEX][score]"
                                min="1" max="100" value="10" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control question-order" name="questions[INDEX][sort_order]"
                                required>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="allowsAttachments"
                            name="questions[INDEX][allows_attachments]" value="1">
                        <label class="form-check-label" for="allowsAttachments">
                            Allow Attachments
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="requiresAttachment"
                            name="questions[INDEX][requires_attachment]" value="1">
                        <label class="form-check-label" for="requiresAttachment">
                            Require Attachment
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="isActive"
                            name="questions[INDEX][is_active]" value="1" checked>
                        <label class="form-check-label" for="isActive">
                            Question Active
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </template>

@endsection

@push('scripts')
    <script>
        let currentStep = 1;
        let questionCount = 0;

        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < 3) {
                    document.querySelectorAll('.prog-indicator-item').forEach(i => i.classList.remove('active'));
                    currentStep++;

                    document.getElementById('step-category').classList.toggle('active', currentStep == 1);
                    document.getElementById('step-questions').classList.toggle('active', currentStep == 2);
                    document.getElementById('step-review').classList.toggle('active', currentStep == 3);

                    document.querySelectorAll('.wizard-step').forEach(step => step.style.display = 'none');
                    document.getElementById(
                            `${currentStep == 1 ? 'category' : currentStep == 2 ? 'questions' : 'review'}-step`).style
                        .display = 'block';

                    if (currentStep == 3) {
                        generateReview();
                    }
                }
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                document.querySelectorAll('.prog-indicator-item').forEach(i => i.classList.remove('active'));
                currentStep--;

                document.getElementById('step-category').classList.toggle('active', currentStep == 1);
                document.getElementById('step-questions').classList.toggle('active', currentStep == 2);
                document.getElementById('step-review').classList.toggle('active', currentStep == 3);


                document.querySelectorAll('.wizard-step').forEach(step => step.style.display = 'none');
                document.getElementById(`${currentStep === 1 ? 'category' : currentStep === 2 ? 'questions' :
        'review'}-step`).style.display = 'block';
            }
        }

        function addQuestion() {
            const template = document.getElementById('questionTemplate');
            const container = document.getElementById('questionsContainer');
            const noQuestionsText = document.getElementById('noQuestionsText');

            if (noQuestionsText) noQuestionsText.style.display = 'none';

            const clone = template.content.cloneNode(true);

            // استبدال INDEX بالـ questionCount
            clone.querySelectorAll('[name*="INDEX"]').forEach(el => {
                el.name = el.name.replace('INDEX', questionCount);
            });
            clone.querySelectorAll('[id*="INDEX"]').forEach(el => {
                el.id = el.id.replace('INDEX', questionCount);
            });

            clone.querySelector('.question-number').textContent = questionCount + 1;
            clone.querySelector('.question-order').value = questionCount + 1;

            container.appendChild(clone);
            questionCount++;
        }

        function removeQuestion(button) {
            button.closest('.question-item').remove();
            questionCount--;

            if (questionCount === 0) {
                document.getElementById('noQuestionsText').style.display = 'block';
            }
        }

        function addOption(button) {
            const optionsList = button.parentElement.querySelector('.options-list');
            const optionCount = optionsList.querySelectorAll('.input-group').length;

            if (optionCount >= 10) {
                alert('Maximum 10 options allowed');
                return;
            }

            const letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            const questionItem = button.closest('.question-item');
            const index = Array.from(document.querySelectorAll('.question-item')).indexOf(questionItem);

            const newOption = document.createElement('div');
            newOption.className = 'input-group mb-2';
            newOption.innerHTML = `
                <span class="input-group-text">
                    <span class="badge bg-info rounded-circle">${letters[optionCount]}</span>
                </span>
                <input type="text" class="form-control" name="questions[${index}][options][]" required>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOption(this)">
                    <i class="fas fa-times"></i>
                </button>
                `;

            optionsList.appendChild(newOption);
        }

        function removeOption(button) {
            const optionsList = button.closest('.options-list');
            if (optionsList.querySelectorAll('.input-group').length <= 2) {
                alert('Minimum 2 options required');
                return;
            }
            button.closest('.input-group').remove();
        }

        function generateReview() {
            const
                reviewContent = document.getElementById('reviewContent');
            const formData = new
            FormData(document.getElementById('categoryWizardForm'));
            let html = ` <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold text-purple mb-3">Category Information</h6>
                <p><strong>Name (EN):</strong> ${formData.get('name[en]')}</p>
                <p><strong>Name (AR):</strong> ${formData.get('name[ar]')}</p>
                <p><strong>Description (EN):</strong> ${formData.get('description[en]') || 'No description'}</p>
                <p><strong>Description (AR):</strong> ${formData.get('description[ar]') || 'No description'}</p>
                <p><strong>Active:</strong> ${formData.get('is_active') ? 'Yes' : 'No'}</p>
                <p><strong>Paid Services:</strong> ${formData.get('has_pricable_services') ? 'Yes' : 'No'}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold text-purple mb-3">Questions Summary</h6>
                <p><strong>Total Questions:</strong> ${questionCount}</p>
                ${questionCount > 0
                ? `<p><strong>Total Score:</strong> ${Array.from(document.querySelectorAll('.question-score')).reduce((sum,
                                            input) => sum + parseInt(input.value || 0), 0)} points</p>`
                : '<p class="text-muted">No questions added</p>'}
            </div>
            </div>
            `;

            if (questionCount > 0) {
                html += '<h6 class="fw-bold text-purple mt-4 mb-3">Questions Preview</h6>';
                document.querySelectorAll('.question-item').forEach((item, index) => {
                    const title = item.querySelector('.question-title').value;
                    const score = item.querySelector('.question-score').value;
                    html += `
            <div class="border rounded p-3 mb-2">
                <div class="fw-bold">Question ${index + 1}: ${title}</div>
                <small class="text-muted">Score: ${score} points</small>
            </div>
            `;
                });
            }

            reviewContent.innerHTML = html;
        }

        function validateCurrentStep() {
            if (currentStep === 1) {
                const nameEn = document.querySelector('input[name="name[en]"]').value.trim();
                const nameAr = document.querySelector('input[name="name[ar]"]').value.trim();
                if (!nameEn || !nameAr) {
                    alert('Please enter both English and Arabic category names');
                    return false;
                }
            }
            return true;
        }
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
    </script>
@endpush
