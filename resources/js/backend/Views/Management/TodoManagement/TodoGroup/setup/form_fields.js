/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "name",
		label: "Enter Name",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "phase",
		label: "Enter Phase",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "sort_order",
		label: "Enter Sort Order",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "status",
		label: "Select Status",
		type: "select",
		label: "Select Status",
		multiple: false,
		data_list: [
			{ label: "Pending", value: "pending" },
			{ label: "In_progress", value: "in_progress" },
			{ label: "Completed", value: "completed" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
