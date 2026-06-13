/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "type",
		label: "Select Type",
		type: "select",
		label: "Select Type",
		multiple: false,
		data_list: [
			{ label: "Central", value: "central" },
			{ label: "Others", value: "others" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "user_id",
		label: "Select User",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "name",
		label: "Enter Name",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "mobile",
		label: "Enter Mobile",
		type: "tel",
		placeholder: "+1 (555) 000-0000",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "address",
		label: "Enter Address",
		type: "textarea",
		rows: 4,
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
