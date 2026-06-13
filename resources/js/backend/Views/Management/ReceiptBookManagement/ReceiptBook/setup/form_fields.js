/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "receipt_book_no",
		label: "Enter Receipt Book No",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "receipt_start_serial_no",
		label: "Enter Receipt Start Serial No",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "receipt_end_serial_no",
		label: "Enter Receipt End Serial No",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "last_issued_serial_no",
		label: "Enter Last Issued Serial No",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "total_pages",
		label: "Enter Total Pages",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "book_status",
		label: "Select Book Status",
		type: "select",
		label: "Select Book Status",
		multiple: false,
		data_list: [
			{ label: "Active", value: "active" },
			{ label: "Exhausted", value: "exhausted" },
			{ label: "Void", value: "void" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "approval",
		label: "Select Approval",
		type: "select",
		label: "Select Approval",
		multiple: false,
		data_list: [
			{ label: "Pending", value: "pending" },
			{ label: "Accept", value: "accept" },
			{ label: "Reject", value: "reject" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
