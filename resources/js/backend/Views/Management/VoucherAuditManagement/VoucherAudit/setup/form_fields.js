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
		name: "auditor_id",
		label: "Select Auditor",
		type: "select",
		multiple: false,
		data_list: [],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "audit_period_start",
		label: "Enter Audit Period Start",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "audit_period_end",
		label: "Enter Audit Period End",
		type: "date",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "audit_status",
		label: "Select Audit Status",
		type: "select",
		label: "Select Audit Status",
		multiple: false,
		data_list: [
			{ label: "Draft", value: "draft" },
			{ label: "In_progress", value: "in_progress" },
			{ label: "Completed", value: "completed" },
		],
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
