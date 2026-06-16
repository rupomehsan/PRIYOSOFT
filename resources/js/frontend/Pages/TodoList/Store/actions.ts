const api = (path: string) => (window as any).privateAxios(path);

export const actions = {

    async fetchAllData(this: any) {
        this.loading = true;
        this.error   = null;
        try {
            await Promise.all([
                this.fetchMilestones(),
                this.fetchGroups(),
                this.fetchTasks(),
            ]);
            if (this.milestones.length && !this.selectedMilestoneId) {
                this.selectedMilestoneId = this.milestones[0].id;
            }
        } catch (e: any) {
            this.error = e?.message ?? 'Failed to load data.';
        } finally {
            this.loading = false;
        }
    },

    async fetchMilestones(this: any) {
        const res  = await api('todo-milestones?get_all=1&limit=100&sort_by_col=sort_order&sort_type=asc');
        const list = res?.data?.data ?? res?.data ?? [];
        this.milestones = Array.isArray(list) ? list : [];
    },

    async fetchGroups(this: any) {
        const res  = await api('todo-groups?get_all=1&limit=500&sort_by_col=sort_order&sort_type=asc');
        const list = res?.data?.data ?? res?.data ?? [];
        const raw  = Array.isArray(list) ? list : [];
        this.groups = raw.map((g: any) => ({
            ...g,
            todo_milestone_id: typeof g.todo_milestone_id === 'object' && g.todo_milestone_id !== null
                ? g.todo_milestone_id.id
                : g.todo_milestone_id,
        }));
    },

    async fetchTasks(this: any) {
        const res  = await api('todo-lists?get_all=1&limit=2000&sort_by_col=sort_order&sort_type=asc');
        const list = res?.data?.data ?? res?.data ?? [];
        const raw  = Array.isArray(list) ? list : [];
        // Eloquent eager-loads todoGroupId relation → serialises as todo_group_id (object),
        // stomping the integer FK. Normalise back to the numeric id.
        this.tasks = raw.map((t: any) => ({
            ...t,
            todo_group_id: typeof t.todo_group_id === 'object' && t.todo_group_id !== null
                ? t.todo_group_id.id
                : t.todo_group_id,
        }));
    },

    selectMilestone(this: any, id: number) {
        this.selectedMilestoneId = id;
    },
};
