/**
 * Survey Detail Manager
 * Handles survey detail page interactions and form validations
 */
class SurveyDetailManager {
    constructor(options) {
        this.options = options;
        this.surveyUid = options.surveyUid;
        this.currentStatus = options.currentStatus;
    }

    init() {
        this.initFormValidations();
        this.initAutoRefresh();
        this.initTooltips();
    }

    initFormValidations() {
        // Schedule Form Validation
        const scheduleForm = document.getElementById('scheduleForm');
        if (scheduleForm) {
            scheduleForm.addEventListener('submit', (e) => {
                if (!this.validateScheduleForm()) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        // Score Form Validation
        const scoreForm = document.getElementById('scoreForm');
        if (scoreForm) {
            scoreForm.addEventListener('submit', (e) => {
                if (!this.validateScoreForm()) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        // Approval Form Validation
        const approvalForm = document.getElementById('approvalForm');
        if (approvalForm) {
            approvalForm.addEventListener('submit', (e) => {
                if (!this.validateApprovalForm()) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    }

    validateScheduleForm() {
        const dateInput = document.querySelector('[name="scheduled_date"]');
        const timeInput = document.querySelector('[name="scheduled_time"]');

        if (!dateInput.value || !timeInput.value) {
            this.showError('Please select both date and time');
            return false;
        }

        // Check if date is not in the past
        const selectedDateTime = new Date(dateInput.value + ' ' + timeInput.value);
        const now = new Date();

        if (selectedDateTime < now) {
            this.showError('Cannot schedule survey in the past');
            return false;
        }

        return true;
    }

    validateScoreForm() {
        const scoreInput = document.getElementById('scoreInput');
        const notesInput = document.querySelector('#scoreForm [name="notes"]');

        if (!scoreInput.value || scoreInput.value < 0 || scoreInput.value > 100) {
            this.showError('Score must be between 0 and 100');
            return false;
        }

        if (!notesInput.value || notesInput.value.trim().length < 10) {
            this.showError('Please provide detailed assessment notes (minimum 10 characters)');
            return false;
        }

        return true;
    }

    validateApprovalForm() {
        const statusSelect = document.getElementById('approvalStatus');
        const notesInput = document.querySelector('#approvalForm [name="notes"]');

        if (!statusSelect.value) {
            this.showError('Please select a decision');
            return false;
        }

        if (!notesInput.value || notesInput.value.trim().length < 20) {
            this.showError('Please provide detailed comments (minimum 20 characters)');
            return false;
        }

        // Confirm rejection
        if (statusSelect.value === 'REJECTED') {
            return confirm('Are you sure you want to reject this survey? This action cannot be undone.');
        }

        return true;
    }

    initAutoRefresh() {
        // Auto-refresh page if status changes (via polling)
        if (['IN_PROGRESS', 'SCORING', 'PENDING_APPROVAL'].includes(this.currentStatus)) {
            setInterval(() => {
                this.checkStatusUpdate();
            }, 30000); // Check every 30 seconds
        }
    }

    checkStatusUpdate() {
        fetch(`/api/v1/surveys/${this.surveyUid}/status`)
            .then(response => response.json())
            .then(data => {
                if (data.status !== this.currentStatus) {
                    this.showNotification('Survey status has been updated. Refreshing page...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Status check failed:', error);
            });
    }

    initTooltips() {
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    showError(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: message,
                confirmButtonColor: '#dc3545'
            });
        } else {
            alert(message);
        }
    }

    showNotification(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Update',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }
}

/**
 * View score details
 */
function viewScoreDetails(scoreId) {
    // Implement score details modal
    console.log('View score details:', scoreId);
}

/**
 * Proceed to execution
 */
function proceedToExecution() {
    if (confirm('Proceed to project execution phase?')) {
        // Implement navigation to project execution
        window.location.href = '/projects/execution';
    }
}
