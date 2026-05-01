/**
 * Survey List Manager
 * Handles DataTables initialization, filtering, and statistics
 */
class SurveyListManager {
    constructor(options) {
        this.options = options;
        this.table = null;
        this.statusBadges = {
            'DRAFT': { class: 'bg-secondary', icon: 'ti-file', label: 'Draft' },
            'SCHEDULED': { class: 'bg-info', icon: 'ti-calendar', label: 'Scheduled' },
            'IN_PROGRESS': { class: 'bg-warning', icon: 'ti-progress', label: 'In Progress' },
            'SCORING': { class: 'bg-primary', icon: 'ti-calculator', label: 'Scoring' },
            'PENDING_APPROVAL': { class: 'bg-info', icon: 'ti-hourglass', label: 'Pending Approval' },
            'APPROVED': { class: 'bg-success', icon: 'ti-check', label: 'Approved' },
            'COMPLETED': { class: 'bg-success', icon: 'ti-check-circle', label: 'Completed' },
            'REJECTED': { class: 'bg-danger', icon: 'ti-x', label: 'Rejected' },
            'SKIPPED': { class: 'bg-dark', icon: 'ti-player-skip-forward', label: 'Skipped' }
        };
    }

    init() {
        this.initDataTable();
        this.initFilters();
        this.loadStatistics();
    }

    initDataTable() {
        const self = this;

        this.table = $(this.options.tableSelector).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: window.location.href,
                data: function (d) {
                    d.status = $(self.options.filterSelector).val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '5%'
                },
                {
                    data: 'project_name',
                    name: 'project.project_name',
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">${data}</h6>
                                    <small class="text-muted">${row.project_code || ''}</small>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        return self.renderStatusBadge(data);
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return self.renderProgressBar(row);
                    }
                },
                {
                    data: 'scheduled_at',
                    name: 'scheduled_at',
                    render: function (data) {
                        if (!data) return '-';
                        const date = new Date(data);
                        const options = { day: '2-digit', month: 'short', year: 'numeric' };
                        return date.toLocaleDateString('en-GB', options);
                    }
                },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function (data) {
                        if (!data) return '-';
                        const color = data >= 90 ? 'success' : data >= 70 ? 'warning' : 'danger';
                        return `<span class="badge bg-${color}">${parseFloat(data).toFixed(1)}</span>`;
                    }
                },
                {
                    data: 'is_feasible',
                    name: 'is_feasible',
                    render: function (data, type, row) {
                        if (row.total_score === null) return '-';
                        return data
                            ? '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Feasible</span>'
                            : '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Not Feasible</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return self.renderActionButtons(row);
                    }
                }
            ],
            order: [[4, 'desc']], // Sort by scheduled_at
            pageLength: 15,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            drawCallback: function () {
                self.loadStatistics();
            }
        });
    }

    renderStatusBadge(status) {
        const badge = this.statusBadges[status] || { class: 'bg-secondary', icon: 'ti-help', label: status };
        return `
            <span class="badge ${badge.class}">
                <i class="ti ${badge.icon} me-1"></i>${badge.label}
            </span>
        `;
    }

    renderProgressBar(row) {
        const statusSteps = {
            'DRAFT': 1,
            'SCHEDULED': 2,
            'IN_PROGRESS': 3,
            'SCORING': 4,
            'PENDING_APPROVAL': 5,
            'APPROVED': 6,
            'COMPLETED': 7,
            'REJECTED': 0,
            'SKIPPED': 0
        };

        const currentStep = statusSteps[row.status] || 0;
        const totalSteps = 7;
        const percentage = currentStep > 0 ? Math.round((currentStep / totalSteps) * 100) : 0;

        const progressClass = percentage >= 80 ? 'bg-success' : percentage >= 50 ? 'bg-warning' : 'bg-info';

        return `
            <div class="progress" style="height: 8px;">
                <div class="progress-bar ${progressClass}" role="progressbar" 
                     style="width: ${percentage}%" 
                     aria-valuenow="${percentage}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
            <small class="text-muted">${percentage}%</small>
        `;
    }

    renderActionButtons(row) {
        let buttons = `
            <a href="/project-survey/${row.uid}" 
               class="btn btn-sm btn-info me-1" 
               title="View Details">
                <i class="ti ti-eye"></i>
            </a>
        `;

        // Print PDF button - show only when survey is completed
        if (row.status === 'COMPLETED') {
            buttons += `
                <a href="/project-survey/${row.uid}/report/pdf" 
                   class="btn btn-sm btn-danger me-1" 
                   title="Print Survey Report PDF"
                   target="_blank">
                    <i class="ti ti-file-type-pdf"></i>
                </a>
            `;
        }

        // Add conditional action buttons based on status
        if (row.status === 'DRAFT') {
            buttons += `
                <button class="btn btn-sm btn-primary me-1" 
                        onclick="surveyActions.schedule('${row.uid}')"
                        title="Schedule Survey">
                    <i class="ti ti-calendar-event"></i>
                </button>
            `;
        }

        if (['IN_PROGRESS', 'SCORING'].includes(row.status)) {
            buttons += `
                <button class="btn btn-sm btn-success me-1" 
                        onclick="surveyActions.submitScore('${row.uid}')"
                        title="Submit Score">
                    <i class="ti ti-calculator"></i>
                </button>
            `;
        }

        return buttons;
    }

    initFilters() {
        const self = this;

        $(this.options.filterSelector).on('change', function () {
            self.table.ajax.reload();
        });
    }

    loadStatistics() {
        const self = this;

        $.ajax({
            url: '/api/v1/surveys/stats/dashboard',
            method: 'GET',
            success: function (data) {
                $(self.options.statsSelectors.total).text(data.total || 0);
                $(self.options.statsSelectors.progress).text(data.in_progress || 0);
                $(self.options.statsSelectors.feasible).text(data.feasible || 0);
                $(self.options.statsSelectors.pending).text(data.pending_approval || 0);
            },
            error: function () {
                // Silently fail - stats are not critical
            }
        });
    }
}

/**
 * Survey Actions
 * Handles user actions on surveys
 */
const surveyActions = {
    schedule: function (uid) {
        window.location.href = `/project-survey/${uid}?action=schedule`;
    },

    submitScore: function (uid) {
        window.location.href = `/project-survey/${uid}?action=score`;
    }
};
