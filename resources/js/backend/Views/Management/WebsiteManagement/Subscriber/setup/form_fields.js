/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "email",
		label: "Enter Email",
		type: "email",
		placeholder: "example@domain.com",
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
		name: "is_active",
		label: "Select Is Active",
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
