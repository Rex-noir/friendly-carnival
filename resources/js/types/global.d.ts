import Echo from "laravel-echo";
import { route as routeFn } from "ziggy-js";
import { UserRoles, UserStatus } from "./enums.types";

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
        role: UserRoles;
        status: UserStatus;
    }
}
