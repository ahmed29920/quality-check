@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h6>Add Product</h6>
            </div>
            <div class="card-body">
                <form id="productWizardForm" action="{{ route('admin.products.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="productWizard">
                        <ul class="nav">
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-1">Basic Info</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-2">Pricing & Stock</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-3">Images</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-4">Category</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-5">Attributes</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-6">Related Products</a></li>
                            <li class="btn mx-1 nav-item"><a class="nav-link" href="#step-7">SEO</a></li>

                        </ul>
                        <div class="tab-content">
                            <!-- Step 1: Basic Info -->
                            <div id="step-1" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Name (EN) <span class="text-danger">*</span></label>
                                        <input type="text" name="name[en]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Name (AR) <span class="text-danger">*</span></label>
                                        <input type="text" name="name[ar]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Slug <span class="text-danger">*</span></label>
                                        <input type="text" name="slug" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>SKU <span class="text-danger">*</span></label>
                                        <input type="text" name="sku" class="form-control" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Short Description (EN)</label>
                                    <textarea name="short_description[en]" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Short Description (AR)</label>
                                    <textarea name="short_description[ar]" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Description (EN)</label>
                                    <textarea name="description[en]" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Description (AR)</label>
                                    <textarea name="description[ar]" class="form-control"></textarea>
                                </div>
                            </div>

                            <!-- Step 2: Pricing & Stock -->
                            <div id="step-2" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" value="1">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Discount</label>
                                        <input type="number" name="discount" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" name="manage_stock"
                                                id="manage_stock" value="1" checked>
                                            <label class="form-check-label" for="manage_stock">Manage Stock</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Stock</label>
                                        <input type="number" id="stock" name="stock" class="form-control"
                                            value="1">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" class="form-check-input" name="is_active"
                                                value="1" id="is_active">
                                            <label for="is_active" class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" class="form-check-input" name="is_featured"
                                                value="1" id="is_featured">
                                            <label for="is_featured" class="form-check-label">Featured</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" class="form-check-input" name="is_new"
                                                value="1" id="is_new">
                                            <label for="is_new" class="form-check-label">New</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Images -->
                            <div id="step-3" class="tab-pane" role="tabpanel">
                                <div class="box p-4 rounded shadow bg-white dark:bg-gray-900 p-4">

                                    <div class="mb-4 flex justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-white">Images</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-300">Recommended resolution:
                                                560px X 609px</p>
                                        </div>
                                    </div>

                                    <div class="grid gap-2">
                                        <div class="d-flex flex-wrap gap-2">
                                            <!-- Image Upload Label -->
                                            <label
                                                class="flex flex-col items-center justify-center cursor-pointer  border border-dashed rounded text-center p-5"
                                                style="border-style: dashed" for="imageInput">
                                                <span class="text-2xl">📷</span>
                                                <p class="text-xs text-center">Add Image<br>png, jpeg, jpg</p>
                                                <input type="file" id="imageInput" name="images[]"
                                                    class="hidden d-none" accept="image/*" multiple>
                                            </label>

                                            <!-- Preview Container -->
                                            <div id="imagesPreview" class="d-flex flex-wrap gap-2"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- Step 4: Category -->
                            <div id="step-4" class="tab-pane" role="tabpanel">
                                <label class="form-label">Category</label>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    @php
                                        $renderRadios = function ($categories, $prefix = '', $selected = null) use (
                                            &$renderRadios,
                                        ) {
                                            foreach ($categories as $cat) {
                                                echo '<div class="form-check">';
                                                echo '<input class="form-check-input" type="radio" name="category_id" value="' .
                                                    $cat['id'] .
                                                    '" ' .
                                                    ($selected == $cat['id'] ? 'checked' : '') .
                                                    '>';
                                                echo '<label class="form-check-label">' .
                                                    $prefix .
                                                    ($cat['name']['en'] ?? 'No Name') .
                                                    '</label>';
                                                echo '</div>';
                                                if (!empty($cat['children'])) {
                                                    echo '<div class="ms-4">';
                                                    $renderRadios($cat['children'], $prefix . '— ', $selected);
                                                    echo '</div>';
                                                }
                                            }
                                        };
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category_id" value=""
                                            checked>
                                        <label class="form-check-label">-- None --</label>
                                    </div>
                                    {!! $renderRadios($categories) !!}
                                </div>
                            </div>

                            <!-- Step 5: Attributes -->
                            <div id="step-5" class="tab-pane" role="tabpanel">
                                <h6>Select Attributes</h6>
                                <div class="row">
                                    @foreach ($attributes as $attribute)
                                        <div class="col-md-4 mb-3">
                                            <label>{{ $attribute->getTranslation('name', 'en') }}
                                                @if ($attribute->is_required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>

                                            @if ($attribute->options->count() > 0)
                                                <select name="attributes[{{ $loop->index }}][attribute_id]"
                                                    class="d-none">
                                                    <option value="{{ $attribute->id }}" selected></option>
                                                </select>
                                                <select name="attributes[{{ $loop->index }}][attribute_option_id]"
                                                    class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($attribute->options as $option)
                                                        <option value="{{ $option->id }}">{{ $option->value }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="hidden" name="attributes[{{ $loop->index }}][attribute_id]"
                                                    value="{{ $attribute->id }}">
                                                <input type="text" name="attributes[{{ $loop->index }}][value]"
                                                    class="form-control" placeholder="Enter value">
                                            @endif
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <!-- Step 6: Related Products -->
                            <div id="step-6" class="tab-pane" role="tabpanel">
                                <h6>Select Related Products</h6>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="offcanvas"
                                        data-bs-target="#relatedProductsCanvas">
                                        Add Related Products
                                    </button>
                                    <div id="relatedProductsWrapper" style="display: none;">
                                        <table class="table" id="finalSelectedRelatedProductsTable">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                                <h6>Select Cross Sell Products</h6>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="offcanvas"
                                        data-bs-target="#crossSellProductsCanvas">
                                        Add Cross Sell Products
                                    </button>
                                    <div id="crossSellProductsWrapper" style="display: none;">
                                        <table class="table" id="finalSelectedCrossSellProductsTable">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>SKU</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 7: SEO -->
                            <div id="step-7" class="tab-pane" role="tabpanel">
                                <h6>SEO Fields</h6>
                                <div class="mb-3">
                                    <label>Meta Title (EN)</label>
                                    <input type="text" name="meta_title[en]" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Meta Title (AR)</label>
                                    <input type="text" name="meta_title[ar]" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Meta Description (EN)</label>
                                    <textarea name="meta_description[en]" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Meta Description (AR)</label>
                                    <textarea name="meta_description[ar]" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Meta Keywords (EN)</label>
                                    <input type="text" name="meta_keywords[en]" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Meta Keywords (AR)</label>
                                    <input type="text" name="meta_keywords[ar]" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-purple mt-3">Save Product</button>
                </form>
            </div>
        </div>
        {{-- related products offcanvas --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="relatedProductsCanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Select Related Products</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">

                <!-- Search -->
                <input type="text" id="relatedProductSearch" class="form-control mb-3"
                    placeholder="Search products...">

                <!-- Results -->
                <div id="relatedProductResults" style="max-height: 400px; overflow-y: auto;"></div>

                <!-- Selected -->
                <h6 class="mt-3">Selected Products:</h6>
                <div id="selectedRelatedProducts" class="d-flex flex-wrap gap-2"></div>
            </div>
        </div>
        {{-- cross sell products offcanvas --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="crossSellProductsCanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Select Cross Sell Products</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">

                <!-- Search -->
                <input type="text" id="crossSellProductSearch" class="form-control mb-3"
                    placeholder="Search products...">

                <!-- Results -->
                <div id="crossSellProductResults" style="max-height: 400px; overflow-y: auto;"></div>

                <!-- Selected -->
                <h6 class="mt-3">Selected Products:</h6>
                <div id="selectedCrossSellProducts" class="d-flex flex-wrap gap-2"></div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard.min.css" rel="stylesheet">

    <script>
        // Initialize wizard, Image preview, Generate slug
        $(document).ready(function() {

            // Initialize wizard
            $('#productWizard').smartWizard({
                theme: 'dots',
                autoAdjustHeight: true,
                backButtonSupport: true,
                transition: {
                    animation: 'fade'
                }
            });
            $('#productWizard').on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
                $('#productWizard .tab-content').css('height', 'auto');
            });


            // Image preview
            const imageInput = document.getElementById('imageInput');
            const imagesPreview = document.getElementById('imagesPreview');

            imageInput.addEventListener('change', function() {
                imagesPreview.innerHTML = ''; // clear previous previews
                const files = Array.from(this.files);

                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className =
                            'relative border border-gray-300 rounded overflow-hidden position-relative text-center align-content-center';
                        div.style.width = '180px';
                        div.style.height = '180px';
                        div.style.position = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="object-cover w-full h-full" style="width:100%;height:100%">
                                <button type="button" class="position-absolute right-0 text-white bg-danger btn  rounded-full p-0 text-sm remove-btn"
                                style="position: absolute;top:0;right: 0;width: 25px;height: 25px;border-radius: 50%;align-content: center;padding: 0;">x</button>
                            `;
                        imagesPreview.appendChild(div);

                        // Remove button
                        div.querySelector('.remove-btn').addEventListener('click', function() {
                            div.remove();
                        });
                    }
                    reader.readAsDataURL(file);
                });
            });

            // Generate slug
            const nameInput = document.querySelector('input[name="name[en]"]');
            const slugInput = document.querySelector('input[name="slug"]');
            nameInput.addEventListener('input', function() {
                let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                slugInput.value = slug;
            });
        });
        $(document).ready(function () {
            // State objects
            let selectedRelatedProducts = {};
            let selectedCrossSellProducts = {};

            // === Generic Search Handler ===
            function handleSearch(inputSelector, resultsSelector, selectedProducts, checkboxClass, addBtnId) {
                $(inputSelector).on('input', function () {
                    let query = $(this).val();

                    if (query.length < 2) {
                        $(resultsSelector).html('<p class="text-muted">Type at least 2 chars...</p>');
                        return;
                    }

                    $.get("{{ route('admin.products.search') }}", { q: query }, function (res) {
                        let html = '';
                        res.forEach(product => {
                            let isChecked = selectedProducts[product.id] ? 'checked' : '';

                            html += `
                                <div class="d-flex align-items-center border-bottom py-2 gap-3">
                                    <input type="checkbox" class="form-check-input ${checkboxClass} border"
                                        data-id="${product.id}"
                                        data-name="${product.name}"
                                        data-sku="${product.sku}"
                                        data-price="${product.price}"
                                        data-image="${product.image}"
                                        ${isChecked}>

                                    <img src="${product.image}" alt="${product.name}" width="50" height="50" class="rounded">

                                    <div class="flex-grow-1">
                                        <strong>${product.name}</strong><br>
                                        <small>SKU: ${product.sku} | Price: ${product.price}</small>
                                    </div>
                                </div>
                            `;
                        });

                        html += `<div class="mt-3">
                                    <button type="button" class="btn btn-success btn-sm" id="${addBtnId}">Add Selected</button>
                                </div>`;

                        $(resultsSelector).html(html);
                    });
                });
            }

            // === Related Products ===
            handleSearch('#relatedProductSearch', '#relatedProductResults', selectedRelatedProducts, 'product-checkbox-related', 'addSelectedRelatedProducts');

            $(document).on('click', '#addSelectedRelatedProducts', function () {
                $('.product-checkbox-related:checked').each(function () {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let sku = $(this).data('sku');
                    let price = $(this).data('price');
                    let image = $(this).data('image');

                    if (!selectedRelatedProducts[id]) {
                        selectedRelatedProducts[id] = { name, sku, price, image };

                        $('#finalSelectedRelatedProductsTable tbody').append(`
                            <tr id="related-${id}">
                                <td><img src="${image}" alt="${name}" width="50" height="50" class="rounded"></td>
                                <td>${name}</td>
                                <td>${sku}</td>
                                <td>${price}</td>
                                <td>
                                    <input type="hidden" name="related_products[]" value="${id}">
                                    <button type="button" class="btn btn-sm btn-danger remove-related" data-id="${id}">Remove</button>
                                </td>
                            </tr>
                        `);
                        $('#relatedProductsWrapper').show();
                    }
                });

                $('#relatedProductSearch').val('');
                $('#relatedProductResults').html('');
            });

            $(document).on('click', '.remove-related', function () {
                let id = $(this).data('id');
                delete selectedRelatedProducts[id];
                $(`#related-${id}`).remove();
            });

            // === Cross Sell Products ===
            handleSearch('#crossSellProductSearch', '#crossSellProductResults', selectedCrossSellProducts, 'product-checkbox-cross', 'addSelectedCrossSellProducts');

            $(document).on('click', '#addSelectedCrossSellProducts', function () {
                $('.product-checkbox-cross:checked').each(function () {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let sku = $(this).data('sku');
                    let price = $(this).data('price');
                    let image = $(this).data('image');

                    if (!selectedCrossSellProducts[id]) {
                        selectedCrossSellProducts[id] = { name, sku, price, image };

                        $('#finalSelectedCrossSellProductsTable tbody').append(`
                            <tr id="cross-${id}">
                                <td><img src="${image}" alt="${name}" width="50" height="50" class="rounded"></td>
                                <td>${name}</td>
                                <td>${sku}</td>
                                <td>${price}</td>
                                <td>
                                    <input type="hidden" name="cross_sell_products[]" value="${id}">
                                    <button type="button" class="btn btn-sm btn-danger remove-cross" data-id="${id}">Remove</button>
                                </td>
                            </tr>
                        `);
                        $('#crossSellProductsWrapper').show();

                    }
                });

                $('#crossSellProductSearch').val('');
                $('#crossSellProductResults').html('');
            });

            $(document).on('click', '.remove-cross', function () {
                let id = $(this).data('id');
                delete selectedCrossSellProducts[id];
                $(`#cross-${id}`).remove();
            });
        });

        // Manage Stock
        document.getElementById('manage_stock').addEventListener('change', function() {
            let stockInput = document.getElementById('stock');
            if (this.checked) {
                stockInput.disabled = false;
                if (stockInput.value == 0) {
                    stockInput.value = 1; // default
                }
            } else {
                stockInput.disabled = true;
                stockInput.value = 0;
            }
        });
    </script>
@endpush
