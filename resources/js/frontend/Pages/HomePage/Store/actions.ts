const api = (path: string) => (window as any).axios.get(path);

export const actions = {

    async fetchAllPortfolioData(this: any) {
        this.loading = true;
        try {
            await Promise.allSettled([
                this.fetchHeroSection(),
                this.fetchSiteSections(),
                this.fetchProducts(),
                this.fetchTeamMembers(),
                this.fetchTestimonials(),
                this.fetchBlogPosts(),
                this.fetchFaqs(),
                this.fetchAboutUs(),
                this.fetchWhoWeAre(),
            ]);
        } finally {
            this.loading = false;
        }
    },

    async fetchHeroSection(this: any) {
        try {
            const res = await api('public/hero-sections?get_all=1&status=active');
            const list = res?.data?.data ?? res?.data ?? [];
            this.heroSlides = Array.isArray(list) ? list : (list ? [list] : []);
        } catch { /* silent fail — fallback slides shown */ }
    },

    async fetchSiteSections(this: any) {
        try {
            const res = await api('public/site-sections?get_all=1&status=active');
            this.siteSections = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchProducts(this: any) {
        try {
            const res = await api('public/products?get_all=1&status=active&limit=12');
            this.products = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchTeamMembers(this: any) {
        try {
            const res = await api('public/team-members?get_all=1&status=active');
            this.teamMembers = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchTestimonials(this: any) {
        try {
            const res = await api('public/testimonials?get_all=1&status=active&limit=12');
            this.testimonials = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchBlogPosts(this: any) {
        try {
            const res = await api('public/blogs?get_all=1&status=active&limit=3');
            this.blogPosts = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchFaqs(this: any) {
        try {
            const res = await api('public/faqs?get_all=1&status=active');
            this.faqs = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async fetchWhoWeAre(this: any) {
        try {
            const res = await api('public/who-we-are?get_all=1&status=active&limit=1');
            const list = res?.data?.data ?? res?.data ?? [];
            this.whoWeAre = Array.isArray(list) ? (list[0] ?? null) : (list || null);
        } catch { }
    },

    async fetchAboutUs(this: any) {
        try {
            const res = await api('public/about-us?get_all=1&status=active&limit=100&sort_by_col=sort_order&sort_type=asc');
            this.aboutSections = res?.data?.data ?? res?.data ?? [];
        } catch { }
    },

    async subscribeNewsletter(this: any, payload: { email: string; name?: string }) {
        this.newsletterLoading = true;
        this.newsletterSuccess = false;
        this.newsletterError   = null;
        try {
            await (window as any).axios.post('public/subscribe', payload);
            this.newsletterSuccess = true;
        } catch (err: any) {
            this.newsletterError = err?.response?.data?.message ?? 'Subscription failed. Please try again.';
        } finally {
            this.newsletterLoading = false;
        }
    },
};

export default actions;
