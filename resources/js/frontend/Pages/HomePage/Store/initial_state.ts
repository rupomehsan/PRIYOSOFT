export const initialState = {
    loading: false,
    error: null as null | string,

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
