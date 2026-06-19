import axios from "axios";
import { defineStore } from "pinia";

const CACHE_KEY = "ps_site_settings";
const CACHE_TTL = 5 * 60 * 1000; // 5 minutes

function readCache() {
    try {
        const raw = localStorage.getItem(CACHE_KEY);
        if (!raw) return null;
        const { data, ts } = JSON.parse(raw);
        if (Date.now() - ts > CACHE_TTL) return null;
        return Array.isArray(data) ? data : null;
    } catch { return null; }
}

function writeCache(data) {
    try { localStorage.setItem(CACHE_KEY, JSON.stringify({ data, ts: Date.now() })); }
    catch { /* storage full — ignore */ }
}

export const site_settings_store = defineStore("site_settings_store", {
    state: () => ({
        website_settings_data: readCache() ?? [],
        _fetching: false,
    }),

    actions: {
        async get_all_website_settings() {
            if (this._fetching) return;
            this._fetching = true;
            try {
                const response = await axios.get("/website-settings?get_all=1&limit=100");
                const data = Array.isArray(response.data?.data)
                    ? response.data.data
                    : Object.values(response.data?.data ?? {});
                this.website_settings_data = data;
                writeCache(data);
            } catch (error) {
                console.error("Error fetching website settings:", error);
            } finally {
                this._fetching = false;
            }
        },

        get_setting_value(key, multiple = false) {
            if (!Array.isArray(this.website_settings_data)) return multiple ? [] : "";
            try {
                if (multiple) {
                    const item = this.website_settings_data.find(i => i.title === key);
                    return item?.setting_values ?? [];
                }
                const item = this.website_settings_data.find(i => i.title === key);
                return item?.setting_values?.[0]?.value || "";
            } catch { return multiple ? [] : ""; }
        },
    },
});
