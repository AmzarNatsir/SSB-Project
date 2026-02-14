$(document).ready(function () {

    if($('#permission_list').length > 0) {
		$('#permission_list').DataTable({
			"bFilter": false, 
				"bInfo": false,
					"ordering": true,
				"autoWidth": true,
				"language": {
					search: ' ',
					sLengthMenu: '_MENU_',
					searchPlaceholder: "Search",
					info: "_START_ - _END_ of _TOTAL_ items",
					"lengthMenu":     "Show _MENU_ entries",
					paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
					},
				initComplete: (settings, json)=>{
					$('.dataTables_paginate').appendTo('.datatable-paginate');
					$('.dataTables_length').appendTo('.datatable-length');
				},  
				"data":[
					{
						"id" : 1,
						"si_no" : "",
						"module" : "Dashboard",
						"sub_module" : "Dashboard",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"module" : "Contacts",
						"sub_module" : "Contacts",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"module" : "Companies",
						"sub_module" : "Companies",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"module" : "Leads",
						"sub_module" : "Leads",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"module" : "Deals",
						"sub_module" : "Deals",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"module" : "Pipelines",
						"sub_module" : "Pipelines",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"module" : "Compaign",
						"sub_module" : "Compaign",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"module" : "Projects",
						"sub_module" : "Projects",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"module" : "Tasks",
						"sub_module" : "Tasks",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					},
					{
						"id" : 10,
						"si_no" : "",
						"module" : "Activity",
						"sub_module" : "Activity",
						"create" : "",
						"edit" : "",
						"view" : "",
						"delete" : "",
						"allow" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "module" },
				{ "data": "sub_module" },
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}}
			]
		});
	}

});