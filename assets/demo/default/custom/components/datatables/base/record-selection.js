//== Class definition
var base_url ="http://remarketingfbbot.dev/admin";
var DatatableRecordSelectionDemo = function () {
	//== Private functions

	// basic demo
	var demo = function () {

		var datatable = $('.m_datatable').mDatatable({

			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: base_url+'/users/get-user-listing'
					}
				},
				pageSize: 10,
				saveState: {
					cookie: true,
					webstorage: true
				},
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true
			},

			// layout definition
			layout: {
				theme: 'default', // datatable theme
				class: '', // custom wrapper class
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				height: 550, // datatable's body's fixed height
				footer: false // display/hide footer
			},

			// column sorting
			sortable: true,

			// column based filtering
			filterable: false,

			pagination: true,

			// columns definition
			columns: [{
				field: "id",
				title: "#",
				sortable: false, // disable sort for this column
				width: 40,
				textAlign: 'center',
				selector: {class: 'm-checkbox--solid m-checkbox--brand'}
			}, {
				field: "name",
				title: "Name",
				// sortable: 'asc', // default sort
				filterable: false, // disable or enable filtering
				width: 150,
				// basic templating support for column rendering,
				//template: '{{OrderID}} - {{ShipCountry}}'
			}, {
				field: "username",
				title: "Username",
				width: 150,
				//template: function (row) {
					// callback function support for column rendering
					//return row.ShipCountry + ' - ' + row.ShipCity;
				//}
			}, {
				field: "email",
				title: "Email",
				sortable: true // disable sort for this column
			}, {
				field: "created_at",
				title: "Created",
				width: 100
			},{
				field: "status",
				title: "status",
				// callback function support for column rendering
				template: function (row) {
					var status = {
						0: {'title': 'Inactive', 'class': 'm-badge--danger'},
						1: {'title': 'Active', 'class': 'm-badge--success'},

					};
					return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
				}
			}, {
				field: "Actions",
				width: 110,
				title: "Actions",
				sortable: false,
				overflow: 'visible',
				template: function (row) {
					var dropup = (row.getDatatable().getPageSize() - row.getIndex()) <= 4 ? 'dropup' : '';

					return '\
						<div class="dropdown '+ dropup +'">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\
						  	</div>\
						</div>\
						<a href="'+base_url+'/users/'+row.hash+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
				}
			}]
		});

		var query = datatable.getDataSourceQuery();

		$('#m_form_search').on('keyup', function (e) {
			// shortcode to datatable.getDataSourceParam('query');
			var query = datatable.getDataSourceQuery();
			query.generalSearch = $(this).val().toLowerCase();
			// shortcode to datatable.setDataSourceParam('query', query);
			datatable.setDataSourceQuery(query);
			datatable.load();
		}).val(query.generalSearch);

		$('#m_form_status').on('change', function () {
			// shortcode to datatable.getDataSourceParam('query');
			var query = datatable.getDataSourceQuery();
			query.Status = $(this).val().toLowerCase();
			// shortcode to datatable.setDataSourceParam('query', query);
			datatable.setDataSourceQuery(query);
			datatable.load();
		}).val(typeof query.Status !== 'undefined' ? query.Status : '');

		$('#m_form_type').on('change', function () {
			// shortcode to datatable.getDataSourceParam('query');
			var query = datatable.getDataSourceQuery();
			query.Type = $(this).val().toLowerCase();
			// shortcode to datatable.setDataSourceParam('query', query);
			datatable.setDataSourceQuery(query);
			datatable.load();
		}).val(typeof query.Type !== 'undefined' ? query.Type : '');

		$('#m_form_status, #m_form_type').selectpicker();

		// on checkbox checked event
		$('.m_datatable')
			.on('m-datatable--on-check', function (e, args) {
				var count = datatable.setSelectedRecords().getSelectedRecords().length;
				$('#m_datatable_selected_number').html(count);
				if (count > 0) {
					$('#m_datatable_group_action_form').collapse('show');
				}
			})
			.on('m-datatable--on-uncheck m-datatable--on-layout-updated', function (e, args) {
				var count = datatable.setSelectedRecords().getSelectedRecords().length;
				$('#m_datatable_selected_number').html(count);
				if (count === 0) {
					$('#m_datatable_group_action_form').collapse('hide');
				}
			});
	};

	return {
		// public functions
		init: function () {
			demo();
		}
	};
}();

jQuery(document).ready(function () {
	DatatableRecordSelectionDemo.init();
});