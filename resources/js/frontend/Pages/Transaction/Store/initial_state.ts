export const initialState = {
    // Dashboard
    dashLoading: false,
    dashError:   null as null | string,
    dashData: {
        total_income:          0,
        total_expense:         0,
        monthly_due:           0,
        current_month_income:  0,
        current_month_expense: 0,
        total_users:           0,
        total_applications:    0,
        pending_vouchers:      0,
        monthly_income:  [0,0,0,0,0,0,0,0,0,0,0,0] as number[],
        monthly_expense: [0,0,0,0,0,0,0,0,0,0,0,0] as number[],
    },

    // Transaction tab cache
    cache:       {} as Record<string, { rows: any[]; total: number; page: number; loaded: boolean }>,
    activeTab:   'dashboard',
    loading:     false,
    loadingMore: false,
    error:       null as null | string,
};
