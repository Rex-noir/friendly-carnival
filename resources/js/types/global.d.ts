import Echo from "laravel-echo";
import { route as routeFn } from "ziggy-js";
import { UserStatus } from "./actions.types";

declare global {
    interface Window {
        Echo: Echo;
    }
    var route: typeof routeFn;
    interface User {
        id: number;
        name: string;
        email: string;
        email_verified_at: string;
        created_at: string;
        updated_at: string;
        role: string;
        status: UserStatus;
    }
}
