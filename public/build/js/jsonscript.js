
$(document).ready(function () {

	// Categories List

	if($('#categorieslist').length > 0) {
		$('#categorieslist').DataTable({
			"bFilter": false,
			"bInfo": false,
			"ordering": true,
			"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				"lengthMenu": "Show _MENU_ entries",
				paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
			},
			initComplete: function(settings, json) {
				$('.dataTables_paginate').appendTo('.datatable-paginate');
				$('.dataTables_length').appendTo('.datatable-length');
			},
			"data":[
				{
					"id" : 1,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Darlee Robertson",
					"customer_image" : "build/img/profiles/avatar-19.jpg",
					"customer_no" : "Facility Manager",
					"phone" : "1234567890",
					"location_image" : "build/img/flags/us.svg",
					"location_name" : "USA",
					"tag" : "0",
					"rating" : "4.2",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 2,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Sharon Roy",
					"customer_image" : "build/img/profiles/avatar-20.jpg",
					"customer_no" : "Installer",
					"phone" : "+1 989757485",
					"location_image" : "build/img/flags/ae.svg",
					"location_name" : "UAE",
					"tag" : "2",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "1",
					"Action" : ""
				},
				{
					"id" : 3,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Vaughan Lewis",
					"customer_image" : "build/img/profiles/avatar-21.jpg",
					"customer_no" : "Senior  Manager",
					"phone" : "+1 546555455",
					"location_image" : "build/img/flags/de.svg",
					"location_name" : "Germany",
					"tag" : "0",
					"rating" : "3.5",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 4,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jessica Louise",
					"customer_image" : "build/img/profiles/avatar-23.jpg",
					"customer_no" : "Test Engineer",
					"phone" : "+1 454478787",
					"location_image" : "build/img/flags/fr.svg",
					"location_name" : "France",
					"tag" : "1",
					"rating" : "4.5",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 5,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Carol Thomas",
					"customer_image" : "build/img/profiles/avatar-16.jpg",
					"customer_no" : "UI /UX Designer",
					"phone" : "+1 124547845",
					"location_image" : "build/img/flags/india.svg",
					"location_name" : "India",
					"tag" : "0",
					"rating" : "4.7",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 6,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Dawn Mercha",
					"customer_image" : "build/img/profiles/avatar-22.jpg",
					"customer_no" : "Technician",
					"phone" : "+1 478845447",
					"location_image" : "build/img/flags/brazil.svg",
					"location_name" : "Brazil",
					"tag" : "1",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 7,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Rachel Hampton",
					"customer_image" : "build/img/profiles/avatar-24.jpg",
					"customer_no" : "Software Developer",
					"phone" : "+1 215544845",
					"location_image" : "build/img/flags/mexico.svg",
					"location_name" : "Mexico",
					"tag" : "2",
					"rating" : "3.1",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 8,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonelle Curtiss",
					"customer_image" : "build/img/profiles/avatar-25.jpg",
					"customer_no" : "Supervisor",
					"phone" : "+1 121145471",
					"location_image" : "build/img/flags/china.svg",
					"location_name" : "China",
					"tag" : "1",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 9,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonathan Smith",
					"customer_image" : "build/img/profiles/avatar-26.jpg",
					"customer_no" : "Team Lead Dev",
					"phone" : "+1 321454789",
					"location_image" : "build/img/flags/russia.svg",
					"location_name" : "Russia",
					"tag" : "0",
					"rating" : "2.7",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				}
				,
				{
					"id" : 10,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Brook Carter",
					"customer_image" : "build/img/profiles/avatar-01.jpg",
					"customer_no" : "Team Lead Dev ",
					"phone" : "+1 278907145",
					"location_image" : "build/img/flags/fr.svg",
					"location_name" : "France",
					"tag" : "2",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				}
				,
				{
					"id" : 11,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Eric Adams",
					"customer_image" : "build/img/profiles/avatar-06.jpg",
					"customer_no" : "HR Manager",
					"phone" : "+1 19023-78104",
					"location_image" : "build/img/flags/italy.svg",
					"location_name" : "Italy",
					"tag" : "3",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				}
				,
				{
					"id" : 12,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Richard Cooper",
					"customer_image" : "build/img/profiles/avatar-05.jpg",
					"customer_no" : "Devops Engineer",
					"phone" : "+1 18902-63904",
					"location_image" : "build/img/flags/canada.svg",
					"location_name" : "Canada",
					"tag" : "1",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
					"Action" : ""
				}
				
			],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="contact_details" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="contact_details" class="d-flex flex-column">' + row['customer_name'] + ' <span class="text-body fs-13 fw-normal mt-1">' + row['customer_no'] + ' </span></a></h6>';
					}
				},
				{ "data": "phone" },
				{
					"render": function (data, type, row) {
						var class_name, status_name;
						if (row['tag'] == "0") {
							class_name = "badge-soft-success";
							status_name = "Collab";
						} else if (row['tag'] == "1") {
							class_name = "badge-soft-warning";
							status_name = "VIP";
						} else if (row['tag'] == "3") {
							class_name = "badge-soft-info";
							status_name = "Premium";
						} else {
							class_name = "badge-soft-primary";
							status_name = "Promotion";
						}
						
						return '<span class="badge badge-tag ' + class_name + '" >' + status_name + '</span>';
					}
				},
				{ 
					"render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="contact_details" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['location_image'] + '" alt="User Image"></a>' + row['location_name'] + '</div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<div class="set-star"><span><i class="ti ti-star-filled text-warning"></i> ' + row['rating'] + ' </span></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<ul class="social-links d-flex align-items-center"><li><a href="#"><i class="ti ti-mail"></i></a></li><li><a href="#"><i class="ti ti-phone-check"></i></a></li><li><a href="#"><i class="ti ti-message-circle-share"></i></a></li></li><li><a href="#"><i class="ti ti-brand-facebook "></i></a></li></ul>';
					}
				},
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{
					"render": function (data, type, row) {
						return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="contact_details"><i class="ti ti-eye text-blue-light"></i> Preview</a></div></div>';
					}
				}
			]
		});
		
	}

    // Companies List

	if($('#companieslist').length > 0) {
		$('#companieslist').DataTable({
				"bFilter": false, 
				"bInfo": false,
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
						"select" : "",
						"company_name" : "NovaWave LLC",
						"company_image" : "build/img/icons/company-icon-01.svg",
						"phone" : "+1 875455453",
						"email" : "robertson@example.com",
						"location" : "Germany",
						"tag" : "0",
						"rating" : "4.2",
						"owner" : "Hendry Milner",
						"owner_image": "build/img/profiles/avatar-01.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Paid Social",
						"won_deals": "5 Deals, $100000",
						"lost_deals": "2 Deals, $80000",
						"created_date": "25 Sep 2025, 01:22 pm"
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"company_name" : "BlueSky Industries",
						"company_image" : "build/img/icons/company-icon-02.svg",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"location" : "USA",
						"tag" : "0",
						"rating" : "5.0",
						"owner" : "Guilory Berggren",
						"owner_image": "build/img/profiles/avatar-06.jpg",
						"status" : "1",
						"Action" : "",
						"source": "Referrals",
						"won_deals": "4 Deals, $120000",
						"lost_deals": "3 Deals, $90000",
						"created_date": "29 Sep 2025, 04:15 pm"
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"company_name" : "SilverHawk",
						"company_image" : "build/img/icons/company-icon-03.svg",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"location" : "Canada",
						"tag" : "0",
						"rating" : "3.5",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-13.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Campaigns",
						"won_deals": "3 Deals, $110000",
						"lost_deals": "2 Deals, $70000",
						"created_date": "04 Oct 2025, 10:18 am"
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"company_name" : "SummitPeak",
						"company_image" : "build/img/icons/company-icon-04.svg",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"location" : "India",
						"tag" : "0",
						"rating" : "4.5",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Google",
						"won_deals": "6 Deals, $200000",
						"lost_deals": "3 Deals, $100000",
						"created_date": "17 Oct 2025, 03:31 pm"
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"company_name" : "RiverStone Ventur",
						"company_image" : "build/img/icons/company-icon-05.svg",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"location" : "China",
						"tag" : "0",
						"rating" : "4.7",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Paid Social",
						"won_deals": "3 Deals, $80000",
						"lost_deals": "1 Deal, $40000",
						"created_date": "24 Oct 2025, 09:14 pm"
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"company_name" : "Bright Bridge Grp",
						"company_image" : "build/img/icons/company-icon-06.svg",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"location" : "Martin Lewis",
						"tag" : "0",
						"rating" : "5.0",
						"owner" : "Martin Lewis",
						"owner_image": "build/img/profiles/avatar-20.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Referrals",
						"won_deals": "5 Deals, $95000",
						"lost_deals": "2 Deals, $60000",
						"created_date": "08 Nov 2025, 09:56 am"
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"company_name" : "CoastalStar Co.",
						"company_image" : "build/img/icons/company-icon-07.svg",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"location" : "Indonesia",
						"tag" : "0",
						"rating" : "3.1",
						"owner" : "Newell Egan",
						"owner_image": "build/img/profiles/avatar-15.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Campaigns",
						"won_deals": "4 Deals, $100000",
						"lost_deals": "1 Deal, $50000",
						"created_date": "14 Nov 2025, 04:19 pm"
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"company_name" : "HarborView",
						"company_image" : "build/img/icons/company-icon-08.svg",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"location" : "Cuba",
						"tag" : "2",
						"rating" : "5.0",
						"owner" : "Janet Carlson",
						"owner_image": "build/img/profiles/avatar-04.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Google",
						"won_deals": "3 Deals, $70000",
						"lost_deals": "3 Deals, $80000",
						"created_date": "23 Nov 2025, 11:14 pm"
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"company_name" : "Golden Gate Ltd",
						"company_image" : "build/img/icons/company-icon-09.svg",
						"phone" : "+1 321454789",
						"email" : "jonathan@example.com",
						"location" : "Isreal",
						"tag" : "2",
						"rating" : "2.7",
						"owner" : "Craig Brown",
						"owner_image": "build/img/profiles/avatar-21.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Referrals",
						"won_deals": "6 Deals, $130000",
						"lost_deals": "4 Deals, $100000",
						"created_date": "10 Dec 2025, 06:43 am"
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"company_name" : "Redwood Inc",
						"company_image" : "build/img/icons/company-icon-10.svg",
						"phone" : "+1 278907145",
						"email" : "brook@example.com",
						"location" : "Colombia",
						"tag" : "2",
						"rating" : "3.0",
						"owner" : "Daniel Byrne",
						"owner_image": "build/img/profiles/avatar-23.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Campaigns",
						"won_deals": "5 Deals, $90000",
						"lost_deals": "2 Deals, $55000",
						"created_date": "25 Dec 2025, 08:17 pm"
					},
					{
						"id" : 11,
						"si_no" : "",
						"select" : "",
						"company_name" : "SilverHawk",
						"company_image" : "build/img/icons/company-icon-03.svg",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"location" : "Canada",
						"tag" : "0",
						"rating" : "3.5",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-25.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Paid Social",
						"won_deals": "5 Deals, $100000",
						"lost_deals": "2 Deals, $80000",
						"created_date": "25 Sep 2025, 01:22 pm"
					},
					{
						"id" : 12,
						"si_no" : "",
						"select" : "",
						"company_name" : "SummitPeak",
						"company_image" : "build/img/icons/company-icon-04.svg",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"location" : "India",
						"tag" : "0",
						"rating" : "4.5",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-26.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Google",
						"won_deals": "3 Deals, $70000",
						"lost_deals": "3 Deals, $80000",
						"created_date": "23 Nov 2025, 11:14 pm"
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="company_details" class="avatar avatar-sm border rounded-circle p-1 me-2"><img class="w-auto h-auto" src="'+row['company_image']+'" alt="User Image"></a><a href="company_details" class="d-flex flex-column fw-medium">'+row['company_name']+'</a></h6>';
				}},
				{ "data": "email" },
				{ "render": function (data, type, row) {
						var class_name, status_name;
						if (row['tag'] == "0") {
							class_name = "badge-soft-success";
							status_name = "Collab";
						} else if (row['tag'] == "1") {
							class_name = "badge-soft-warning";
							status_name = "VIP";
						} else if (row['tag'] == "3") {
							class_name = "badge-soft-info";
							status_name = "Premium";
						} else {
							class_name = "badge-soft-primary";
							status_name = "Promotion";
						}
						
						return '<span class="badge badge-tag ' + class_name + '" >' + status_name + '</span>';
				}},
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "render": function ( data, type, row ){
					return '<ul class="social-links d-flex align-items-center"><li><a href="#"><i class="ti ti-mail"></i></a></li><li><a href="#"><i class="ti ti-phone-check"></i></a></li><li><a href="#"><i class="ti ti-message-circle-share"></i></a></li><li><a href="#"><i class="ti ti-brand-facebook "></i></a></li></ul>';
				}},
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="company_details"><i class="ti ti-eye text-blue-light"></i> Preview</a></div></div>';
				}}
			]
		});
	}

	// Leads List

	if($('#leads_list').length > 0) {
		$('#leads_list').DataTable({
				"bFilter": false, 
				"bInfo": false,
					"ordering": true,
				"autoWidth": true,"autoWidth": true,
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
						"select" : "",
						"customer_name" : "Darlee Robertson",
				    	"customer_image" : "build/img/profiles/avatar-19.jpg",
						"company_name" : "NovaWave LLC",
						"company_image" : "build/img/icons/company-icon-01.svg",
						"company_address" : "Newyork, USA",
						"phone" : "+1 875455453",
						"email" : "robertson@example.com",
						"created_date" : "25 Sep 2025, 01:22 pm",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-13.jpg",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Sharon Roy",
				     	"customer_image" : "build/img/profiles/avatar-20.jpg",
						"company_name" : "BlueSky Industries",
						"company_image" : "build/img/icons/company-icon-02.svg",
						"company_address" : "Winchester, KY",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"created_date" : "29 Sep 2025, 04:15 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"source" : "Referrals",
						"status" : "2",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Vaughan Lewis",
				    	"customer_image" : "build/img/profiles/avatar-21.jpg",
						"company_name" : "SilverHawk",
						"company_image" : "build/img/icons/company-icon-03.svg",
						"company_address" : "Jametown, NY",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"created_date" : "04 Oct 2025, 10:18 am",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"source" : "Campaigns",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
				 		"customer_name" : "Jessica Louise",
					    "customer_image" : "build/img/profiles/avatar-23.jpg",
						"company_name" : "SummitPeak",
						"company_image" : "build/img/icons/company-icon-04.svg",
						"company_address" : "Compton, RI",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"created_date" : "17 Oct 2025, 03:31 pm",
						"owner" : "Martin Lewis",
						"owner_image": "build/img/profiles/avatar-20.jpg",
						"source" : "Google",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Carol Thomas",
				    	"customer_image" : "build/img/profiles/avatar-16.jpg",
						"company_name" : "RiverStone Ventur",
						"company_image" : "build/img/icons/company-icon-05.svg",
						"company_address" : "Dayton, OH",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"created_date" : "24 Oct 2025, 09:14 pm",
						"owner" : "Newell Egan",
						"owner_image": "build/img/profiles/avatar-15.jpg",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Dawn Mercha",
					    "customer_image" : "build/img/profiles/avatar-22.jpg",
						"company_name" : "Bright Bridge Grp",
						"company_image" : "build/img/icons/company-icon-06.svg",
						"company_address" : "Lafayette, LA",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"created_date" : "08 Nov 2025, 09:56 am",
						"owner" : "Janet Carlson",
						"owner_image": "build/img/profiles/avatar-04.jpg",
						"source" : "Referrals",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Rachel Hampton",
					    "customer_image" : "build/img/profiles/avatar-24.jpg",
						"company_name" : "CoastalStar Co.",
						"company_image" : "build/img/icons/company-icon-07.svg",
						"company_address" : "Centerville, VA",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"created_date" : "14 Nov 2025, 04:19 pm",
						"owner" : "Craig Brown",
						"owner_image": "build/img/profiles/avatar-21.jpg",
						"source" : "Campaigns",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonelle Curtiss",
					    "customer_image" : "build/img/profiles/avatar-25.jpg",
						"company_name" : "HarborView",
						"company_image" : "build/img/icons/company-icon-08.svg",
						"company_address" : "Providence, RI",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"created_date" : "23 Nov 2025, 11:14 pm",
						"owner" : "Daniel Byrne",
						"owner_image": "build/img/profiles/avatar-23.jpg",
						"source" : "Google",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonathan Smith",
					    "customer_image" : "build/img/profiles/avatar-26.jpg",
						"company_name" : "Golden Gate Ltd",
						"company_image" : "build/img/icons/company-icon-09.svg",
						"company_address" : "Swayzee, IN",
						"phone" : "+1 321454789",
						"email" : "jonathan@example.com",
						"created_date" : "10 Dec 2025, 06:43 am",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-25.jpg",
						"source" : "Paid Social",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Richard Cooper",
				    	"customer_image" : "build/img/profiles/avatar-05.jpg",
						"company_name" : "Redwood Inc",
						"company_image" : "build/img/icons/company-icon-10.svg",
						"company_address" : "Florida City, FL",
						"phone" : "+1 278907145",
						"email" : "brook@example.com",
						"created_date" : "25 Dec 2025, 08:17 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-26.jpg",
						"source" : "Referrals",
						"status" : "1",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="leads_details" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="leads_details" class="d-flex flex-column">' + row['customer_name']  + ' </span></a></h6>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="company_details" class="avatar border rounded p-1 me-2 rounded-circle"><img class="w-auto h-auto" src="'+row['company_image']+'" alt="User Image"></a><a href="company_details" class="d-flex flex-column">'+row['company_name']+'<span class="text-body fs-13 mt-1 fw-normal">'+row['company_address']+' </span></a></h6>';
				}},
				{ "data": "phone" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Closed" } else if(row['status'] == "1") { var class_name = "bg-danger";var status_name ="Lost" } else if(row['status'] == "2") { var class_name = "bg-info";var status_name ="Not Contacted"}
					else { var class_name = "bg-warning";var status_name ="Contacted"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},				
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xs me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lead"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="#"><i class="ti ti-clipboard-copy text-blue-light"></i> Clone</a></div></div>';
				}}
			]
		});
	}
		
	// Faq List

	if($('#faqlist').length > 0) {
		$('#faqlist').DataTable({
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
				"data": [
					{
						"id": 1,
						"si_no": "",
						"select": "",
						"questions": "What is a CRM and why should I use it?",
						"category": "Services",
						"answers": "organize contacts, manage sales pipelines, track communication,",
						"created_at": "25 Sep 2025, 01:22 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 2,
						"si_no": "",
						"select": "",
						"questions": "How do I add a new contact or company?",
						"category": "Advertising",
						"answers": "Go to the Contacts or Companies tab, click “Add New”, and fill in the form",
						"created_at": "29 Sep 2025, 08:12 am",
						"status": "1",
						"Action": ""
					},
					{
						"id": 3,
						"si_no": "",
						"select": "",
						"questions": "What’s the difference between a Lead, Contact, and Deal?",
						"category": "Services",
						"answers": "A potential customer who hasn't been qualified yet.",
						"created_at": "02 Oct 2025, 02:32 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 4,
						"si_no": "",
						"select": "",
						"questions": "How do I track my calls, emails, and meetings?",
						"category": "Services",
						"answers": "You can log activities manually under the contact or deal record",
						"created_at": "11 Oct 2025, 02:32 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 5,
						"si_no": "",
						"select": "",
						"questions": "What is the sales pipeline and how do I use it?",
						"category": "Media",
						"answers": "The pipeline shows your deals in different stages",
						"created_at": "04 Nov 2025, 04:22 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 6,
						"si_no": "",
						"select": "",
						"questions": "How can I set reminders or follow-up tasks?",
						"category": "Content Marketing",
						"answers": "You can create a task under a contact or deal, and set a due date and reminder.",
						"created_at": "16 Nov 2025, 10:51 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 7,
						"si_no": "",
						"select": "",
						"questions": "Can I collaborate with my team in the CRM?",
						"category": "Health Care",
						"answers": "Yes! You can assign deals, tag teammates in notes.",
						"created_at": "25 Nov 2025, 03:43 pm",
						"status": "1",
						"Action": ""
					},
					{
						"id": 8,
						"si_no": "",
						"select": "",
						"questions": "How do I use the CRM on my phone?",
						"category": "Services",
						"answers": "Most CRMs offer a mobile app for iOS and Android.",
						"created_at": "07 Dec 2025, 11:22 am",
						"status": "1",
						"Action": ""
					},
					{
						"id": 9,
						"si_no": "",
						"select": "",
						"questions": "Is my data automatically saved and synced?",
						"category": "Social Marketing",
						"answers": "Yes. All updates are saved automatically and synced across devices and users in real time.",
						"created_at": "15 Dec 2025, 08:17 am",
						"status": "1",
						"Action": ""
					},
					{
						"id": 10,
						"si_no": "",
						"select": "",
						"questions": "Who do I contact if I need help?",
						"category": "Media",
						"answers": "You can reach out to your CRM admin, use the Help Center.",
						"created_at": "29 Dec 2025, 01:22 pm",
						"status": "1",
						"Action": ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "data": "questions" },
				{ "data": "category" },
				{ "data": "answers" },
				{ "data": "created_at" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } if(row['status'] == "1") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},                 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_faq"><i class="ti ti-edit"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_faq"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

	// Deal List

	if($('#deal_list').length > 0) {
		$('#deal_list').DataTable({
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
				"data": [
					{
						"id": 1,
						"Deal_Name": "Collins",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$04,51,000",
						"tag1": "Collab",
						"close_date": "25 Sep 2025",
						"created_date" : "25 Sep 2025, 01:22 pm",
						"owner" : "Hendry Milner",
						"source" : "Paid Social",
						"Probability": "90%",
						"Status": "0"
					},
					{
						"id": 2,
						"Deal_Name": "Konopelski",
						"Stage": "Proposal Made",
						"Deal_Value": "$03,12,500",
						"tag1": "Rated",
						"close_date": "29 Sep 2025",
						"created_date" : "29 Sep 2025, 04:15 pm",
						"owner" : "Guilory Berggren",
						"source" : "Referrals",
						"Probability": "15 %",
						"Status": "1"
					},
					{
						"id": 3,
						"Deal_Name": "Adams",
						"Stage": "Contact Made",
						"Deal_Value": "$04,14,800",
						"tag1": "Rejected",
						"close_date": "04 Oct 2025",
						"created_date" : "04 Oct 2025, 10:18 am",
						"owner" : "Jami Carlile",
						"source" : "Campaigns",
						"Probability": "95 %",
						"Status": "0"
					},
					{
						"id": 4,
						"Deal_Name": "Schumm",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$11,14,400",
						"tag1": "Collab",
						"close_date": "15 Oct 2025",
						"created_date" : "17 Oct 2025, 03:31 pm",
						"owner" : "Theresa Nelson",
						"source" : "Google",
						"Probability": "99 %",
						"Status": "0"
					},
					{
						"id": 5,
						"Deal_Name": "Wisozk",
						"Stage": "Presentation",
						"Deal_Value": "$16,11,400",
						"tag1": "Rated",
						"close_date": "27 Oct 2025",
						"created_date" : "24 Oct 2025, 09:14 pm",
						"owner" : "Smith Cooper",
						"source" : "Paid Social",
						"Probability": "10 %",
						"Status": "2"
					},
					{
						"id": 6,
						"Deal_Name": "Heller",
						"Stage": "Appointment",
						"Deal_Value": "$78,11,800",
						"tag1": "Rated",
						"close_date": "07 Nov 2025",
						"created_date" : "08 Nov 2025, 09:56 am",
						"owner" : "Martin Lewis",
						"source" : "Referrals",
						"Probability": "70 %",
						"Status": "0"
					},
					{
						"id": 7,
						"Deal_Name": "Gutkowski",
						"Stage": "Proposal Made",
						"Deal_Value": "$09,05,947",
						"tag1": "Promotion",
						"close_date": "12 Nov 2025",
						"created_date" : "14 Nov 2025, 04:19 pm",
						"owner" : "Newell Egan",
						"source" : "Campaigns",
						"Probability": "10 %",
						"Status": "2"
					},
					{
						"id": 8,
						"Deal_Name": "Walter",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$04,51,000",
						"tag1": "Rejected",
						"close_date": "23 Nov 2025",
						"created_date" : "23 Nov 2025, 11:14 pm",
						"owner" : "Janet Carlson",
						"source" : "Google",
						"Probability": "90 %",
						"Status": "0"
					},
					{
						"id": 9,
						"Deal_Name": "Hansen",
						"Stage": "Appointment",
						"Deal_Value": "$72,14,078",
						"tag1": "Collab",
						"close_date": "11 Dec 2025",
						"created_date" : "10 Dec 2025, 06:43 am",
						"owner" : "Craig Brown",
						"source" : "Paid Social",
						"Probability": "40 %",
						"Status": "0"
					},
					{
						"id": 10,
						"Deal_Name": "Leuschke",
						"Stage": "Proposal Made",
						"Deal_Value": "$09,05,947",
						"tag1": "Rated",
						"close_date": "17 Dec 2025",
						"created_date" : "25 Dec 2025, 08:17 pm",
						"owner" : "Daniel Byrne",
						"source" : "Referrals",
						"Probability": "47 %",
						"Status": "1"
					}
					],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="deals_details" class="title-name">'+row['Deal_Name']+'</a>';
				}},
				{ "data": "Stage" },
				{ "data": "Deal_Value" },
				{ "render": function ( data, type, row ){
					if(row['tag1'] == "Collab") { var class_name = "badge-soft-success";var status_name ="Collab" }else if(row['tag1'] == "Rated") { var class_name = "badge-soft-warning";var status_name ="Rated" } else if(row['tag1'] == "Promotion"){ var class_name = "badge-soft-info";var status_name ="Promotion"} else { var class_name = "badge-soft-danger";var status_name ="Rejected"}
					return '<span class="badge badge-tag '+class_name+'" >'+status_name+'</span>';
				}},
				{ "data": "close_date" },
				{ "data": "Probability" },
				{ "render": function ( data, type, row ){
					if(row['Status'] == "0") { var class_name = "bg-success";var status_name ="Won" }else if(row['Status'] == "1"){ var class_name = "bg-danger";var status_name ="Lost"} else { var class_name = "bg-purple";var status_name ="open"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ti ti-bounce-right"></i> Add Activity</a><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_deal"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="deals_details"><i class="ti ti-eye text-blue-light"></i> Preview</a></div></div>';
				}}
			]
		});
	}

	// Testimonials List

	if($('#testimonials_list').length > 0) {
		$('#testimonials_list').DataTable({
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
						"select" : "",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_designation" : "Facility Manager",
						"content" : "Our team cut customer onboarding time by 60% after ",
						"createdat" : "25 Sep 2025, 01:22pm",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_designation" : "Installer",
						"content" : "Incredibly intuitive, and their support is top-notch.",
						"createdat" : "29 Sep 2025, 08:12 am",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_designation" : "Senior  Manager",
						"content" : "Everything arrived on time, and I’ve already placed.",
						"createdat" : "02 Oct 2025, 10:15 am",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_designation" : "Test Engineer",
						"content" : "The product quality and customer service blew.",
						"createdat" : "11 Oct 2025, 02:32 pm",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_designation" : "UI /UX Designer",
						"content" : "I was hesitant to shop online, but the product quality",
						"createdat" : "4 Nov 2025, 04:22 pm",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_designation" : "Technician",
						"content" : "Strategic advice we got from Apex Consulting",
						"createdat" : "16 Nov 2025, 10:51 pm",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Rachel Hampton",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_designation" : "Software Developer",
						"content" : "The confidence and skills to land my first tech job",
						"createdat" : "25 Nov 2025, 3:43 pm",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonelle Curtiss",
						"customer_image" : "build/img/profiles/avatar-25.jpg",
						"customer_designation" : "Supervisor",
						"content" : "They're now a core part of our growth team.",
						"createdat" : "07 Dec 2025, 11:22 am",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonathan Smith",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_designation" : "Team Lead Dev",
						"content" : "The instructors genuinely care, and the real-world",
						"createdat" : "15 Dec 2025, 8:17 am",
						"status" : "1",
						"Action" : ""
					}
					,
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Eric Adams",
						"customer_image" : "build/img/profiles/avatar-06.jpg",
						"customer_designation" : "HR Manager",
						"content" : "This course gave me the confidence and skills to land.",
						"createdat" : "29 Dec 2025, 1:22 pm",
						"status" : "1",
						"Action" : ""
					}
					
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="#" class="avatar avatar-rounded me-2"><img src="'+row['customer_image']+'" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">'+row['customer_name']+'<span class="text-body fw-normal fs-13 d-inline-block mt-1">'+row['customer_designation']+' </span></a></h2>';
				}},
				{
					"render": function (data, type, row) {
						let starsHtml = '<div class="set-star rating-select filled">';
						for (let i = 0; i < 5; i++) {
						starsHtml += '<i class="ti ti-star-filled fs-16 me-1"></i>';
						}
						starsHtml += '</div>';
						return starsHtml;
					}
					},
					
				{ "data": "content" },
				{ "data": "createdat" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } if(row['status'] == "1") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#edit_testimonial"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_testimonial"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}

	// Source List

	if ($("#source_list").length > 0) {
		$("#source_list").DataTable({
			bFilter: false,
			bInfo: false,
			"ordering": true,
			"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				"lengthMenu": "Show _MENU_ entries",
				paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
			},
			initComplete: function(settings, json) {
				$('.dataTables_paginate').appendTo('.datatable-paginate');
				$('.dataTables_length').appendTo('.datatable-length');
			},
			"data": [
			{
				"id": 1,
				"title": "Phone Calls",
				"created_date": "25 Jan 2025, 01:22 PM",
				"status": "0"
			},
			{
				"id": 2,
				"title": "Social Media",
				"created_date": "29 Sep 2025, 04:15 pm",
				"status": "1"
			},
			{
				"id": 3,
				"title": "Referral Sites",
				"created_date": "04 Oct 2025, 10:18 am",
				"status": "0"
			},
			{
				"id": 4,
				"title": "Web Analytics",
				"created_date": "17 Oct 2025, 03:31 pm",
				"status": "0"
			},
			{
				"id": 5,
				"title": "Previous Purchases",
				"created_date": "24 Oct 2025, 09:14 pm",
				"status": "0"
			},
			{
				"id": 6,
				"title": "Lead & Opportunity",
				"created_date": "08 Nov 2025, 09:56 am",
				"status": "0"
			},
			{
				"id": 7,
				"title": "Image-based Features",
				"created_date": "14 Nov 2025, 04:19 pm",
				"status": "0"
			},
			{
				"id": 8,
				"title": "Bots",
				"created_date": "23 Nov 2025, 11:14 pm",
				"status": "0"
			},
			{
				"id": 9,
				"title": "Insights",
				"created_date": "10 Dec 2025, 06:43 am",
				"status": "0"
			},
			{
				"id": 10,
				"title": "Commerce",
				"created_date": "25 Dec 2025, 08:17 pm",
				"status": "0"
			}
			],
			columns: [
			{
				"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}
			},
			{ "render": function ( data, type, row ){
				return '<span class="title-name">'+row['title']+'</span>';
			}},
			{ data: "created_date" },
			{
				render: function (data, type, row) {
				if (row["status"] == "1") {
					var class_name = "bg-success";
					var status_name = "Active";
				}
				if (row["status"] == "0") {
					var class_name = "bg-success";
					var status_name = "Active";
				} else {
					var class_name = "bg-danger";
					var status_name = "Inactive";
				}
				return (
					'<span class="badge badge-pill badge-status ' +
					class_name +
					'" >' +
					status_name +
					"</span>"
				);
				},
			},

			{
					"render": function (data, type, row) {
						return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_source"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_source"><i class="ti ti-trash"></i> Delete</a></div></div>';
					}
				}
			],
		});
	}

	if($('#customer-reporttable').length > 0) {
		$('#customer-reporttable').DataTable({
			"bFilter": false, 
			"bInfo": false,
				"ordering": true,
				"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: 'MENU',
				searchPlaceholder: "Search",
				info: "START - END of TOTAL items",
				"lengthMenu":     "Show MENU entries",
				paginate: {
					next: 'Next <i class=" fa fa-angle-right"></i> ',
					previous: '<i class="fa fa-angle-left"></i> Prev '
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
					"select" : "",
					"customer_name" : "Darlee Robertson",
					"customer_image" : "build/img/profiles/avatar-19.jpg",
					"customer_no" : "Facility Manager",
					"phone" : "1234567890",
					"email" : "robertson@example.com",
					"location" : "Germany",
					"tag" : "0",
					"rating" : "4.2",
					"created_date" : "25 Sep 2025, 01:22 pm",
					"owner" : "Hendry Milner",
					"source" : "Paid Social",
					"company_name" : "NovaWave LLC",
					"company_image" : "build/img/icons/company-icon-01.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Retail Industry",
					"type" : "Customer",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 2,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Sharon Roy",
					"customer_image" : "build/img/profiles/avatar-20.jpg",
					"customer_no" : "Installer",
					"phone" : "+1 989757485",
					"email" : "sharon@example.com",
					"location" : "USA",
					"tag" : "2",
					"rating" : "5.0",
						"created_date" : "29 Sep 2025, 04:15 pm",
						"owner" : "Guilory Berggren",
						"source" : "Referrals",
					"company_name" : "BlueSky Industries",
					"company_image" : "build/img/icons/company-icon-02.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Banking",
					"type" : "Accounts",
					"status" : "1",
					"Action" : ""
				},
				{
					"id" : 3,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Vaughan Lewis",
					"customer_image" : "build/img/profiles/avatar-21.jpg",
					"customer_no" : "Senior  Manager",
					"phone" : "+1 546555455",
					"email" : "vaughan12@example.com",
					"location" : "Canada",
					"tag" : "0",
					"rating" : "3.5",
					"created_date" : "04 Oct 2025, 10:18 am",
					"owner" : "Jami Carlile",
					"source" : "Campaigns",
					"company_name" : "SilverHawk",
					"company_image" : "build/img/icons/company-icon-03.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Hotels",
					"type" : "Partner",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 4,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jessica Louise",
					"customer_image" : "build/img/profiles/avatar-23.jpg",
					"customer_no" : "Test Engineer",
					"phone" : "+1 454478787",
					"email" : "jessica13@example.com",
					"location" : "India",
					"tag" : "1",
					"rating" : "4.5",
					"created_date" : "17 Oct 2025, 03:31 pm",
						"owner" : "Theresa Nelson",
						"source" : "Google",
					"company_name" : "SummitPeak",
					"company_image" : "build/img/icons/company-icon-04.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Financial Services",
					"type" : "Prospect",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 5,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Carol Thomas",
					"customer_image" : "build/img/profiles/avatar-16.jpg",
					"customer_no" : "UI /UX Designer",
					"phone" : "+1 124547845",
					"email" : "caroltho3@example.com",
					"location" : "China",
					"tag" : "0",
					"rating" : "4.7",
					"created_date" : "24 Oct 2025, 09:14 pm",
						"owner" : "Smith Cooper",
						"source" : "Paid Social",
					"company_name" : "RiverStone Ventur",
					"company_image" : "build/img/icons/company-icon-05.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Insurance",
					"type" : "Lead",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 6,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Dawn Mercha",
					"customer_image" : "build/img/profiles/avatar-22.jpg",
					"customer_no" : "Technician",
					"phone" : "+1 478845447",
					"email" : "dawnmercha@example.com",
					"location" : "Martin Lewis",
					"tag" : "1",
					"rating" : "5.0",
					"created_date" : "08 Nov 2025, 09:56 am",
						"owner" : "Martin Lewis",
						"source" : "Referrals",
					"company_name" : "Bright Bridge Grp",
					"company_image" : "build/img/icons/company-icon-06.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Consulatation",
					"type" : "Influencer",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 7,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Rachel Hampton",
					"customer_image" : "build/img/profiles/avatar-24.jpg",
					"customer_no" : "Software Developer",
					"phone" : "+1 215544845",
					"email" : "rachel@example.com",
					"location" : "Indonesia",
					"tag" : "2",
					"rating" : "3.1",
					"created_date" : "14 Nov 2025, 04:19 pm",
						"owner" : "Newell Egan",
						"source" : "Campaigns",
					"company_name" : "CoastalStar Co.",
					"company_image" : "build/img/icons/company-icon-07.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Agriculture",
					"type" : "Vendor",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 8,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonelle Curtiss",
					"customer_image" : "build/img/profiles/avatar-25.jpg",
					"customer_no" : "Supervisor",
					"phone" : "+1 121145471",
					"email" : "jonelle@example.com",
					"location" : "Cuba",
					"tag" : "1",
					"rating" : "5.0",
						"created_date" : "23 Nov 2025, 11:14 pm",
						"owner" : "Janet Carlson",
						"source" : "Google",
					"company_name" : "HarborView",
					"company_image" : "build/img/icons/company-icon-08.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Insurance",
					"type" : "Customer",
					"status" : "0",
					"Action" : ""
				},
				{
					"id" : 9,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonathan Smith",
					"customer_image" : "build/img/profiles/avatar-26.jpg",
					"customer_no" : "Team Lead Dev",
					"phone" : "+1 321454789",
					"email" : "jonathan@example.com",
					"location" : "Isreal",
					"tag" : "0",
					"rating" : "2.7",
					"created_date" : "10 Dec 2025, 06:43 am",
						"owner" : "Craig Brown",
						"source" : "Paid Social",
					"company_name" : "Golden Gate Ltd",
					"company_image" : "build/img/icons/company-icon-09.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Banking",
					"type" : "Accounts",
					"status" : "0",
					"Action" : ""
				}
				,
				{
					"id" : 10,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Brook Carter",
					"customer_image" : "build/img/profiles/avatar-01.jpg",
					"customer_no" : "Team Lead Dev ",
					"phone" : "+1 278907145",
					"email" : "brook@example.com",
					"location" : "Colombia",
					"tag" : "2",
					"rating" : "3.0",
					"close_date": "17 Dec 2025",
						"created_date" : "25 Dec 2025, 08:17 pm",
						"owner" : "Daniel Byrne",
						"source" : "Referrals",
					"company_name" : "Redwood Inc",
					"company_image" : "build/img/icons/company-icon-10.svg",
					"owner_image": "build/img/profiles/avatar-14.jpg",
						"industry" : "Financial Services",
					"type" : "Influencer",
					"status" : "0",
					"Action" : ""
				}
				
			],
		"columns": [
			{ "render": function ( data, type, row ){
				return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
			}},
			{ "render": function ( data, type, row ){
				return '<h2 class="d-flex align-items-center"><a href="#" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['customerreport_image']+'" alt="User Image"></a><a href="javascript:void(0);">'+row['customerreport_name']+'</a></h2>';
			}},
			{ "data": "position" },
			{ "data": "phone" },
			{ "data": "email" },
			{ "data": "location" },
			{ "data": "owner" },
			{ "render": function ( data, type, row ){
				return '<span class="source-report">'+row['source_name']+'</span>';
			}},
			{ "data": "created_date" },
		]
	});
	}

	if($('#recent-project').length > 0) {
		$('#recent-project').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"priority_name" : "Truelysell",
					"priority_img" : "build/img/priority/truellysel.svg",
					"recent_name" : "NovaWave LLC",
					"recent_img" : "build/img/icons/company-icon-01.svg",
					"client" : "1",
					"due_date" : "23 Nov 2025"
				},
				{
					"id" : 2,
					"priority_name" : "Dreamschat",
					"priority_img" : "build/img/priority/dreamchat.svg",
					"recent_name" : "BlueSky",
					"recent_img" : "build/img/icons/company-icon-02.svg",
					"client" : "2",
					"due_date" : "07 Nov 2025"
				},
				{
					"id" : 3,
					"priority_name" : "DreamGigs",
					"priority_img" : "build/img/priority/truellysell.svg",
					"recent_name" : "Silve Hawk",
					"recent_img" : "build/img/icons/company-icon-03.svg",
					"client" : "",
					"due_date" : "15 Oct 2025"
				},
				{
					"id" : 4,
					"priority_name" : "Servbook",
					"priority_img" : "build/img/priority/servbook.svg",
					"recent_name" : "Summit Peak",
					"recent_img" : "build/img/icons/company-icon-04.svg",
					"client" : "1",
					"due_date" : "29 Sep 2025"
				},
				{
					"id" : 5,
					"priority_name" : "DreamPOS",
					"priority_img" : "build/img/priority/dream-pos.svg",
					"recent_name" : "RiverStone Ltd",
					"recent_img" : "build/img/icons/company-icon-05.svg",
					"client" : "2",
					"due_date" : "25 Sep 2025"
				}
				
			],
			
		"columns": [
			{ "render": function ( data, type, row ){
				return '<h2 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="project_details" class="avatar avatar-rounded border me-2"><img class="w-auto h-auto" src="'+row['priority_img']+'" alt="User Image"></a><a href="project_details">'+row['priority_name']+'</a></h2>';
			}},
			{ "render": function ( data, type, row ){
				return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="company_details" class="avatar avatar-rounded border me-2"><img class="w-auto h-auto" src="'+row['recent_img']+'" alt="User Image"></a><a href="company_details">'+row['recent_name']+'</a></h6>';
			}},
			{ "render": function ( data, type, row ){
				if(row['client'] == "1") { var class_name = "badge-soft-success border border-success";var status_name ="Low" } if(row['client'] == "2") { var class_name = "badge-soft-warning border border-warning";var status_name ="Medium" } else { var class_name = "badge-soft-danger border border-danger";var status_name ="High"}
				return '<span class="d-inline-flex align-items-center badge badge-pill  '+class_name+'" ><i class="ti ti-square-rounded-filled me-1"></i> '+status_name+'</span>';
			}},
			{ "data": "due_date" },
		]
	});
	}

	if($('#lead-project').length > 0) {
		$('#lead-project').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"lead" : "Collins",
					"lead_name" : "NovaWave LLC",
					"lead_city" : "Newyork, USA",
					"lead_img" : "build/img/icons/company-icon-01.svg",
					"phone" : "+1 875455453",
					"status" : "1"
				},
				{
					"id" : 2,
					"lead" : "Konopelski",
					"lead_name" : "BlueSky Industries",
					"lead_city" : "Winchester, KY",
					"lead_img" : "build/img/icons/company-icon-02.svg",
					"phone" : "+1 989757485",
					"status" : "1"
				},
				{
					"id" : 3,
					"lead" : "Adams",
					"lead_name" : "Silver Hawk",
					"lead_city" : "Jametown, NY",
					"lead_img" : "build/img/icons/company-icon-03.svg",
					"phone" : "+1 546555455",
					"status" : "1"
				},
				{
					"id" : 4,
					"lead" : "Schumm",
					"lead_name" : "Summit Peak",
					"lead_city" : "Compton, RI",
					"lead_img" : "build/img/icons/company-icon-04.svg",
					"phone" : "+1 454478787",
					"status" : "2"
				},
				{
					"id" : 5,
					"lead" : "Wisozk",
					"lead_name" : "RiverStone Ltd",
					"lead_city" : "Compton, RI",
					"lead_img" : "build/img/icons/company-icon-05.svg",
					"phone" : "+1 1245427875",
					"status" : "1"
				}
		
			],
		"columns": [
			{ "render": function ( data, type, row ){
				return '<a href="leads_details">'+row['lead']+'</a>';
			}},
			{ "render": function ( data, type, row ){
				return '<div class="d-flex align-items-center"><a href="company_details" class="avatar avatar-rounded border"><img class="w-auto h-auto" src="'+row['lead_img']+'" alt="User Image"></a><div class="ms-2"><h6 class="fs-14 fw-medium mb-0"><a href="company_details" class="d-flex flex-column">'+row['lead_name']+'</a></h6></div></div>';
			}},
			{ "data": "phone" },
			{ "render": function ( data, type, row ){
				if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Closed" } if(row['status'] == "1") { var class_name = "bg-success";var status_name ="Closed" } else { var class_name = "bg-warning";var status_name ="Contacted"}
				return '<span class="badge badge-pill  '+class_name+'" > '+status_name+'</span>';
			}},
		]
	});
	}

	if($('#deals-project').length > 0) {
		$('#deals-project').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"deal_name" : "SkyHigh Annual Booking",
					"stage" : "Appointment",
					"deal_value" : "$04,51,000",
					"status" : "2"
				},
				{
					"id" : 2,
					"deal_name" : "CRM Onboarding Package",
					"stage" : "Contact Made",
					"deal_value" : "$72,14,078",
					"status" : "1"
				},
				{
					"id" : 3,
					"deal_name" : "Enterprise Plan Upgrade",
					"stage" : "Presentation",
					"deal_value" : "$04,14,800",
					"status" : "2"
				},
				{
					"id" : 4,
					"deal_name" : "CRM Migration Project",
					"stage" : "Proposal Made",
					"deal_value" : "$16,11,400",
					"status" : "2"
				},
				{
					"id" : 5,
					"deal_name" : "Sales Pipeline Optimization",
					"stage" : "Qualify To Buy",
					"deal_value" : "$09,05,947",
					"status" : "2"
				}
		
			],
		"columns": [
			{ "render": function ( data, type, row ){
				return '<a href="deals_details" class="fw-medium">'+row['deal_name']+'</a>';
			}},
			{ "data": "stage" },
			{ "data": "deal_value" },
			{ "render": function ( data, type, row ){
				if(row['status'] == "0") { var class_name = "bg-pending";var status_name ="Open" } if(row['status'] == "1") { var class_name = "bg-danger";var status_name ="Lost" } else { var class_name = "bg-success";var status_name ="Won"}
				return '<span class="badge badge-pill  '+class_name+'" >'+status_name+'</span>';
			}},
		]
	});
	}

	// Pipeline List

	if($('#pipeline-list').length > 0) {
		$('#pipeline-list').DataTable({
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
						"name" : "Sales",
						"deal_value" : "$4,50,664",
						"no_deal" : "315",
						"stage" : "0",
						"createdat" : "25 Sep 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"name" : "Marketing",
						"deal_value" : "$3,12,893",
						"no_deal" : "447",
						"stage" : "0",
						"createdat" : "29 Sep 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"name" : "Email",
						"deal_value" : "$2,89,274",
						"no_deal" : "654",
						"stage" : "1",
						"createdat" : "15 Oct 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"name" : "Chats",
						"deal_value" : "$1,59,326",
						"no_deal" : "768",
						"stage" : "0",
						"createdat" : "29 Oct 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"name" : "Operational",
						"deal_value" : "$2,90,173",
						"no_deal" : "142",
						"stage" : "0",
						"createdat" : "03 Nov 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"name" : "Collaborative",
						"deal_value" : "$4,51,417",
						"no_deal" : "315",
						"stage" : "2",
						"createdat" : "17 Nov 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"name" : "Differentiate",
						"deal_value" : "$3,17,589",
						"no_deal" : "478",
						"stage" : "3",
						"createdat" : "23 Nov 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"name" : "Interact ",
						"deal_value" : "$1,69,146",
						"no_deal" : "664",
						"stage" : "4",
						"createdat" : "09 Dec 2025",
						"status" : "1",
						"Action" : ""
					}
					
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['name']+'</span>';
				}},
				{ "data": "deal_value" },
				{ "data": "no_deal" },
				{
					"render": function (data, type, row) {
							if(row['stage'] == "0") { var class_name = "success";var status_name ="Win" } else if(row['stage'] == "1") { var class_name = "violet";var status_name ="In Pipeline" } else if(row['stage'] == "2") { var class_name = "green";var status_name ="Conversation"} else if(row['stage'] == "2") { var class_name = "info";var status_name ="Follow Up"} else  { var class_name = "danger";var status_name ="Lost"}
					return '<div class="pipeline-progress d-flex align-items-center"><div class="progress"><div class="progress-bar progress-bar-'+class_name+'" role="progressbar"></div></div><span>'+status_name+'</span></div>';
					}
				},                      
				{ "data": "createdat" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } if(row['status'] == "1") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}

	// Campaign List

	if($('#campaign-list').length > 0) {
		$('#campaign-list').DataTable({
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
						"star" : "",
						"name" : "Distribution",
						"type" : "Public Relations",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "25 Sep 2025",
						"end_date" : "29 Sep 2025",
						"created_date" : "25 Sep 2025",
						"open" : "40.5%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"star" : "",
						"name" : "Merchandising",
						"type" : "Content Marketing",
						"mem_image1" : "build/img/profiles/avatar-03.jpg",
						"mem_image2": "build/img/profiles/avatar-05.jpg",
						"mem_image3": "build/img/profiles/avatar-06.jpg",
						"start_date" : "03 Oct 2025",
						"end_date" : "16 Oct 2025",
						"created_date" : "03 Oct 2025",
						"open" : "65.5%",
						"close" : "83.5%",
						"unscubscribe" : "67.5%",
						"delivered" : "32.0%",
						"converstion" : "22.5%",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"star" : "",
						"name" : "Pricing",
						"type" : "Social Marketing",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-01.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "17 Oct 2025",
						"end_date" : "28 Oct 2025",
						"created_date" : "17 Oct 2025",
						"open" : "64.0%",
						"close" : "97.0%",
						"unscubscribe" : "14.5%",
						"delivered" : "38.5%",
						"converstion" : "53.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"star" : "",
						"name" : "Increased sales",
						"type" : "Brand",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-13.jpg",
						"start_date" : "07 Nov 2025",
						"end_date" : "14 Nov 2025",
						"created_date" : "07 Nov 2025",
						"open" : "32.5%",
						"close" : "57.0%",
						"unscubscribe" : "26.3%",
						"delivered" : "65.8%",
						"converstion" : "17.4%",
						"status" : "2",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"star" : "",
						"name" : "Brand recognition",
						"type" : "Sales",
						"mem_image1" : "build/img/profiles/avatar-10.jpg",
						"mem_image2": "build/img/profiles/avatar-11.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "19 Nov 2025",
						"end_date" : "26 Nov 2025",
						"created_date" : "19 Nov 2025",
						"open" : "72.6%",
						"close" : "53.5%",
						"unscubscribe" : "16.5%",
						"delivered" : "83.0%",
						"converstion" : "29.3%",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"star" : "",
						"name" : "Enhanced brand",
						"type" : "Media",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-09.jpg",
						"mem_image3": "build/img/profiles/avatar-08.jpg",
						"start_date" : "02 Dec 2025",
						"end_date" : "13 Dec 2025",
						"created_date" : "02 Dec 2025",
						"open" : "56.3%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "4",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"star" : "",
						"name" : "Repeat customers",
						"type" : "Rebranding",
						"mem_image1" : "build/img/profiles/avatar-06.jpg",
						"mem_image2": "build/img/profiles/avatar-07.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "17 Dec 2025",
						"end_date" : "27 Dec 2025",
						"created_date" : "17 Dec 2025",
						"open" : "63.2%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "87.8%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"star" : "",
						"name" : "Competitor ",
						"type" : "Product launch",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-05.jpg",
						"start_date" : "06 Jan 2024",
						"end_date" : "17 Jan 2024",
						"created_date" : "06 Jan 2024",
						"open" : "40.5%",
						"close" : "52.7%",
						"unscubscribe" : "13.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "4",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{ "data": "name" },
				{ "data": "type" },
				{ "render": function ( data, type, row ){
					return '<ul class="list-progress d-flex gap-3"><li><h6 class="fs-14 fw-semibold mb-1">'+row['open']+'</h6><p class="fs-13 mb-0">Opened</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['close']+'</h6><p class="fs-13 mb-0">Closed</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['unscubscribe']+'</h6><p class="fs-13 mb-0">Unsubscribe</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['delivered']+'</h6><p class="fs-13 mb-0">Delivered</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['converstion']+'</h6><p class="fs-13 mb-0">Conversation</p></li></ul>';
				}},
				{
					"render": function (data, type, row) {
					return '<ul class="avatar-list-stacked avatar-group-sm"><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image1']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image2']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image3']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0 bg-light fs-10"><a href="#">3+</a></li></ul>';
					}
				},               			
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Success" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Pending" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Bounced" } else if(row['status'] == "3") { var class_name = "green";var status_name ="Running" } else { var class_name = "info";var status_name ="Paused"}
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},           
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_campaign"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}

	// Campaign Complete

	if($('#campaign-complete').length > 0) {
		$('#campaign-complete').DataTable({
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
						"star" : "",
						"name" : "Distribution",
						"type" : "Public Relations",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "25 Sep 2025",
						"end_date" : "29 Sep 2025",
						"created_date" : "25 Sep 2025",
						"open" : "40.5%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"star" : "",
						"name" : "Merchandising",
						"type" : "Content Marketing",
						"mem_image1" : "build/img/profiles/avatar-03.jpg",
						"mem_image2": "build/img/profiles/avatar-05.jpg",
						"mem_image3": "build/img/profiles/avatar-06.jpg",
						"start_date" : "03 Oct 2025",
						"end_date" : "16 Oct 2025",
						"created_date" : "03 Oct 2025",
						"open" : "65.5%",
						"close" : "83.5%",
						"unscubscribe" : "67.5%",
						"delivered" : "32.0%",
						"converstion" : "22.5%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"star" : "",
						"name" : "Pricing",
						"type" : "Social Marketing",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-01.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "17 Oct 2025",
						"end_date" : "28 Oct 2025",
						"created_date" : "17 Oct 2025",
						"open" : "64.0%",
						"close" : "97.0%",
						"unscubscribe" : "14.5%",
						"delivered" : "38.5%",
						"converstion" : "53.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"star" : "",
						"name" : "Increased sales",
						"type" : "Brand",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-13.jpg",
						"start_date" : "07 Nov 2025",
						"end_date" : "14 Nov 2025",
						"created_date" : "07 Nov 2025",
						"open" : "32.5%",
						"close" : "57.0%",
						"unscubscribe" : "26.3%",
						"delivered" : "65.8%",
						"converstion" : "17.4%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"star" : "",
						"name" : "Brand recognition",
						"type" : "Sales",
						"mem_image1" : "build/img/profiles/avatar-10.jpg",
						"mem_image2": "build/img/profiles/avatar-11.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "19 Nov 2025",
						"end_date" : "26 Nov 2025",
						"created_date" : "19 Nov 2025",
						"open" : "72.6%",
						"close" : "53.5%",
						"unscubscribe" : "16.5%",
						"delivered" : "83.0%",
						"converstion" : "29.3%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"star" : "",
						"name" : "Enhanced brand",
						"type" : "Media",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-09.jpg",
						"mem_image3": "build/img/profiles/avatar-08.jpg",
						"start_date" : "02 Dec 2025",
						"end_date" : "13 Dec 2025",
						"created_date" : "02 Dec 2025",
						"open" : "56.3%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"star" : "",
						"name" : "Repeat customers",
						"type" : "Rebranding",
						"mem_image1" : "build/img/profiles/avatar-06.jpg",
						"mem_image2": "build/img/profiles/avatar-07.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "17 Dec 2025",
						"end_date" : "27 Dec 2025",
						"created_date" : "17 Dec 2025",
						"open" : "63.2%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "87.8%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"star" : "",
						"name" : "Competitor ",
						"type" : "Product launch",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-05.jpg",
						"start_date" : "06 Jan 2024",
						"end_date" : "17 Jan 2024",
						"created_date" : "06 Jan 2024",
						"open" : "40.5%",
						"close" : "52.7%",
						"unscubscribe" : "13.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "0",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{ "data": "name" },
				{ "data": "type" },
				{ "render": function ( data, type, row ){
					return '<ul class="list-progress d-flex gap-3"><li><h6 class="fs-14 fw-semibold mb-1">'+row['open']+'</h6><p class="fs-13 mb-0">Opened</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['close']+'</h6><p class="fs-13 mb-0">Closed</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['unscubscribe']+'</h6><p class="fs-13 mb-0">Unsubscribe</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['delivered']+'</h6><p class="fs-13 mb-0">Delivered</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['converstion']+'</h6><p class="fs-13 mb-0">Conversation</p></li></ul>';
				}},
				{
					"render": function (data, type, row) {
					return '<ul class="avatar-list-stacked avatar-group-sm"><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image1']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image2']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image3']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0 bg-light fs-10"><a href="#">3+</a></li></ul>';
					}
				},               			
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Success" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Pending" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Bounced" } else if(row['status'] == "3") { var class_name = "green";var status_name ="Running" } else { var class_name = "info";var status_name ="Paused"}
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},           
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_campaign"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}
	

	// Campaign Archieve

	if($('#campaign-archieve').length > 0) {
		$('#campaign-archieve').DataTable({
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
						"star" : "",
						"name" : "Distribution",
						"type" : "Public Relations",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "25 Sep 2025",
						"end_date" : "29 Sep 2025",
						"created_date" : "25 Sep 2025",
						"open" : "40.5%",
						"close" : "20.5%",
						"unscubscribe" : "30.5%",
						"delivered" : "70.5%",
						"converstion" : "35.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"star" : "",
						"name" : "Merchandising",
						"type" : "Content Marketing",
						"mem_image1" : "build/img/profiles/avatar-03.jpg",
						"mem_image2": "build/img/profiles/avatar-05.jpg",
						"mem_image3": "build/img/profiles/avatar-06.jpg",
						"start_date" : "03 Oct 2025",
						"end_date" : "16 Oct 2025",
						"created_date" : "03 Oct 2025",
						"open" : "65.5%",
						"close" : "83.5%",
						"unscubscribe" : "67.5%",
						"delivered" : "32.0%",
						"converstion" : "22.5%",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"star" : "",
						"name" : "Pricing",
						"type" : "Social Marketing",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-01.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"start_date" : "17 Oct 2025",
						"end_date" : "28 Oct 2025",
						"created_date" : "17 Oct 2025",
						"open" : "64.0%",
						"close" : "97.0%",
						"unscubscribe" : "14.5%",
						"delivered" : "38.5%",
						"converstion" : "53.0%",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"star" : "",
						"name" : "Increased sales",
						"type" : "Brand",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-13.jpg",
						"start_date" : "07 Nov 2025",
						"end_date" : "14 Nov 2025",
						"created_date" : "07 Nov 2025",
						"open" : "32.5%",
						"close" : "57.0%",
						"unscubscribe" : "26.3%",
						"delivered" : "65.8%",
						"converstion" : "17.4%",
						"status" : "0",
						"Action" : ""
					}
				],
		"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{ "data": "name" },
				{ "data": "type" },
				{ "render": function ( data, type, row ){
					return '<ul class="list-progress d-flex gap-3"><li><h6 class="fs-14 fw-semibold mb-1">'+row['open']+'</h6><p class="fs-13 mb-0">Opened</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['close']+'</h6><p class="fs-13 mb-0">Closed</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['unscubscribe']+'</h6><p class="fs-13 mb-0">Unsubscribe</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['delivered']+'</h6><p class="fs-13 mb-0">Delivered</p></li><li><h6 class="fs-14 fw-semibold mb-1">'+row['converstion']+'</h6><p class="fs-13 mb-0">Conversation</p></li></ul>';
				}},
				{
					"render": function (data, type, row) {
					return '<ul class="avatar-list-stacked avatar-group-sm"><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image1']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image2']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0"><a href="#"><img src="'+row['mem_image3']+'" alt="img"></a></li><li class="avatar avatar-rounded flex-shrink-0 bg-light fs-10"><a href="#">3+</a></li></ul>';
					}
				},               			
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Success" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Pending" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Bounced" } else if(row['status'] == "3") { var class_name = "green";var status_name ="Running" } else { var class_name = "info";var status_name ="Paused"}
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},           
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_campaign"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}

	// Projects List

	if($('#project-list').length > 0) {
		$('#project-list').DataTable({
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
						"id" : "#12145",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "NovaWave LLC",
						"pro_img" : "build/img/priority/truellysel.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"piority" : "0",
						"start_date" : "25 Sep 2025",
						"end_date" : "15 Oct 2025",
						"stage" : "3",
						"type" : "Web App",
						"status" : "0",
						"value": "$03,50,000",
						"hrs": "100",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$40000",
						"Action" : ""
					},
					{
						"id" : "#12146",
						"si_no" : "",
						"star" : "",
						"name" : "Dreamschat",
						"client" : "BlueSky Industries",
						"pro_img" : "build/img/priority/dreamchat.svg",
						"client_img": "build/img/icons/company-icon-02.svg",
						"piority" : "0",
						"start_date" : "29 Sep 2025",
						"end_date" : "19 Oct 2025",
						"stage" : "1",
						"type" : "Web App",
						"status" : "1",
						"value": "$02,15,000",
						"hrs": "80",
						"mem_image1" : "build/img/profiles/avatar-03.jpg",
						"mem_image2": "build/img/profiles/avatar-05.jpg",
						"mem_image3": "build/img/profiles/avatar-06.jpg",
						"budget": "$300000",
						"currently_spend": "$120000",
						"Action" : ""
					},
					{
						"id" : "#12147",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "SilverHawk",
						"pro_img" : "build/img/priority/truellysell.svg",
						"client_img": "build/img/icons/company-icon-03.svg",
						"piority" : "0",
						"start_date" : "05 Oct 2025",
						"end_date" : "12 Oct 2025",
						"stage" : "0",
						"type" : "Web App",
						"status" : "0",
						"value": "$01,45,000",
						"hrs": "75",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-01.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$200000",
						"Action" : ""
					},
					{
						"id" : "#12148",
						"si_no" : "",
						"star" : "",
						"name" : "Servbook",
						"client" : "SummitPeak",
						"pro_img" : "build/img/priority/servbook.svg",
						"client_img": "build/img/icons/company-icon-04.svg",
						"piority" : "0",
						"start_date" : "14 Oct 2025",
						"end_date" : "24 Oct 2025",
						"stage" : "2",
						"type" : "Web App",
						"status" : "1",
						"value": "$02,15,000",
						"hrs": "60",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-13.jpg",
						"budget": "$300000",
						"currently_spend": "$60000",
						"Action" : ""
					},
					{
						"id" : "#12149",
						"si_no" : "",
						"star" : "",
						"name" : "DreamPOS",
						"client" : "RiverStone Ventur",
						"pro_img" : "build/img/priority/dream-pos.svg",
						"client_img": "build/img/icons/company-icon-05.svg",
						"piority" : "0",
						"start_date" : "15 Nov 2025",
						"end_date" : "22 Nov 2025",
						"stage" : "2",
						"type" : "Web App",
						"status" : "2",
						"value": "$03,64,000",
						"hrs": "72",
						"mem_image1" : "build/img/profiles/avatar-10.jpg",
						"mem_image2": "build/img/profiles/avatar-11.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$120000",
						"currently_spend": "$40000",
						"Action" : ""
					},
					{
						"id" : "#12150",
						"si_no" : "",
						"star" : "",
						"name" : "Kofejob",
						"client" : "CoastalStar Co.",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-06.svg",
						"piority" : "0",
						"start_date" : "25 Nov 2025",
						"end_date" : "09 Dec 2025",
						"stage" : "1",
						"type" : "Meeting",
						"status" : "0",
						"value": "$02,12,000",
						"hrs": "96",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-09.jpg",
						"mem_image3": "build/img/profiles/avatar-08.jpg",
						"budget": "$200000",
						"currently_spend": "$90000",
						"Action" : ""
					},
					{
						"id" : "#12151",
						"si_no" : "",
						"star" : "",
						"name" : "Doccure",
						"client" : "HarborView",
						"pro_img" : "build/img/priority/project-02.svg",
						"client_img": "build/img/icons/company-icon-07.svg",
						"piority" : "0",
						"start_date" : "08 Dec 2025",
						"end_date" : "16 Dec 2025",
						"stage" : "0",
						"type" : "Web App",
						"status" : "1",
						"value": "$04,18,000",
						"hrs": "85",
						"mem_image1" : "build/img/profiles/avatar-06.jpg",
						"mem_image2": "build/img/profiles/avatar-07.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$195000",
						"Action" : ""
					},
					{
						"id" : "#12152",
						"si_no" : "",
						"star" : "",
						"name" : "Best@laundry",
						"client" : "Golden Gate Ltd",
						"pro_img" : "build/img/priority/best.svg",
						"client_img": "build/img/icons/company-icon-08.svg",
						"piority" : "0",
						"start_date" : "21 Dec 2025",
						"end_date" : "13 Jan 2024",
						"stage" : "0",
						"type" : "Meeting",
						"status" : "2",
						"value": "$01,23,000",
						"hrs": "65",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-05.jpg",
						"budget": "$230000",
						"currently_spend": "$220000",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "POS",
						"client" : "CoastalStar Inc",
						"pro_img" : "build/img/priority/dream-pos.svg",
						"client_img": "build/img/icons/company-icon-06.svg",
						"piority" : "0",
						"start_date" : "01 Jan 2024",
						"end_date" : "11 Jan 2024",
						"stage" : "1",
						"type" : "Web App",
						"status" : "1",
						"value": "$03,64,000",
						"hrs": "60",
						"mem_image1" : "build/img/profiles/avatar-08.jpg",
						"mem_image2": "build/img/profiles/avatar-12.jpg",
						"mem_image3": "build/img/profiles/avatar-04.jpg",
						"budget": "$200000",
						"currently_spend": "$177777 ",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "Bookserv",
						"client" : "Redwood Inc",
						"pro_img" : "build/img/priority/servbook.svg",
						"client_img": "build/img/icons/company-icon-09.svg",
						"piority" : "0",
						"start_date" : "12 Jan 2024",
						"end_date" : "29 Jan 2024",
						"stage" : "1",
						"type" : "Meeting",
						"status" : "1",
						"value": " $04,10,000",
						"hrs": "56",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-14.jpg",
						"mem_image3": "build/img/profiles/avatar-01.jpg",
						"budget": "$300000",
						"currently_spend": "$100000 ",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "Dreamchat",
						"client" : "Redwood Inc",
						"pro_img" : "build/img/priority/sports.svg",
						"client_img": "build/img/icons/company-icon-09.svg",
						"piority" : "0",
						"start_date" : "16 Jan 2024",
						"end_date" : "25 Jan 2024",
						"stage" : "1",
						"type" : "Meeting",
						"status" : "1",
						"value": "$02,19,000",
						"hrs": "55",
						"mem_image1" : "build/img/profiles/avatar-08.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-12.jpg",
						"budget": "$400000",
						"currently_spend": "$200000 ",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "Sports",
						"client" : "Ventur",
						"pro_img" : "build/img/priority/best.svg",
						"client_img": "build/img/icons/company-icon-08.svg",
						"piority" : "0",
						"start_date" : "12 Jan 2024",
						"end_date" : "29 Jan 2024",
						"stage" : "1",
						"type" : "Web App",
						"status" : "1",
						"value": "$01,23,000",
						"hrs": "63",
						"mem_image1" : "build/img/profiles/avatar-01.jpg",
						"mem_image2": "build/img/profiles/avatar-11.jpg",
						"mem_image3": "build/img/profiles/avatar-14.jpg",
						"budget": "$300000",
						"currently_spend": "$100000 ",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium"><a href="project_details" class="avatar border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['pro_img']+'" alt="User Image"></a><a href="project_details">'+row['name']+'</a></h6>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium"><a href="company_details" class="avatar avatar-sm border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['client']+'</a></h6>';
				}},   
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "danger";var status_name ="High" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Medium" }  else { var class_name = "success";var status_name ="Low"}
					return '<span class="priority badge badge-tag badge-soft-'+class_name+'" ><i class="ti ti-square-rounded-filled me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "start_date" },                 
				{ "data": "end_date" },
				{
					"render": function (data, type, row) {
							if(row['stage'] == "0") { var class_name = "success";var status_name ="Completed" } else if(row['stage'] == "1") { var class_name = "info";var status_name ="Develop" } else if(row['stage'] == "2") { var class_name = "warning";var status_name ="Design"}  else  { var class_name = "violet";var status_name ="Plan"}
					return '<div class="pipeline-progress d-flex align-items-center"><div class="progress"><div class="progress-bar progress-bar-'+class_name+'" role="progressbar"></div></div><span>'+status_name+'</span></div>';
					}
				},   
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" }  else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},       
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item " data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_project"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-clipboard-copy text-green"></i> Clone this Project</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-subtask"></i> Add New Task</a></div></div>';
				}},
				
			]
				
		});
	}
	// Estimations List

	if($('#estimations-list').length > 0) {
		$('#estimations-list').DataTable({
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
						"id" : "#274738",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "NovaWave LLC",
						"Amount" : "$2,15,000",
						"pro_img" : "build/img/priority/truellysel.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"expiry_date" : "25 Sep 2025",
						"date" : "15 Oct 2025",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_no" : "Facility Manager",	
						"status": "3",
						"status_no" : "Sent",					
						"Action" : ""
					},
					{
						"id" : "#274737",
						"si_no" : "",
						"star" : "",
						"name" : "Dreamschat",
						"client" : "BlueSky Industries",
						"Amount" : "$1,45,000",
						"pro_img" : "build/img/priority/dreamchat.svg",
						"client_img": "build/img/icons/company-icon-02.svg",
						"expiry_date" : "10 Sep 2028",
						"date" : "19 Oct 2025",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Installer",
						"status" : "0",						
						"status_no" : "Accepted",						
						"Action" : ""
					},
					{
						"id" : "#274736",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "Silver Hawk",
						"Amount" : "$2,15,000",
						"pro_img" : "build/img/priority/truellysell.svg",
						"client_img": "build/img/icons/company-icon-03.svg",
						"expiry_date" : "20 Oct 2026",
						"date" : "24 Oct 2025",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_no" : "Senior  Manager",		
						"status" : "1",				
						"status_no" : "Draft",				
						"Action" : ""
					},
					{
						"id" : "#274735",
						"si_no" : "",
						"star" : "",
						"name" : "Servbook",
						"client" : "Summit  Peak",
						"Amount" : "$4,80,380",
						"pro_img" : "build/img/priority/servbook.svg",
						"client_img": "build/img/icons/company-icon-04.svg",
						"expiry_date" : "07 Oct 2028",
						"date" : "10 Nov 2025",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_no" : "Test Engineer",
						"status" : "0",						
						"status_no" : "Accepted",						
						"Action" : ""
					},
					{
						"id" : "#274734",
						"si_no" : "",
						"star" : "",
						"name" : "DreamPOS",
						"client" : "RiverStone Ventur",
						"Amount" : "$2,12,000",
						"pro_img" : "build/img/priority/dream-pos.svg",
						"client_img": "build/img/icons/company-icon-05.svg",
						"expiry_date" : "10 Oct 2026",
						"date" : "18 Nov 2025",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "UI /UX Designer",
						"status" : "2",						
						"status_no" : "Declined",						
						"Action" : ""
					},
					{
						"id" : "#274733",
						"si_no" : "",
						"star" : "",
						"name" : "Kofejob",
						"client" : "CoastalStar Co.",
						"Amount" : "$3,50,000",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-07.svg",
						"expiry_date" : "18 Oct 2027",
						"date" : "20 Nov 2025",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_no" : "Technician",
						"status" : "1",						
						"status_no" : "Draft",						
						"Action" : ""
					},
					{
						"id" : "#274732",
						"si_no" : "",
						"star" : "",
						"name" : "Doccure",
						"client" : "HarborView",
						"Amount" : "$1,23,000",
						"pro_img" : "build/img/priority/project-02.svg",
						"client_img": "build/img/icons/company-icon-08.svg",
						"expiry_date" : "05 Nov 2026",
						"date" : "07 Dec 2025",
						"customer_name" : "Rachel Hampton",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_no" : "Software Developer",
						"status" : "3",						
						"status_no" : "Sent",						
						"Action" : ""
					},
					{
						"id" : "#274731",
						"si_no" : "",
						"star" : "",
						"name" : "Best@laundry",
						"client" : "Golden Gate Ltd",
						"Amount" : "$3,12,50",
						"pro_img" : "build/img/priority/best.svg",
						"client_img": "build/img/icons/company-icon-09.svg",
						"expiry_date" : "11 Nov 2028",
						"date" : "14 Dec 2025",
						"customer_name" : "Jonelle Curtiss",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_no" : "Supervisor",
						"status" : "0",						
						"status_no" : "Accepted",						
						"Action" : ""
					},
					{
						"id" : "#274730",
						"si_no" : "",
						"star" : "",
						"name" : "Dreamsports",
						"client" : "Golden Gate Ltd",
						"Amount" : "$4,18,000",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-10.svg",
						"expiry_date" : "20 Nov 2027",
						"date" : "22 Dec 2025",
						"customer_name" : "Jonathan Smith",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_no" : "Team Lead Dev",
						"status" : "2",						
						"status_no" : "Declined",						
						"Action" : ""
					},
					{
						"id" : "#274729",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "NovaWave LLC",
						"Amount" : "$4,80,380",
						"pro_img" : "build/img/priority/truellysel.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"expiry_date" : "25 Nov 2026",
						"date" : "28 Dec 2025",
						"customer_name" : "Brook Carter",
						"customer_image" : "build/img/profiles/avatar-01.jpg",
						"customer_no" : "Team Lead Dev",
						"status" : "0",						
						"status_no" : "Accepted",						
						"Action" : ""
					},
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					 return '<a href="#" class="title-name">'+row['id']+'</a>';
					// if(row['id'] == "0") { var class_name = "add-popups"; } else if(row['status'] == "1") { var class_name = "warning" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Declined" } else if(row['status'] == "3") { var class_name = "violet";var status_name ="Sent" }
					// return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+id+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="company_details" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['client']+'</a></h2>';
				}},
				{ "data": "Amount" },
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="#" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['pro_img']+'" alt="User Image"></a><a href="#">'+row['name']+'</a></h2>';
				}},   
				{ "data": "date" },                 
				{ "data": "expiry_date" },
				  				
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="#" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="'+row['customer_image']+'" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">'+row['customer_name']+'<span class="text-default">'+row['customer_no']+' </span></a></h2>';
				}}, 
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Accepted" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Draft" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Declined" } else if(row['status'] == "3") { var class_name = "violet";var status_name ="Sent" }
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},       
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_estimations"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-clipboard-copy text-violet"></i> View Estimation</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks text-green"></i> Mark as Accpeted</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file"></i> Mark as Draft</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker text-blue"></i> Mark as Declined</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer text-info"></i> Print</a></div></div>';
				}},
				
			]
				
		});
	}

	// Proposals List

	if($('#proposals-list').length > 0) {
		$('#proposals-list').DataTable({
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
						"id" : "#1493024",
						"si_no" : "",
						"star" : "",
						"subject" : "SEO Proposal",
						"sent_to" : "NovaWave LLC",
						"pro_img" : "build/img/priority/truellysel.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"total_value" : "$2,05,426",
						"project" : "Truelysell",
						"piority" : "0",
						"created_date": "21 May 2024",
						"date" : "15 May 2024",
						"open_till" : "15 Aug 2025",
						"status" : "0",
						"status_name" : "Accepted",
						"Action" : ""
					},
					{
						"id" : "#1493023",
						"si_no" : "",
						"star" : "",
						"subject" : "Web Design",
						"sent_to" : "Redwood Inc",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-10.svg",
						"total_value" : "$2,105",
						"project" : "Dreamsports",
						"piority" : "0",
						"created_date": "15 Apr 2024",
						"date" : "16 Jan 2024",
						"open_till" : "15 Sep 2024",
						"status" : "1",
						"status_name" : "Declined",
						"Action" : ""
					},
					{
						"id" : "#1493022",
						"si_no" : "",
						"star" : "",
						"subject" : "Logo & Branding",
						"sent_to" : "HarborView",
						"pro_img" : "build/img/priority/best.svg",
						"client_img": "build/img/icons/company-icon-08.svg",
						"total_value" : "$4,05,656",
						"project" : "Best@laundry",
						"piority" : "0",
						"created_date": "12  Mar 2024",
						"date" : "17 Sep 2024",
						"open_till" : "15 Nov 2024",
						"status" : "2",
						"status_name" : "Deleted",
						"Action" : ""
					},
					{
						"id" : "#1493021",
						"si_no" : "",
						"star" : "",
						"subject" : "Development",
						"sent_to" : "CoastalStar Co.",
						"pro_img" : "build/img/priority/project-02.svg",
						"client_img": "build/img/icons/company-icon-07.svg",
						"total_value" : "$2,05,426",
						"project" : "Doccure",
						"piority" : "0",
						"created_date": "15 Feb 2024",
						"date" : "18 May 2024",
						"open_till" : "15 Jun 2024",
						"status" : "4",
						"status_name" : "Draft",
						"Action" : ""
					},
					{
						"id" : "#1493020",
						"si_no" : "",
						"star" : "",
						"subject" : "SEO Proposal",
						"sent_to" : "RiverStone Ventur",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-05.svg",
						"total_value" : "$3,15,145",
						"project" : "Kofejob",
						"piority" : "0",
						"created_date": "15 Jan 2024",
						"date" : "19 Aug 2024",
						"open_till" : "15 Oct 2024",
						"status" : "3",
						"status_name" : "Sent",
						"Action" : ""
					},
					{
						"id" : "#1493019",
						"si_no" : "",
						"star" : "",
						"subject" : "Web Design",
						"sent_to" : "Summit  Peak",
						"pro_img" : "build/img/priority/dream-pos.svg",
						"client_img": "build/img/icons/company-icon-04.svg",
						"total_value" : "$6,154",
						"project" : "DreamPOS",
						"piority" : "0",
						"created_date": "15 Dec 2025",
						"date" : "20 May 2024",
						"open_till" : "08 Aug 2024",
						"status" : "4",
						"status_name" : "Draft",
						"Action" : ""
					},
					{
						"id" : "#1493018",
						"si_no" : "",
						"star" : "",
						"subject" : "Logo",
						"sent_to" : "Silver Hawk",
						"pro_img" : "build/img/priority/servbook.svg",
						"client_img": "build/img/icons/company-icon-03.svg",
						"total_value" : "$1,457",
						"project" : "Servbook",
						"piority" : "0",
						"created_date": "15 Nov 2025",
						"date" : "22 Aug 2024",
						"open_till" : "25 Jan 2025",
						"status" : "5",
						"status_name" : "Open",
						"Action" : ""
					},
					{
						"id" : "#1493017",
						"si_no" : "",
						"star" : "",
						"subject" : "Branding",
						"sent_to" : "BlueSky Industries",
						"pro_img" : "build/img/priority/truellysell.svg",
						"client_img": "build/img/icons/company-icon-02.svg",
						"total_value" : "$2,01,464",
						"project" : "Truelysell",
						"piority" : "0",
						"created_date": "15 Sep 2025",
						"date" : "15 May 2024",
						"open_till" : "12 Aug 2024",
						"status" : "0",
						"status_name" : "Accepted",
						"Action" : ""
					},
					{
						"id" : "#1493018",
						"si_no" : "",
						"star" : "",
						"subject" : "Development",
						"sent_to" : "Golden Gate Ltd",
						"pro_img" : "build/img/priority/dreamchat.svg",
						"client_img": "build/img/icons/company-icon-09.svg",
						"total_value" : "$1,10,145",
						"project" : "Dreamschat",
						"piority" : "0",
						"created_date": "15 Aug 2025",
						"date" : "14 Aug 2024",
						"open_till" : "07 Dec 2024 ",	
						"status" : "1",
						"status_name" : "Declined",
						"Action" : ""
					},
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name" >'+row['id']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name">'+row['subject']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fw-medium fs-14"><a href="company_details" class="avatar avatar-sm border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['sent_to']+'</a></h6>';
				}},
				{ "data": "total_value" },  
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fw-medium fs-14"><a href="#" class="avatar avatar-sm border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['pro_img']+'" alt="User Image"></a><a href="#">'+row['project']+'</a></h6>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Accepted" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Declined" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Deleted" } else if(row['status'] == "3") { var class_name = "green";var status_name ="Sent" } else if(row['status'] == "4") { var class_name = "info";var status_name ="Draft" } else { var class_name = "purple";var status_name ="Paused"} 
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},      
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_proposals"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-clipboard-copy text-green"></i> View Proposal</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Accpeted</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file text-tertiary"></i> Mark as Draft</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker text-blue"></i> Mark ad Declined</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-subtask text-pink"></i> Convert to estimate</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-invoice text-tertiary"></i> Convert to Invoice</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a></div></div>';
				}},
				
			]
				
		});
	}

	// Contracts List

	if($('#contracts-list').length > 0) {
		$('#contracts-list').DataTable({
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
						"id" : "#1493024",
						"si_no" : "",
						"star" : "",
						"subject" : "SEO Proposal",
						"customer" : "NovaWave LLC",
						"client_img": "build/img/icons/company-icon-01.svg",
						"contract_type" : "Contracts under Seal",
						"contract_value" : "$2,05,426",
						"date" : "15 Aug 2024",
						"end_date" : "15 May 2024",
						"Action" : ""
					},
					{
						"id" : "#1493023",
						"si_no" : "",
						"star" : "",
						"subject" : "Web Design",
						"customer" : "Redwood Inc",
						"client_img": "build/img/icons/company-icon-10.svg",
						"contract_type" : "Implied Contracts",
						"contract_value" : "$2,105",
						"date" : "15 Sep 2024",
						"end_date" : "15 Apr 2024",
						"Action" : ""
					},
					{
						"id" : "#1493022",
						"si_no" : "",
						"star" : "",
						"subject" : "Logo & Branding",
						"customer" : "HarborView",
						"client_img": "build/img/icons/company-icon-08.svg",
						"contract_type" : "Implied Contracts",
						"contract_value" : "$4,05,656",
						"date" : "15 Nov 2024",
						"end_date" : "15 Mar 2024",
						"Action" : ""
					},
					{
						"id" : "#1493021",
						"si_no" : "",
						"star" : "",
						"subject" : "Development",
						"customer" : "CoastalStar Co.",
						"client_img": "build/img/icons/company-icon-07.svg",
						"contract_type" : "Executory Contracts",
						"contract_value" : "$2,05,426",
						"date" : "15 Jun 2024",
						"end_date" : "15 Feb 2024",
						"Action" : ""
					},
					{
						"id" : "#1493020",
						"si_no" : "",
						"star" : "",
						"subject" : "SEO Proposal",
						"customer" : "RiverStone Ventur",
						"client_img": "build/img/icons/company-icon-05.svg",
						"contract_type" : "Voidable Contracts",
						"contract_value" : "$3,15,145",
						"date" : "15 Oct 2024",
						"end_date" : "15 Jan 2024",
						"Action" : ""
					},
					{
						"id" : "#1493019",
						"si_no" : "",
						"star" : "",
						"subject" : "Web Design",
						"customer" : "Summit  Peak",
						"client_img": "build/img/icons/company-icon-04.svg",
						"contract_type" : "Unilateral Contracts",
						"contract_value" : "$6,154",
						"date" : "08 Aug 2024",
						"end_date" : "15 Dec 2025",
						"Action" : ""
					},
					{
						"id" : "#1493018",
						"si_no" : "",
						"star" : "",
						"subject" : "Logo",
						"customer" : "Silver Hawk",
						"client_img": "build/img/icons/company-icon-03.svg",
						"contract_type" : "Unconscionable",
						"contract_value" : "$1,457",
						"date" : "25 Jan 2025 ",
						"end_date" : "15 Nov 2025",
						"Action" : ""
					},
					{
						"id" : "#1493017",
						"si_no" : "",
						"star" : "",
						"subject" : "Branding",
						"customer" : "BlueSky Industries",
						"client_img": "build/img/icons/company-icon-02.svg",
						"contract_type" : "Express Contracts",
						"contract_value" : "$2,01,464",
						"date" : "12 Aug 2024",
						"end_date" : "15 Sep 2025",
						"Action" : ""
					},
					{
						"id" : "#1493018",
						"si_no" : "",
						"star" : "",
						"subject" : "Development",
						"customer" : "Golden Gate Ltd",
						"client_img": "build/img/icons/company-icon-09.svg",
						"contract_type" : "Contracts under Seal",
						"contract_value" : "$1,10,145",
						"date" : "07 Dec 2024",
						"end_date" : "15 Aug 2025 ",
						"Action" : ""
					},
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name">'+row['id']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name">'+row['subject']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fw-medium fs-14"><a href="company_details" class="avatar border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['customer']+'</a></h6>';
				}},                  
				{ "data": "contract_type" },                 
				{ "data": "date" },                 
				{ "data": "end_date" },				
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy text-tertiary"></i> Clone</a><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy text-violet"></i> View Contract</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a></div></div>';
				}},
				
			]
				
		});
	}

	// Proposals List

	if($('#invoices-list').length > 0) {
		$('#invoices-list').DataTable({
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
						"id" : "#1254058",
						"si_no" : "",
						"star" : "",
						"sent_to" : "NovaWave LLC",
						"pro_img" : "build/img/priority/truellysel.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"amount" : "$2,15,000",
						"paid_amount" : "$2,15,000",
						"balance_amount" : "$0",
						"project" : "Truelysell",
						"due_date": "21 May 2024",
						"status" : "1",
						"status_name" : "Partially Paid",
						"Action" : ""
					},
					{
						"id" : "#1254057",
						"si_no" : "",
						"star" : "",
						"sent_to" : "BlueSky Industries",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-10.svg",
						"amount" : "$1,45,000",
						"paid_amount" : "$1,45,000",
						"balance_amount" : "$0",
						"project" : "Dreamschat",
						"due_date" : "19 Oct 2025",
						"status" : "0",
						"status_name" : "Paid",
						"Action" : ""
					},
					{
						"id" : "#1254056",
						"si_no" : "",
						"star" : "",
						"sent_to" : "Silver Hawk",
						"pro_img" : "build/img/priority/best.svg",
						"client_img": "build/img/icons/company-icon-08.svg",
						"amount" : "$2,15,000",
						"paid_amount" : "$1,00,000",
						"balance_amount" : "$1,15,000",
						"project" : "Truelysell",
						"due_date" : "24 Oct 2025",
						"status" : "1",
						"status_name" : "Partially Paid",
						"Action" : ""
					},
					{
						"id" : "#1254055",
						"si_no" : "",
						"star" : "",
						"sent_to" : "Summit  Peak",
						"pro_img" : "build/img/priority/project-02.svg",
						"client_img": "build/img/icons/company-icon-07.svg",
						"amount" : "$4,80,380",
						"paid_amount" : "$4,80,380",
						"balance_amount" : "$0",
						"project" : "Servbook",
						"due_date" : "10 Nov 2025",
						"status" : "0",
						"status_name" : "Paid",
						"Action" : ""
					},
					{
						"id" : "#1254054",
						"si_no" : "",
						"star" : "",
						"sent_to" : "RiverStone Ventur",
						"pro_img" : "build/img/priority/project-01.svg",
						"client_img": "build/img/icons/company-icon-05.svg",
						"amount" : "$2,12,000",
						"paid_amount" : "$0",
						"balance_amount" : "$2,12,000",
						"project" : "DreamPOS",
						"due_date" : "18 Nov 2025",
						"status" : "2",
						"status_name" : "Unpaid",
						"Action" : ""
					},
					{
						"id" : "#1254053",
						"si_no" : "",
						"star" : "",
						"sent_to" : "CoastalStar Co.",
						"pro_img" : "build/img/priority/dream-pos.svg",
						"client_img": "build/img/icons/company-icon-04.svg",
						"amount" : "$3,50,000",
						"paid_amount" : "$1,50,000",
						"balance_amount" : "$2,00,000",
						"project" : "Kofejob",
						"due_date" : "20 Nov 2025",
						"status" : "1",
						"status_name" : "Partially Paid",
						"Action" : ""
					},
					{
						"id" : "#1254052",
						"si_no" : "",
						"star" : "",
						"sent_to" : "HarborView",
						"pro_img" : "build/img/priority/servbook.svg",
						"client_img": "build/img/icons/company-icon-03.svg",
						"amount" : "$1,23,000",
						"paid_amount" : "$1,23,000",
						"balance_amount" : "$1,23,000",
						"project" : "Doccure",
						"due_date" : "07 Dec 2025",
						"status" : "3",
						"status_name" : "Overdue",
						"Action" : ""
					},
					{
						"id" : "#1254051",
						"si_no" : "",
						"star" : "",
						"sent_to" : "Golden Gate Ltd",
						"pro_img" : "build/img/priority/truellysell.svg",
						"client_img": "build/img/icons/company-icon-02.svg",
						"amount" : "$3,12,500",
						"paid_amount" : "$3,12,500",
						"balance_amount" : "$0",
						"project" : "Best@laundry",
						"due_date" : "14 Dec 2025",
						"status" : "0",
						"status_name" : "Paid",
						"Action" : ""
					},
					{
						"id" : "#1254050",
						"si_no" : "",
						"star" : "",
						"sent_to" : "Redwood Inc",
						"pro_img" : "build/img/priority/dreamchat.svg",
						"client_img": "build/img/icons/company-icon-09.svg",
						"amount" : "$4,18,000",
						"paid_amount" : "$0",
						"balance_amount" : "$4,18,000",
						"project" : "Dreamsports",
						"due_date" : "22 Dec 2025",
						"open_till" : "07 Dec 2024 ",	
						"status" : "2",
						"status_name" : "Unpaid",
						"Action" : ""
					},
					{
						"id" : "#1254049",
						"si_no" : "",
						"star" : "",
						"sent_to" : "NovaWave LLC",
						"pro_img" : "build/img/priority/dreamchat.svg",
						"client_img": "build/img/icons/company-icon-01.svg",
						"amount" : "$5,00,000",
						"paid_amount" : "$5,00,000",
						"balance_amount" : "$0",
						"project" : "Truelysell",
						"due_date" : "28 Dec 2025",	
						"status" : "0",
						"status_name" : "Paid",
						"Action" : ""
					},
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name">'+row['id']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="company_details" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['sent_to']+'</a></h2>';
				}},				  
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="#" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['pro_img']+'" alt="User Image"></a><a href="#">'+row['project']+'</a></h2>';
				}},
				{ "data": "due_date" },    
				{ "data": "amount" },    
				{ "data": "paid_amount" },    
				{ "data": "balance_amount" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "success";var status_name ="Paid" } else if(row['status'] == "1") { var class_name = "warning";var status_name ="Partially Paid" } else if(row['status'] == "2") { var class_name = "danger";var status_name ="Unpaid" } else if(row['status'] == "3") { var class_name = "violet";var status_name ="Overdue" }  
					return '<span class="badge badge-pill badge-status bg-'+class_name+'" >'+status_name+'</span>';
				}},      
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item " data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit" href="#"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash"></i> Delete</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-clipboard-copy text-green"></i> View Invoices</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks text-success"></i> Mark as Paid</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file text-tertiary"></i> Mark as Partially Paid</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker text-blue"></i> Mark ad Unpaid</a><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer text-info"></i> Print</a></div></div>';
				}},
				
			]
				
		});
	}

	// Contracts List

	if($('#payments-list').length > 0) {
		$('#payments-list').DataTable({
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
						"invoice_id" : "#1254058",
						"customer" : "NovaWave LLC",
						"client_img": "build/img/icons/company-icon-01.svg",
						"amount" : "$2500",
						"due_date" : "15 Oct 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID1234567890",
						"Action" : ""
					},
					{
						"id" : 2,
						"invoice_id" : "#1254057",
						"customer" : "BlueSky Industries",
						"client_img": "build/img/icons/company-icon-02.svg",
						"amount" : "$1450",
						"due_date" : "19 Oct 2025",
						"payment_method" : "Credit",
						"transaction_id" : "TXNID9876543210",
						"Action" : ""
					},
					{
						"id" : 3,
						"invoice_id" : "#1254056",
						"customer" : "Silver Hawk",
						"client_img": "build/img/icons/company-icon-03.svg",
						"amount" : "$2100",
						"due_date" : "24 Oct 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID2468135790",
						"Action" : ""
					},
					{
						"id" : 4,
						"invoice_id" : "#1254055",
						"customer" : "Summit Peak",
						"client_img": "build/img/icons/company-icon-04.svg",
						"amount" : "$4000",
						"due_date" : "10 Nov 2025",
						"payment_method" : "Credit",
						"transaction_id" : "TXNID1357924680",
						"Action" : ""
					},
					{
						"id" : 5,
						"invoice_id" : "#1254054",
						"customer" : "RiverStone Ventur",
						"client_img": "build/img/icons/company-icon-05.svg",
						"amount" : "$2120",
						"due_date" : "18 Nov 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID0123456789",
						"Action" : ""
					},
					{
						"id" : 6,
						"invoice_id" : "#1254053",
						"customer" : "CoastalStar Co.",
						"client_img": "build/img/icons/company-icon-04.svg",
						"amount" : "$3500",
						"due_date" : "20 Nov 2025",
						"payment_method" : "Credit",
						"transaction_id" : "TXNIDABCDE12345",
						"Action" : ""
					},
					{
						"id" : 7,
						"invoice_id" : "#1254052",
						"customer" : "HarborView",
						"client_img": "build/img/icons/company-icon-03.svg",
						"amount" : "$1230",
						"due_date" : "07 Dec 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID54321XYZ789",
						"Action" : ""
					},
					{
						"id" : 8,
						"invoice_id" : "#1254051",
						"customer" : "Golden Gate Ltd",
						"client_img": "build/img/icons/company-icon-02.svg",
						"amount" : "$3125",
						"due_date" : "14 Dec 2025",
						"payment_method" : "Credit",
						"transaction_id" : "TXNIDQWERTY0987",
						"Action" : ""
					},
					{
						"id" : 9,
						"invoice_id" : "#1254050",
						"customer" : "Redwood Inc",
						"client_img": "build/img/icons/company-icon-10.svg",
						"amount" : "$4180",
						"due_date" : "22 Dec 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID98765ASDF43",
						"Action" : ""
					},
					{
						"id" : 10,
						"invoice_id" : "#1254049",
						"customer" : "NovaWave LLC",
						"client_img": "build/img/icons/company-icon-05.svg",
						"amount" : "$5000",
						"due_date" : "28 Dec 2025",
						"payment_method" : "Cash",
						"transaction_id" : "TXNID1A2B3C4D5E6",
						"Action" : ""
					},			
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<a href="#" class="title-name">'+row['invoice_id']+'</a>';
				}},
				
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium"><a href="company_details" class="avatar avatar-sm border rounded-circle me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['customer']+'</a></h6>';
				}},  
				{ "data": "amount" },                 
				{ "data": "due_date" },                 
				{ "data": "payment_method" },                 
				{ "data": "transaction_id" },				
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-eye text-indigo"></i> Preview</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_payments"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
				
			]
				
		});
	}

	// Analytics Contact

	if($('#analytic-contact').length > 0) {
		$('#analytic-contact').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"lead_name" : "Elizabeth Morgan",
					"lead_city" : "Product Manager",
					"lead_img" : "build/img/profiles/avatar-09.jpg",
					"phone" : "+1 87545 54503",
					"email" : "caroo3@example.com",
					"date" : "10 May 2025"
				},
				{
					"id" : 2,
					"lead_name" : "Katherine Brooks",
					"lead_city" : "Installer",
					"lead_img" : "build/img/profiles/avatar-22.jpg",
					"phone" : "+1 98975 17485",
					"email" : "dercha@example.com",
					"date" : "02 May 2025"
				},
				{
					"id" : 3,
					"lead_name" : "Samantha Reed",
					"lead_city" : "Human Resources",
					"lead_img" : "build/img/profiles/avatar-08.jpg",
					"phone" : "+1 54655 25455",
					"email" : "rael@example.com",
					"date" : "28 Apr 2025"
				},
				{
					"id" : 4,
					"lead_name" : "William Anderson",
					"lead_city" : "Data Analytics",
					"lead_img" : "build/img/profiles/avatar-24.jpg",
					"phone" : "+1 45447 58787",
					"email" : "joe@example.com",
					"date" : "16 Apr 2025"
				},
				{
					"id" : 5,
					"lead_name" : "Jonathan Mitchell",
					"lead_city" : "Facility Manager",
					"lead_img" : "build/img/profiles/avatar-23.jpg",
					"phone" : "+1 12454 27845",
					"email" : "rael@example.com",
					"date" : "05 Apr 2025"
				}
		
			],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="d-flex align-items-center"><a href="contact_details" class="avatar"><img class="img-fluid rounded-circle" src="'+row['lead_img']+'" alt="User Image"></a><div class="ms-2"><h6 class="fs-14 fw-medium mb-1"><a href="contact_details" class="d-flex flex-column fw-medium">'+row['lead_name']+'</a></h6><span class="text-body fs-13 d-inline-block">'+row['lead_city']+' </span></div></div>';
				}},
				{ "data": "phone" },
				{ "data": "date" }
			]
		});
	}

	// Analytics Deal

	if($('#analytic-deal').length > 0) {
		$('#analytic-deal').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"name" : "Collins",
					"stage" : "Conversation",
					"value" : "$04,51,000",
					"probability" : "85%",
					"email" : "caroo3@example.com",
					"status" : "0"
				},
				{
					"id" : 2,
					"name" : "Konopelski",
					"stage" : "Pipeline",
					"value" : "$04,14,800",
					"probability" : "15%",
					"status" : "1"
				},
				{
					"id" : 3,
					"name" : "Adams",
					"stage" : "Won",
					"value" : "$04,14,800",
					"probability" : "95%",
					"status" : "2"
				},
				{
					"id" : 4,
					"name" : "Schumm",
					"stage" : "Lost",
					"value" : "$9,14,400",
					"probability" : "47%",
					"status" : "2"
				},
				{
					"id" : 5,
					"name" : "Wisozk",
					"stage" : "Follow Up",
					"value" : "$11,14,400",
					"probability" : "98%",
					"status" : "2"
				}
		
			],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<a href="deals_details"> '+row['name']+'</a>';
				}},
				{ "data": "stage" },
				{ "data": "value" },
				{ "data": "probability" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-info";var status_name ="Open" } else if(row['status'] == "1") { var class_name = "bg-danger";var status_name ="Lost" } else { var class_name = "bg-success";var status_name ="Won"}
					return '<span class="badge badge-pill badge-status '+class_name+'" > '+status_name+'</span>';
				}},
			]
		});
	}

	// Analytics Company

	if($('#analytic-company').length > 0) {
		$('#analytic-company').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"lead_name" : "NovaWaveLLC",
					"lead_img" : "build/img/icons/company-icon-01.svg",
					"phone" : "+1 87545 54503",
					"email" : "caroo3@example.com",
					"date" : "10 May 2025"
				},
				{
					"id" : 2,
					"lead_name" : "BlueSky Industries",
					"lead_img" : "build/img/icons/company-icon-02.svg",
					"phone" : "+1 98975 17485",
					"email" : "dercha@example.com",
					"date" : "02 May 2025"
				},
				{
					"id" : 3,
					"lead_name" : "Silver Hawk",
					"lead_img" : "build/img/icons/company-icon-03.svg",
					"phone" : "+1 54655 25455",
					"email" : "rael@example.com",
					"date" : "28 Apr 2025"
				},
				{
					"id" : 4,
					"lead_name" : "Summit  Peak",
					"lead_img" : "build/img/icons/company-icon-04.svg",
					"phone" : "+1 45447 58787",
					"email" : "joe@example.com",
					"date" : "16 Apr 2025"
				},
				{
					"id" : 5,
					"lead_name" : "RiverStone Ltd",
					"lead_img" : "build/img/icons/company-icon-05.svg",
					"phone" : "+1 12454 27845",
					"email" : "joe@example.com",
					"date" : "05 Apr 2025"
				},
				{
					"id" : 6,
					"lead_name" : "Redwood Inc",
					"lead_img" : "build/img/icons/company-icon-06.svg",
					"phone" : "+1 46789 27845",
					"email" : "sharon@example.com",
					"date" : "15 Nov 2025"
				}
		
			],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="d-flex align-items-center"><a href="company_details" class="avatar avatar-rounded border"><img class="w-auto h-auto" src="'+row['lead_img']+'" alt="User Image"></a><div class="ms-2"><h6 class="fs-14 fw-medium mb-0"><a href="company_details">'+row['lead_name']+'</a></h6></div></div>';
				}},
				{ "data": "phone" },
				{ "data": "date" }
			]
		});
	}

	// Analytics Lead

	if($('#analytic-lead').length > 0) {
		$('#analytic-lead').DataTable({
			"bFilter": false, 
			"bInfo": false,
			"ordering": false,
			"paging":false,
			"data":[
				{
					"id" : 1,
					"name" : "Collins",
					"lead_name" : "NovaWaveLLC",
					"lead_img" : "build/img/icons/company-icon-01.svg",
					"lead_city" : "Newyork, USA",
					"phone" : "+1 87545 54503",
					"status" : "0"
				},
				{
					"id" : 2,
					"name" : "Konopelski",
					"lead_name" : "BlueSky",
					"lead_img" : "build/img/icons/company-icon-02.svg",
					"lead_city" : "Winchester, KY",
					"phone" : "+1 98975 17485",
					"status" : "2"
				},
				{
					"id" : 3,
					"name" : "Adams",
					"lead_name" : "Silver Hawk",
					"lead_img" : "build/img/icons/company-icon-03.svg",
					"lead_city" : "Jametown, NY",
					"phone" : "+1 54655 25455",
					"status" : "0"
				},
				{
					"id" : 4,
					"name" : "Schumm",
					"lead_name" : "Summit Peak",
					"lead_img" : "build/img/icons/company-icon-04.svg",
					"lead_city" : "Compton, RI",
					"phone" : "+1 45447 58787",
					"status" : "2"
				},
				{
					"id" : 5,
					"name" : "Wisozk",
					"lead_name" : "RiverStone Ltd",
					"lead_img" : "build/img/icons/company-icon-05.svg",
					"lead_city" : "Dayton, OH",
					"phone" : "+1 12454 27845",
					"status" : "0"
				}
		
			],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<a href="leads_details"> '+row['name']+'</a>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="d-flex align-items-center"><a href="leads_details" class="avatar avatar-rounded border"><img class="w-auto h-auto" src="'+row['lead_img']+'" alt="User Image"></a><div class="ms-2"><h6 class="fs-14 fw-medium mb-0"><a href="leads_details" class="d-flex flex-column">'+row['lead_name']+'</a></h6></div></div>';
				}},
				{ "data": "phone" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Closed" } else if(row['status'] == "1") { var class_name = "bg-pending";var status_name ="Not Contacted" } else { var class_name = "bg-warning";var status_name ="Contacted"}
					return '<span class="badge badge-pill text-white '+class_name+'" > '+status_name+'</span>';
				}},
			]
		});
	}

	// Activity

	if($('#activity-list').length > 0) {
		$('#activity-list').DataTable({
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
						"checkbox": "",
						"title" : "We scheduled a meeting for next week",
						"due_date" : "25 Sep 2025, 12:12 pm",
						"owner" : "Hendry Milner",
						"owner_image": "build/img/profiles/avatar-01.jpg",
						"created_date" : "22 Sep 2025, 10:14 am",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 2,
						"checkbox": "",
						"title" : "Had conversation with Fred regarding task",
						"due_date" : "29 Sep 2025, 04:12 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-26.jpg",
						"created_date" : "27 Sep 2025, 03:26 pm",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 3,
						"checkbox": "",
						"title" : "Analysing latest time estimation for new project",
						"due_date" : "11 Oct 2025, 05:00 pm",
						"owner" : "Guilory Berggren",
						"owner_image": "build/img/profiles/avatar-06.jpg",
						"created_date" : "03 Oct 2025, 03:53 pm",
						"status" : "1",
						"action": ""
					},
					{
						"id" : 4,
						"checkbox": "",
						"title" : "Store and manage contact data",
						"due_date" : "19 Oct 2025, 02:35 pm",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-13.jpg",
						"created_date" : "14 Oct 2025, 01:25 pm",
						"status" : "2",
						"action": ""
					},
					{
						"id" : 5,
						"checkbox": "",
						"title" : "Will have a meeting before project start",
						"due_date" : "27 Oct 2025, 12:30 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"created_date" : "21 Oct 2025, 03:00 pm",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 6,
						"checkbox": "",
						"title" : "Call John and discuss about project",
						"due_date" : "12 Nov 2025, 10:20 pm",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"created_date" : "02 Nov 2025, 05:35 pm",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 7,
						"checkbox": "",
						"title" : "Built landing pages",
						"due_date" : "25 Nov 2025, 01:40 pm",
						"owner" : "Martin Lewis",
						"owner_image": "build/img/profiles/avatar-20.jpg",
						"created_date" : "20 Nov 2025, 08:20 am",
						"status" : "2",
						"action": ""
					},
					{
						"id" : 8,
						"checkbox": "",
						"title" : "Regarding latest updates in project",
						"due_date" : "30 Nov 2025, 09:20 pm",
						"owner" : "Newell Egan",
						"owner_image": "build/img/profiles/avatar-15.jpg",
						"created_date" : "25 Nov 2025, 07:20 pm",
						"status" : "1",
						"action": ""
					},
					{
						"id" : 9,
						"checkbox": "",
						"title" : "Discussed budget proposal with Edwin",
						"due_date" : "08 Dec 2025, 04:35 pm",
						"owner" : "Janet Carlson",
						"owner_image": "build/img/profiles/avatar-04.jpg",
						"created_date" : "01 Dec 2025, 10:45 am",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 10,
						"checkbox": "",
						"title" : "Attach final proposal for upcoming project",
						"due_date" : "19 Dec 2025, 02:20 pm",
						"owner" : "Craig Brown",
						"owner_image": "build/img/profiles/avatar-21.jpg",
						"created_date" : "10 Dec 2025, 06:30 pm",
						"status" : "1",
						"action": ""
					},
					{
						"id" : 11,
						"checkbox": "",
						"title" : "Discussed budget proposal with Edwin",
						"due_date" : "26 Dec 2025, 08:30 am",
						"owner" : "Daniel Byrne",
						"owner_image": "build/img/profiles/avatar-23.jpg",
						"created_date" : "18 Dec 2025, 05:00 pm",
						"status" : "3",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "title" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "badge badge-soft-info border-0";var status_name ="Meeting";var icon_class_name = "user-share" } else if(row['status'] == "1") { var class_name = "badge badge-soft-warning border-0";var status_name ="Email";var icon_class_name = "mail" } else if(row['status'] == "2") { var class_name = "badge badge-soft-danger border-0";var status_name ="Task";var icon_class_name = "subtask" } else { var class_name = "badge badge-soft-success border-0";var status_name ="Calls";var icon_class_name = "phone" }
					return '<span class="badge activity-badge '+class_name+'" ><i class="ti ti-'+icon_class_name+' me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "due_date" },
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_activity"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
			]
		});
	}

	// Activity

	if($('#activity-calls').length > 0) {
		$('#activity-calls').DataTable({
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
						"id" : 2,
						"checkbox": "",
						"title" : "Had conversation with Fred regarding task",
						"due_date" : "29 Sep 2025, 04:12 pm",
						"owner" : "Guilory Berggren",
						"owner_image": "build/img/profiles/avatar-06.jpg",
						"created_date" : "27 Sep 2025, 03:26 pm",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 6,
						"checkbox": "",
						"title" : "Call John and discuss about project",
						"due_date" : "12 Nov 2025, 10:20 pm",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-13.jpg",
						"created_date" : "02 Nov 2025, 05:35 pm",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 9,
						"checkbox": "",
						"title" : "Discussed budget proposal with Edwin",
						"due_date" : "08 Dec 2025, 04:35 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"created_date" : "01 Dec 2025, 10:45 am",
						"status" : "3",
						"action": ""
					},
					{
						"id" : 11,
						"checkbox": "",
						"title" : "Discussed budget proposal with Edwin",
						"due_date" : "26 Dec 2025, 08:30 am",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"created_date" : "18 Dec 2025, 05:00 pm",
						"status" : "3",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "title" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "badge badge-soft-info border-0";var status_name ="Meeting";var icon_class_name = "user-share" } else if(row['status'] == "1") { var class_name = "badge badge-soft-warning border-0";var status_name ="Email";var icon_class_name = "mail" } else if(row['status'] == "2") { var class_name = "badge badge-soft-danger border-0";var status_name ="Task";var icon_class_name = "subtask" } else { var class_name = "badge badge-soft-success border-0";var status_name ="Calls";var icon_class_name = "phone" }
					return '<span class="badge activity-badge '+class_name+'" ><i class="ti ti-'+icon_class_name+' me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "due_date" },
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_activity"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
			]
		});
	}

	// Activity

	if($('#activity-mail').length > 0) {
		$('#activity-mail').DataTable({
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
						"id" : 3,
						"checkbox": "",
						"title" : "Analysing latest time estimation for new project",
						"due_date" : "11 Oct 2025, 05:00 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-26.jpg",
						"created_date" : "03 Oct 2025, 03:53 pm",
						"status" : "1",
						"action": ""
					},
					{
						"id" : 8,
						"checkbox": "",
						"title" : "Regarding latest updates in project",
						"due_date" : "30 Nov 2025, 09:20 pm",
						"owner" : "Guilory Berggren",
						"owner_image": "build/img/profiles/avatar-06.jpg",
						"created_date" : "25 Nov 2025, 07:20 pm",
						"status" : "1",
						"action": ""
					},
					{
						"id" : 10,
						"checkbox": "",
						"title" : "Attach final proposal for upcoming project",
						"due_date" : "19 Dec 2025, 02:20 pm",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-13.jpg",
						"created_date" : "10 Dec 2025, 06:30 pm",
						"status" : "1",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "title" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "badge badge-soft-info border-0";var status_name ="Meeting";var icon_class_name = "user-share" } else if(row['status'] == "1") { var class_name = "badge badge-soft-warning border-0";var status_name ="Email";var icon_class_name = "mail" } else if(row['status'] == "2") { var class_name = "badge badge-soft-danger border-0";var status_name ="Task";var icon_class_name = "subtask" } else { var class_name = "badge badge-soft-success border-0";var status_name ="Calls";var icon_class_name = "phone" }
					return '<span class="badge activity-badge '+class_name+'" ><i class="ti ti-'+icon_class_name+' me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "due_date" },
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_activity"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
			]
		});
	}

	// Activity

	if($('#activity-task').length > 0) {
		$('#activity-task').DataTable({
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
						"id" : 4,
						"checkbox": "",
						"title" : "Store and manage contact data",
						"due_date" : "19 Oct 2025, 02:35 pm",
						"owner" : "Craig Brown",
						"owner_image": "build/img/profiles/avatar-21.jpg",
						"created_date" : "14 Oct 2025, 01:25 pm",
						"status" : "2",
						"action": ""
					},
					{
						"id" : 7,
						"checkbox": "",
						"title" : "Built landing pages",
						"due_date" : "25 Nov 2025, 01:40 pm",
						"owner" : "Daniel Byrne",
						"owner_image": "build/img/profiles/avatar-23.jpg",
						"created_date" : "20 Nov 2025, 08:20 am",
						"status" : "2",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "title" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "badge badge-soft-info border-0";var status_name ="Meeting";var icon_class_name = "user-share" } else if(row['status'] == "1") { var class_name = "badge badge-soft-warning border-0";var status_name ="Email";var icon_class_name = "mail" } else if(row['status'] == "2") { var class_name = "badge badge-soft-danger border-0";var status_name ="Task";var icon_class_name = "subtask" } else { var class_name = "badge badge-soft-success border-0";var status_name ="Calls";var icon_class_name = "phone" }
					return '<span class="badge activity-badge '+class_name+'" ><i class="ti ti-'+icon_class_name+' me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "due_date" },
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_activity"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
			]
		});
	}

	// Activity

	if($('#activity-meeting').length > 0) {
		$('#activity-meeting').DataTable({
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
						"checkbox": "",
						"title" : "We scheduled a meeting for next week",
						"due_date" : "25 Sep 2025, 12:12 pm",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"created_date" : "22 Sep 2025, 10:14 am",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 2,
						"checkbox": "",
						"title" : "Will have a meeting before project start",
						"due_date" : "27 Oct 2025, 12:30 pm",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"created_date" : "21 Oct 2025, 03:00 pm",
						"status" : "0",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "title" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "badge badge-soft-info border-0";var status_name ="Meeting";var icon_class_name = "user-share" } else if(row['status'] == "1") { var class_name = "badge badge-soft-warning border-0";var status_name ="Email";var icon_class_name = "mail" } else if(row['status'] == "2") { var class_name = "badge badge-soft-danger border-0";var status_name ="Task";var icon_class_name = "subtask" } else { var class_name = "badge badge-soft-success border-0";var status_name ="Calls";var icon_class_name = "phone" }
					return '<span class="badge activity-badge '+class_name+'" ><i class="ti ti-'+icon_class_name+' me-1"></i>'+status_name+'</span>';
				}},    
				{ "data": "due_date" },
				{ "render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="javascript:void(0);" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['owner_image'] + '" alt="User Image"></a>' + row['owner'] + '</div>';
				}},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_activity"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}},
			]
		});
	}

	// Language List

	if($('#language-list').length > 0) {
		$('#language-list').DataTable({
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
						"checkbox": "",
						"rating": "",
						"lang_img" : "build/img/icons/flag-01.svg",
						"language" : "English",
						"code" : "en",
						"total" : "3481",
						"done" : "2861",
						"stage" : "1",
						"rtl": "",
						"progress": "80%",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 2,
						"checkbox": "",
						"rating": "",
						"lang_img" : "build/img/icons/flag-02.svg",
						"language" : "Arabic",
						"code" : "ar",
						"total" : "4815",
						"done" : "4815",
						"stage" : "0",
						"rtl": "checked",
						"progress": "100%",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 3,
						"checkbox": "",
						"rating": "",
						"lang_img" : "build/img/icons/flag-03.svg",
						"language" : "German",
						"code" : "zh",
						"total" : "2590",
						"done" : "250",
						"stage" : "3",
						"rtl": "checked",
						"progress": "5%",
						"status" : "0",
						"action": ""
					},
					{
						"id" : 4,
						"checkbox": "",
						"rating": "",
						"lang_img" : "build/img/icons/flag-04.svg",
						"language" : "French",
						"code" : "hi",
						"total" : "1892",
						"done" : "387",
						"stage" : "2",
						"rtl": "checked",
						"progress": "40%",
						"status" : "0",
						"action": ""
					}
			
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm border me-2"><img class="w-auto h-auto" src="'+row['lang_img']+'" alt="User Image"></a><a href="javascript:void(0);">'+row['language']+'</a></h2>';
				}},
				{ "data": "code" },
				{
					"render": function (data, type, row) {
						if(row['rtl'] == "checked") { var attr_name = "checked";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
						return '<div class="status-toggle"><input type="checkbox" id="'+row['language']+'" class="check" '+attr_name+'><label for="'+row['language']+'" class="checktoggle">/label></div>';
					}
				},     
				{ "data": "total" },
				{ "data": "done" },
				{
					"render": function (data, type, row) {
							if(row['stage'] == "0") { var class_name = "success" } else if(row['stage'] == "1") { var class_name = "warning" } else if(row['stage'] == "2") { var class_name = "info"} else  { var class_name = "danger"}
					return '<div class="pipeline-progress d-flex align-items-center"><div class="progress"><div class="progress-bar progress-bar-'+class_name+'" role="progressbar"></div></div><span>'+row['progress']+'</span></div>';
					}
				},     
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}}, 
				{ "render": function ( data, type, row ){
					return '<div class="d-flex align-items-center"><ul class="lang-type"><li><a href="language_web">Web</a></li><li><a href="javascript:void(0);">App</a></li><li><a href="javascript:void(0);">Admin</a></li></ul><div class="dropdown table-action"><a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_translation"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_translation"><i class="ti ti-trash"></i> Delete</a></div></div></div>';
				}},
			]
		});
	}

	// Language Web

	if($('#language-web').length > 0) {
		$('#language-web').DataTable({
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
						"medium" : "Web",
						"file" : "Contacts",
						"total" : "3481",
						"done" : "2861",
						"progress": "80%",
						"stage" : "1",
						"action": ""
					},
					{
						"id" : 2,
						"medium" : "Web",
						"file" : "Customers",
						"total" : "4815",
						"done" : "4815",
						"progress": "100%",
						"stage" : "0",
						"action": ""
					},
					{
						"id" : 3,
						"medium" : "Web",
						"file" : "Companies",
						"total" : "2590",
						"done" : "250",
						"progress": "5%",	
						"stage" : "3",
						"action": ""
					},
					{
						"id" : 4,
						"medium" : "Web",
						"file" : "Projects",
						"total" : "1892",
						"done" : "387",
						"progress": "40%",
						"stage" : "2",
						"action": ""
					}
			
				],
			"columns": [
				{ "data": "medium" },
				{ "render": function ( data, type, row ){
					return '<span class="black-text">'+row['file']+'</i></span>';
				}},
				{ "data": "total" },
				{ "data": "done" },
				{
					"render": function (data, type, row) {
							if(row['stage'] == "0") { var class_name = "success" } else if(row['stage'] == "1") { var class_name = "warning" } else if(row['stage'] == "2") { var class_name = "info"} else  { var class_name = "danger"}
					return '<div class="pipeline-progress d-flex align-items-center"><div class="progress"><div class="progress-bar progress-bar-'+class_name+'" role="progressbar"></div></div><span class="fw-normal text-body">'+row['progress']+'</span></div>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<a href="language_web-edit" class="action-icon btn btn-xs shadow btn-icon btn-outline-light text-body"><i class="ti ti-edit text-black"></i></a>';
				}},
			]
		});
	}

	// Manage Users List

	if($('#manage-users-list').length > 0) {
		$('#manage-users-list').DataTable({
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
						"select" : "",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_no" : "Facility Manager",
						"phone" : "1234567890",
						"email" : "robertson@example.com",
						"location" : "Germany",
						"created" : "25 Sep 2025, 12:12 pm",
						"last_activity": "2 mins ago",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Installer",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"location" : "USA",
						"created" : "27 Sep 2025, 07:40 am",
						"last_activity": "5 mins ago",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_no" : "Senior  Manager",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"location" : "Canada",
						"created" : "29 Sep 2025, 08:20 am",
						"last_activity": "2 days ago",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_no" : "Test Engineer",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"location" : "India",
						"created" : "25 Sep 2025, 12:12 pm",
						"last_activity": "2 mins ago",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "UI /UX Designer",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"location" : "China",
						"created" : "02 Oct 2025, 10:10 am",
						"last_activity": "Online",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_no" : "Technician",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"location" : "Martin Lewis",
						"created" : "17 Oct 2025, 04:25 pm",
						"last_activity": "3 days ago",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Rachel Hampton",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_no" : "Software Developer",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"location" : "Indonesia",
						"created" : "28 Oct 2025, 07:16 am",
						"last_activity": "10 days ago",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonelle Curtiss",
						"customer_image" : "build/img/profiles/avatar-25.jpg",
						"customer_no" : "Supervisor",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"location" : "Cuba",
						"created" : "08 Nov 2025, 06:10 am",
						"last_activity": "1 week go",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonathan Smith",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_no" : "Team Lead Dev",
						"phone" : "+1 321454789",
						"email" : "jonathan@example.com",
						"location" : "Isreal",
						"created" : "15 Nov 2025, 11:50 am",
						"last_activity": "1 day ago",
						"status" : "0",
						"Action" : ""
					}
					,
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Brook Carter",
						"customer_image" : "build/img/profiles/avatar-01.jpg",
						"customer_no" : "Team Lead Dev ",
						"phone" : "+1 278907145",
						"email" : "brook@example.com",
						"location" : "Colombia",
						"created" : "25 Nov 2025, 06:34 pm",
						"last_activity": "8 mins ago",
						"status" : "0",
						"Action" : ""
					}
					
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar avatar-rounded me-2"><img src="'+row['customer_image']+'" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">'+row['customer_name']+' <span class="text-body fs-13 mt-1 d-inline-block fw-normal">'+row['customer_no']+' </span></a></h6>';
				}},
				{ "data": "phone" },
				{ "data": "email" },
				{ "data": "created" },
				{ "data": "last_activity" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

	// Delete Request

	if($('#delete_request').length > 0) {
		$('#delete_request').DataTable({
			"bFilter": false, 
			"bInfo": false,
				"ordering": true,
				"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				lengthMenu:     "Show _MENU_ entries",
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
							"select" : "",
							"customer_name" : "Darlee Robertson",
							"customer_image" : "build/img/profiles/avatar-19.jpg",
							"customer_no" : "Facility Manager",
							"created" : "25 Sep 2025, 12:12 pm",
							"delete_request": "25 Sep 2025, 12:12 pm",
							"reason": "No longer using service",
							"status" : "0",
							"Action" : ""
						},
						{
							"id" : 2,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Sharon Roy",
							"customer_image" : "build/img/profiles/avatar-20.jpg",
							"customer_no" : "Installer",
							"created" : "27 Sep 2025, 07:40 am",
							"delete_request" : "27 Sep 2025, 07:40 am",
							"reason": "Privacy concerns",
							"status" : "1",
							"Action" : ""
						},
						{
							"id" : 3,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Vaughan Lewis",
							"customer_image" : "build/img/profiles/avatar-21.jpg",
							"customer_no" : "Senior  Manager",
							"created" : "29 Sep 2025, 08:20 am",
							"delete_request": "29 Sep 2025, 08:20 am",
							"reason": "Duplicate account",
							"status" : "0",
							"Action" : ""
						},
						{
							"id" : 4,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Jessica Louise",
							"customer_image" : "build/img/profiles/avatar-23.jpg",
							"customer_no" : "Test Engineer",
							"created" : "25 Sep 2025, 12:12 pm",
							"delete_request": "25 Sep 2025, 12:12 pm",
							"reason": "Technical issues",
							"status" : "0",
							"Action" : ""
						},
						{
							"id" : 5,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Carol Thomas",
							"customer_image" : "build/img/profiles/avatar-16.jpg",
							"customer_no" : "UI /UX Designer",
							"created" : "02 Oct 2025, 10:10 am",
							"delete_request": "02 Oct 2025, 10:10 am",
							"reason": "Receiving too many emails",
							"status" : "1",
							"Action" : ""
						},
						{
							"id" : 6,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Dawn Mercha",
							"customer_image" : "build/img/profiles/avatar-22.jpg",
							"customer_no" : "Technician",
							"created" : "17 Oct 2025, 04:25 pm",
							"delete_request": "17 Oct 2025, 04:25 pm",
							"reason": "Privacy concerns",
							"status" : "1",
							"Action" : ""
						},
						{
							"id" : 7,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Rachel Hampton",
							"customer_image" : "build/img/profiles/avatar-24.jpg",
							"customer_no" : "Software Developer",
							"created" : "28 Oct 2025, 07:16 am",
							"delete_request": "28 Oct 2025, 07:16 am",
							"reason": "Duplicate account",
							"status" : "1",
							"Action" : ""
						},
						{
							"id" : 8,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Jonelle Curtiss",
							"customer_image" : "build/img/profiles/avatar-25.jpg",
							"customer_no" : "Supervisor",
							"created" : "08 Nov 2025, 06:10 am",
							"delete_request": "08 Nov 2025, 06:10 am",
							"reason": "No longer using service",
							"status" : "1",
							"Action" : ""
						},
						{
							"id" : 9,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Jonathan Smith",
							"customer_image" : "build/img/profiles/avatar-26.jpg",
							"customer_no" : "Team Lead Dev",
							"created" : "15 Nov 2025, 11:50 am",
							"delete_request": "15 Nov 2025, 11:50 am",
							"reason": "No longer using service",
							"status" : "1",
							"Action" : ""
						}
						,
						{
							"id" : 10,
							"si_no" : "",
							"select" : "",
							"customer_name" : "Brook Carter",
							"customer_image" : "build/img/profiles/avatar-01.jpg",
							"customer_no" : "Team Lead Dev ",
							"created" : "25 Nov 2025, 06:34 pm",
							"delete_request": "25 Nov 2025, 06:34 pm",
							"reason": "Privacy concerns",
							"status" : "1",
							"Action" : ""
						}
						
					],
				"columns": [
					{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
					{ "render": function ( data, type, row ){
						return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
					}},
					{ "render": function ( data, type, row ){
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar avatar-rounded me-2"><img src="'+row['customer_image']+'" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">'+row['customer_name']+' <span class="text-body fs-13 fw-normal d-inline-block mt-1">'+row['customer_no']+' </span></a></h2>';
					}},
					{ "data": "created" },
					{ "data": "delete_request" },
					{ "data": "reason" },
					{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-danger";var status_name ="Rejected" } else { var class_name = "bg-warning";var status_name ="Pending"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}},
					{ "render": function ( data, type, row ){
						return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#approve_request"><i class="ti ti-check"></i> Approve</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reject_request"><i class="ti ti-x"></i> Reject</a></div></div>';
					}}
					]
			});
	}

	// Roles

	if($('#roles_list').length > 0) {
		$('#roles_list').DataTable({
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
						"roles_name" : "Admin",
						"created" : "25 Sep 2025, 12:12 pm",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"roles_name" : "Company Owner",
						"created" : "27 Sep 2025, 07:40 am",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"roles_name" : "Deal Owner",
						"created" : "29 Sep 2025, 08:20 am",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"roles_name" : "Project Manager",
						"created" : "25 Sep 2025, 12:12 pm",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"roles_name" : "Client",
						"created" : "15 Oct 2025, 06:18 pm",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"roles_name" : "Lead",
						"created" : "29 Oct 2025, 03:10 pm",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "data": "roles_name" },
				{ "data": "created" },
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="permission"><i class="ti ti-shield"></i> Permission</a></div></div>';
				}}
			]
		});
	}

	// Permission

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

	// Contact messages

	if($('#contact-messages-list').length > 0) {
		$('#contact-messages-list').DataTable({
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
						"select" : "",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_no" : "Facility Manager",
						"phone" : "1234567890",
						"email" : "robertson@example.com",
						"message" : "Duis aute irure dolor in reprehenderit",
						"created" : "25 Sep 2025, 12:12 pm",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Installer",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"message" : "Excepteur sint occaecat cupidatat",
						"created" : "27 Sep 2025, 07:40 am",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_no" : "Senior  Manager",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"message" : "Lorem ipsum dolor sit consectetur",
						"created" : "29 Sep 2025, 08:20 am",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_no" : "Test Engineer",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"message" : "Nemo enim ipsam voluptatem quia",
						"created" : "25 Sep 2025, 12:12 pm",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "UI /UX Designer",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"message" : "Sed ut perspiciatis unde omnis iste",
						"created" : "02 Oct 2025, 10:10 am",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_no" : "Technician",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"message" : "Ut enim ad minim veniam, quis",
						"created" : "17 Oct 2025, 04:25 pm",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Rachel Hampton",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_no" : "Software Developer",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"message" : "Duis aute irure dolor in reprehenderit",
						"created" : "28 Oct 2025, 07:16 am",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonelle Curtiss",
						"customer_image" : "build/img/profiles/avatar-25.jpg",
						"customer_no" : "Supervisor",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"message" : "Ut enim ad minim veniam, quis",
						"created" : "08 Nov 2025, 06:10 am",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonathan Smith",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_no" : "Team Lead Dev",
						"phone" : "+1 321454789",
						"email" : "jonathan@example.com",
						"message" : "Excepteur sint occaecat cupidatat",
						"created" : "15 Nov 2025, 11:50 am",
						"status" : "0",
						"Action" : ""
					}
					,
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Brook Carter",
						"customer_image" : "build/img/profiles/avatar-01.jpg",
						"customer_no" : "Team Lead Dev ",
						"phone" : "+1 278907145",
						"email" : "brook@example.com",
						"message" : "Ut enim ad minim veniam, quis",
						"created" : "25 Nov 2025, 06:34 pm",
						"status" : "0",
						"Action" : ""
					}
					
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">' + row['customer_name'] + ' <span class="text-body fs-13 fw-normal mt-1">' + row['customer_no'] + ' </span></a></h6>';
					}
				},
				{ "data": "phone" },
				{ "data": "email" },
				{ "data": "message" },
				{ "data": "created" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_contact"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

	// Tickets 

	if($('#tickets-list').length > 0) {
		$('#tickets-list').DataTable({
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
						"select" : "",
						"ticket_id" : "#TK0020",
						"subject" : "Support for theme",
						"assigned_name" : "Richard Bennett",
						"assigned_image" : "build/img/profiles/avatar-02.jpg",
						"created" : "25 Jan 2025, 01:22 PM",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_no" : "Facility Manager",
						"priority" : "1",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0019",
						"subject" : "verify your email",
						"assigned_name" : "Elizabeth Collins",
						"assigned_image" : "build/img/profiles/avatar-01.jpg",
						"created" : "03 Feb 2025, 09:45 AM",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Installer",
						"priority" : "0",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0018",
						"subject" : "Calling for help",
						"assigned_name" : "Michel Dubois",
						"assigned_image" : "build/img/profiles/avatar-04.jpg",
						"created" : "14 Mar 2025, 06:10 PM",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_no" : "Senior  Manager",
						"priority" : "2",
						"status" : "2",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0017",
						"subject" : "Management",
						"assigned_name" : "Esther Williams",
						"assigned_image" : "build/img/profiles/avatar-03.jpg",
						"created" : "29 Apr 2025, 11:00 AM",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_no" : "Test Engineer",
						"priority" : "1",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0016",
						"subject" : "Calling for help",
						"assigned_name" : "Wilson Clarke",
						"assigned_image" : "build/img/profiles/avatar-05.jpg",
						"created" : "07 May 2025, 04:35 PM",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "UI /UX Designer",
						"priority" : "0",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0015",
						"subject" : "Support for theme",
						"assigned_name" : "Walter Thompson",
						"assigned_image" : "build/img/profiles/avatar-06.jpg",
						"created" : "18 Jun 2025, 08:20 AM",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_no" : "Technician",
						"priority" : "2",
						"status" : "2",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0014",
						"subject" : "Password Reset",
						"assigned_name" : "Noah Mitchell",
						"assigned_image" : "build/img/profiles/avatar-07.jpg",
						"created" : "18 Apr 2025, 08:00 AM",
						"customer_name" : "Alexander Carter",
						"customer_image" : "build/img/profiles/avatar-27.jpg",
						"customer_no" : "Project Manager",
						"priority" : "1",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0013",
						"subject" : "Error 502 on Dashboard",
						"assigned_name" : "Mason Hayes",
						"assigned_image" : "build/img/profiles/avatar-24.jpg",
						"created" : "05 Feb 2025, 10:45 AM",
						"customer_name" : "Benjamin Harrison",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "Team Lead",
						"priority" : "0",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0012",
						"subject" : "Plan Upgrade Inquiry",
						"assigned_name" : "Ron Thompson",
						"assigned_image" : "build/img/profiles/avatar-25.jpg",
						"created" : "15 Jan 2025, 02:02 PM",
						"customer_name" : "Nicholas Wright",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Supervisor",
						"priority" : "2",
						"status" : "3",
						"Action" : ""
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"ticket_id" : "#TK0011",
						"subject" : "Event Collaboration Request",
						"assigned_name" : "James Bennett",
						"assigned_image" : "build/img/profiles/avatar-10.jpg",
						"created" : "12 Mar 2025, 08:00 PM",
						"customer_name" : "Alexandra Bennett",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_no" : "Marketing",
						"priority" : "1",
						"status" : "2",
						"Action" : ""
					},
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{
					"render": function (data, type, row) {
						return '<a href="ticket_details">'+ row['ticket_id'] +'</a>';
					}
				},
				{ "data": "subject" },
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar avatar-xs me-2"><img class="img-fluid rounded-circle" src="' + row['assigned_image'] + '" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">' + row['assigned_name'] + '</a></h6>';
					}
				},
				{ "data": "created" },
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">' + row['customer_name'] + ' <span class="text-body fs-13 fw-normal mt-1">' + row['customer_no'] + ' </span></a></h6>';
					}
				},
				{ "render": function ( data, type, row ){
					if(row['priority'] == "0") { var class_name = "badge-soft-warning";var status_name ="Medium" }else if(row['priority'] == "1") { var class_name = "badge-soft-success";var status_name ="Low" } else { var class_name = "badge-soft-danger";var status_name ="High"}
					return '<span class="badge badge-tag '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Resolved" }else if(row['status'] == "1") { var class_name = "bg-danger";var status_name ="Closed" }else if(row['status'] == "2") { var class_name = "bg-warning";var status_name ="Pending" } else { var class_name = "bg-info";var status_name ="Open"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_ticket"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_ticket"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

	// States List

	if($('#states_list').length > 0) {
		$('#states_list').DataTable({
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
				"data": [
					{
						"id": 1,
						"si_no": "",
						"select" : "",
						"country_code": "US",
						"country_id": "840",
						"country_image":"build/img/country/country-01.svg",
						"state": "United States",
						"state_name": "Indiana",
						"Action": ""
					},
					{
						"id": 2,
						"si_no": "",
						"select" : "",
						"country_code": "CAN",
						"country_id": "124",
						"country_image":"build/img/country/country-02.svg",
						"state": "Canada",
						"state_name": "Alberta",
						"Action": ""
					},
					{
						"id": 3,
						"si_no": "",
						"select" : "",
						"country_code": "ES",
						"country_id": "34",
						"country_image":"build/img/country/country-03.svg",
						"state": "Spain",
						"state_name": "Madrid",
						"Action": ""
					},
					{
						"id": 4,
						"si_no": "",
						"select" : "",
						"country_code": "IN",
						"country_id": "356",
						"country_image":"build/img/country/country-04.svg",
						"state": "India",
						"state_name": "Tamil Nadu",
						"Action": ""
					},
					{
						"id": 5,
						"si_no": "",
						"select" : "",
						"country_code": "BR",
						"country_id": "076",
						"country_image":"build/img/country/country-05.svg",
						"state": "Brazil",
						"state_name": "Alagoas",
						"Action": ""
					},
					{
						"id": 6,
						"si_no": "",
						"select" : "",
						"country_code": "DE",
						"country_id": "49",
						"country_image":"build/img/country/country-06.svg",
						"state": "Germany",
						"state_name": "Saarland",
						"Action": ""
					},
					{
						"id": 7,
						"si_no": "",
						"select" : "",
						"country_code": "MX",
						"country_id": "52",
						"country_image":"build/img/country/country-07.svg",
						"state": "Mexico",
						"state_name": "Durango",
						"Action": ""
					},
					{
						"id": 8,
						"si_no": "",
						"select" : "",
						"country_code": "CN",
						"country_id": "156",
						"country_image":"build/img/country/country-08.svg",
						"state": "China",
						"state_name": "Shandong",
						"Action": ""
					},
					{
						"id": 9,
						"si_no": "",
						"select" : "",
						"country_code": "RU",
						"country_id": "7",
						"country_image":"build/img/country/country-09.svg",
						"state": "Russia",
						"state_name": "Kalmykia",
						"Action": ""
					},
					{
						"id": 10,
						"si_no": "",
						"select" : "",
						"country_code": "IT",
						"country_id": "39",
						"country_image":"build/img/country/country-10.svg",
						"state": "Italy",
						"state_name": "Tuscany",
						"Action": ""
					}
				],
		"columns": [
			{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
			}},
			{ "render": function ( data, type, row ){
				return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
			}},
			{ "data": "country_code" },
			{ "render": function ( data, type, row ){
				return '<a href="javascript:void(0);" class="table-imgname flag-image">' +
				'<span class="me-2"><img src="'+ row['country_image']+'" class="img-fluid" alt="img"></span>' +
				'<span>'+ row['state'] +'</span>'+
				'</a> ';
			}}, 
			{"data": "state_name" },     
			{ "render": function ( data, type, row ){
				return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_state"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_state"><i class="ti ti-trash"></i> Delete</a></div></div>';
			}}
		]
	});
	}

	// membership Transaction

	if($('#transactions_list').length > 0) {
		$('#transactions_list').DataTable({
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
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$650",
						"date": "25 Sep 2025, 01:22 PM",
						"payment_type":"Paypal",
						"status": "1"
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"type" : "Purchase",
						"amount" : "-350",
						"date": "27 Sep 2025, 04:18 PM",
						"payment_type":"Cash",
						"status": "0"
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"type" : "Refund",
						"amount" : "+$100",
						"date": "29 Sep 2025, 10:08 AM",
						"payment_type":"Paypal",
						"status": "1"
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$650",
						"date": "05 Oct 2025, 09:43 AM",
						"payment_type":"Cash",
						"status": "1"
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$650",
						"date": "17 Oct 2025, 01:22 AM",
						"payment_type":"Paypal",
						"status": "0"
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$650",
						"date": "22 Oct 2025, 06:32 PM",
						"payment_type":"Cash",
						"status": "1"
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"type" : "Refund",
						"amount" : "+$500",
						"date": "05 May 2025, 10:45 AM",
						"payment_type":"Cash",
						"status": "1"
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$380",
						"date": "03 May 2025, 09:45 AM",
						"payment_type":"Cash",
						"status": "1"
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"type" : "Refund",
						"amount" : "+$290",
						"date": "15 Feb 2025, 02:02 PM",
						"payment_type":"PayPal",
						"status": "1"
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"type" : "Wallet Topup",
						"amount" : "+$380",
						"date": "25 Feb 2025, 01:22 PM",
						"payment_type":"Cash",
						"status": "1"
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select filled"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "data": "type" },
				{ "data": "amount" },
				{ "data": "date" },
				{ "data": "payment_type" },
				{ "render": function ( data, type, row ){
					if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Completed" } if(row['status'] == "1") { var class_name = "bg-success";var status_name ="Completed" } else { var class_name = "bg-danger";var status_name ="Cancel"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
			]
		});
	}

	// Cities List

	if($('#cities_list').length > 0) {
		$('#cities_list').DataTable({
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
						"select" : "",
						"city_name" : "Indianapolis",
						"country_image":"build/img/country/country-01.svg",
						"country_name": "United States",
						"state_name": "Indiana",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"city_name" : "Calgary",
						"country_image":"build/img/country/country-02.svg",
						"country_name": "Canada",
						"state_name": "Alberta",
						"Action" : ""
						
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"city_name" : "Bulgaria",
						"country_image":"build/img/country/country-03.svg",
						"country_name": "Spain",
						"state_name": "Madrid",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"city_name" : "Trichy",
						"country_image":"build/img/country/country-04.svg",
						"country_name": "India",
						"state_name": "Tamil Nadu",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"city_name" : "Porto Alegre",
						"country_image":"build/img/country/country-05.svg",
						"country_name": "Brazil",
						"state_name": "Alagoas",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"city_name" : "Hamburg",
						"country_image":"build/img/country/country-06.svg",
						"country_name": "Germany",
						"state_name": "Saarland",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"city_name" : "Guadalajara",
						"country_image":"build/img/country/country-07.svg",
						"country_name": "Mexico",
						"state_name": "Durango",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"city_name" : "Chengdu",
						"country_image":"build/img/country/country-08.svg",
						"country_name": "China",
						"state_name": "Shandong",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"city_name" : "Moscow",
						"country_image":"build/img/country/country-09.svg",
						"country_name": "Russia",
						"state_name": "Kalmykia",
						"Action" : ""
					}
					,
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"city_name" : "Rome",
						"country_image":"build/img/country/country-10.svg",
						"country_name": "Italy",
						"state_name": "Tuscany",
						"Action" : ""
					}
					
					
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="javascript:void(0);" class="table-imgname flag-image">' +
					'<span class="location-flag-img me-2"><img src="'+ row['country_image']+'" class="img-fluid" alt="img"></span>' +
					'<span>'+ row['country_name'] +'</span>'+
					'</a> ';
				}},  
				{ "data": "state_name" },
				{ "data": "city_name" },             
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_city"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_city"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

	// Countries List

	if($('#countrieslist').length > 0) {
		$('#countrieslist').DataTable({
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
				"data": [
					{
						"id": 1,
						"si_no": "",
						"select" : "",
						"country_code": "US",
						"country_id": "840",
						"country_image":"build/img/country/country-01.svg",
						"country_name": "United States",
						"Action": ""
					},
					{
						"id": 2,
						"si_no": "",
						"select" : "",
						"country_code": "CAN",
						"country_id": "124",
						"country_image":"build/img/country/country-02.svg",
						"country_name": "Canada",
						"Action": ""
					},
					{
						"id": 3,
						"si_no": "",
						"select" : "",
						"country_code": "ES",
						"country_id": "34",
						"country_image":"build/img/country/country-03.svg",
						"country_name": "Spain",
						"Action": ""
					},
					{
						"id": 4,
						"si_no": "",
						"select" : "",
						"country_code": "IN",
						"country_id": "356",
						"country_image":"build/img/country/country-04.svg",
						"country_name": "India",
						"Action": ""
					},
					{
						"id": 5,
						"si_no": "",
						"select" : "",
						"country_code": "BR",
						"country_id": "076",
						"country_image":"build/img/country/country-05.svg",
						"country_name": "Brazil",
						"Action": ""
					},
					{
						"id": 6,
						"si_no": "",
						"select" : "",
						"country_code": "DE",
						"country_id": "49",
						"country_image":"build/img/country/country-06.svg",
						"country_name": "Germany",
						"Action": ""
					},
					{
						"id": 7,
						"si_no": "",
						"select" : "",
						"country_code": "MX",
						"country_id": "52",
						"country_image":"build/img/country/country-07.svg",
						"country_name": "Mexico",
						"Action": ""
					},
					{
						"id": 8,
						"si_no": "",
						"select" : "",
						"country_code": "CN",
						"country_id": "156",
						"country_image":"build/img/country/country-08.svg",
						"country_name": "China",
						"Action": ""
					},
					{
						"id": 9,
						"si_no": "",
						"select" : "",
						"country_code": "RU",
						"country_id": "7",
						"country_image":"build/img/country/country-09.svg",
						"country_name": "Russia",
						"Action": ""
					},
					{
						"id": 10,
						"si_no": "",
						"select" : "",
						"country_code": "IT",
						"country_id": "39",
						"country_image":"build/img/country/country-10.svg",
						"country_name": "Italy",
						"Action": ""
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "data": "country_code" },
				{ "data": "country_id" },
				{ "render": function ( data, type, row ){
					return '<a href="javascript:void(0);" class="table-imgname flag-image">' +
					'<span class="location-flag-img me-2"><img src="'+ row['country_image']+'" class="img-fluid" alt="img"></span>' +
					'<span>'+ row['country_name'] +'</span>'+
					'</a> ';
				}},               
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_country"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_country"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}


	// Contact Reports

	if($('#contact_reports').length > 0) {
		$('#contact_reports').DataTable({
			"bFilter": false,
			"bInfo": false,
			"ordering": true,
			"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				"lengthMenu": "Show _MENU_ entries",
				paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
			},
			initComplete: function(settings, json) {
				$('.dataTables_paginate').appendTo('.datatable-paginate');
				$('.dataTables_length').appendTo('.datatable-length');
			},
			"data":[
				{
					"id" : 1,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Darlee Robertson",
					"customer_image" : "build/img/profiles/avatar-19.jpg",
					"customer_no" : "Facility Manager",
					"phone" : "1234567890",
					"location_image" : "build/img/flags/us.svg",
					"location_name" : "USA",
					"tag" : "0",
					"rating" : "4.2",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 2,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Sharon Roy",
					"customer_image" : "build/img/profiles/avatar-20.jpg",
					"customer_no" : "Installer",
					"phone" : "+1 989757485",
					"location_image" : "build/img/flags/ae.svg",
					"location_name" : "UAE",
					"tag" : "2",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "1",
				},
				{
					"id" : 3,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Vaughan Lewis",
					"customer_image" : "build/img/profiles/avatar-21.jpg",
					"customer_no" : "Senior  Manager",
					"phone" : "+1 546555455",
					"location_image" : "build/img/flags/de.svg",
					"location_name" : "Germany",
					"tag" : "0",
					"rating" : "3.5",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 4,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jessica Louise",
					"customer_image" : "build/img/profiles/avatar-23.jpg",
					"customer_no" : "Test Engineer",
					"phone" : "+1 454478787",
					"location_image" : "build/img/flags/fr.svg",
					"location_name" : "France",
					"tag" : "1",
					"rating" : "4.5",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 5,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Carol Thomas",
					"customer_image" : "build/img/profiles/avatar-16.jpg",
					"customer_no" : "UI /UX Designer",
					"phone" : "+1 124547845",
					"location_image" : "build/img/flags/india.svg",
					"location_name" : "India",
					"tag" : "0",
					"rating" : "4.7",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 6,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Dawn Mercha",
					"customer_image" : "build/img/profiles/avatar-22.jpg",
					"customer_no" : "Technician",
					"phone" : "+1 478845447",
					"location_image" : "build/img/flags/brazil.svg",
					"location_name" : "Brazil",
					"tag" : "1",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 7,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Rachel Hampton",
					"customer_image" : "build/img/profiles/avatar-24.jpg",
					"customer_no" : "Software Developer",
					"phone" : "+1 215544845",
					"location_image" : "build/img/flags/mexico.svg",
					"location_name" : "Mexico",
					"tag" : "2",
					"rating" : "3.1",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 8,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonelle Curtiss",
					"customer_image" : "build/img/profiles/avatar-25.jpg",
					"customer_no" : "Supervisor",
					"phone" : "+1 121145471",
					"location_image" : "build/img/flags/china.svg",
					"location_name" : "China",
					"tag" : "1",
					"rating" : "5.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				},
				{
					"id" : 9,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Jonathan Smith",
					"customer_image" : "build/img/profiles/avatar-26.jpg",
					"customer_no" : "Team Lead Dev",
					"phone" : "+1 321454789",
					"location_image" : "build/img/flags/russia.svg",
					"location_name" : "Russia",
					"tag" : "0",
					"rating" : "2.7",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				}
				,
				{
					"id" : 10,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Brook Carter",
					"customer_image" : "build/img/profiles/avatar-01.jpg",
					"customer_no" : "Team Lead Dev ",
					"phone" : "+1 278907145",
					"location_image" : "build/img/flags/fr.svg",
					"location_name" : "France",
					"tag" : "2",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				}
				,
				{
					"id" : 11,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Eric Adams",
					"customer_image" : "build/img/profiles/avatar-06.jpg",
					"customer_no" : "HR Manager",
					"phone" : "+1 19023-78104",
					"location_image" : "build/img/flags/italy.svg",
					"location_name" : "Italy",
					"tag" : "3",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				}
				,
				{
					"id" : 12,
					"si_no" : "",
					"select" : "",
					"customer_name" : "Richard Cooper",
					"customer_image" : "build/img/profiles/avatar-05.jpg",
					"customer_no" : "Devops Engineer",
					"phone" : "+1 18902-63904",
					"location_image" : "build/img/flags/canada.svg",
					"location_name" : "Canada",
					"tag" : "1",
					"rating" : "3.0",
					"owner_image": "build/img/profiles/avatar-14.jpg",
					"status" : "0",
				}
				
			],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="contact_details" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="contact_details" class="d-flex flex-column">' + row['customer_name'] + ' <span class="text-body fs-13 fw-normal mt-1">' + row['customer_no'] + ' </span></a></h6>';
					}
				},
				{ "data": "phone" },
				{
					"render": function (data, type, row) {
						var class_name, status_name;
						if (row['tag'] == "0") {
							class_name = "badge-soft-success";
							status_name = "Collab";
						} else if (row['tag'] == "1") {
							class_name = "badge-soft-warning";
							status_name = "VIP";
						} else if (row['tag'] == "3") {
							class_name = "badge-soft-info";
							status_name = "Premium";
						} else {
							class_name = "badge-soft-primary";
							status_name = "Promotion";
						}
						
						return '<span class="badge badge-tag ' + class_name + '" >' + status_name + '</span>';
					}
				},
				{ 
					"render": function (data, type, row) {
						return '<div class="d-flex align-items-center mb-0"><a href="contact_details" class="avatar avatar-xss me-2"><img class="img-fluid rounded-circle" src="' + row['location_image'] + '" alt="User Image"></a>' + row['location_name'] + '</div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<div class="set-star"><span><i class="ti ti-star-filled text-warning"></i> ' + row['rating'] + ' </span></div>';
					}
				},
				{
					"render": function (data, type, row) {
						return '<ul class="social-links d-flex align-items-center"><li><a href="#"><i class="ti ti-mail"></i></a></li><li><a href="#"><i class="ti ti-phone-check"></i></a></li><li><a href="#"><i class="ti ti-message-circle-share"></i></a></li></li><li><a href="#"><i class="ti ti-brand-facebook "></i></a></li></ul>';
					}
				},
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}
			]
		});
		
	}

	// Deal Reports

	if($('#deal_reports').length > 0) {
		$('#deal_reports').DataTable({
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
				"data": [
					{
						"id": 1,
						"Deal_Name": "Annual Software Subscription",
						"Stage": "Appointment",
						"Deal_Value": "$04,51,000",
						"tag": "0",
						"close_date": "25 Sep 2025",
						"Probability": "90%",
						"Status": "0"
					},
					{
						"id": 2,
						"Deal_Name": " CRM Onboarding Package",
						"Stage": "Appointment",
						"Deal_Value": "$03,12,500",
						"tag": "1",
						"close_date": "29 Sep 2025",
						"Probability": "15 %",
						"Status": "1"
					},
					{
						"id": 3,
						"Deal_Name": "Enterprise Plan Upgrade",
						"Stage": "Contact Made",
						"Deal_Value": "$04,14,800",
						"tag": "3",
						"close_date": "04 Oct 2025",
						"Probability": "95 %",
						"Status": "0"
					},
					{
						"id": 4,
						"Deal_Name": "BrightWorks Campaign",
						"Stage": "Presentation",
						"Deal_Value": "$11,14,400",
						"tag": "0",
						"close_date": "15 Oct 2025",
						"Probability": "99 %",
						"Status": "0"
					},
					{
						"id": 5,
						"Deal_Name": "Sales Pipeline Optimization",
						"Stage": "Proposal Made",
						"Deal_Value": "$16,11,400",
						"tag": "0",
						"close_date": "27 Oct 2025",
						"Probability": "10 %",
						"Status": "2"
					},
					{
						"id": 6,
						"Deal_Name": "CRM Migration Project",
						"Stage": "Proposal Made",
						"Deal_Value": "$78,11,800",
						"tag": "0",
						"close_date": "07 Nov 2025",
						"Probability": "70 %",
						"Status": "0"
					},
					{
						"id": 7,
						"Deal_Name": "Multi-Store License Renewal",
						"Stage": "Proposal Made",
						"Deal_Value": "$09,05,947",
						"tag": "2",
						"close_date": "12 Nov 2025",
						"Probability": "10 %",
						"Status": "2"
					},
					{
						"id": 8,
						"Deal_Name": " Custom Feature Development",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$04,51,000",
						"tag": "3",
						"close_date": "23 Nov 2025",
						"Probability": "90 %",
						"Status": "0"
					},
					{
						"id": 9,
						"Deal_Name": "SkyHigh Annual Booking",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$72,14,078",
						"tag": "1",
						"close_date": "11 Dec 2025",
						"Probability": "40 %",
						"Status": "0"
					},
					{
						"id": 10,
						"Deal_Name": "BlueOcean Funding Round",
						"Stage": "Qualify To Buy",
						"Deal_Value": "$09,05,947",
						"tag": "1",
						"close_date": "17 Dec 2025",
						"Probability": "47 %",
						"Status": "1"
					}
					],
			"columns": [
				{ "render": function (data, type, row) {
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<a href="deals_details" class="title-name">'+row['Deal_Name']+'</a>';
				}},
				{ "data": "Stage" },
				{ "data": "Deal_Value" },
				{ "render": function ( data, type, row ){
					if(row['tag'] == "0") { var class_name = "badge-soft-warning";var status_name ="Rated" }else if(row['tag'] == "1"){ var class_name = "badge-soft-danger";var status_name ="Collab"}else if(row['tag'] == "2"){ var class_name = "badge-soft-primary";var status_name ="Promotion"} else { var class_name = "badge-soft-danger";var status_name ="Rejected"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
				{ "data": "close_date" },
				{ "data": "Probability" },
				{ "render": function ( data, type, row ){
					if(row['Status'] == "0") { var class_name = "bg-success";var status_name ="Won" }else if(row['Status'] == "1"){ var class_name = "bg-danger";var status_name ="Lost"} else { var class_name = "bg-indigo";var status_name ="open"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
				}},
			]
		});
	}

	// Leads Reports

	if($('#leads_reports').length > 0) {
		$('#leads_reports').DataTable({
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
						"select" : "",
						"lead_image" : "build/img/users/avatar-4.jpg",
						"lead_name" : "Elizabeth Morgan",
						"company_name" : "NovaWave LLC",
						"company_image" : "build/img/company/company-01.svg",
						"company_address" : "New York, USA",
						"phone" : "+1 875455453",
						"created_date" : "25 Sep 2025, 01:22 pm",
						"owner_image" : "build/img/profiles/avatar-01.jpg",
						"owner" : "Robert Johnson",
						"status" : "0",
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/avatar-8.jpg",
						"lead_name" : "Katherine Brooks",
						"company_name" : "BlueSky Industries",
						"company_image" : "build/img/company/company-02.svg",
						"company_address" : "Toronto, Canada",
						"phone" : "+1 98975 17485",
						"created_date" : "03 Feb 2025, 09:45 AM",
						"owner_image" : "build/img/profiles/avatar-04.jpg",
						"owner" : "Isabella Cooper",
						"status" : "1",
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-02.jpg",
						"lead_name" : "Samantha Reed",
						"company_name" : "Silver Hawk",
						"company_image" : "build/img/company/company-03.svg",
						"company_address" : "London, UK",
						"phone" : "+1 54655 25455",
						"created_date" : "14 Mar 2025, 06:10 PM",
						"owner_image" : "build/img/profiles/avatar-03.jpg",
						"owner" : "John Smith",
						"status" : "0",
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-03.jpg",
						"lead_name" : "William Anderson",
						"company_name" : "Summit  Peak",
						"company_image" : "build/img/company/company-04.svg",
						"company_address" : "Sydney, Australia",
						"phone" : "+1 45447 58787",
						"created_date" : "29 Apr 2025, 11:00 AM",
						"owner_image" : "build/img/profiles/avatar-07.jpg",
						"owner" : "Sophia Parker",
						"status" : "2",
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/profiles/avatar-10.jpg",
						"lead_name" : "Jonathan Mitchell",
						"company_name" : "RiverStone Ltd",
						"company_image" : "build/img/company/company-05.svg",
						"company_address" : "Berlin, Germany",
						"phone" : "+1 12454 27845",
						"created_date" : "07 May 2025, 04:35 PM",
						"owner_image" : "build/img/profiles/avatar-08.jpg",
						"owner" : "Ethan Reynolds",
						"status" : "0",
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-06.jpg",
						"lead_name" : "Jennifer Adams",
						"company_name" : "Bright Bridge Grp",
						"company_image" : "build/img/company/company-06.svg",
						"company_address" : "Tokyo, Japan",
						"phone" : "+1 47884 75447",
						"created_date" : "18 Jun 2025, 08:20 AM",
						"owner_image" : "build/img/profiles/avatar-09.jpg",
						"owner" : "Liam Carter",
						"status" : "0",
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-11.jpg",
						"lead_name" : "Alexander Carter",
						"company_name" : "CoastalStar Co.",
						"company_image" : "build/img/company/company-07.svg",
						"company_address" : "Paris, France",
						"phone" : "+1 21554 34845",
						"created_date" : "18 Apr 2025, 08:00 AM",
						"owner_image" : "build/img/profiles/avatar-11.jpg",
						"owner" : "Noah Mitchell",
						"status" : "0",
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-12.jpg",
						"lead_name" : "Benjamin Harrison",
						"company_name" : "HarborView",
						"company_image" : "build/img/company/company-08.svg",
						"company_address" : "Dubai, UAE",
						"phone" : "+1 12114 65471",
						"created_date" : "05 Feb 2025, 10:45 AM",
						"owner_image" : "build/img/profiles/avatar-16.jpg",
						"owner" : "Mason Hayes",
						"status" : "0",
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-14.jpg",
						"lead_name" : "Nicholas Wright",
						"company_name" : "Golden Gate Ltd",
						"company_image" : "build/img/company/company-09.svg",
						"company_address" : "Mumbai, India",
						"phone" : "+1 32145 54789",
						"created_date" : "15 Jan 2025, 02:02 PM",
						"owner_image" : "build/img/profiles/avatar-17.jpg",
						"owner" : "Ron Thompson",
						"status" : "0",
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"lead_image" : "build/img/users/user-16.jpg",
						"lead_name" : "Alexandra Bennett",
						"company_name" : "Redwood Inc",
						"company_image" : "build/img/company/company-10.svg",
						"company_address" : "Tokyo, Japan",
						"phone" : "+1 27890 17145",
						"created_date" : "12 Mar 2025, 08:00 PM",
						"owner_image" : "build/img/profiles/avatar-17.jpg",
						"owner" : "James Bennett",
						"status" : "3",
					}
				],
			"columns": [
				{ "render": function (data, type, row) {
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex fs-14 align-items-center fw-medium mb-0"><a href="#" class="avatar avatar-rounded border me-2"><img src="'+row['lead_image']+'" alt="User Image"></a><a href="#" class="d-flex flex-column">'+row['lead_name']+'</a></h6>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex fs-14 align-items-center fw-medium mb-0"><a href="company_details" class="avatar rounded-circle border me-2"><img class="w-auto h-auto" src="'+row['company_image']+'" alt="User Image"></a><a href="company_details" class="d-flex flex-column">'+row['company_name']+'<span class="text-body fs-13 fw-normal mt-1">'+row['company_address']+' </span></a></h6>';
				}},
				{ "data": "phone" },
				{
					"render": function (data, type, row) {
						var class_name, status_name;
						if (row['status'] == "0") {
							class_name = "bg-success";
							status_name = "Closed";
						} else if (row['status'] == "1") {
							class_name = "bg-info";
							status_name = "Not Closed";
						} else if (row['status'] == "2") {
							class_name = "bg-warning";
							status_name = "Contacted";
						} else {
							class_name = "bg-danger";
							status_name = "Lost";
						}
						
						return '<span class="badge badge-tag ' + class_name + '" >' + status_name + '</span>';
					}
				},
				{ "data": "created_date" },
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex fs-14 align-items-center fw-medium mb-0"><a href="#" class="avatar avatar-rounded border me-2"><img src="'+row['owner_image']+'" alt="User Image"></a><a href="#" class="d-flex flex-column">'+row['owner']+'</a></h6>';
				}}
				
			]
		});
	}

	// Companies List

	if($('#company_reports').length > 0) {
		$('#company_reports').DataTable({
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
						"select" : "",
						"company_name" : "NovaWave LLC",
						"company_image" : "build/img/company/company-01.svg",
						"email" : "robertson@example.com",
						"tag" : "0",
						"owner" : "Hendry Milner",
						"owner_image": "build/img/profiles/avatar-06.jpg",
						"status" : "0",
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"company_name" : "BlueSky Industries",
						"company_image" : "build/img/company/company-02.svg",
						"phone" : "+1 989757485",
						"email" : "sharon@example.com",
						"location" : "USA",
						"tag" : "0",
						"rating" : "5.0",
						"owner" : "Guilory Berggren",
						"owner_image": "build/img/profiles/avatar-05.jpg",
						"status" : "1",
						"Action" : "",
						"source": "Referrals",
						"won_deals": "4 Deals, $120000",
						"lost_deals": "3 Deals, $90000",
						"created_date": "29 Sep 2025, 04:15 pm"
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"company_name" : "SilverHawk",
						"company_image" : "build/img/company/company-03.svg",
						"phone" : "+1 546555455",
						"email" : "vaughan12@example.com",
						"location" : "Canada",
						"tag" : "0",
						"rating" : "3.5",
						"owner" : "Jami Carlile",
						"owner_image": "build/img/profiles/avatar-04.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Campaigns",
						"won_deals": "3 Deals, $110000",
						"lost_deals": "2 Deals, $70000",
						"created_date": "04 Oct 2025, 10:18 am"
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"company_name" : "SummitPeak",
						"company_image" : "build/img/company/company-04.svg",
						"phone" : "+1 454478787",
						"email" : "jessica13@example.com",
						"location" : "India",
						"tag" : "0",
						"rating" : "4.5",
						"owner" : "Theresa Nelson",
						"owner_image": "build/img/profiles/avatar-08.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Google",
						"won_deals": "6 Deals, $200000",
						"lost_deals": "3 Deals, $100000",
						"created_date": "17 Oct 2025, 03:31 pm"
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"company_name" : "RiverStone Ventur",
						"company_image" : "build/img/company/company-05.svg",
						"phone" : "+1 124547845",
						"email" : "caroltho3@example.com",
						"location" : "China",
						"tag" : "0",
						"rating" : "4.7",
						"owner" : "Smith Cooper",
						"owner_image": "build/img/profiles/avatar-02.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Paid Social",
						"won_deals": "3 Deals, $80000",
						"lost_deals": "1 Deal, $40000",
						"created_date": "24 Oct 2025, 09:14 pm"
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"company_name" : "Bright Bridge Grp",
						"company_image" : "build/img/company/company-06.svg",
						"phone" : "+1 478845447",
						"email" : "dawnmercha@example.com",
						"location" : "Martin Lewis",
						"tag" : "0",
						"rating" : "5.0",
						"owner" : "Martin Lewis",
						"owner_image": "build/img/profiles/avatar-01.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Referrals",
						"won_deals": "5 Deals, $95000",
						"lost_deals": "2 Deals, $60000",
						"created_date": "08 Nov 2025, 09:56 am"
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"company_name" : "CoastalStar Co.",
						"company_image" : "build/img/company/company-07.svg",
						"phone" : "+1 215544845",
						"email" : "rachel@example.com",
						"location" : "Indonesia",
						"tag" : "0",
						"rating" : "3.1",
						"owner" : "Newell Egan",
						"owner_image": "build/img/profiles/avatar-17.jpg",
						"status" : "0",
						"Action" : "",
						"source": "Campaigns",
						"won_deals": "4 Deals, $100000",
						"lost_deals": "1 Deal, $50000",
						"created_date": "14 Nov 2025, 04:19 pm"
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"company_name" : "HarborView",
						"company_image" : "build/img/company/company-08.svg",
						"phone" : "+1 121145471",
						"email" : "jonelle@example.com",
						"location" : "Cuba",
						"tag" : "2",
						"rating" : "5.0",
						"owner" : "Janet Carlson",
						"owner_image": "build/img/profiles/avatar-16.jpg",
						"status" : "0",
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"company_name" : "Golden Gate Ltd",
						"company_image" : "build/img/company/company-09.svg",
						"email" : "jonathan@example.com",
						"tag" : "2",
						"owner" : "Craig Brown",
						"owner_image": "build/img/profiles/avatar-15.jpg",
						"status" : "0",
					},
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"company_name" : "Redwood Inc",
						"company_image" : "build/img/company/company-10.svg",
						"email" : "brook@example.com",
						"tag" : "2",
						"owner" : "Daniel Byrne",
						"owner_image": "build/img/profiles/avatar-14.jpg",
						"status" : "0",
					},
				],
			"columns": [
				{ "render": function (data, type, row) {
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="company_details" class="avatar rounded-circle border me-2"><img class="w-auto h-auto" src="'+row['company_image']+'" alt="User Image"></a><a href="company_details">'+row['company_name']+'</a></h6>';
				}},
				{ "data": "email" },
				{
					"render": function (data, type, row) {
						var class_name, status_name;
						if (row['tag'] == "0") {
							class_name = "badge-soft-success";
							status_name = "Collab";
						} else if (row['tag'] == "1") {
							class_name = "badge-soft-warning";
							status_name = "VIP";
						} else if (row['tag'] == "3") {
							class_name = "badge-soft-info";
							status_name = "Premium";
						} else {
							class_name = "badge-soft-primary";
							status_name = "Promotion";
						}
						
						return '<span class="badge badge-tag ' + class_name + '" >' + status_name + '</span>';
					}
				},
				{ "render": function ( data, type, row ){
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="#" class="avatar avatar-sm avatar-rounded me-2"><img src="'+row['owner_image']+'" alt="User Image"></a><a href="#">'+row['owner']+'</a></h6>';
				}},
				{
					"render": function (data, type, row) {
						return '<ul class="social-links d-flex align-items-center"><li><a href="#"><i class="ti ti-mail"></i></a></li><li><a href="#"><i class="ti ti-phone-check"></i></a></li><li><a href="#"><i class="ti ti-message-circle-share"></i></a></li></li><li><a href="#"><i class="ti ti-brand-facebook "></i></a></li></ul>';
					}
				},
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}
			]
		});
	}

	// Projects List

	if($('#project-reports').length > 0) {
		$('#project-reports').DataTable({
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
						"id" : "#12145",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "NovaWave LLC",
						"pro_img" : "build/img/projects/project-01.svg",
						"client_img": "build/img/company/company-01.svg",
						"priority" : "0",
						"start_date" : "25 Sep 2025",
						"end_date" : "15 Oct 2025",
						"stage" : "3",
						"type" : "Web App",
						"status" : "0",
						"value": "$03,50,000",
						"hrs": "100",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$40000",
						"Action" : ""
					},
					{
						"id" : "#12146",
						"si_no" : "",
						"star" : "",
						"name" : "Dreamschat",
						"client" : "BlueSky Industries",
						"pro_img" : "build/img/projects/project-02.svg",
						"client_img": "build/img/company/company-02.svg",
						"priority" : "1",
						"start_date" : "29 Sep 2025",
						"end_date" : "19 Oct 2025",
						"stage" : "1",
						"type" : "Web App",
						"status" : "1",
						"value": "$02,15,000",
						"hrs": "80",
						"mem_image1" : "build/img/profiles/avatar-03.jpg",
						"mem_image2": "build/img/profiles/avatar-05.jpg",
						"mem_image3": "build/img/profiles/avatar-06.jpg",
						"budget": "$300000",
						"currently_spend": "$120000",
						"Action" : ""
					},
					{
						"id" : "#12147",
						"si_no" : "",
						"star" : "",
						"name" : "Truelysell",
						"client" : "SilverHawk",
						"pro_img" : "build/img/projects/project-03.svg",
						"client_img": "build/img/company/company-03.svg",
						"priority" : "2",
						"start_date" : "05 Oct 2025",
						"end_date" : "12 Oct 2025",
						"stage" : "0",
						"type" : "Web App",
						"status" : "0",
						"value": "$01,45,000",
						"hrs": "75",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-01.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$200000",
						"Action" : ""
					},
					{
						"id" : "#12148",
						"si_no" : "",
						"star" : "",
						"name" : "Servbook",
						"client" : "SummitPeak",
						"pro_img" : "build/img/projects/project-04.svg",
						"client_img": "build/img/company/company-04.svg",
						"priority" : "0",
						"start_date" : "14 Oct 2025",
						"end_date" : "24 Oct 2025",
						"stage" : "2",
						"type" : "Web App",
						"status" : "1",
						"value": "$02,15,000",
						"hrs": "60",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-13.jpg",
						"budget": "$300000",
						"currently_spend": "$60000",
						"Action" : ""
					},
					{
						"id" : "#12149",
						"si_no" : "",
						"star" : "",
						"name" : "DreamPOS",
						"client" : "RiverStone Ventur",
						"pro_img" : "build/img/projects/project-05.svg",
						"client_img": "build/img/company/company-05.svg",
						"priority" : "1",
						"start_date" : "15 Nov 2025",
						"end_date" : "22 Nov 2025",
						"stage" : "2",
						"type" : "Web App",
						"status" : "2",
						"value": "$03,64,000",
						"hrs": "72",
						"mem_image1" : "build/img/profiles/avatar-10.jpg",
						"mem_image2": "build/img/profiles/avatar-11.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$120000",
						"currently_spend": "$40000",
						"Action" : ""
					},
					{
						"id" : "#12150",
						"si_no" : "",
						"star" : "",
						"name" : "Kofejob",
						"client" : "CoastalStar Co.",
						"pro_img" : "build/img/projects/project-06.svg",
						"client_img": "build/img/company/company-06.svg",
						"priority" : "2",
						"start_date" : "25 Nov 2025",
						"end_date" : "09 Dec 2025",
						"stage" : "1",
						"type" : "Meeting",
						"status" : "0",
						"value": "$02,12,000",
						"hrs": "96",
						"mem_image1" : "build/img/profiles/avatar-14.jpg",
						"mem_image2": "build/img/profiles/avatar-09.jpg",
						"mem_image3": "build/img/profiles/avatar-08.jpg",
						"budget": "$200000",
						"currently_spend": "$90000",
						"Action" : ""
					},
					{
						"id" : "#12151",
						"si_no" : "",
						"star" : "",
						"name" : "Doccure",
						"client" : "HarborView",
						"pro_img" : "build/img/projects/project-07.svg",
						"client_img": "build/img/company/company-07.svg",
						"priority" : "0",
						"start_date" : "08 Dec 2025",
						"end_date" : "16 Dec 2025",
						"stage" : "0",
						"type" : "Web App",
						"status" : "1",
						"value": "$04,18,000",
						"hrs": "85",
						"mem_image1" : "build/img/profiles/avatar-06.jpg",
						"mem_image2": "build/img/profiles/avatar-07.jpg",
						"mem_image3": "build/img/profiles/avatar-16.jpg",
						"budget": "$200000",
						"currently_spend": "$195000",
						"Action" : ""
					},
					{
						"id" : "#12152",
						"si_no" : "",
						"star" : "",
						"name" : "Best@laundry",
						"client" : "Golden Gate Ltd",
						"pro_img" : "build/img/projects/project-08.svg",
						"client_img": "build/img/company/company-08.svg",
						"priority" : "1",
						"start_date" : "21 Dec 2025",
						"end_date" : "13 Jan 2024",
						"stage" : "0",
						"type" : "Meeting",
						"status" : "2",
						"value": "$01,23,000",
						"hrs": "65",
						"mem_image1" : "build/img/profiles/avatar-04.jpg",
						"mem_image2": "build/img/profiles/avatar-15.jpg",
						"mem_image3": "build/img/profiles/avatar-05.jpg",
						"budget": "$230000",
						"currently_spend": "$220000",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "POS",
						"client" : "CoastalStar Inc",
						"pro_img" : "build/img/projects/project-09.svg",
						"client_img": "build/img/company/company-09.svg",
						"priority" : "2",
						"start_date" : "01 Jan 2024",
						"end_date" : "11 Jan 2024",
						"stage" : "1",
						"type" : "Web App",
						"status" : "1",
						"value": "$03,64,000",
						"hrs": "60",
						"mem_image1" : "build/img/profiles/avatar-08.jpg",
						"mem_image2": "build/img/profiles/avatar-12.jpg",
						"mem_image3": "build/img/profiles/avatar-04.jpg",
						"budget": "$200000",
						"currently_spend": "$177777 ",
						"Action" : ""
					},
					{
						"id" : "#12153",
						"si_no" : "",
						"star" : "",
						"name" : "Bookserv",
						"client" : "Redwood Inc",
						"pro_img" : "build/img/projects/project-10.svg",
						"client_img": "build/img/company/company-10.svg",
						"priority" : "0",
						"start_date" : "12 Jan 2024",
						"end_date" : "29 Jan 2024",
						"stage" : "1",
						"type" : "Meeting",
						"status" : "1",
						"value": " $04,10,000",
						"hrs": "56",
						"mem_image1" : "build/img/profiles/avatar-12.jpg",
						"mem_image2": "build/img/profiles/avatar-14.jpg",
						"mem_image3": "build/img/profiles/avatar-01.jpg",
						"budget": "$300000",
						"currently_spend": "$100000 ",
						"Action" : ""
					}
				],
			"columns": [
				{ "render": function (data, type, row) {
					return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="project_details" class="avatar rounded-circle border me-2"><img class="w-auto h-auto" src="'+row['pro_img']+'" alt="User Image"></a><a href="project_details">'+row['name']+'</a></h6>';
				}},
				{ "render": function ( data, type, row ){
					return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="company_details" class="avatar rounded-circle border me-2"><img class="w-auto h-auto" src="'+row['client_img']+'" alt="User Image"></a><a href="company_details">'+row['client']+'</a></h6>';
				}},   
				{
					"render": function (data, type, row) {
							if(row['priority'] == "0") { var class_name = "badge-soft-danger";var status_name ="High" } else if(row['priority'] == "1") { var class_name = "badge-soft-warning";var status_name ="Medium" } else { var class_name = "badge-soft-success";var status_name ="Low"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				} ,
				{ "data": "start_date" },                 
				{ "data": "end_date" },
				{
					"render": function (data, type, row) {
							if(row['stage'] == "0") { var class_name = "success";var status_name ="Completed" } else if(row['stage'] == "1") { var class_name = "info";var status_name ="Develop" } else if(row['stage'] == "2") { var class_name = "warning";var status_name ="Design"}  else  { var class_name = "violet";var status_name ="Plan"}
					return '<div class="pipeline-progress d-flex align-items-center"><div class="progress"><div class="progress-bar progress-bar-'+class_name+'" role="progressbar"></div></div><span>'+status_name+'</span></div>';
					}
				},
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}
			]
				
		});
	}

		// Task List

	if($('#task-reports').length > 0) {
		$('#task-reports').DataTable({
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
						"id" : "1",
						"si_no" : "",
						"star" : "",
						"task_name" : "Add a form to Update Task",
						"piority" : "0",
						"start_date" : "25 Sep 2025",
						"type" : "Calls",
						"status" : "1",
						"created_date" : "25 Sep 2025, 01:22 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "2",
						"si_no" : "",
						"star" : "",
						"task_name" : "Make all strokes thinner",
						"piority" : "1",
						"start_date" : "29 Sep 2025",
						"type" : "Meeting",
						"status" : "0",
						"created_date" : "29 Sep 2025, 04:15 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "3",
						"si_no" : "",
						"star" : "",
						"task_name" : "Update orginal contentuelysell",
						"piority" : "0",
						"start_date" : "05 Oct 2025",
						"type" : "Email",
						"status" : "1",
						"created_date" : "04 Oct 2025, 10:18 am",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "4",
						"si_no" : "",
						"star" : "",
						"task_name" : "Use only component colours",
						"piority" : "1",
						"start_date" : "14 Oct 2025",
						"type" : "Meeting",
						"status" : "0",
						"created_date" : "17 Oct 2025, 03:31 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "5",
						"si_no" : "",
						"star" : "",
						"task_name" : "Add images to the cards section",
						"piority" : "2",
						"start_date" : "15 Nov 2025",
						"type" : "Task",
						"status" : "1",
						"created_date" : "24 Oct 2025, 09:14 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "6",
						"si_no" : "",
						"star" : "",
						"task_name" : "Design description banner & landing page",
						"piority" : "0",
						"start_date" : "25 Nov 2025",
						"type" : "Calls",
						"status" : "0",
						"created_date" : "08 Nov 2025, 09:56 am",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "7",
						"si_no" : "",
						"star" : "",
						"task_name" : "Make sure all the padding should be 24px",
						"piority" : "2",
						"start_date" : "08 Dec 2025",
						"type" : "Email",
						"status" : "0",
						"created_date" : "14 Nov 2025, 04:19 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "8",
						"si_no" : "",
						"star" : "",
						"task_name" : "Use border radius as 5px or 10 px",
						"piority" : "1",
						"start_date" : "21 Dec 2025",
						"type" : "Task",
						"status" : "0",
						"created_date" : "23 Nov 2025, 11:14 pm",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					},
					{
						"id" : "9",
						"si_no" : "",
						"star" : "",
						"task_name" : "Use Grey scale colors as body color",
						"piority" : "1",
						"start_date" : "21 Dec 2025",
						"type" : "Meeting",
						"status" : "1",
						"created_date" : "10 Dec 2025, 06:43 am",
						"img" : "build/img/profiles/avatar-14.jpg",
						"assignee": "Adrian Davies"
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['task_name']+'</span>';
				}},
				{ "render": function ( data, type, row ){
					return '<h2 class="d-flex align-items-center"><a href="javascript:void(0);" class="avatar avatar-sm me-2"><img class="w-auto h-auto" src="'+row['img']+'" alt="User Image"></a><a href="javascript:void(0);">'+row['assignee']+'</a></h2>';
				}},	  
				{ "render": function ( data, type, row ){
					if(row['piority'] == "0") { var class_name = "danger";var status_name ="High" } else if(row['piority'] == "1") { var class_name = "warning";var status_name ="Medium" }  else { var class_name = "success";var status_name ="Low"}
					return '<span class="priority badge badge-tag badge-'+class_name+'-light" ><i class="ti ti-square-rounded-filled"></i>'+status_name+'</span>';
				}},    
				{ "data": "start_date" },   	
				{ "data": "type" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Completed" } else { var class_name = "bg-warning";var status_name ="Inprogress"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "data": "created_date" }
			]
				
		});
	}		

	// Calls List

	if($('#calls-list').length > 0) {
		$('#calls-list').DataTable({
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
						"id" : "1",
						"si_no" : "",
						"title" : "Busy",
						"created_date" : "25 Feb 2025, 01:22 PM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "2",
						"si_no" : "",
						"title" : "No Answer",
						"created_date" : "03 Apr 2025, 09:45 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "3",
						"si_no" : "",
						"title" : "Wrong Number",
						"created_date" : "14 Apr 2025, 11:11 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "4",
						"si_no" : "",
						"title" : "Unavailable",
						"created_date" : "12 May 2025, 01:09 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "5",
						"si_no" : "",
						"title" : "Technical Issue",
						"created_date" : "28 May 2025, 07:08 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "6",
						"si_no" : "",
						"title" : "Bug Report",
						"created_date" : "01 July 2025, 02:15 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "7",
						"si_no" : "",
						"title" : "Customer Call",
						"created_date" : "20 Jul 2025, 10:25 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "8",
						"si_no" : "",
						"title" : "Management Call",
						"created_date" : "16 Sep 2025, 02:10 PM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "9",
						"si_no" : "",
						"title" : "Support Call",
						"created_date" : "10 Oct 2025, 10:15 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "10",
						"si_no" : "",
						"title" : "Sales Call",
						"created_date" : "01 Nov 2025, 01:32 PM",
						"status" : "0",
						"action" : ""
					},
			
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['title']+'</span>';
				}},
				{ "data": "created_date" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_calls"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_calls"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}

	// Industry List

	if($('#industry-list').length > 0) {
		$('#industry-list').DataTable({
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
						"id" : "1",
						"si_no" : "",
						"title" : "Retail & E-commerce",
						"created_date" : "25 Feb 2025, 01:22 PM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "2",
						"si_no" : "",
						"title" : "Electronics Manufacturing",
						"created_date" : "03 Apr 2025, 09:45 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "3",
						"si_no" : "",
						"title" : "Online Learning Platforms",
						"created_date" : "14 Apr 2025, 11:11 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "4",
						"si_no" : "",
						"title" : "Real Estate",
						"created_date" : "12 May 2025, 01:09 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "5",
						"si_no" : "",
						"title" : "Qualified",
						"created_date" : "28 May 2025, 07:08 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "6",
						"si_no" : "",
						"title" : "Negotiation",
						"created_date" : "01 July 2025, 02:15 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "7",
						"si_no" : "",
						"title" : "Subscriber",
						"created_date" : "20 Jul 2025, 10:25 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "8",
						"si_no" : "",
						"title" : "Architecture",
						"created_date" : "16 Sep 2025, 02:10 PM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "9",
						"si_no" : "",
						"title" : "Construction & Engineering",
						"created_date" : "10 Oct 2025, 10:15 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "10",
						"si_no" : "",
						"title" : "Textiles",
						"created_date" : "01 Nov 2025, 01:32 PM",
						"status" : "0",
						"action" : ""
					},
			
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['title']+'</span>';
				}},
				{ "data": "created_date" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_industry"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_industry"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}

	// Contact Stage

	if($('#contact-stage').length > 0) {
		$('#contact-stage').DataTable({
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
						"id" : "1",
						"si_no" : "",
						"title" : "Contacted",
						"created_date" : "25 Sep 2025, 01:22 PM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "2",
						"si_no" : "",
						"title" : "Not Contacted",
						"created_date" : "29 Sep 2025, 10:20 PM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "3",
						"si_no" : "",
						"title" : "Closed",
						"created_date" : "04 Oct 2025, 08:30 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "4",
						"si_no" : "",
						"title" : "Lost",
						"created_date" : "17 Oct 2025, 11:45 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "5",
						"si_no" : "",
						"title" : "Qualified",
						"created_date" : "28 May 2025, 07:08 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "6",
						"si_no" : "",
						"title" : "Negotiation",
						"created_date" : "01 July 2025, 02:15 AM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "7",
						"si_no" : "",
						"title" : "Subscriber",
						"created_date" : "20 Jul 2025, 10:25 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "8",
						"si_no" : "",
						"title" : "Renewed",
						"created_date" : "16 Sep 2025, 02:10 PM",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "9",
						"si_no" : "",
						"title" : "Lead",
						"created_date" : "10 Oct 2025, 10:15 AM",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "10",
						"si_no" : "",
						"title" : "New Lead",
						"created_date" : "01 Nov 2025, 01:32 PM",
						"status" : "0",
						"action" : ""
					}
			
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['title']+'</span>';
				}},
				{ "data": "created_date" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_contact_stage"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact_stage"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}

	// Lost Reason

	if($('#reason-list').length > 0) {
		$('#reason-list').DataTable({
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
						"id" : "1",
						"si_no" : "",
						"title" : "Client went silent",
						"created_date" : "25 Sep 2025, 01:22 pm",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "2",
						"si_no" : "",
						"title" : "Don't have the budget",
						"created_date" : "29 Sep 2025, 10:20 pm",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "3",
						"si_no" : "",
						"title" : "Doesn't pick up the phone, doesn't respond",
						"created_date" : "04 Oct 2025, 08:30 am",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "4",
						"si_no" : "",
						"title" : "Lack of expertise",
						"created_date" : "17 Oct 2025, 11:45 am",
						"status" : "1",
						"action" : ""
					},
					{
						"id" : "5",
						"si_no" : "",
						"title" : "Not responsible",
						"created_date" : "26 Oct 2025, 04:10 pm",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "6",
						"si_no" : "",
						"title" : "They couldn't afford our services",
						"created_date" : "08 Nov 2025, 05:23 am",
						"status" : "0",
						"action" : ""
					},
					{
						"id" : "7",
						"si_no" : "",
						"title" : "Went with our competitor",
						"created_date" : "11 Nov 2025, 02:32 pm",
						"status" : "0",
						"action" : ""
					}
			
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['title']+'</span>';
				}},
				{ "data": "created_date" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_lost_reason"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_lost_reason"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}

	// Page List

	if($('#pages').length > 0) {
		$('#pages').DataTable({
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
						"pages" :"Dashboard",
						"page_slug" : "Dashboard",
						"status" : "0"
						
					},
					{
						"id" : 2,
						"pages" :"Contacts",
						"page_slug" : "Contacts",
						"status" : "1"
						
					},
					{
						"id" : 3,
						"pages" :"Home",
						"page_slug" : "Home",
						"status" : "0"
						
					},
					{
						"id" : 4,
						"pages" :"Landing Pages",
						"page_slug" : "Landing Pages",
						"status" : "0"
						
					},
					{
						"id" : 5,
						"pages" :"Reports & Analytics",
						"page_slug" : "Reports & Analytics",
						"status" : "0"
						
					},
					{
						"id" : 6,
						"pages" :"Terms & Conditions",
						"page_slug" : "Terms & Conditions",
						"status" : "0"
						
					},
					{
						"id" : 7,
						"pages" :"Categories",
						"page_slug" : "Categories",
						"status" : "0"
						
					},
					{
						"id" : 8,
						"pages" :"Privacy Policy",
						"page_slug" : "Privacy Policy",
						"status" : "0"
						
					},
					{
						"id" : 9,
						"pages" :"FAQ",
						"page_slug" : "FAQ",
						"status" : "0"
						
					},
					{
						"id" : 10,
						"pages" :"About Us",
						"page_slug" : "About Us",
						"status" : "0"
						
					},
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['pages']+'</span>';
				}},
				{ "data": "page_slug" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="edit_page"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}







	// Page List

	if($('#printer-table').length > 0) {
		$('#pages').table({
				"data":[
					{
						"id" : 1,
						"name" :"HP Printer",
						"type" : "Network",
						"ip" : "151.00.1.22",
						"port": "900"
						
					},
					{
						"id" : 2,
						"name" :"Epson",
						"type" : "Network",
						"ip" : "1"
						
					}
				],
			"columns": [
				{ "render": function ( data, type, row ){
					return '<label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label>';
				}},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="fa fa-star"></i></div>';
				}},
				{ "render": function ( data, type, row ){
					return '<span class="title-name">'+row['pages']+'</span>';
				}},
				{ "data": "page_slug" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Active" } else { var class_name = "bg-danger";var status_name ="Inactive"}
				return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				}, 
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_page"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
				
		});
	}

	// Blog Categories List

	if ($("#categories_list").length > 0) {
		$("#categories_list").DataTable({
			bFilter: false,
			bInfo: false,
			"ordering": true,
			"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				"lengthMenu": "Show _MENU_ entries",
				paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
			},
			initComplete: function(settings, json) {
				$('.dataTables_paginate').appendTo('.datatable-paginate');
				$('.dataTables_length').appendTo('.datatable-length');
			},
			"data": [
			{
				"id": 1,
				"title": "Sales Optimization",
				"created_date": "17 Dec 2025",
				"status": "0"
			},
			{
				"id": 2,
				"title": "Automation",
				"created_date": "11 Dec 2025",
				"status": "0"
			},
			{
				"id": 3,
				"title": "Marketing",
				"created_date": "23 Nov 2025",
				"status": "0"
			},
			{
				"id": 4,
				"title": "Implementation",
				"created_date": "12 Nov 2025",
				"status": "0"
			},
			{
				"id": 5,
				"title": "Product Features",
				"created_date": "07 Nov 2025",
				"status": "0"
			},
			{
				"id": 6,
				"title": "Data & Analytics",
				"created_date": "15 Oct 2025",
				"status": "1"
			},
			{
				"id": 7,
				"title": "Customization",
				"created_date": "04 Oct 2025",
				"status": "1"
			},
			{
				"id": 8,
				"title": "Future & Trends",
				"created_date": "29 Sep 2025",
				"status": "0"
			},
			{
				"id": 9,
				"title": "Training & Adoption",
				"created_date": "25 Sep 2025",
				"status": "1"
			},
			{
				"id": 10,
				"title": "Security",
				"created_date": "17 Sep 2025",
				"status": "0"
			}
			],
			columns: [
			{
				"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}
			},
			{ "render": function ( data, type, row ){
				return '<span class="title-name">'+row['title']+'</span>';
			}},
			{ data: "created_date" },
			{
				render: function (data, type, row) {
				if (row["status"] == "1") {
					var class_name = "bg-success";
					var status_name = "Active";
				}
				if (row["status"] == "0") {
					var class_name = "bg-success";
					var status_name = "Active";
				} else {
					var class_name = "bg-danger";
					var status_name = "Inactive";
				}
				return (
					'<span class="badge badge-pill badge-status ' +
					class_name +
					'" >' +
					status_name +
					"</span>"
				);
				},
			},

			{
					"render": function (data, type, row) {
						return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_categories"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_categories"><i class="ti ti-trash"></i> Delete</a></div></div>';
					}
				}
			],
		});
	}

	// Blog Tags List

	if ($("#tags_list").length > 0) {
		$("#tags_list").DataTable({
			bFilter: false,
			bInfo: false,
			"ordering": true,
			"autoWidth": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				info: "_START_ - _END_ of _TOTAL_ items",
				"lengthMenu": "Show _MENU_ entries",
				paginate: {
					next: '<i class="ti ti-chevron-right"></i> ',
					previous: '<i class="ti ti-chevron-left"></i> '
				},
			},
			initComplete: function(settings, json) {
				$('.dataTables_paginate').appendTo('.datatable-paginate');
				$('.dataTables_length').appendTo('.datatable-length');
			},
			"data": [
			{
				"id": 1,
				"title": "Productivity",
				"created_date": "17 Dec 2025",
				"status": "0"
			},
			{
				"id": 2,
				"title": "Integration",
				"created_date": "11 Dec 2025",
				"status": "0"
			},
			{
				"id": 3,
				"title": "Integration",
				"created_date": "23 Nov 2025",
				"status": "0"
			},
			{
				"id": 4,
				"title": "Security",
				"created_date": "12 Nov 2025",
				"status": "0"
			},
			{
				"id": 5,
				"title": "Data Insights",
				"created_date": "07 Nov 2025",
				"status": "0"
			},
			{
				"id": 6,
				"title": "Automation",
				"created_date": "15 Oct 2025",
				"status": "1"
			},
			{
				"id": 7,
				"title": "Marketing",
				"created_date": "04 Oct 2025",
				"status": "1"
			},
			{
				"id": 8,
				"title": "Marketing",
				"created_date": "29 Sep 2025",
				"status": "0"
			},
			{
				"id": 9,
				"title": "User Training",
				"created_date": "25 Sep 2025",
				"status": "1"
			},
			{
				"id": 10,
				"title": "Security",
				"created_date": "17 Sep 2025",
				"status": "0"
			}
			],
			columns: [
			{
				"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
				}
			},
			{ "render": function ( data, type, row ){
				return '<span class="title-name">'+row['title']+'</span>';
			}},
			{ data: "created_date" },
			{
				render: function (data, type, row) {
				if (row["status"] == "1") {
					var class_name = "bg-success";
					var status_name = "Active";
				}
				if (row["status"] == "0") {
					var class_name = "bg-success";
					var status_name = "Active";
				} else {
					var class_name = "bg-danger";
					var status_name = "Inactive";
				}
				return (
					'<span class="badge badge-pill badge-status ' +
					class_name +
					'" >' +
					status_name +
					"</span>"
				);
				},
			},

			{
					"render": function (data, type, row) {
						return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_tags"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_tags"><i class="ti ti-trash"></i> Delete</a></div></div>';
					}
				}
			],
		});
	}
	
	// Contact messages

	if($('#blog-comment-list').length > 0) {
		$('#blog-comment-list').DataTable({
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
						"select" : "",
						"customer_name" : "Darlee Robertson",
						"customer_image" : "build/img/profiles/avatar-19.jpg",
						"customer_no" : "Facility Manager",
						"email" : "robertson@example.com",
						"message" : "Great tips! I’ll definitely try these out with my sales team.",
						"created" : "17 Dec 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 2,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Sharon Roy",
						"customer_image" : "build/img/profiles/avatar-20.jpg",
						"customer_no" : "Installer",
						"email" : "sharon@example.com",
						"message" : "Automation is a game-changer. Thanks for sharing this.",
						"created" : "11 Dec 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 3,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Vaughan Lewis",
						"customer_image" : "build/img/profiles/avatar-21.jpg",
						"customer_no" : "Senior  Manager",
						"email" : "vaughan12@example.com",
						"message" : "Can you recommend tools that work best for integration?",
						"created" : "23 Nov 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 4,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jessica Louise",
						"customer_image" : "build/img/profiles/avatar-23.jpg",
						"customer_no" : "Test Engineer",
						"email" : "jessica13@example.com",
						"message" : "Really helpful guide. Saved me from repeating old errors.",
						"created" : "12 Nov 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 5,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Carol Thomas",
						"customer_image" : "build/img/profiles/avatar-16.jpg",
						"customer_no" : "UI /UX Designer",
						"email" : "caroltho3@example.com",
						"message" : "Looking forward to trying out these new features!",
						"created" : "07 Nov 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 6,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Dawn Mercha",
						"customer_image" : "build/img/profiles/avatar-22.jpg",
						"customer_no" : "Technician",
						"email" : "dawnmercha@example.com",
						"message" : "Love the focus on data-driven decisions.",
						"created" : "15 Oct 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 7,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Rachel Hampton",
						"customer_image" : "build/img/profiles/avatar-24.jpg",
						"customer_no" : "Software Developer",
						"email" : "rachel@example.com",
						"message" : "Customization has really improved our workflow.",
						"created" : "04 Oct 2025",
						"status" : "1",
						"Action" : ""
					},
					{
						"id" : 8,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonelle Curtiss",
						"customer_image" : "build/img/profiles/avatar-25.jpg",
						"customer_no" : "Supervisor",
						"email" : "jonelle@example.com",
						"message" : "Excited to see how these trends will shape the future.",
						"created" : "29 Sep 2025",
						"status" : "0",
						"Action" : ""
					},
					{
						"id" : 9,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Jonathan Smith",
						"customer_image" : "build/img/profiles/avatar-26.jpg",
						"customer_no" : "Team Lead Dev",
						"email" : "jonathan@example.com",
						"message" : "User training is so important. Thanks for the insights.",
						"created" : "25 Sep 2025",
						"status" : "1",
						"Action" : ""
					}
					,
					{
						"id" : 10,
						"si_no" : "",
						"select" : "",
						"customer_name" : "Brook Carter",
						"customer_image" : "build/img/profiles/avatar-01.jpg",
						"customer_no" : "Team Lead Dev ",
						"email" : "brook@example.com",
						"message" : "This is a must-read for anyone handling sensitive data.",
						"created" : "17 Sep 2025",
						"status" : "0",
						"Action" : ""
					}
					
				],
			"columns": [
				{
					"render": function (data, type, row) {
						return '<div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>';
				}},
				{
					"render": function (data, type, row) {
						return '<h6 class="d-flex align-items-center fs-14 fw-medium mb-0"><a href="javascript:void(0);" class="avatar me-2"><img class="img-fluid rounded-circle" src="' + row['customer_image'] + '" alt="User Image"></a><a href="javascript:void(0);" class="d-flex flex-column">' + row['customer_name'] + ' <span class="text-body fs-13 fw-normal mt-1">' + row['customer_no'] + ' </span></a></h6>';
					}
				},
				{ "data": "email" },
				{ "data": "message" },
				{ "data": "created" },
				{
					"render": function (data, type, row) {
							if(row['status'] == "0") { var class_name = "bg-success";var status_name ="Publish" } else { var class_name = "bg-danger";var status_name ="Unpublish"}
					return '<span class="badge badge-pill badge-status '+class_name+'" >'+status_name+'</span>';
					}
				},
				{ "render": function ( data, type, row ){
					return '<div class="dropdown table-action"><a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_comments"><i class="ti ti-edit text-blue"></i> Edit</a><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_comments"><i class="ti ti-trash"></i> Delete</a></div></div>';
				}}
			]
		});
	}

});
