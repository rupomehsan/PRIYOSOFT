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
		name: "email",
		label: "Enter Email",
		type: "email",
		placeholder: "example@domain.com",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "phone",
		label: "Enter Phone",
		type: "tel",
		placeholder: "+1 (555) 000-0000",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "subject",
		label: "Enter Subject",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
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
		name: "message",
		label: "Enter Message",
		type: "textarea",
		rows: 4,
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
			{ label: "New", value: "new" },
			{ label: "Read", value: "read" },
			{ label: "Replied", value: "replied" },
			{ label: "Closed", value: "closed" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "ip_address",
		label: "Enter Ip Address",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
