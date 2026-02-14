<div class="card mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="ti ti-file-text me-2"></i>Survey Documents
            </h5>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#documentUploadModal">
                <i class="ti ti-upload me-1"></i>Upload PDF
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($survey->documents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Uploaded By</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($survey->documents as $document)
                            <tr>
                                <td>
                                    <i class="ti ti-file-type-pdf text-danger me-2"></i>
                                    {{ $document->file_name }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $document->file_type }}</span>
                                </td>
                                <td>{{ $document->uploader->name ?? '-' }}</td>
                                <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('project-survey.document.download', [$survey->uid, $document->id]) }}" 
                                       class="btn btn-sm btn-success" 
                                       title="Download">
                                        <i class="ti ti-download"></i>
                                    </a>
                                    <form action="{{ route('project-survey.document.delete', [$survey->uid, $document->id]) }}" 
                                          method="POST" 
                                          id="deleteDocForm-{{ $document->id }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDeleteDocument({{ $document->id }})"
                                                title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="ti ti-file-off fs-48 text-muted mb-3 d-block"></i>
                <p class="text-muted mb-2">No documents uploaded yet</p>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#documentUploadModal">
                    <i class="ti ti-upload me-1"></i>Upload First Document
                </button>
            </div>
        @endif
    </div>
</div>
