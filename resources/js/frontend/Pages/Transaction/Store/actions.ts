const api = (path: string) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        (window as any).axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }
    return (window as any).axios.get(path);
};

export const actions = {

    async fetchDashboard(this: any) {
        this.dashLoading = true;
        this.dashError   = null;
        try {
            const res  = await api('get-all-dashboard-data');
            const data = res?.data?.data ?? {};
            this.dashData = { ...this.dashData, ...data };
        } catch (e: any) {
            this.dashError = e?.response?.status === 401
                ? 'Session expired or not logged in. Please log in to view financial data.'
                : (e?.response?.data?.message ?? 'Failed to load dashboard.');
        } finally {
            this.dashLoading = false;
        }
    },

    async fetchTab(this: any, key: string, endpoint: string) {
        this.loading = true;
        this.error   = null;
        try {
            const res   = await api(`${endpoint}?limit=50&page=1`);
            const paged = res?.data?.data;
            const items = Array.isArray(paged?.data) ? paged.data
                        : Array.isArray(paged)        ? paged
                        : [];
            const total = paged?.total ?? items.length;
            this.cache  = { ...this.cache, [key]: { rows: items, total, page: 1, loaded: true } };
        } catch (e: any) {
            this.error = e?.response?.status === 401
                ? 'Session expired or not logged in. Please log in first.'
                : (e?.response?.data?.message ?? 'Failed to load data.');
        } finally {
            this.loading = false;
        }
    },

    async loadMoreTab(this: any, key: string, endpoint: string) {
        const entry = this.cache[key];
        if (!entry || this.loadingMore) return;
        this.loadingMore = true;
        try {
            const next  = entry.page + 1;
            const res   = await api(`${endpoint}?limit=50&page=${next}`);
            const paged = res?.data?.data;
            const more  = Array.isArray(paged?.data) ? paged.data
                        : Array.isArray(paged)        ? paged
                        : [];
            this.cache = {
                ...this.cache,
                [key]: { ...entry, rows: [...entry.rows, ...more], page: next },
            };
        } catch (e: any) {
            this.error = e?.response?.status === 401
                ? 'Session expired. Please log in again.'
                : (e?.response?.data?.message ?? 'Failed to load more.');
        } finally {
            this.loadingMore = false;
        }
    },

    selectTab(this: any, key: string) {
        this.activeTab = key;
    },
};
