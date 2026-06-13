/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
	{
		name: "creator",
		label: "Enter Creator",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "participant",
		label: "Enter Participant",
		type: "number",
		step: "1",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "is_group",
		label: "Select Is Group",
		type: "select",
		label: "Select Is Group",
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
		name: "group_name",
		label: "Enter Group Name",
		type: "text",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "group_participants",
		label: "Enter Group Participants",
		type: "textarea",
		rows: 6,
		placeholder: "Enter valid JSON",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
	{
		name: "last_updated",
		label: "Enter Last Updated",
		type: "datetime-local",
		value: "",
		is_visible: true,
		class: "col-md-6",
	},
];
