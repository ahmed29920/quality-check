@extends('dashboard.layouts.app')

@section('title', 'Create MCQ Question')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h4 class="mb-0 text-purple fw-bold">Create New MCQ Question</h4>
                    <small class="text-muted">Add a multiple choice question with options and scoring</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mcq-questions.store') }}" method="POST" id="mcqForm">
                        @csrf

                        {{-- Category Selection --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            @if($category && $category->id == $cat->id) selected @endif>
                                        {{ $cat->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Question Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Question Title <span class="text-danger">*</span></label>
                            <textarea name="title" class="form-control" rows="3"
                                      placeholder="Enter your question here..." required>{{ old('title') }}</textarea>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Answer Options --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Answer Options <span class="text-danger">*</span></label>
                            <div id="optionsContainer">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <span class="badge bg-purple rounded-circle">A</span>
                                    </span>
                                    <input type="text" name="options[]" class="form-control"
                                           placeholder="Option A" value="{{ old('options.0') }}">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <span class="badge bg-purple rounded-circle">B</span>
                                    </span>
                                    <input type="text" name="options[]" class="form-control"
                                           placeholder="Option B" value="{{ old('options.1') }}">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <span class="badge bg-purple rounded-circle">C</span>
                                    </span>
                                    <input type="text" name="options[]" class="form-control"
                                           placeholder="Option C" value="{{ old('options.2') }}">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <span class="badge bg-purple rounded-circle">D</span>
                                    </span>
                                    <input type="text" name="options[]" class="form-control"
                                           placeholder="Option D" value="{{ old('options.3') }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-purple btn-sm" onclick="addOption()">
                                <i class="fas fa-plus"></i> Add Option
                            </button>
                            <small class="text-muted d-block mt-2">Minimum 2 options, maximum 10 options</small>
                            @error('options')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Score --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Score <span class="text-danger">*</span></label>
                            <input type="number" name="score" class="form-control" min="1" max="100"
                                   value="{{ old('score', 1) }}" required>
                            <small class="text-muted">Points awarded for correct answer (1-100)</small>
                            @error('score')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Attachment Settings --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Attachment Settings</label>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-check">
                                        <input type="checkbox" name="allows_attachments" id="allows_attachments"
                                               class="form-check-input" value="1"
                                               @if(old('allows_attachments')) checked @endif>
                                        <label class="form-check-label" for="allows_attachments">
                                            Allow attachments
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="requires_attachment" id="requires_attachment"
                                               class="form-check-input" value="1"
                                               @if(old('requires_attachment')) checked @endif>
                                        <label class="form-check-label" for="requires_attachment">
                                            Require attachment
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Attachment requirements will only apply if attachments are allowed</small>
                        </div>

                        {{-- Additional Settings --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Additional Settings</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" id="is_active"
                                               class="form-check-input" value="1"
                                               @if(old('is_active', true)) checked @endif>
                                        <label class="form-check-label" for="is_active">
                                            Question is active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" min="0"
                                           value="{{ old('sort_order', 0) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.mcq-questions.index', $category ? ['category_id' => $category->id] : []) }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-purple">
                                <i class="fas fa-save"></i> Create Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let optionCount = 4;
const optionLabels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

function addOption() {
    if (optionCount >= 10) {
        alert('Maximum 10 options allowed');
        return;
    }

    const container = document.getElementById('optionsContainer');
    const newOption = document.createElement('div');
    newOption.className = 'input-group mb-2';
    newOption.innerHTML = `
        <span class="input-group-text">
            <span class="badge bg-purple rounded-circle">${optionLabels[optionCount]}</span>
        </span>
        <input type="text" name="options[]" class="form-control rounded-end"
               placeholder="Option ${optionLabels[optionCount]}">
        <button type="button" class="btn btn-outline-danger m-0" onclick="removeOption(this)">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(newOption);
    optionCount++;
}

function removeOption(button) {
    if (document.querySelectorAll('#optionsContainer .input-group').length <= 2) {
        alert('Minimum 2 options required');
        return;
    }

    button.closest('.input-group').remove();
    optionCount--;
}

// Add remove buttons to existing options
document.addEventListener('DOMContentLoaded', function() {
    const existingOptions = document.querySelectorAll('#optionsContainer .input-group');
    existingOptions.forEach((option, index) => {
        if (index >= 2) { // Keep first 2 options without remove buttons
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-danger m-0';
            button.innerHTML = '<i class="fas fa-times"></i>';
            button.onclick = () => removeOption(button);
            option.appendChild(button);
        }
    });
});
</script>
@endpush
