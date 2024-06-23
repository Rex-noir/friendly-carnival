import { modes } from "@/preferences";
export class LayoutUtils {
    static toggleDarkMode() {
        const html = document.querySelector("html") as HTMLElement;
        if (modes.isDarkMode) {
            html.classList.remove("dark");
            modes.isDarkMode = false;
        } else {
            html.classList.add("dark");
            modes.isDarkMode = true;
        }
    }
}
