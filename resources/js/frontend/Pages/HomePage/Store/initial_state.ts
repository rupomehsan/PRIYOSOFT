export const initialState = {
    loading: false,
    error: null as null | string,

    // ── Per-section loading flags (true until that section's API resolves)
    loadingProducts:     true,
    loadingAbout:        true,
    loadingWhoWeAre:     true,
    loadingTestimonials: true,
    loadingBlog:         true,
    loadingFaq:          true,

    // ── Portfolio data ────────────────────────────────────────────────
    heroSlides:    []    as any[],
    siteSections:  []    as any[],
    products:      []    as any[],
    productGroups: []    as any[],
    teamMembers:   []    as any[],
    testimonials:  []    as any[],
    blogPosts:     []    as any[],
    faqs:          []    as any[],
    aboutSections: []    as any[],
    whoWeAre:      null  as any,

    // ── Newsletter ────────────────────────────────────────────────────
    newsletterLoading: false,
    newsletterSuccess: false,
    newsletterError:   null as null | string,
};

export default initialState;
