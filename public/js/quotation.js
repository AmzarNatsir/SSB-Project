$(document).ready(function () {

    // ==========================================
    // Wizard Navigation
    // ==========================================
    $('.nexttab').click(function () {
        var nextId = $(this).data('nexttab');
        var nextTab = new bootstrap.Tab(document.querySelector('#' + nextId));
        nextTab.show();
    });

    $('.previoustab').click(function () {
        var prevId = $(this).data('previous');
        var prevTab = new bootstrap.Tab(document.querySelector('#' + prevId));
        prevTab.show();
    });

    // ==========================================
    // Project Selection Logic
    // ==========================================
    $('#project_id').change(function () {
        var selected = $(this).find(':selected');
        var budgetId = selected.data('budget-id');
        var hpp = parseFloat(selected.data('budget-hpp')) || 0;

        $('#project_budget_id').val(budgetId);
        $('#display_hpp').text(formatCurrency(hpp));
        $('#summary_project').text(selected.text());
        $('#summary_hpp').text(formatCurrency(hpp));

        // Sim data
        $('#sim_hpp').text(formatCurrency(hpp));
        window.currentHpp = hpp;

        if (!budgetId) {
            $('#no_budget_alert').removeClass('d-none');
        } else {
            $('#no_budget_alert').addClass('d-none');
        }

        recalculateSimulation();
    });

    // ==========================================
    // Units & Pricing Logic
    // ==========================================

    // Fetch Units (Mock/Proxy)
    var unitsData = [];
    // Only fetch if endpoint exists, otherwise fallback
    $.get('/api/units').done(function (data) {
        unitsData = data;
    }).fail(function () {
        console.log('API units not reachable, using fallback');
    });

    // Add Item
    $('#add_item_btn').click(function () {
        var index = $('#items_table tbody tr').length;
        var template = $('#item_row_template').html().replace(/{index}/g, index);
        var row = $(template);

        // Populate units
        var select = row.find('.item-unit-select');
        // If API returns data, populate. If not (for now), generic options
        if (unitsData.length > 0) {
            unitsData.forEach(function (u) {
                select.append(new Option(u.name, u.name)); // Value is name for now as per schema
            });
        } else {
            // Fallback options
            select.append(new Option('Excavator PC200', 'Excavator PC200'));
            select.append(new Option('Dump Truck', 'Dump Truck'));
            select.append(new Option('Manpower', 'Manpower'));
        }

        $('#items_table tbody').append(row);
    });

    // Remove Item
    $(document).on('click', '.remove-item', function () {
        $(this).closest('tr').remove();
        calculateGrandTotal();
    });

    // Calculation Events
    $(document).on('input change', '.item-rate, .item-qty, .item-duration', function () {
        var row = $(this).closest('tr');
        calculateRow(row);
        calculateGrandTotal();
    });

    $(document).on('change', '.item-unit-select', function () {
        // Logic to maybe fetch default rate for unit?
        // Not required by prompt but good UX
    });

    function calculateRow(row) {
        var rate = parseFloat(row.find('.item-rate').val()) || 0;
        var qty = parseFloat(row.find('.item-qty').val()) || 0;
        var dur = parseFloat(row.find('.item-duration').val()) || 0;

        var total = rate * qty * dur;
        row.find('.item-total').text(formatCurrency(total));
        row.data('total', total);
    }

    function calculateGrandTotal() {
        var total = 0;
        $('#items_table tbody tr').each(function () {
            total += ($(this).data('total') || 0);
        });

        $('#total_project_value_display').text(formatCurrency(total));

        // Update Simulation & Summary
        $('#analysis_item_total').text(formatCurrency(total));
        $('#analysis_item_total').data('value', total);

        // Default: If no margin override, Selling Price = Project Value
        recalculateSimulation();
    }

    // ==========================================
    // Profit Planning Logic
    // ==========================================
    $('#profit_margin_percent').on('input', function () {
        recalculateSimulation();
    });

    function recalculateSimulation() {
        var hpp = window.currentHpp || 0;
        var margin = parseFloat($('#profit_margin_percent').val()) || 0;
        var projectValue = parseFloat($('#analysis_item_total').data('value')) || 0;

        $('#margin_display').text(margin + '%');
        $('#summary_margin').text(margin + '%');

        // Formula per requirements: 
        // SELLING_PRICE = QUOTATION_PRICE × (1 + profit_margin%)
        // QUOTATION_PRICE = HPP

        // If HPP is 0 (no budget), this formula yields 0, which might be wrong if we have items.
        // Let's assume if HPP > 0:
        var targetSellingPrice = 0;
        if (hpp > 0) {
            targetSellingPrice = hpp * (1 + (margin / 100));
        } else {
            // Fallback: If no HPP, maybe Margin is on top of Project Value? 
            // Or just treat Project Value as Selling Price
            targetSellingPrice = projectValue;
        }

        var targetProfit = targetSellingPrice - hpp;

        $('#sim_selling').text(formatCurrency(targetSellingPrice));
        $('#sim_profit').text(formatCurrency(targetProfit));

        $('#analysis_target_total').text(formatCurrency(targetSellingPrice));

        // Comparison
        var diff = projectValue - targetSellingPrice;
        var statusBadge = $('#margin_status_badge');

        if (Math.abs(diff) < 1000) {
            statusBadge.removeClass().addClass('badge bg-success').text('Balanced');
            $('#summary_total').text(formatCurrency(projectValue));
        } else if (projectValue > targetSellingPrice) {
            // We are charging MORE than the target margin -> Good!
            var extra = projectValue - targetSellingPrice;
            statusBadge.removeClass().addClass('badge bg-success').text('Surplus: ' + formatCurrency(extra));
            // Summary should probably reflect the ACTUAL Project Value (Items)
            $('#summary_total').text(formatCurrency(projectValue));
        } else {
            // We are charging LESS -> Need to increase rates
            var deficit = targetSellingPrice - projectValue;
            statusBadge.removeClass().addClass('badge bg-danger').text('Deficit: ' + formatCurrency(deficit));
            $('#summary_total').text(formatCurrency(projectValue));
        }
    }

    // ==========================================
    // Helpers
    // ==========================================
    function formatCurrency(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    }

    // AJAX Submit
    $('#quotationForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');

        btn.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (response) {
                // Swal is available globally in this project
                Swal.fire('Success', response.message, 'success').then(() => {
                    if (response.redirect) window.location.href = response.redirect;
                });
            },
            error: function (xhr) {
                btn.prop('disabled', false);
                var msg = xhr.responseJSON?.message || 'Submission failed';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors)[0][0]; // First error
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });

});
