@extends('dashboard.layouts.app')

@section('title', 'Edit MCQ Question')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Header --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h4 class="mb-0 text-info fw-bold">Edit MCQ Question</h4>
                    <small class="text-muted">Update question details and options</small>
                </div>
            </div>

            {{-- Form --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.mcq-questions.update', $mcqQuestion) }}" method="POST" id="mcqForm">
                        @csrf
                        @method('PUT')

                        {{-- Category Selection --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            @if(old('category_id', $mcqQuestion->category_id) == $cat->id) selected @endif>
                                        {{ $cat->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Question Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Question Title <span class="text-danger">*</span></label>
                            <textarea name="title" class="form-control" rows="3"
                                      placeholder="Enter your question here..." required>{{ old('title', $mcqQuestion->title) }}</textarea>
                            @error('title')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Answer Options --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Answer Options <span class="text-danger">*</span></label>
                            <div id="optionsContainer">
                                @foreach($mcqQuestion->options as $index => $option)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">
                                            <span class="badge bg-info rounded-circle">{{ chr(65 + $index) }}</span>
                                        </span>
                                        <input type="text" name="options[]" class="form-control"
                                               placeholder="Option {{ chr(65 + $index) }}"
                                               value="{{ old('options.' . $index, $option) }}">
                                        @if($index >= 2)
                                            <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="addOption()">
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
                                   value="{{ old('score', $mcqQuestion->score) }}" required>
                            <small class="text-muted">Points awarded for correct answer (1-100)</small>
                            @error('score')
                                <small class="text-danger d-block">{{ $message }}</small>
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
                                               @if(old('allows_attachments', $mcqQuestion->allows_attachments)) checked @endif>
                                        <label class="form-check-label" for="allows_attachments">
                                            Allow attachments
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="requires_attachment" id="requires_attachment"
                                               class="form-check-input" value="1"
                                               @if(old('requires_attachment', $mcqQuestion->requires_attachment)) checked @endif>
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
                                               @if(old('is_active', $mcqQuestion->is_active)) checked @endif>
                                        <label class="form-check-label" for="is_active">
                                            Question is active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" min="0"
                                           value="{{ old('sort_order', $mcqQuestion->sort_order) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.mcq-questions.index', ['category_id' => $mcqQuestion->category_id]) }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-save"></i> Update Question
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
let optionCount = {{ count($mcqQuestion->options) }};
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
            <span class="badge bg-info rounded-circle">${optionLabels[optionCount]}</span>
        </span>
        <input type="text" name="options[]" class="form-control"
               placeholder="Option ${optionLabels[optionCount]}">
        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
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
</script>
@endpush
