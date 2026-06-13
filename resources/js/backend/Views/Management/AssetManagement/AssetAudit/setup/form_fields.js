/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
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
		name: "start_date",
		label: "Enter Start Date",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "end_date",
		label: "Enter End Date",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "is_complete",
		label: "Select Is Complete",
		type: "select",
		label: "Select Is Complete",
		multiple: false,
		data_list: [
			{ label: "Yes", value: "yes" },
			{ label: "No", value: "no" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
