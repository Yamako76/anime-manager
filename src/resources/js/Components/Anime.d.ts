export type Anime = {
    created_at: string;
    deleted_at: string | null;
    id: number;
    latest_changed_at: string;
    memo: string;
    name: string;
    status: "active" | "deleted";
    updated_at: string;
    user_id: number;
};
