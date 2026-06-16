export const initialState = {
    loading: false,
    error:   null as null | string,

    milestones:          [] as any[],
    groups:              [] as any[],
    tasks:               [] as any[],

    selectedMilestoneId: null as null | number,
};
