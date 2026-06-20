<template>
  <div>
    <form @submit.prevent="submitHandler">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="text-capitalize">
            {{
              param_id
                ? `${setup.edit_page_title}`
                : `${setup.create_page_title}`
            }}
          </h5>
          <div>
            <router-link
              v-if="item.slug"
              class="btn btn-outline-info mr-2 btn-sm"
              :to="{
                name: `Details${setup.route_prefix}`,
                params: { id: item.slug },
              }"
            >
              {{ setup.details_page_title }}
            </router-link>
            <router-link
              class="btn btn-outline-warning btn-sm"
              :to="{ name: `All${setup.route_prefix}` }"
            >
              {{ setup.all_page_title }}
            </router-link>
          </div>
        </div>
        <div class="card-body card_body_fixed_height">
          <div class="row" v-if="form_ready">
            <template
              v-for="form_field in form_fields"
              :key="form_field.name"
            >
              <common-input
                :label="form_field.label"
                :type="form_field.type"
                :name="form_field.name"
                :placeholder="form_field.placeholder"
                :multiple="form_field.multiple"
                :value="form_field.value"
                :data_list="form_field.data_list"
                :is_visible="form_field.is_visible"
                :class="form_field.class"
                :onchange="form_field.onchange"
              />
            </template>
          </div>
          <div v-else class="d-flex align-items-center justify-content-center py-5">
            <span class="text-muted">Loading...</span>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-light btn-square px-5" :disabled="!form_ready">
            <i class="icon-lock"></i>
            Submit
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { store } from "../store";
import setup from "../setup";
import form_fields from "../setup/form_fields";

export default {
  data: () => ({
    setup,
    form_fields,
    param_id: null,
    form_ready: false,
  }),
  created: async function () {
    let id = (this.param_id = this.$route.params.id);
    this.reset_fields();
    this.setup_media_type_toggle();
    await this.load_products();
    if (id) {
      await this.set_fields(id);
      this.sync_video_url_visibility();
    }
    this.form_ready = true;
    // TextEditor (summernote) uses a 1000ms internal timer before it's ready.
    // Set editor content after the DOM is rendered and summernote is initialized.
    if (id) {
      this.$nextTick(() => {
        setTimeout(() => this.set_editor_content(), 1200);
      });
    }
  },
  methods: {
    ...mapActions(store, {
      create: "create",
      update: "update",
      details: "details",
      get_all: "get_all",
      set_only_latest_data: "set_only_latest_data",
    }),
    setup_media_type_toggle: function () {
      const mediaField = this.form_fields.find((f) => f.name === "media_type");
      if (mediaField) {
        mediaField.onchange = (event) => {
          mediaField.value = event?.target?.value ?? event;
          this.sync_video_url_visibility();
        };
      }
    },
    sync_video_url_visibility: function () {
      const mediaField = this.form_fields.find((f) => f.name === "media_type");
      const videoField = this.form_fields.find((f) => f.name === "video_url");
      if (mediaField && videoField) {
        videoField.is_visible = mediaField.value === "video";
      }
    },
    load_products: async function () {
      try {
        // Same pattern as Product form's loadProductGroups:
        // relative URL → baseURL prepends /api/v1/ automatically
        // get_all=1 → response.data.data is the array directly (not paginated)
        const res = await window.axios.get(
          "products?get_all=1&limit=1000&sort_by_col=name&sort_type=asc"
        );
        const raw = res?.data?.data ?? [];
        const list = Array.isArray(raw) ? raw : [];
        const productField = this.form_fields.find((f) => f.name === "product_id");
        if (productField) {
          productField.data_list = list.map((p) => ({
            label: p.name,
            value: p.id,
          }));
        }
      } catch (e) {
        console.warn("Could not load products:", e);
      }
    },
    reset_fields: function () {
      this.form_fields.forEach((item) => {
        item.value = "";
      });
    },
    set_fields: async function (id) {
      this.param_id = id;
      await this.details(id);
      if (this.item) {
        this.form_fields.forEach((field, index) => {
          Object.entries(this.item).forEach(([key, val]) => {
            if (field.name === key) {
              const resolved =
                val && typeof val === "object" && !Array.isArray(val) && "id" in val
                  ? val.id
                  : val;
              this.form_fields[index].value = resolved;
            }
          });
        });
      }
    },
    set_editor_content: function () {
      const msgField = this.form_fields.find((f) => f.name === "message");
      if (msgField?.value) {
        try {
          $("#message").summernote("code", msgField.value);
        } catch (e) {
          console.warn("Could not set message editor content:", e);
        }
      }
    },

    submitHandler: async function ($event) {
      this.set_only_latest_data(true);
      if (this.param_id) {
        this.setSummerEditor();
        let response = await this.update($event);
        // await this.get_all();
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data successfully updated");
          this.$router.push({ name: `Details${this.setup.route_prefix}` });
        }
      } else {
        this.setSummerEditor();
        let response = await this.create($event);
        // await this.get_all();
        if ([200, 201].includes(response.status)) {
          window.s_alert("Data Successfully Created");
          this.$router.push({ name: `All${this.setup.route_prefix}` });
        }
      }
    },
    setSummerEditor() {
      // Set property_detail summernote content if message field exists
      const messageElement = document.getElementById("message");
      if (messageElement) {
        try {
          var markupStr = $("#message").summernote("code");
          var target = document.createElement("input");
          target.setAttribute("name", "message");
          target.value = markupStr;
          messageElement.appendChild(target);
        } catch (e) {
          console.warn("message editor not available:", e);
        }
      }
    },
  },

  computed: {
    ...mapState(store, {
      item: "item",
    }),
  },
};
</script>

<style scoped></style>
