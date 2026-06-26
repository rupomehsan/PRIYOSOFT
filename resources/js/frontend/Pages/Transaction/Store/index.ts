import { defineStore } from 'pinia';
import { initialState } from './initial_state';
import { actions }      from './actions';

export const store = defineStore('transaction_page', {
    state: () => ({ ...initialState }),

    actions: { ...actions },

    getters: {
        tabRows:     (state) => (key: string) => state.cache[key]?.rows   ?? [],
        tabTotal:    (state) => (key: string) => state.cache[key]?.total  ?? 0,
        tabLoaded:   (state) => (key: string) => !!(state.cache[key]?.loaded),

        netBalance:  (state): number =>
            Number(state.dashData.total_income) - Number(state.dashData.total_expense),

        monthNet:    (state): number =>
            Number(state.dashData.current_month_income) - Number(state.dashData.current_month_expense),

        healthScore: (state): number => {
            const inc = Number(state.dashData.total_income);
            const exp = Number(state.dashData.total_expense);
            if (!inc && !exp) return 50;
            return Math.round((inc / (inc + exp)) * 100);
        },
    },
});
