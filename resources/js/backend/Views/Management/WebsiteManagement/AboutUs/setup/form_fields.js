/**
 * Form Fields Configuration
 * Auto-generated — edit data_list / class / is_visible as needed.
 */

export default [
  {
    name: "section",
    label: "Select Section",
    type: "select",
    label: "Select Section",
    multiple: false,
    data_list: [
    
      { label: "Mission", value: "mission" },
      { label: "Vision", value: "vision" },
      { label: "Value", value: "value" },
      { label: "Stat", value: "stat" },
    ],
    value: "",
    is_visible: true,
    class: "col-md-6",
  },
  {
    name: "title",
    label: "Enter Title",
    type: "text",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },

  {
    name: "icon",
    label: "Enter Icon",
    type: "text",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },

  {
    name: "stat_value",
    label: "Enter Stat Value",
    type: "text",
    value: "",
    is_visible: true,
    class: "col-md-6",
  },
  {
    name: "stat_label",
    label: "Enter Stat Label",
    type: "text",
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
  {
    name: "image",
    label: "Upload Image",
    type: "file",
    multiple: false,
    accept: "image/*",
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
    class: "col-md-12",
  },
];
