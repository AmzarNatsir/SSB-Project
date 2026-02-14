<?php $page = 'projects'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Project Header -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2">{{ $project->project_name }}</h2>
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted">Lokasi Proyek</span>
                                <span class="fw-semibold">: {{ $project->category->name ?? '-' }}</span>
                                
                                <span class="text-muted ms-4">Waktu Pelaksanaan</span>
                                <span class="fw-semibold">: {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <span class="text-muted">Waktu Berjalan</span>
                                <span class="fw-semibold">: {{ $project->duration_of_work ?? 0 }} Hari</span>
                                
                                <span class="text-muted ms-4">Sisa Waktu</span>
                                <span class="fw-semibold">: {{ $project->end_date ? \Carbon\Carbon::now()->diffInDays($project->end_date, false) : 0 }} Hari</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('projects.index') }}" class="btn btn-light">
                                <i class="ti ti-arrow-left me-1"></i> Back to List
                            </a>
                            @if($project->project_status === 'NOT STARTED')
                                <a href="javascript:void(0);" class="btn btn-warning edit-project-btn" data-id="{{ $project->uid }}">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs-modern mb-4" id="projectTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="ti ti-info-circle me-1"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                                <i class="ti ti-file-text me-1"></i> Project Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="client-tab" data-bs-toggle="tab" data-bs-target="#client" type="button" role="tab">
                                <i class="ti ti-user me-1"></i> Client Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                                <i class="ti ti-photo me-1"></i> Images
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="projectTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Number</label>
                                        <p class="fw-semibold">{{ $project->project_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Code</label>
                                        <p class="fw-semibold">{{ $project->project_code }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Category</label>
                                        <p class="fw-semibold">{{ $project->category->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Sub Category</label>
                                        <p class="fw-semibold">{{ $project->subCategory->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Status</label>
                                        <div>
                                            @php
                                                $statusConfig = [
                                                    'NOT STARTED' => ['color' => 'bg-purple', 'text' => 'Plan'],
                                                    'ON PROGRESS' => ['color' => 'bg-info', 'text' => 'Survey'],
                                                    'COMPLETED' => ['color' => 'bg-success', 'text' => 'Completed'],
                                                    'ON HOLD' => ['color' => 'bg-warning', 'text' => 'On Hold'],
                                                    'CANCELLED' => ['color' => 'bg-danger', 'text' => 'Cancelled'],
                                                ];
                                                $config = $statusConfig[$project->project_status] ?? ['color' => 'bg-secondary', 'text' => $project->project_status];
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 80px; height: 6px;">
                                                    <div class="progress-bar {{ $config['color'] }}" role="progressbar" style="width: 100%"></div>
                                                </div>
                                                <span>{{ $config['text'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Value</label>
                                        <p class="fw-semibold text-success">Rp {{ number_format($project->project_value, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Description</label>
                                        <p>{{ $project->description ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Details Tab -->
                        <div class="tab-pane fade" id="details" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Request Date</label>
                                        <p class="fw-semibold">{{ $project->request_date ? $project->request_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Start Date</label>
                                        <p class="fw-semibold">{{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">End Date</label>
                                        <p class="fw-semibold">{{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Duration</label>
                                        <p class="fw-semibold">{{ $project->duration_of_work ?? 0 }} Days</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Location</label>
                                        <p class="fw-semibold">{{ $project->project_location ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Coordinates</label>
                                        <p class="fw-semibold">{{ $project->project_coordinates ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Job Type</label>
                                        <p class="fw-semibold">{{ $project->job_type ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">PIC</label>
                                        <p class="fw-semibold">{{ $project->pic->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Equipment Rental Rate</label>
                                        <p class="fw-semibold">{{ $project->equipmentRentalRate->jenis_alat ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Bank Account</label>
                                        <p class="fw-semibold">{{ $project->bank_account ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Scope of Work</label>
                                        <p>{{ $project->scope_of_work ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client Information Tab -->
                        <div class="tab-pane fade" id="client" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">User Name</label>
                                        <p class="fw-semibold">{{ $project->user_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">User Code</label>
                                        <p class="fw-semibold">{{ $project->user_code ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Email</label>
                                        <p class="fw-semibold">{{ $project->email ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Phone Number</label>
                                        <p class="fw-semibold">{{ $project->phone_number ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Taxpayer ID</label>
                                        <p class="fw-semibold">{{ $project->taxpayer_id ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Address</label>
                                        <p>{{ $project->user_address ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images Tab -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <!-- Breadcrumb -->
                            <div class="mb-3">
                                <h5 class="mb-2">File Uploads</h5>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">File Uploads</li>
                                    </ol>
                                </nav>
                            </div>

                            <!-- Dropzone Upload Section -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Dropzone File Upload</h6>
                                    <p class="text-muted small mb-3">DropzoneJS is an open source library that provides drag'n'drop file uploads with image previews.</p>
                                    
                                    <form action="{{ route('projects.upload-image', $project->uid) }}" 
                                          class="dropzone" 
                                          id="projectImageDropzone">
                                        @csrf
                                        <div class="dz-message text-center">
                                            <i class="ti ti-cloud-upload" style="font-size: 48px; color: #6c757d;"></i>
                                            <h5 class="mt-3">Drop files here or click to upload.</h5>
                                            <p class="text-muted">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Image Gallery -->
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Uploaded Images</h6>
                                    <div class="row" id="imageGallery">
                                        @forelse($project->images as $image)
                                            <div class="col-md-4 col-lg-3 mb-3" id="image-{{ $image->uid }}">
                                                <div class="card h-100 shadow-sm border-0">
                                                    <a href="{{ url('storage/' . $image->file_path) }}" 
                                                       data-fancybox="gallery" 
                                                       data-type="image"
                                                       data-caption="{{ $image->description ?? $image->file_image }}">
                                                        <img src="{{ url('storage/' . $image->file_path) }}" 
                                                             class="card-img-top rounded" 
                                                             alt="{{ $image->file_image }}"
                                                             style="height: 200px; object-fit: cover; cursor: pointer;">
                                                    </a>
                                                    <div class="card-body p-2">
                                                        <p class="card-text small text-truncate mb-2" title="{{ $image->description ?? $image->file_image }}">
                                                            {{ $image->description ?? $image->file_image }}
                                                        </p>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger delete-image-btn w-100" 
                                                                data-id="{{ $image->uid }}">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center py-5" id="noImagesMessage">
                                                <i class="ti ti-photo" style="font-size: 64px; color: #ccc;"></i>
                                                <p class="text-muted mt-3">No images uploaded yet</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            background: #ffffff;
            min-height: 250px;
            padding: 40px;
            transition: all 0.3s ease;
        }
        .dropzone:hover {
            border-color: #0087F7;
            background: #f8f9fa;
        }
        .dropzone .dz-message {
            margin: 0;
        }
        .dropzone .dz-message h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }
        .dropzone .dz-message p {
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        /* Image gallery hover effect */
        .card img {
            transition: transform 0.3s ease;
        }
        .card a:hover img {
            transform: scale(1.05);
        }

        /* Modern Tabs Style */
        .nav-tabs-modern {
            display: inline-flex;
            background-color: #f4f7fb;
            padding: 6px;
            border-radius: 12px;
            border: none;
            gap: 4px;
        }

        .nav-tabs-modern .nav-item {
            margin-bottom: 0;
            border: none;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            color: #64748b;
            font-weight: 500;
            font-size: 14px;
            background: transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .nav-tabs-modern .nav-link i {
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .nav-tabs-modern .nav-link:hover {
            color: #1e293b;
            background-color: rgba(0, 0, 0, 0.03);
        }

        .nav-tabs-modern .nav-link:hover i {
            transform: translateY(-1px);
        }

        .nav-tabs-modern .nav-link.active {
            background-color: #ffffff;
            color: #ff3b3b; /* Using theme red or primary */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: none !important;
        }

        .nav-tabs-modern .nav-link.active i {
            color: #ff3b3b;
        }

        /* Adjusting for theme primary if available */
        :root {
            --primary-color: #ff3b3b;
        }

        .nav-tabs-modern .nav-link.active {
            color: var(--primary-color);
        }
        .nav-tabs-modern .nav-link.active i {
            color: var(--primary-color);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            // Fancybox initialization
            Fancybox.bind("[data-fancybox='gallery']", {
                Images: {
                    type: "image",
                },
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["slideshow", "thumbs", "close"],
                    },
                },
            });

            // Initialize Dropzone
            var myDropzone = new Dropzone("#projectImageDropzone", {
                paramName: "file",
                maxFilesize: 5, // MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "Drop images here or click to upload",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    if (response.success) {
                        $('#noImagesMessage').remove();
                        var imageHtml = `
                            <div class="col-md-4 col-lg-3 mb-3" id="image-${response.image.uid}">
                                <div class="card h-100 shadow-sm border-0">
                                    <a href="${response.url}" 
                                       data-fancybox="gallery" 
                                       data-type="image"
                                       data-caption="${response.image.file_image}">
                                        <img src="${response.url}" 
                                             class="card-img-top rounded" 
                                             alt="${response.image.file_image}"
                                             style="height: 200px; object-fit: cover; cursor: pointer;">
                                    </a>
                                    <div class="card-body p-2">
                                        <p class="card-text small text-truncate mb-2" title="${response.image.file_image}">
                                            ${response.image.file_image}
                                        </p>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-image-btn w-100" 
                                                data-id="${response.image.uid}">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#imageGallery').append(imageHtml);
                        myDropzone.removeFile(file);
                    }
                },
                error: function(file, response) {
                    alert('Error uploading image: ' + (response.message || 'Unknown error'));
                    myDropzone.removeFile(file);
                }
            });

            // Delete image
            $('body').on('click', '.delete-image-btn', function() {
                var imageId = $(this).data('id');
                
                if (typeof Swal === 'undefined') {
                    if (confirm('Are you sure you want to delete this image?')) {
                        performDelete(imageId);
                    }
                    return;
                }

                Swal.fire({
                    title: "Delete this image?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: "btn btn-primary me-2",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDelete(imageId);
                    }
                });
            });

            function performDelete(imageId) {
                $.ajax({
                    url: '/project-images/' + imageId,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#image-' + imageId).fadeOut(300, function() {
                            $(this).remove();
                            if ($('#imageGallery .col-md-4').length === 0 && $('#imageGallery .col-lg-3').length === 0) {
                                $('#imageGallery').html(`
                                    <div class="col-12 text-center py-5" id="noImagesMessage">
                                        <i class="ti ti-photo" style="font-size: 64px; color: #ccc;"></i>
                                        <p class="text-muted mt-3">No images uploaded yet</p>
                                    </div>
                                `);
                            }
                        });
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Failed to delete image.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var res = JSON.parse(xhr.responseText);
                                if (res.message) errorMessage = res.message;
                            } catch(e) {}
                        }
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        } else {
                            alert(errorMessage);
                        }
                    }
                });
            }
        });
    </script>
    @endpush

@endsection
