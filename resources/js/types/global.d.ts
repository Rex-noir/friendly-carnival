import Echo from "laravel-echo";
import { route as routeFn } from "ziggy-js";

declare global {
    interface Window {
        Echo: Echo;
    }
    var route: typeof routeFn;
}
