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
		name: "type",
		label: "Select Type",
		type: "select",
		label: "Select Type",
		multiple: false,
		data_list: [
			{ label: "Cash", value: "cash" },
			{ label: "Bank", value: "bank" },
			{ label: "Mobile_banking", value: "mobile_banking" },
			{ label: "Crypto", value: "crypto" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "account_number",
		label: "Enter Account Number",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "opening_balance",
		label: "Enter Opening Balance",
		type: "number",
		step: "0.01",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "current_balance",
		label: "Enter Current Balance",
		type: "number",
		step: "0.01",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "currency",
		label: "Enter Currency",
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
