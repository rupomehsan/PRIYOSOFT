/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "loan_type",
		label: "Select Loan Type",
		type: "select",
		label: "Select Loan Type",
		multiple: false,
		data_list: [
			{ label: "Given", value: "given" },
			{ label: "Taken", value: "taken" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "loan_id",
		label: "Select Loan",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "transaction_log_id",
		label: "Select Transaction Log",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "amount",
		label: "Enter Amount",
		type: "number",
		step: "0.01",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "payment_date",
		label: "Enter Payment Date",
		type: "date",
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
];
