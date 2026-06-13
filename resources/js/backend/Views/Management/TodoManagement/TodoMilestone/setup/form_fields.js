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
		name: "phase",
		label: "Enter Phase",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "target_date",
		label: "Enter Target Date",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "achieved_date",
		label: "Enter Achieved Date",
		type: "date",
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
			{ label: "Upcoming", value: "upcoming" },
			{ label: "Achieved", value: "achieved" },
			{ label: "Missed", value: "missed" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "note",
		label: "Enter Note",
		type: "textarea",
		rows: 4,
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
];
