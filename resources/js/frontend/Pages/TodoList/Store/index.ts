import { defineStore } from "pinia";
import { initialState } from "./initial_state";
import { actions } from "./actions";

export const store = defineStore("todo_board_store", {
    state: () => ({ ...initialState }),

    getters: {
        selectedMilestone: (state): any =>
            state.milestones.find((m: any) => m.id === state.selectedMilestoneId) ?? null,

        groupsForSelected: (state): any[] =>
            state.groups.filter((g: any) => g.todo_milestone_id === state.selectedMilestoneId),

        tasksForGroup: (state) => (groupId: number): any[] =>
            state.tasks.filter((t: any) => t.todo_group_id === groupId),

        milestoneProgress: (state) => (milestoneId: number): number => {
            const groupIds = state.groups
                .filter((g: any) => g.todo_milestone_id === milestoneId)
                .map((g: any) => g.id);
            const mTasks = state.tasks.filter((t: any) => groupIds.includes(t.todo_group_id));
            if (!mTasks.length) return 0;
            const done = mTasks.filter((t: any) => t.current_status === 'completed').length;
            return Math.round((done / mTasks.length) * 100);
        },

        milestoneTotalCost: (state) => (milestoneId: number): number => {
            return state.groups
                .filter((g: any) => g.todo_milestone_id === milestoneId)
                .reduce((sum: number, g: any) => sum + (Number(g.cost) || 0), 0);
        },

        totalCostSummary: (state) => {
            const budget = state.milestones
                .reduce((s: number, m: any) => s + (Number(m.cost) || 0), 0);
            const grouped = state.groups
                .reduce((s: number, g: any) => s + (Number(g.cost) || 0), 0);
            return { budget, grouped };
        },

        overallStats: (state) => {
            const total      = state.tasks.length;
            const completed  = state.tasks.filter((t: any) => t.current_status === 'completed').length;
            const inProgress = state.tasks.filter((t: any) => t.current_status === 'in_progress').length;
            const pending    = state.tasks.filter((t: any) => t.current_status === 'pending').length;
            const skipped    = state.tasks.filter((t: any) => t.current_status === 'skipped').length;
            return { total, completed, inProgress, pending, skipped };
        },
    },

    actions: { ...actions },
});
