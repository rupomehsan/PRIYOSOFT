/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "product_id",
		label: "Select Product",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "question",
		label: "Enter Question",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "answer",
		label: "Enter Answer",
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
	{
		name: "is_visible",
		label: "Select Is Visible",
		type: "select",
		multiple: false,
		data_list: [
			{ label: "Yes", value: "1" },
			{ label: "No", value: "0" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
