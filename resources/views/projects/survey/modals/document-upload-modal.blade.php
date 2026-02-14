<!-- Document Upload Modal -->
<div class="modal fade" id="documentUploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('project-survey.document.upload', $survey->uid) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="documentUploadForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-upload me-2"></i>Upload Survey Document
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Only PDF files are allowed. Maximum file size: 10MB
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Document Type <span class="text-danger">*</span></label>
                        <select name="document_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Berita Acara">Berita Acara</option>
                            <option value="Supporting Evidence">Supporting Evidence</option>
                            <option value="Survey Report">Survey Report</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select PDF File <span class="text-danger">*</span></label>
                        <input type="file" 
                               name="document" 
                               class="form-control" 
                               accept=".pdf"
                               required
                               id="documentFile">
                        <div class="form-text">
                            <i class="ti ti-alert-circle me-1"></i>
                            Accepted format: PDF only
                        </div>
                    </div>

                    <div id="fileInfo" class="alert alert-secondary d-none">
                        <strong>Selected File:</strong>
                        <p class="mb-0" id="fileName"></p>
                        <small class="text-muted" id="fileSize"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                        <i class="ti ti-upload me-1"></i>Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('documentFile');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const uploadBtn = document.getElementById('uploadBtn');

    fileInput?.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            
            // Show file info
            fileName.textContent = file.name;
            fileSize.textContent = `Size: ${sizeMB} MB`;
            fileInfo.classList.remove('d-none');
            
            // Validate file size
            if (file.size > 10 * 1024 * 1024) { // 10MB
                fileInfo.classList.remove('alert-secondary');
                fileInfo.classList.add('alert-danger');
                fileSize.textContent = `Size: ${sizeMB} MB - File too large! Maximum 10MB`;
                uploadBtn.disabled = true;
            } else {
                fileInfo.classList.remove('alert-danger');
                fileInfo.classList.add('alert-secondary');
                uploadBtn.disabled = false;
            }
        }
    });
});
</script>
