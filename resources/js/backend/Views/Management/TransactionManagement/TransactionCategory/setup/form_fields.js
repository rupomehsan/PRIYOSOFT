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
		name: "parent",
		label: "Enter Parent",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "type",
		label: "Select Type",
		type: "select",
		label: "Select Type",
		multiple: false,
		data_list: [
			{ label: "Expense", value: "expense" },
			{ label: "Income", value: "income" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
