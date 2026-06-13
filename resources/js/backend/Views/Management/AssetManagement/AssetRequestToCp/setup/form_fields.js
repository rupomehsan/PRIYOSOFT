/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "central_branch_id",
		label: "Select Central Branch",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "asset_quotation_id",
		label: "Select Asset Quotation",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "title",
		label: "Enter Title",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "description",
		label: "Enter Description",
		type: "textarea",
		rows: 4,
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "is_approved",
		label: "Select Is Approved",
		type: "select",
		label: "Select Is Approved",
		multiple: false,
		data_list: [
			{ label: "Yes", value: "yes" },
			{ label: "No", value: "no" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "request_type",
		label: "Select Request Type",
		type: "select",
		label: "Select Request Type",
		multiple: false,
		data_list: [
			{ label: "Purchase", value: "purchase" },
			{ label: "Remove", value: "remove" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
