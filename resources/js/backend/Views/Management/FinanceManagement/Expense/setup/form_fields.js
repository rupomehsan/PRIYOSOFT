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
		name: "expense_category_id",
		label: "Select Expense Category",
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
		name: "attachment",
		label: "Upload Attachment",
		type: "file",
		multiple: false,
		accept: "image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
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
		class: "col-md-12",
	},

];
