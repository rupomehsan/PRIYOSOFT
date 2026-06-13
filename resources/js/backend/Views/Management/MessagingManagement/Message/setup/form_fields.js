/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "conversation_id",
		label: "Select Conversation",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "sender",
		label: "Enter Sender",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "receiver",
		label: "Enter Receiver",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "text",
		label: "Enter Text",
		type: "textarea",
		rows: 4,
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "attachment",
		label: "Enter Attachment",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "date_time",
		label: "Enter Date Time",
		type: "datetime-local",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "is_read",
		label: "Select Is Read",
		type: "select",
		label: "Select Is Read",
		multiple: false,
		data_list: [
			{ label: "Yes", value: "yes" },
			{ label: "No", value: "no" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "read_at",
		label: "Enter Read At",
		type: "datetime-local",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
